<?php

class Variable extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Variablesmodel');
    }

    public function index()
    {
        $this->load->view('partials/_mydashboard_header');
        $this->load->view('variable/index');
    }

    public function serverSideDatatables()
    {
        // set column field database for datatable orderable
        $columns = array(
            0 => 'nama_variable'
        );

        // set column field database for datatable searchable
        $searchable = array(
            0 => 'nama_variable'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->Variablesmodel->count_all_variable();
        $totalFiltered = $this->Variablesmodel->count_variable_filtered($search, $searchable);

        if(empty($this->input->post('search')['value'])){
            $variable = $this->Variablesmodel->get_datatables_variable($limit, $start, $order, $dir, $search, $searchable);
        } else {
            $search = $this->input->post('search')['value'];
            $variable = $this->Variablesmodel->variable_search($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->Variablesmodel->count_variable_filtered($search, $searchable);
        }
        
        $data = array();
        if(!empty($variable)) {
            $i = $start + 1;
            foreach ($variable as $row) {

                $nestedData['no_urut'] = $i;
                $i++;
                $nestedData['nama_parameter'] = $row->nama_parameter;
                $nestedData['nama_variable'] = $row->nama_variable;
                $nestedData['action'] = '<button class="btn btn-sm btn-info" type="button" title="Edit" onclick="editData(' . "'" . $row->id_variable . "'" . ')">Edit</i></button>
                <button class="btn btn-sm btn-danger" onclick="deleteVariable(' . "'" . $row->id_variable . "'" . ')">Hapus</button>';
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

    public function store()
    {

        $parameter_id = $this->input->post('parameter_id');
        $nama_variable = $this->input->post('nama_variable');
        
        $is_exist = $this->Variablesmodel->check_nama_variable($nama_variable);

        if ($is_exist) {
            $is_success = false;
            $message = "Nama variabel sudah ada !!";
        } else {
            
            //$message = "Nama variable bisa digunakan";

            $data = [
                'parameter_id' => $parameter_id,
                'nama_variable' => $nama_variable
            ];

            $is_success = $this->Variablesmodel->insert_variable($data);

            if ($is_success) {
                $message = "Data inserted successfully";
            } else {
                $message = "Failed to insert data";
            }

        }

        $output = array(
            "is_success" => $is_success,
            "message" => $message
        );

        //output to json format
        echo json_encode($output);
    }

    public function delete($id)
    {

        $id = $this->uri->segment(3);
        
        $deleted_rows = $this->Variablesmodel->delete_variable($id);

        if ($deleted_rows > 0) {
            $is_success = true;
            $message = "Data deleted successfully";
        } else {
            $is_success = false;
            $message = "Failed to delete data";
        }

        $output = array(
            "is_success" => $is_success,
            "message" => $message
        );

        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $id = $this->uri->segment(3);
        $edit_data = $this->Variablesmodel->get_variable_by_id($id);
        if ($edit_data) {
            $data = [
                'parameter_id' => $edit_data->parameter_id,
                'id_variable' => $edit_data->id_variable,
                'nama_variable' => $edit_data->nama_variable
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

    public function update()
    {

        $id_variable = $this->input->post('hidden_edit_id_variable');
        $id_parameter = $this->input->post('edit_parameter_id');
        $edit_nama_variable = $this->input->post('edit_nama_variable');

        $hidden_edit_old_nama_variable = $this->input->post('hidden_edit_old_nama_variable');

        if ($edit_nama_variable == $hidden_edit_old_nama_variable) {

        } else {

            $is_exist = $this->Variablesmodel->check_nama_variable($edit_nama_variable);
            
            if ($is_exist) {
                $is_success = false;
                $message = "Variabel sudah ada !!";
            } else {

                $data = array(
                    'nama_variable' => $edit_nama_variable
                );

                $this->Variablesmodel->update_variable($id_variable, $data);
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

    function load_dropdown_parameter()
	{

		if ($this->Variablesmodel->getParameter()->num_rows() > 0){
			$is_data_ada = TRUE;
			$list_data = $this->Variablesmodel->getParameter()->result_array();
		} else {
			$is_data_ada = FALSE;
		}

		$ddata = array();

		foreach ($list_data as $qryget) 
		{

			$row = array();

			$row['id_parameter'] = $qryget['id_parameter'];
			$row['nama_parameter'] = $qryget['nama_parameter'];
			$ddata[] = $row;
		
		}

		$output = array(
			"is_data_ada" => $is_data_ada,
			"list_data" => $ddata,
		);
		
		//output to json format
		echo json_encode($output);
		
	}

}