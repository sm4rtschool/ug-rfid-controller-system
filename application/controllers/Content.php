<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Content Controller
*
*	@author Ridwan Sapoetra | sm4rtschool@gmail.com | 082113332009
*
*/

class Content extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Contentmodel');
        $this->load->model('Homemodel', 'home');
    }

    public function index()
    {

        // Add your create logic here

        $parameter = $this->home->get_parameter();

		$array_parameter = array();
		foreach ($parameter as $val){
			$array_parameter[$val->id] = $val->kategori;
		}
		
		$data['kategori'] = $array_parameter;

        // load data sound

        $qryGetSound = $this->Contentmodel->getSoundToPlay()->result();
        $data['sound'] = $qryGetSound;

        // Load the form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('parameter_id', 'Parameter', 'required');
        $this->form_validation->set_rules('variable_id', 'Variable', 'required');
        $this->form_validation->set_rules('is_parameter_active', 'Is Parameter Active', 'required');

        //$data['contents'] = $this->Contentmodel->select_content();
        $this->load->view('partials/_mydashboard_header', $data);
        $this->load->view('content/index', $data);
        //$this->load->view('partials/_mydashboard_footer');
        
    }

    public function serverSideData()
    {
        //$this->load->model('Contentmodel');
        $columns = array(
            0 => 'a.id_temp_table',
            1 => 'a.id_temp_table',
            2 => 'kode_aset',
            3 => 'nup',
            4 => 'nama_aset',
            5 => 'room_name',
            6 => 'reader_gate',
            7 => 'reader_angle',
            8 => 'waktu',
            9 => 'Action'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $filter_id_parameter = $this->input->post('filter_id_parameter');

        $totalData = $this->Contentmodel->count_all_content($filter_id_parameter);
        $totalFiltered = $totalData;

        if(empty($this->input->post('search')['value'])) {
            $contents = $this->Contentmodel->get_content($limit, $start, $order, $dir, $filter_id_parameter);
        } else {
            $search = $this->input->post('search')['value'];
            $contents =  $this->Contentmodel->content_search($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->Contentmodel->content_search_count($search);
        }

        $data = array();
        if(!empty($contents)) {
            $autoNumber = $start + 1;
            foreach($contents as $row) {

                $kategori_pergerakan = ($row->kategori_pergerakan == 'normal' ? '<span style="color:green;">Normal</span>' : '<span style="color:red;">Anomali</span>');

                $nestedData['No'] = $autoNumber;
                $autoNumber++;
                $nestedData['ID Content'] = $row->id_temp_table;
                $nestedData['lokasi_sebelumnya'] = $row->nama_lokasi_terakhir;
                $nestedData['Ruangan'] = $row->room_name;
                $nestedData['reader_gate'] = $row->reader_gate;
                $nestedData['reader_angle'] = $row->reader_angle;
                $nestedData['waktu'] = $row->waktu;
                $nestedData['rfid_tag_number'] = $row->rfid_tag_number;
                $nestedData['Kode Brg'] = $row->kode_aset;
                $nestedData['NUP'] = $row->nup;
                $nestedData['Nama Brg'] = $row->nama_aset;
                // $nestedData['kategori_pergerakan'] = $kategori_pergerakan;

                // $is_legal_moving = ($row->is_legal_moving == 1 ? '<span style="color:green;">Legal</span>' : '<span style="color:red;">Illegal</span>');
                // $nestedData['is_legal_moving'] = $is_legal_moving;

                // $nestedData['keterangan_pergerakan'] = $row->keterangan_pergerakan;
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

    public function serverSideDataAset()
    {
        //$this->load->model('Contentmodel');
        $columns = array(
            0 => 'id_aset',
            1 => 'nama_aset',
            2 => 'kode_tid',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $filter_id_parameter = $this->input->post('filter_id_parameter');

        $totalData = $this->Contentmodel->count_all_aset();
        $totalFiltered = $totalData;

        if(empty($this->input->post('search')['value'])) {
            $contents = $this->Contentmodel->get_aset($limit, $start, $order, $dir, $filter_id_parameter);
        } else {
            $search = $this->input->post('search')['value'];
            $contents =  $this->Contentmodel->content_search_aset($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->Contentmodel->content_search_count_aset($search);
        }

        $data = array();
        if(!empty($contents)) {
            $autoNumber = $start + 1;
            foreach($contents as $row) {

                // $nestedData['no'] = $autoNumber;
                $autoNumber++;
                $nestedData['id_aset'] = $row->id_aset;
                $nestedData['nama_aset'] = $row->nama_aset;
                $nestedData['kode_tid'] = $row->kode_tid;

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
        
        // Add your store logic here
        $room_id = $this->input->post('ruangan_id');
        $room_name = $this->input->post('room_name');

        $reader_id = $this->input->post('reader_id');
        $reader_antena = $this->input->post('reader_antena');
        $reader_angle = $this->input->post('reader_angle');
        $reader_gate = $this->input->post('reader_gate');
        $rfid_tag_number = $this->input->post('rfid_tag_number');
        $is_legal_moving = $this->input->post('tipe_moving');

        $data = [
            'lokasi_terakhir_id' => $room_id,
            'nama_lokasi_terakhir' => $room_name,
            'room_id' => $room_id,
            'room_name' => $room_name,
            'reader_id' => $reader_id,
            'reader_antena' => $reader_antena,
            'reader_angle' => $reader_angle,
            'reader_gate' => $reader_gate,
            'rfid_tag_number' => $rfid_tag_number,
            'is_legal_moving' => $is_legal_moving
        ];

        // Save the data to the database
        $is_success = $this->Contentmodel->insert_content($data);

        if ($is_success) {
            $message = "Data inserted successfully";
        } else {
            $message = "Failed to insert data";
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
        // Add your edit logic here
        // Retrieve data from the database based on the provided ID
        $edit_data = $this->Contentmodel->getContentById($id);

        // Check if data is found
        if ($edit_data) {

            $data = [
                'id_content' => $edit_data->id_content,
                'parameter_id' => $edit_data->parameter_id,
                'variable_id' => $edit_data->variable_id,
                'is_parameter_active' => $edit_data->is_parameter_active,
                'free_text_tts' => $edit_data->free_text_tts
            ];

            // Prepare the response
            $response = [
                'is_success' => true,
                'message' => 'Data retrieved successfully',
                'data' => $data
            ];

        } else {
            // Data not found
            $response = [
                'is_success' => false,
                'message' => 'Data not found'
            ];
        }

        // Output the response in JSON format
        echo json_encode($response);
    }

    public function update()
    {

        // Add your update logic here

        $hidden_id_content = $this->input->post('hidden_id_content');

        $parameter_id = $this->input->post('edit_parameter_id');
        $variable_id = $this->input->post('edit_variable_id');
        $old_variable_id = $this->input->post('old_variable_id');

        $is_parameter_active = $this->input->post('edit_is_parameter_active');

        $light_active = $this->input->post('edit_light_active');
        $sound_active = $this->input->post('edit_sound_active');
        $text_to_speech_active = $this->input->post('edit_text_to_speech_active');

        $is_light_strobe_active = $this->input->post('edit_is_light_strobe_active');
        
        $free_text_tts = $this->input->post('edit_free_text_tts');

        if ($old_variable_id == $variable_id) {

            $data = array(
                'is_parameter_active' => $is_parameter_active,
                'free_text_tts' => $free_text_tts
            );
            
        } else {

            // klo variablenya di rubah sama user

            $data = array(
                'is_parameter_active' => $is_parameter_active,
                'free_text_tts' => $free_text_tts
            );

        }

        // Update the data in the database
        $is_success = $this->Contentmodel->update_content($hidden_id_content, $data);

        if ($is_success) {
            $message = "Data updated successfully";
        } else {
            $message = "Failed to update data";
        }

        $output = array(
            "is_success" => $is_success,
            "message" => $message
        );

        // Output the response in JSON format
        echo json_encode($output);
        
    }

    public function delete($id)
    {
        // Add your delete logic here
        // Retrieve the id from the URL
        $id = $this->uri->segment(3);

        // Call the delete_content method from the model to delete the content
        $deleted_rows = $this->Contentmodel->delete_content($id);

        // Check if the deletion was successful
        if ($deleted_rows > 0) {
            $is_success = true;
            $message = "Data deleted successfully";
        } else {
            $is_success = false;
            $message = "Failed to delete data";
        }

        // Prepare the output in JSON format
        $output = array(
            "is_success" => $is_success,
            "message" => $message
        );

        // Return the output as JSON
        echo json_encode($output);
    }

    function load_dropdown_aset()
	{

		if ($this->Contentmodel->getAset('')->num_rows() > 0){
			$is_data_ada = TRUE;
			$list_data = $this->Contentmodel->getAset('')->result_array();
		} else {
			$is_data_ada = FALSE;
		}

		$ddata = array();

		foreach ($list_data as $qryget) 
		{

			$row = array();

			$row['id_aset'] = $qryget['id_aset'];
			$row['nama_aset'] = $qryget['nama_aset'];
			$ddata[] = $row;
		
		}

		$output = array(
			"is_data_ada" => $is_data_ada,
			"list_data" => $ddata,
		);
		
		//output to json format
		echo json_encode($output);
		
	}

    function load_dropdown_ruangan()
	{

		if ($this->Contentmodel->getRuangan('')->num_rows() > 0){
			$is_data_ada = TRUE;
			$list_data = $this->Contentmodel->getRuangan('')->result_array();
		} else {
			$is_data_ada = FALSE;
		}

		$ddata = array();

		foreach ($list_data as $qryget) 
		{

			$row = array();

			$row['id'] = $qryget['id'];
			$row['ruangan'] = $qryget['ruangan'];
			$ddata[] = $row;
		
		}

		$output = array(
			"is_data_ada" => $is_data_ada,
			"list_data" => $ddata,
		);
		
		//output to json format
		echo json_encode($output);
		
	}

    function load_dropdown_reader()
	{
		
		$id_ruangan = $this->input->post('id_ruangan', true);

		if ($this->Contentmodel->getReader($id_ruangan, '')->num_rows() > 0){
			$is_data_ada = TRUE;
			$list_data = $this->Contentmodel->getReader($id_ruangan, '')->result_array();
		} else {
			$is_data_ada = FALSE;
		}

		$ddata = array();

		foreach ($list_data as $qryget) 
		{

			$row = array();

			$row['reader_id'] = $qryget['reader_id'];
			$row['reader_name'] = $qryget['reader_name'];
			$ddata[] = $row;
		
		}

		$output = array(
			"is_data_ada" => $is_data_ada,
			"list_data" => $ddata,
		);
		
		//output to json format
		echo json_encode($output);
		
	}

    function arduino_get_content(){

        $query = $this->Contentmodel->arduino_get_content();

        if ($query){

            $output = array(
                "is_success" => true,
                "data_state" => "available"
            );

        } else {
            $output = array(
                "is_success" => false,
                "data_state" => "not available"
            );
        }
        
        echo json_encode($output);

    }

    function load_dropdown_sound()
	{

		if ($this->Contentmodel->getSound()->num_rows() > 0){
			$is_data_ada = TRUE;
			$list_data = $this->Contentmodel->getSound()->result_array();
		} else {
			$is_data_ada = FALSE;
		}

		$ddata = array();

		foreach ($list_data as $qryget) 
		{

			$row = array();

			$row['id_sound'] = $qryget['id_sound'];
			$row['nama_sound'] = $qryget['nama_sound'];
			$ddata[] = $row;
		
		}

		$output = array(
			"is_data_ada" => $is_data_ada,
			"list_data" => $ddata,
		);
		
		//output to json format
		echo json_encode($output);
		
	}

    public function getSoundById()
    {
        $id_sound = $this->uri->segment(3);
        $data = $this->Contentmodel->getSoundById($id_sound)->row();

        if ($data) {

            $output = array(
                'id_sound' => $data->id_sound,
                'nama_sound' => $data->nama_sound,
                'nama_file' => $data->nama_file,
                'html_id' => $data->html_id,
                'is_tts' => $data->is_tts,
                'text_tts' => $data->text_tts
            );

        } else {

            $output = array(
                'id_sound' => 0,
                'nama_sound' => '',
                'nama_file' => '',
                'html_id' => '',
                'is_tts' => 0,
                'text_tts' => ''
            );

        }

        echo json_encode($output);

    }

    public function resetData()
    {

        $this->Contentmodel->resetData();

        if ($this->db->affected_rows() > 0) {
            $is_success = true;
            $message = 'Data has been reset successfully';
        } else {
            $message = 'Failed to reset data';
            $is_success = false;
        }

        $response = array(
            'is_success' => $is_success,
            'message' => $message
        );

        echo json_encode($response);

    }

    function playSound()
    {
        $this->load->view('content/play_sound');
    }

    function getRuanganById()
    {
        $ruangan_id = $this->uri->segment(3);
        $data = $this->Contentmodel->getRuanganById($ruangan_id)->row();

        if ($data) {
            $output = array(
                'ruangan_id' => $data->id,
                'ruangan' => $data->ruangan            
            );
        }

        echo json_encode($output);
    }

    function getReaderById()
    {
        $reader_id = $this->uri->segment(3);
        $data = $this->Contentmodel->getReaderById($reader_id)->row();

        if ($data) {
            $output = array(
                'reader_id' => $data->reader_id,
                'reader_name' => $data->reader_name,
                'reader_antena' => $data->reader_antena,
                'reader_angle' => $data->reader_angle,
                'reader_gate' => $data->reader_gate,
            );
        }

        echo json_encode($output);
    }

    function getAsetById()
    {
        $id_aset = $this->uri->segment(3);
        $data = $this->Contentmodel->getAsetById($id_aset)->row();

        if ($data) {
            $output = array(
                'id_aset' => $data->id_aset,
                'rfid_tag_number' => $data->kode_tid,            
            );
        }

        echo json_encode($output);
    }

    function setStateAll()
	{
		
		$id = $this->input->post('id');
        $state = $this->input->post('state');
		$is_success = $this->Contentmodel->setStateAll($id, $state);

		if ($is_success){
			$status = "success";
			$msg = "Data successfully processed !!";
			$data_notif = "Data berhasil di proses !!";
		}
		else {						
			$status = "error";
			$msg = "Something went wrong when processing the data, please try again.";
			$data_notif = "Data gagal di proses !!";
		}	
	
		echo json_encode(array('status' => $status, 'msg' => $msg, 'data_notif' => $data_notif));

	}

    public function change($id, $value)
    {
        $id = $this->uri->segment(3);
        $value = $this->uri->segment(4);
        $is_success = $this->Contentmodel->change_status_content($id, $value);
        
        if ($is_success){
            $status = "success";
            $msg = "Data successfully processed !!";
            $data_notif = "Data berhasil di proses !!";
        }
        else {                        
            $status = "error";
            $msg = "Something went wrong when processing the data, please try again.";
            $data_notif = "Data gagal di proses !!";
        }
        redirect('content');
    }

}