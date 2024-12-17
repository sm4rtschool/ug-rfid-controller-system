<?php

class Audio extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Audiomodel');
    }

    public function index()
    {
        $this->load->view('partials/_mydashboard_header');
        $this->load->view('audio/index');
    }

    public function serverSideDatatables()
    {
        // set column field database for datatable orderable
        $columns = array(
            0 => 'nama_audio'
        );

        // set column field database for datatable searchable
        $searchable = array(
            0 => 'nama_audio'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->Audiomodel->count_all_audio();
        $totalFiltered = $this->Audiomodel->count_audio_filtered($search, $searchable);

        if(empty($this->input->post('search')['value'])){
            $audio = $this->Audiomodel->get_datatables_audio($limit, $start, $order, $dir, $search, $searchable);
        } else {
            $search = $this->input->post('search')['value'];
            $audio = $this->Audiomodel->audio_search($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->Audiomodel->count_audio_filtered($search, $searchable);
        }
        
        $data = array();
        if(!empty($audio)) {
            $i = $start + 1;
            foreach ($audio as $row) {

                $nestedData['no_urut'] = $i;
                $i++;
                $nestedData['nama_audio'] = $row->nama_audio;
                $nestedData['is_active'] = ($row->is_active == 1) ? '<span class="label label-success" style="cursor:pointer;" onclick="update_status('.$row->id_audio.')">Active</span>' : '<span class="label label-danger" style="cursor:pointer;" onclick="update_status('.$row->id_audio.')">Inactive</span>';
                $nestedData['nama_file'] = '<a href="'.base_url('assets/audio/'.$row->nama_file).'" target="_blank">'.$row->nama_file.'</a>';
                //<button class="btn btn-warning btn-sm editBtn" data-id="'.$row->id_content.'" onClick="hitApi('.$row->id_content.')">Hit API</button>';
                $nestedData['action'] = '<button class="btn btn-sm btn-info" type="button" title="Edit" onclick="editData(' . "'" . $row->id_audio . "'" . ')">Edit</i></button>
                <button class="btn btn-sm btn-danger" onclick="deleteData(' . "'" . $row->id_audio . "'" . ')">Hapus</button>';
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

    public function change($id)
    {

        $id = $this->uri->segment(3);
        $this->Audiomodel->change_default_sound($id);
        redirect('audio');

    }

    public function store()
    {

        $nama_audio = $this->input->post('nama_audio');
        $nama_file = $this->input->post('nama_file');

        $is_exist = $this->Audiomodel->check_nama_audio($nama_audio);

        if ($is_exist) {
            $is_success = false;
            $message = "Nama audio sudah ada !!";
        } else {
            
            //$message = "Audio bisa digunakan";

            if (empty($_FILES["nama_file"]["name"])){
                $is_success = false;
                $message = "Nama File harus diisi";
            } else {

                $this->load->library('upload');

                $config['upload_path'] = './assets/audio/';
                $config['allowed_types'] = 'mp3|wav';
                $config['max_size'] = '10000';
                $config['encrypt_name'] = false;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('nama_file')) {
                    
                    $is_success = false;
                    $message = $this->upload->display_errors();

                } else {

                    $data = $this->upload->data();
                    
                    $nama_file = $data['file_name'];

                    $data = [
                        'nama_audio' => $nama_audio,
                        'is_active' => 0,
                        'nama_file' => $nama_file
                    ];

                    
                    $rowCount = $this->Audiomodel->count_all_audio();
                    
                    if ($rowCount == 0) {
                        $data['is_active'] = 1;
                    }
                    

                    $is_success = $this->Audiomodel->insert_audio($data);

                    if ($is_success) {
                        $message = "Data inserted successfully";
                    } else {
                        $message = "Failed to insert data";
                    }

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

    public function delete($id)
    {

        $id = $this->uri->segment(3);

        $audio = $this->Audiomodel->get_audio_by_id($id);

        if (!$audio) {
            $is_success = false;
            $message = "Data not found";
        }

        if ($audio->is_active == 1) {
            $is_success = false;
            $message = "Audio aktif tidak bisa di hapus";
        }

        $nama_file = $audio->nama_file;

        $file_path = './assets/audio/'.$nama_file;

        if(file_exists($file_path)) {
            unlink($file_path);
        }
        
        $deleted_rows = $this->Audiomodel->delete_audio($id);

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
        $edit_data = $this->Audiomodel->get_audio_by_id($id);
        if ($edit_data) {
            $data = [
                'id_audio' => $edit_data->id_audio,
                'nama_audio' => $edit_data->nama_audio,
                'nama_file' => $edit_data->nama_file,
                'is_active' => $edit_data->is_active
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

        $id_audio = $this->input->post('hidden_edit_id_audio');
        $edit_nama_audio = $this->input->post('edit_nama_audio');

        $hidden_edit_old_nama_audio = $this->input->post('hidden_edit_old_nama_audio');
        $edit_nama_file = $this->input->post('edit_nama_file');

        $hidden_edit_old_nama_file = $this->input->post('hidden_edit_old_nama_file');
        $catatan = "";

        if (empty($_FILES["edit_nama_file"]["name"])){
        // jika user tidak mengupload audio / tidak merubah file audio

            if ($edit_nama_audio != $hidden_edit_old_nama_audio) {
    
                $is_exist = $this->Audiomodel->check_nama_audio($edit_nama_audio);
                
                if ($is_exist) {
                    $is_success = false;
                    $message = "Nama audio sudah ada !!";
                } else {
    
                    $data = array(
                        'nama_audio' => $edit_nama_audio
                    );
    
                    $this->Audiomodel->update_audio($id_audio, $data);
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

            $catatan = "user tidak merubah audio file";

        } else { // jika user mengupload audio / rubah file audio

            if ($edit_nama_audio != $hidden_edit_old_nama_audio) {
    
                $is_exist = $this->Audiomodel->check_nama_audio($edit_nama_audio);
                
                if ($is_exist) {
                    $is_success = false;
                    $message = "Nama audio sudah ada !!";
                } else {

                    $data = array(
                        'nama_audio' => $edit_nama_audio
                    );

                    $this->Audiomodel->update_audio($id_audio, $data);
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

            $this->load->library('upload');

            $config['upload_path'] = './assets/audio/';
            $config['allowed_types'] = 'mp3|wav';
            $config['max_size'] = '10000';
            $config['overwrite'] = true;
            $config['encrypt_name'] = false;
            //$config['file_name'] = $edit_nama_file;

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('edit_nama_file')) {
                $is_success = false;
                $message = $this->upload->display_errors();
            } else {
                    
                $data_upload = $this->upload->data();
                $nama_file = $data_upload['file_name'];

                $data = array(
                    'nama_file' => $nama_file
                );
        
                $this->Audiomodel->update_audio($id_audio, $data);
        
                $is_success = $this->db->affected_rows() > 0;

                if ($is_success) {

                    $is_success = true;
                    $message = "Data updated successfully";
                
                    $file_path = './assets/audio/'.$hidden_edit_old_nama_file;
                        
                    if(file_exists($file_path)) {
                        unlink($file_path);
                    }
                    
                } else {
                    $is_success = false;
                    $message = "Failed to update data";
                }

            }

            $catatan = "user merubah audio file";

        }

        $output = array(
            "is_success" => $is_success,
            "message" => $message,
            "catatan" => $catatan
        );

        echo json_encode($output);

    }

}