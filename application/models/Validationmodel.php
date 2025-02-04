<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Validationmodel extends CI_Model
{
  
  private $CI;
  
  public function __construct()
  {
    parent::__construct();
  }
  
  function getReaderInfoByAliasAntenna($alias_antenna)
  {
    $this->db->select('tr.reader_id, tr.room_id, tr.reader_name, tr.setfor, tr.reader_serialnumber, tr.reader_type, tr.reader_ip, tr.reader_port, tr.reader_com, tr.reader_baudrate, tr.reader_power, tr.reader_interval, tr.reader_mode, tr.reader_updatedby, tr.reader_updated, tr.reader_createdby, tr.reader_created, tr.reader_family, tr.connecting, tr.reader_model, tr.reader_identity, tr.reader_antena, tr.reader_angle, tr.reader_gate, tr.alias_antenna');
    $this->db->select('tb_master_ruangan.id as id_room, tb_master_ruangan.id_area, tb_master_ruangan.id_gedung, tb_master_ruangan.ruangan');
    $this->db->from('tag_reader tr');
    $this->db->join('tb_master_ruangan', 'tr.room_id = tb_master_ruangan.id', 'left');
    $this->db->where('tr.alias_antenna', $alias_antenna);
    $query = $this->db->get();
    return $query;
  }

  function saveData($id, $tid, $epc, $status, $created_time, $description, $category, $flag_alarm, $ant, $alias_antenna, $no_sku){

    $result_data = [];

    $is_exists = $this->db->where('kode_tid', $tid)->get('tb_master_tag_rfid')->num_rows();

    if ($is_exists > 0) {
      
      $result_data['is_tag_registered'] = true;

      $dataReader = $this->getReaderInfoByAliasAntenna($alias_antenna)->row();

      $data = [
          'lokasi_terakhir_id' => $dataReader->room_id,
          'nama_lokasi_terakhir' => $dataReader->ruangan,
          'room_id' => $dataReader->room_id,
          'room_name' => $dataReader->ruangan,
          'reader_id' => $dataReader->reader_id,
          'reader_antena' => $dataReader->reader_antena,
          'reader_angle' => $dataReader->reader_angle,
          'reader_gate' => $dataReader->reader_gate,
          'rfid_tag_number' => $tid,
          'is_legal_moving' => $dataReader->reader_identity
        ];
        
      $is_success = $this->db->insert('tag_temp_table', $data);
      $is_success2 = $this->db->insert('tag_temp_table_process', $data);

      if ($is_success && $is_success2) {
        $result_data['is_success'] = true;
      } else {
        $result_data['is_success'] = false;
      }

      // $result_data['is_success'] = $is_success;

    } else {
      $result_data['is_tag_registered'] = false;
      $result_data['is_success'] = true;
    }

    $result_data['is_exists'] = $is_exists;

    return $result_data;

  }

  function update_status($id_temp_table, $rfid_tag_number, $output, $room_id, $reader_id, $kategori_pergerakan, $keterangan_pergerakan, $lokasi_terakhir, $nama_lokasi_terakhir){

    $this->db->trans_start();

    // untuk update ke aset master
    $status_id = $output;
    $room_id_asset = ($output == 1) ? $room_id : '';

    // untuk insert ke moving
    $output = ($output == 1) ? 'In' : 'Out';
    $room_id_asset_moving = ($status_id == 1) ? $room_id : '';

    // update temp table

    // if ($output == 'In'){
      
    //   $data = array(
    //     'output' => $status_id, 
    //     'rfid_tag_number' => $rfid_tag_number, 
    //     'kategori_pergerakan' => $kategori_pergerakan, 
    //     'keterangan_pergerakan' => $keterangan_pergerakan,
    //     'lokasi_terakhir_id' => $lokasi_terakhir,
    //     'nama_lokasi_terakhir' => $nama_lokasi_terakhir
    //   );

    // } else {

    //   $data = array(
    //     'output' => $status_id, 
    //     'rfid_tag_number' => $rfid_tag_number, 
    //     'kategori_pergerakan' => $kategori_pergerakan, 
    //     'keterangan_pergerakan' => $keterangan_pergerakan
    //   );

    // }

    $data = array(
      'output' => $status_id, 
      'rfid_tag_number' => $rfid_tag_number, 
      'kategori_pergerakan' => $kategori_pergerakan, 
      'keterangan_pergerakan' => $keterangan_pergerakan,
      'lokasi_terakhir_id' => $lokasi_terakhir,
      'nama_lokasi_terakhir' => $nama_lokasi_terakhir
    );

    $this->db->where('id_temp_table', $id_temp_table);
    $this->db->update('tag_temp_table', $data);

    // update asset master

    $data_asset_master = array(
      'status_id' => $status_id, 
      'lokasi' => $room_id_asset,
      'lokasi_terakhir_id' => $lokasi_terakhir,
      'lokasi_terakhir' => $nama_lokasi_terakhir
    );

    $this->db->where('tag_code', $rfid_tag_number);
    $this->db->update('tb_asset_master', $data_asset_master);
    
    // insert to tb_asset_moving
    $data = array(
      'tanggal' => date('Y-m-d'), 
      'waktu' => date('Y-m-d H:i:s'),
      'reader_id' => $reader_id,
      'room_id' => $room_id_asset_moving,
      'tag_code' => $rfid_tag_number, 
      'status_moving' => $output,
      'lokasi_terakhir_id' => $lokasi_terakhir,
      'lokasi_terakhir' => $nama_lokasi_terakhir
    );

    $this->db->insert('tb_asset_moving', $data);

    $this->db->trans_complete();

    return $this->db->trans_status();

  }


  function getConfig($filter){

    $this->db->where('id_config', $filter);
    $query = $this->db->get('config');
    return $query;

  }

}
?>