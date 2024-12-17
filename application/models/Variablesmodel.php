<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Variablesmodel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_datatables_variable($limit, $start, $order, $dir, $search, $searchable)
    {
        $this->db->limit($limit, $start);
        
        $this->db->order_by($order, $dir);

        //$this->db->like($searchable[0], $search);
        $this->db->select('*');
        $this->db->from('parameter a');
        $this->db->join('variable b', 'b.parameter_id = a.id_parameter');
        //$this->db->where('a.id_parameter', $search);
        return $this->db->get()->result();
        echo $this->db->last_query();
    }

    public function variable_search($limit, $start, $search, $order, $dir){
        $this->db->limit($limit, $start);
        $this->db->like('b.nama_variable', $search);
        $this->db->order_by($order, $dir);
        $this->db->select('*');
        $this->db->from('parameter a');
        $this->db->join('variable b', 'b.parameter_id = a.id_parameter');

        $query = $this->db->get();
        return $query->result();
    }

    public function get_variable()
    {
        $query = $this->db->get('variable');
        return $query->result();
    }

    public function insert_variable($data)
    {
        return $this->db->insert('variable', $data);
        //return $this->db->insert_id();
    }

    public function update_variable($id, $data)
    {
        $this->db->where('id_variable', $id);
        $this->db->update('variable', $data);
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }

    public function delete_variable($id)
    {
        $this->db->where('id_variable', $id);
        $this->db->delete('variable');
        return $this->db->affected_rows();
    }

    public function count_all_variable()
    {
        return $this->db->count_all('variable');
    }

    public function count_variable_filtered($search, $searchable)
    {
        $this->db->like($searchable[0], $search);
        return $this->db->count_all_results('variable');
    }

    public function check_nama_variable($nama_variable)
    {
        $is_exist = $this->db->where('nama_variable', $nama_variable)->get('variable')->num_rows();
        return $is_exist;
    }

    /*
    public function get_variable_by_id($id)
    {

        if ($id != '') {
            // Add your logic here for when $id is null
            $this->db->where('id_variable', $id);
        }

        $query = $this->db->get('variable');
        return $query->row();

    }
    */

    public function getParameter(){
        $query = $this->db->get('parameter');
        $this->db->order_by('nama_parameter', 'ASC');
        return $query;
    }

    public function get_variable_by_id($id_variable){

        $this->db->select('*');
        $this->db->from('parameter a');
        $this->db->join('variable b', 'b.parameter_id = a.id_parameter');
        $this->db->where('b.id_variable', $id_variable);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();

    }

}