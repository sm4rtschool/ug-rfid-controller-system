<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Configmodel');
    }

    public function index()
    {
        $data['config'] = $this->Configmodel->getConfig();
        $this->load->view('partials/_mydashboard_header');
        $this->load->view('config/index', $data);
    }

    public function serverSideDatatables()
    {
        // set column field database for datatable orderable
        $columns = array(
            0 => 'config_name',
        );

        // set column field database for datatable searchable
        $searchable = array(
            0 => 'config_name'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->Configmodel->count_all_config();
        $totalFiltered = $this->Configmodel->count_config_filtered($search, $searchable);

        if(empty($this->input->post('search')['value'])){
            $config = $this->Configmodel->get_datatables_config($limit, $start, $order, $dir, $search, $searchable);
        } else {
            $search = $this->input->post('search')['value'];
            $config = $this->Configmodel->config_search($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->Configmodel->count_config_filtered($search, $searchable);
        }
        
        $data = array();
        if(!empty($config)) {
            $i = $start + 1;
            foreach ($config as $row) {

                $nestedData['no_urut'] = $i;
                $i++;
                $nestedData['config_name'] = $row->config_name;
                $nestedData['variable'] = $row->variable;
                $nestedData['value'] = $this->fungsi->pecah($row->value);
                $nestedData['owner'] = $row->owner;
                $nestedData['keterangan'] = $row->keterangan;
                $nestedData['action'] = '<button class="btn btn-sm btn-info" type="button" title="Edit" onclick="editData(' . "'" . $row->id_config . "'" . ')">Edit</i></button>';
                $data[] = $nestedData;

            }

        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function create(){
        $this->load->view('config/create');
    }

    public function store(){
        $config = $this->input->post();
        $this->Configmodel->insertConfig($config);
        redirect('config');
    }

    public function edit($id){

        $id = $this->uri->segment(3);
        $edit_data = $this->Configmodel->getConfigById($id);

        if ($edit_data) {

            $data = [
                'id_config' => $edit_data->id_config,
                'config_name' => $edit_data->config_name,
                'variable' => $edit_data->variable,
                'value' => $this->fungsi->pecah($edit_data->value)
            ];

            $output = array(
                "is_success" => true,
                'message' => 'Data retrieved successfully',
                "data" => $data
            );

        } else {

            $output = array(
                "is_success" => false,
                'message' => 'Data not found',
                "data" => $data
            );

        }

        echo json_encode($output);

    }

    public function update(){
        
        $id_config = $this->input->post('hidden_edit_id_config');
        $edit_config_name = $this->input->post('edit_config_name');
        $variable = $this->input->post('edit_variable');

        $value = $this->input->post('edit_value');
        $value = str_replace(',', '', $value);
        $value = str_replace('.', '', $value);

        $hidden_edit_old_config_name = $this->input->post('hidden_edit_old_config_name');

        if ($edit_config_name == $hidden_edit_old_config_name) {

            $data = array(
                'variable' => $variable,
                'value' => $value
            );

            $this->Configmodel->updateConfig($id_config, $data);
            $is_success = $this->db->affected_rows() > 0;

            if ($is_success) {
                $message = "Data updated successfully";
            } else {
                $message = "Failed to update data";
            }

        } else {

            $is_exist = $this->Configmodel->check_config_name($edit_config_name);
            
            if ($is_exist) {
                $is_success = false;
                $message = "Config name sudah ada !!";
            } else {

                $data = array(
                    'config_name' => $edit_config_name,
                    'variable' => $variable,
                    'value' => $value
                );

                $this->Configmodel->updateConfig($id_config, $data);
                $is_success = $this->db->affected_rows() > 0;

                if ($is_success) {
                    $is_success = true;
                    $message = "Data updated successfully";
                } else {
                    $is_success = false;
                    $message = "Failed to update data";
                }

            }

        }

        $output = array(
            "is_success" => $is_success,
            "message" => $message
        );

        //output to json format
        echo json_encode($output);

    }

    public function delete($id){
        $this->Configmodel->deleteConfig($id);
        redirect('config');
    }

    public function isSystemOn(){
        $isSystemOn = $this->Configmodel->isSystemOn()->row()->is_system_on;
        echo $isSystemOn;
    }

    public function updateToggleSwitch(){

        $value = $this->uri->segment(3);
        $is_success = $this->Configmodel->updateToggleSwitch($value);

        if ($is_success) {
            $message = "Data updated successfully";
        } else {
            $message = "Failed to update data";
        }

        $output = array(
            "is_success" => $is_success,
            "message" => $message
        );

        //output to json format
        echo json_encode($output);

    }

}


