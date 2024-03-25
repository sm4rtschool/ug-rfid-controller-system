<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoriesmodel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_datatables_kategori($limit, $start, $order, $dir, $search, $searchable)
    {
        $this->db->limit($limit, $start);
        $this->db->order_by($order, $dir);
        //$this->db->like($searchable[0], $search);
        return $this->db->get('parameter')->result();
        //echo $this->db->last_query();
    }

    public function kategori_search($limit, $start, $search, $order, $dir){
        $this->db->limit($limit, $start);
        $this->db->like('nama_parameter', $search);
        $this->db->order_by($order, $dir);
        $this->db->select('*');
        $this->db->from('parameter');

        $query = $this->db->get();
        return $query->result();
    }

    public function get_categories()
    {
        $query = $this->db->get('parameter');
        return $query->result();
    }

    public function insert_categories($data)
    {
        return $this->db->insert('parameter', $data);
        //return $this->db->insert_id();
    }

    public function update_categories($id, $data)
    {
        $this->db->where('id_parameter', $id);
        $this->db->update('parameter', $data);
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }

    public function delete_categories($id)
    {
        $this->db->where('id_parameter', $id);
        $this->db->delete('parameter');
        return $this->db->affected_rows();
    }

    public function count_all_kategori()
    {
        return $this->db->count_all('parameter');
    }

    public function count_kategori_filtered($search, $searchable)
    {
        $this->db->like($searchable[0], $search);
        return $this->db->count_all_results('parameter');
    }

    public function check_nama_parameter($nama_parameter)
    {
        $is_exist = $this->db->where('nama_parameter', $nama_parameter)->get('parameter')->num_rows();
        return $is_exist;
    }

    public function get_parameter($id)
    {

        if ($id != '') {
            // Add your logic here for when $id is null
            $this->db->where('id_parameter', $id);
        }

        $query = $this->db->get('parameter');
        return $query->row();

    }

}