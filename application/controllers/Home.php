<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Aset Controller
*
*	@author Ridwan Sapoetra | sm4rtschool@gmail.com | 082113332009
*
*/

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// profiler ini untuk menampilkan debug
		// $this->output->enable_profiler(TRUE);

		//$this->load->database();
		//$this->load->helper('url');
		$this->load->library('fungsi');
		$this->load->model('Homemodel', 'home');
		$this->load->model('Contentmodel');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		
		//$this->getList();

		/*
		$data['area'] = array(
		    1 => 'Monitoring ATM',
		    2 => 'Monitoring SLA',
		    3 => 'Monitoring COM Down'
		);
		*/

		/*
		echo '<pre>';
		print_r($data['area']);
		//echo json_encode($array_variable);
		echo '</pre>';
		exit;
		*/

		$parameter = $this->home->get_parameter();

		$array_parameter = array();
		foreach ($parameter as $val){
			$array_parameter[$val->id] = $val->kategori;
		}
		
		$data['kategori'] = $array_parameter;

		$qrypengaturan_sistem = $this->home->qrypengaturan_sistem()->row();
		$data['qrypengaturan_sistem'] = $qrypengaturan_sistem;

		// $qryGetSound = $this->Contentmodel->getSoundToPlay()->result();
        // $data['sound'] = $qryGetSound;

		$filter_config = 1;
		$qrygetConfig = $this->home->getConfig($filter_config)->row();
		$data['config_list_data'] = $qrygetConfig;

		$filter_config_trigger = 1;
		$qrygetConfigTrigger = $this->home->getConfig($filter_config_trigger)->row();
		$data['config_trigger'] = $qrygetConfigTrigger;

		// $filter_config_global_sound = 3;
		// $qrygetConfigGlobalSound = $this->home->getConfig($filter_config_global_sound)->row();
		// $data['config_global_sound'] = $qrygetConfigGlobalSound;

		// $filter_config_apis_url_play_sound = 4;
		// $qrygetConfigApisUrlPlaySound = $this->home->getConfig($filter_config_apis_url_play_sound)->row();
		// $data['config_apis_url_play_sound'] = $qrygetConfigApisUrlPlaySound;

		// $filter_config_apis_url_web_socket = 5;
		// $qrygetConfigApisUrlWebSocket = $this->home->getConfig($filter_config_apis_url_web_socket)->row();
		// $data['config_apis_url_web_socket'] = $qrygetConfigApisUrlWebSocket;

		// $filter_config_global_light_color = 6;
		// $qrygetConfigGlobalLightColor = $this->home->getConfig($filter_config_global_light_color)->row();
		// $data['config_global_light_color'] = $qrygetConfigGlobalLightColor;

		// $filter_config_ip_address_controller = 10;
		// $qrygetConfigIPAddressController = $this->home->getConfig($filter_config_ip_address_controller)->row();
		// $data['config_ip_address_controller'] = $qrygetConfigIPAddressController;

		$this->load->view('partials/_mydashboard_header', $data);
		$this->load->view('home/home', $data);

	}

	public function get_last_data()
	{
		$query = $this->home->getLastData();
		echo json_encode($query->result(), JSON_PRETTY_PRINT);
	}

	public function get_last_location()
    {

		$rfid_tag_number = $this->input->get('rfid_tag_number');

        if ($this->home->getLastLocation($rfid_tag_number)->num_rows() > 0) {
			$is_data_ada = true;
			$data = $this->home->getLastLocation($rfid_tag_number)->result();
		} else {
			$is_data_ada = false;
			$data = [];
		}

        $response = array(
            'is_data_ada' => $is_data_ada,
            'data' => $data
        );

        echo json_encode($response, JSON_PRETTY_PRINT);

    }

	public function get_last_detection()
    {

		$rfid_tag_number = $this->input->get('rfid_tag_number');
		$room_id = $this->input->get('room_id');
		$reader_angle = $this->input->get('reader_angle');

        if ($this->home->getLastDetection($rfid_tag_number, $room_id, $reader_angle)->num_rows() > 0) {
			$is_data_ada = true;
			// $data = $this->home->getLastDetection($rfid_tag_number)->result();
		} else {
			$is_data_ada = false;
			// $data = [];
		}

        $response = array(
            'is_data_ada' => $is_data_ada
            // 'data' => $data
        );

        echo json_encode($response, JSON_PRETTY_PRINT);

    }

	public function update_status(){
		$id_temp_table = $this->input->post('id_temp_table');
		$rfid_tag_number = $this->input->post('rfid_tag_number');
		$output = $this->input->post('output');
		$room_id = $this->input->post('room_id');
		$reader_id = $this->input->post('reader_id');
		$kategori_pergerakan = $this->input->post('kategori_pergerakan');
		$keterangan_pergerakan = $this->input->post('keterangan_pergerakan');
		$lokasi_terakhir = $this->input->post('lokasi_terakhir');
		$nama_lokasi_terakhir = $this->input->post('nama_lokasi_terakhir');
		$is_legal_moving = $this->input->post('is_legal_moving');

		$is_success = $this->home->update_status($id_temp_table, $rfid_tag_number, $output, $room_id, $reader_id, $kategori_pergerakan, $keterangan_pergerakan, $lokasi_terakhir, $nama_lokasi_terakhir, $is_legal_moving);
		
		if (!$is_success) {
			$response = array('is_success' => $is_success, 'message' => 'Status has not been updated.');
		} else {
			$response = array('is_success' => $is_success, 'message' => 'Status has been updated.', 'is_legal_moving' => $is_legal_moving);
		}

		echo json_encode($response, JSON_PRETTY_PRINT);
	}

	public function get_state(){

		$filter_id_parameter = $this->uri->segment('3');
		$query = $this->home->get_state($filter_id_parameter);

		$array_variable = array();
		foreach($query->result() as $val) {
			$array_variable[] = $val->nama_variable;
		}

		echo json_encode($query->result());

		/*
		echo '<pre>';
		//print_r($array_variable);
		echo json_encode($query->result());
		echo '</pre>';
		exit;
		*/
		
	}

	public function get_state_alert(){

		$query = $this->home->get_state_alert();

		$array_variable = array();
		foreach($query->result() as $val) {
			$array_variable[] = $val->nama_variable;
		}

		echo json_encode($query->result());

		/*
		echo '<pre>';
		//print_r($array_variable);
		echo json_encode($query->result());
		echo '</pre>';
		exit;
		*/
		
	}

	public function getRunningText(){

		$query = $this->home->getRunningText();

		$array_variable = array();
		foreach($query->result() as $val) {
			$array_variable[] = $val->nama_variable;
		}

		echo json_encode($query->result());

		/*
		echo '<pre>';
		//print_r($array_variable);
		echo json_encode($query->result());
		echo '</pre>';
		exit;
		*/
		
	}

	public function getConfig(){

		$filter = $this->uri->segment('3');
		$query = $this->home->getConfig($filter)->row();

		//$array_variable = array();
		echo json_encode($query);

		/*
		echo '<pre>';
		//print_r($array_variable);
		echo json_encode($query);
		echo '</pre>';
		exit;
		*/
		
	}

	public function getList()
	{
		
		//$data['area'] = array(1 => 'ATM Down', 2 => 'SLA', 3 => 'COM Down');
		//$data['ruas'] = array(60 => 'KM 09+200 CIKUNIR 4', 65 => 'KM 11+800', 66 => 'KM 14+000', 67 => 'KM 17+000', 61 => 'KM 26+400 Cibitung', 62 => 'KM 32+200 Cikarang', 63 => 'KM 66+750 Dawuan', 64 => 'KM 72+900 Sadang');
		
		$data['area'] = array(
		    1 => 'ATM Down',
		    2 => 'SLA',
		    3 => 'COM Down'
		);
		
		$data['ruas'] = array(
		    60 => 'KM 09+200 CIKUNIR 4',
		    61 => 'KM 26+400 Cibitung'
		);
		
		$variable = $this->home->get_variable_by_id();

		$array_variable = array();
		foreach ($variable->result() as $val){
			$array_variable[$val->id_variable] = $val->nama_variable;
		}

		//$data['ruas'] = $array_variable;

		/*
		echo '<pre>';
		print_r($array_variable);
		echo '</pre>';
		exit;
		*/

		$this->load->view('home/home', $data);
	}

	public function monitoring(){
		$this->load->view('home/monitoring');
	}

	public function getListDalam()
	{
		$data['area'] = array(2 => 'DALAM KOTA', 1 => 'CIKAMPEK');
		$data['ruas'] = array(14 => 'Tebet 2', 13 => 'Kuningan 1');
		$this->load->view('home/home', $data);
	}

	public function getListHistory()
	{
		// $data['ruas'] =  array(60 => 'KM 09+200 CIKUNIR 4', 65 => 'KM 11+800', 66 => 'KM 14+000', 67 => 'KM 17+000', 61 => 'KM 26+400 Cibitung', 62 => 'KM 32+200 Cikarang', 63 => 'KM 66+750 Dawuan', 64 => 'KM 72+900 Sadang');
		$data['ruas'] = array(80 => 'KM 09+200 CIKUNIR 4', 85 => 'KM 11+800', 86 => 'KM 14+000', 87 => 'KM 17+000', 81 => 'KM 26+400 Cibitung', 82 => 'KM 32+200 Cikarang', 83 => 'KM 66+750 Dawuan', 84 => 'KM 72+900 Sadang', 14 => 'Tebet 2', 13 => 'Kuningan 1');
		$this->load->view('home/history', $data);
	}

	public function getData()
	{
		$rtms_id = $this->uri->segment(3);
		$zona = $this->uri->segment(4);
		$result = '';
		$result = $this->home->getNilai($rtms_id, $zona);
		echo $result;
	}

	public function getHistory()
	{
		$rtms_id = $this->uri->segment(3);
		$tanggal = $this->uri->segment(4);
		$result = '';
		$result = $this->home->getHistory($rtms_id, $tanggal);
		echo $result;
	}

	public function triggerOn(){
		$this->load->view('home/trigger_on');
	}
	
	public function update_flag_tts(){
		$id_content = $this->input->post('id_content');
		$is_success = $this->home->update_flag_tts($id_content);
		echo json_encode(
			array(
				'is_success' => $is_success,
				'message' => 'Text to Speech has been triggered.'
			)
		);
	}
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */