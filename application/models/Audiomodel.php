<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audiomodel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_datatables_audio($limit, $start, $order, $dir, $search, $searchable)
    {
        $this->db->limit($limit, $start);
        $this->db->order_by($order, $dir);
        //$this->db->like($searchable[0], $search);
        return $this->db->get('audio')->result();
        //echo $this->db->last_query();
    }

    public function audio_search($limit, $start, $search, $order, $dir){
        $this->db->limit($limit, $start);
        $this->db->like('nama_audio', $search);
        $this->db->order_by($order, $dir);
        $this->db->select('*');
        $this->db->from('audio');

        $query = $this->db->get();
        return $query->result();
    }

    public function get_audio()
    {
        $query = $this->db->get('audio');
        return $query->result();
    }

    public function insert_audio($data)
    {
        return $this->db->insert('audio', $data);
        //return $this->db->insert_id();
    }

    public function update_audio($id, $data)
    {
        $this->db->where('id_audio', $id);
        $this->db->update('audio', $data);
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }

    public function delete_audio($id)
    {
        $this->db->where('id_audio', $id);
        $this->db->delete('audio');
        return $this->db->affected_rows();
    }

    public function count_all_audio()
    {
        return $this->db->count_all('audio');
    }

    public function count_audio_filtered($search, $searchable)
    {
        $this->db->like($searchable[0], $search);
        return $this->db->count_all_results('audio');
    }

    public function check_nama_audio($nama_audio)
    {
        $is_exist = $this->db->where('nama_audio', $nama_audio)->get('audio')->num_rows();
        return $is_exist;
    }

    public function get_audio_by_id($id)
    {

        if ($id != '') {
            // Add your logic here for when $id is null
            $this->db->where('id_audio', $id);
        }

        $query = $this->db->get('audio');
        return $query->row();

    }

    public function change_default_sound($id)
    {
        $data = array(
            'is_active' => '0'
        );

        $this->db->where('is_active', '1');
        $this->db->update('audio', $data);
        
        $data = array(
            'is_active' => '1'
        );

        $this->db->where('id_audio', $id);
        $this->db->update('audio', $data);
        
        return $this->db->affected_rows();
    }

}