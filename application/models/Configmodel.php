<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getConfig($id_config = null) {
        if ($id_config != null) {
            $this->db->where('id_config', $id_config);
        }
        return $this->db->get('config');
    }

    public function insertConfig($data) {
        $this->db->insert('config', $data);
    }

    public function updateConfig($id_config, $data) {
        $this->db->where('id_config', $id_config);
        $this->db->update('config', $data);
        return $this->db->affected_rows();
    }

    public function deleteConfig($id_config) {
        $this->db->where('id_config', $id_config);
        $this->db->delete('config');
    }

    public function count_config_filtered($search, $searchable) {
        $this->db->like($searchable, $search);
        return $this->db->get('config')->num_rows();
    }

    public function get_datatables_config($limit, $start, $order, $dir, $search, $searchable) {
        $this->db->limit($limit, $start);
        $order_column = $this->db->list_fields('config');

        $column = $order_column[$order];
        $this->db->order_by($column, $dir);

        if ($search != '') {
            $this->db->like($searchable, $search);
        }

        $this->db->select('*');
        $this->db->from('config');
        
        $query = $this->db->get();
        return $query->result();
    }

    public function count_all_config() {
        return $this->db->count_all('config');
    }

    public function config_search($limit, $start, $search, $order, $dir) {
        $this->db->like('config_name', $search);
        $this->db->limit($limit, $start);
        $this->db->order_by($order, $dir);
        return $this->db->get('config')->result();
    }

    public function getConfigById($id_config) {
        $this->db->where('id_config', $id_config);
        return $this->db->get('config')->row();
    }

    public function check_config_name($config_name) {
        $this->db->where('config_name', $config_name);
        return $this->db->get('config')->num_rows() > 0;
    }

    public function isSystemOn() {
        $query = $this->db->get('pengaturan_sistem');
        return $query;
    }

    public function updateToggleSwitch($value){
        $qryExec = $this->db->update('pengaturan_sistem', array('is_system_on' => $value));
        return $qryExec;
    }

}