<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contentmodel extends CI_Model {

    public function select_content(){
        $this->db->select('*');
        $this->db->from('content');
        $query = $this->db->get();
        return $query->result();
    }

    public function insert_content($data){
        return $this->db->insert('content', $data);
    }

    public function update_content($id, $data){
        $this->db->where('id_content', $id);
        $success = $this->db->update('content', $data);
        //echo $this->db->last_query();
        return $success;
    }

    public function update_hitapi($id, $data){
        $this->db->where('id_content', $id);
        $this->db->update('content', $data);
        //echo $this->db->last_query();
        return $this->db->affected_rows();
    }

    public function delete_content($id){
        $this->db->where('id_content', $id);
        $this->db->delete('content');
        return $this->db->affected_rows();
    }

    public function count_all_content($filter_id_parameter){

        // if ($filter_id_parameter != '0') {
        //     $this->db->where('parameter_id', $filter_id_parameter);
        // }

        $this->db->select('a.*, b.kode_aset, b.nup, b.nama_aset');
        $this->db->from('tag_temp_table a');
        $this->db->join('tb_master_aset b', 'a.rfid_tag_number = b.kode_tid');
        return $this->db->count_all_results();
        
    }

    public function get_content($limit, $start, $order, $dir, $filter_id_parameter){

        $this->db->select('a.*, b.kode_aset, b.nup, b.nama_aset');
        $this->db->from('tag_temp_table a');
        $this->db->join('tb_master_aset b', 'a.rfid_tag_number = b.kode_tid');
        $this->db->order_by($order, $dir);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();

    }

    public function content_search($limit, $start, $search, $order, $dir){
        $this->db->limit($limit, $start);
        $this->db->like('b.nama_aset', $search);
        $this->db->or_like('b.kode_aset', $search);
        $this->db->order_by($order, $dir);
        $this->db->select('a.*, b.kode_aset, b.nup, b.nama_aset');
        $this->db->from('tag_temp_table a');
        $this->db->join('tb_master_aset b', 'a.rfid_tag_number = b.kode_tid');
        $query = $this->db->get();
        return $query->result();
    }

    public function content_search_count($search){
        $this->db->select('a.*, b.kode_aset, b.nup, b.nama_aset');
        $this->db->from('tag_temp_table a');
        $this->db->join('tb_master_aset b', 'a.rfid_tag_number = b.kode_tid');
        $this->db->like('b.nama_aset', $search);
        $this->db->or_like('b.kode_aset', $search);
        return $this->db->count_all_results();
    }
    
    public function getParameter($id){

        if ($id != '') {
            // Add your logic here for when $id is null
            $this->db->where('id_parameter', $id);
        }

        $query = $this->db->get('parameter');
        $this->db->order_by('nama_parameter', 'ASC');

        return $query;
    }

    public function getVariable($id_parameter, $id_variable){

        if ($id_parameter != '') {
            $this->db->where('parameter_id', $id_parameter);
        }

        if ($id_variable != '') {
            $this->db->where('id_variable', $id_variable);
        }

        $query = $this->db->get('variable');
        $this->db->order_by('nama_variable', 'ASC');

        return $query;
    }

    public function getContentById($id){
        $this->db->select('b.nama_parameter, c.nama_variable, a.*');
        $this->db->from('content a');
        $this->db->join('parameter b', 'b.id_parameter = a.parameter_id');
        $this->db->join('variable c', 'c.id_variable = a.variable_id');
        $this->db->where('id_content', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function arduino_get_content(){
        
        $ssql = "select b.nama_parameter, c.nama_variable, a.* 
                from content a 
                join parameter b on b.id_parameter = a.parameter_id
                join variable c on c.id_variable = a.variable_id
                order by a.state >= a.threshold_state_qty_active desc";

        $query = $this->db->query($ssql);
		//echo $this->db->last_query();

        return $query->result();
        
    }

    public function getSound(){
        $this->db->where('is_active', 1);
        return $this->db->get('sound');
    }

    public function getSoundById($id_sound)
    {
        $this->db->where('id_sound', $id_sound);
        $this->db->where('is_active', 1);
        $query = $this->db->get('sound');
        return $query;
    }

    public function getSoundToPlay(){
        $this->db->where('is_tts', 0);
        $this->db->where('is_active', 1);
        return $this->db->get('sound');
    }

    public function addFormTest($parameter_id, $variable_id, $state){

        $ssql = "update content set state = '$state' 
                where parameter_id = $parameter_id AND variable_id = $variable_id";

        $query = $this->db->query($ssql);
        return $query;
        
    }

    public function resetData(){
        $this->db->where('1', '1');
        return $this->db->delete('content_demo');
    }

    public function getFormTest($parameter_id, $variable_id){
        $this->db->where('parameter_id', $parameter_id);
        $this->db->where('variable_id', $variable_id);
        $this->db->where('is_parameter_active', 1);
        return $this->db->get('content');
    }

    public function getParameterById($id_parameter){
        $this->db->where('id_parameter', $id_parameter);
        return $this->db->get('parameter');
    }

    public function getParameterVariable($parameter_id, $variable_id){
        $this->db->where('parameter_id', $parameter_id);
        $this->db->where('variable_id', $variable_id);
        // $this->db->where('relation_key', $relation_key);
        return $this->db->get('content');
    }

    public function setStateAll($id, $state)
	{

		$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 
	
		$kode = explode("~",$id);
		$sid = implode(',', array_map('intval', $kode));
		//echo $sid;

		//$ssql = "delete from content where id_content in ($sid)";
		//$this->db->query($ssql);

        $this->db->set('state', $state);
        $this->db->where_in('id_content', $kode);
        $this->db->update('content');
		
		$this->db->trans_complete(); # Completing transaction

		/*Optional*/

		if ($this->db->trans_status() === FALSE) {
			# Something went wrong.    			
			$this->db->trans_rollback();
    		return FALSE;
		} 
		else {
    		# Everything is Perfect. 
    		# Committing data to the database.
			$this->db->trans_commit();
			//echo $ssql;
    		return TRUE;
		}

	}

    public function change_status_content($id, $value)
    {
        $this->db->where('id_content', $id);
        $success = $this->db->update('content', array('is_parameter_active' => $value));
        return $success;
    }

}