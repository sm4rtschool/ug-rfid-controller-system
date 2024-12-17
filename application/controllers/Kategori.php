<?php

class Kategori extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Categoriesmodel');
    }

    public function index()
    {
        $this->load->view('partials/_mydashboard_header');
        $this->load->view('kategori/index');
    }

    public function serverSideDatatables()
    {
        // set column field database for datatable orderable
        $columns = array(
            0 => 'nama_parameter'
        );

        // set column field database for datatable searchable
        $searchable = array(
            0 => 'nama_parameter'
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->Categoriesmodel->count_all_kategori();
        $totalFiltered = $this->Categoriesmodel->count_kategori_filtered($search, $searchable);

        if(empty($this->input->post('search')['value'])){
            $kategori = $this->Categoriesmodel->get_datatables_kategori($limit, $start, $order, $dir, $search, $searchable);
        } else {
            $search = $this->input->post('search')['value'];
            $kategori = $this->Categoriesmodel->kategori_search($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->Categoriesmodel->count_kategori_filtered($search, $searchable);
        }
        
        $data = array();
        if(!empty($kategori)) {
            $i = $start + 1;
            foreach ($kategori as $row) {

                $nestedData['no_urut'] = $i;
                $i++;
                $nestedData['nama_parameter'] = $row->nama_parameter;
                // $nestedData['total_data'] = $this->fungsi->pecah($row->total_data);
                //<button class="btn btn-warning btn-sm editBtn" data-id="'.$row->id_content.'" onClick="hitApi('.$row->id_content.')">Hit API</button>';
                $nestedData['action'] = '<button class="btn btn-sm btn-info" type="button" title="Edit" onclick="editData(' . "'" . $row->id_parameter . "'" . ')">Edit</i></button>
                <button class="btn btn-sm btn-danger" onclick="deleteKategori(' . "'" . $row->id_parameter . "'" . ')">Hapus</button>';
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

        $nama_parameter = $this->input->post('nama_parameter');
        // $total_data = $this->input->post('total_data');
        // $total_data = str_replace(',', '', $total_data);
        // $total_data = str_replace('.', '', $total_data);

        $is_exist = $this->Categoriesmodel->check_nama_parameter($nama_parameter);

        if ($is_exist) {
            $is_success = false;
            $message = "Nama kategori sudah ada !!";
        } else {
            
            //$message = "Nama parameter bisa digunakan";

            $data = [
                'nama_parameter' => $nama_parameter
                // 'total_data' => $total_data
            ];

            $is_success = $this->Categoriesmodel->insert_categories($data);

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
        
        $deleted_rows = $this->Categoriesmodel->delete_categories($id);

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
        $edit_data = $this->Categoriesmodel->get_parameter($id);
        if ($edit_data) {
            $data = [
                'id_parameter' => $edit_data->id_parameter,
                'nama_parameter' => $edit_data->nama_parameter
                // 'total_data' => $edit_data->total_data
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

        $id_parameter = $this->input->post('hidden_edit_id_parameter');
        $edit_nama_parameter = $this->input->post('edit_nama_parameter');

        // $total_data = $this->input->post('edit_total_data');
        // $total_data = str_replace(',', '', $total_data);
        // $total_data = str_replace('.', '', $total_data);

        $hidden_edit_old_nama_parameter = $this->input->post('hidden_edit_old_nama_parameter');
        

        if ($edit_nama_parameter == $hidden_edit_old_nama_parameter) {

            $is_success = true;
            $message = "Data updated successfully";

        } else {

            $is_exist = $this->Categoriesmodel->check_nama_parameter($edit_nama_parameter);
            
            if ($is_exist) {
                $is_success = false;
                $message = "Kategori sudah ada !!";
            } else {

                $data = array(
                    'nama_parameter' => $edit_nama_parameter
                );

                $this->Categoriesmodel->update_categories($id_parameter, $data);
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

}