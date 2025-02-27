<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proxy extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Mengizinkan akses dari domain lain (CORS)
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $qrypengaturan_sistem = $this->db->get('pengaturan_sistem')->row();
            $interval_on = $qrypengaturan_sistem->relay_interval_on;
            $relay_url_on = $qrypengaturan_sistem->relay_url_on;
            
            // URL Arduino Web Server
            $arduino_url = $relay_url_on;

            // Data yang akan dikirim ke Arduino dalam format form-data
            $post_data = http_build_query(['interval_on' => $interval_on]);

            // Mengirim request POST ke Arduino menggunakan cURL
            $ch = curl_init($arduino_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/x-www-form-urlencoded"
            ]);

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code == 200) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Command sent to Arduino',
                    // 'response' => json_decode($response, true)
                    'response' => $response
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to send request to Arduino'
                ]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        }
    }
}
?>
