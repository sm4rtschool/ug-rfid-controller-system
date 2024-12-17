<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homemodel extends CI_Model
{
  
  private $CI;
  
  public function __construct()
  {
    parent::__construct();
  }

  public function update_flag_tts($id_content){
    $this->db->where('id_content', $id_content);
    $is_success = $this->db->update('content_log', array('is_done_play' => 1));
    return $is_success;
  }

  public function qrypengaturan_sistem(){
    $this->db->select('*');
    $this->db->from('pengaturan_sistem');
    $query = $this->db->get();
    return $query;
  }

  public function get_parameter(){
    $this->db->select('*');
    $this->db->from('tb_master_kategori');
    $query = $this->db->get();
    return $query->result();
  }

  public function get_variable_by_id()
	{
		$ssql = "select * from variable";
		$query = $this->db->query($ssql);
		//echo $this->db->last_query();
		return $query;
	}

  function getLastData(){
    $this->db->select('*');
    $this->db->from('tag_temp_table');
    $this->db->where('output', 0);
    $this->db->order_by('id_temp_table', 'asc');
    
    $query = $this->db->get();
    return $query;
  }

  function getLastLocation($rfid_tag_number){
    $this->db->select('*');
    $this->db->from('tb_master_aset');
    $this->db->where('kode_tid', $rfid_tag_number);
    $query = $this->db->get();
    return $query;
  }

  function getLastDetection($rfid_tag_number, $room_id, $reader_angle){
    $this->db->select('*');
    $this->db->from('tag_temp_table');
    // $this->db->join('tb_room_master', 'tb_room_master.id_room = tb_asset_master.lokasi', 'left');
    $this->db->where('room_id', $room_id);
    $this->db->where('reader_angle', $reader_angle);
    $this->db->where('rfid_tag_number', $rfid_tag_number);
    $query = $this->db->get();
    return $query;
  }

  function update_status($id_temp_table, $rfid_tag_number, $output, $room_id, $reader_id, $kategori_pergerakan, $keterangan_pergerakan, $lokasi_terakhir, $nama_lokasi_terakhir, $is_legal_moving){

    $this->db->trans_start();

    $qrypengaturan_sistem = $this->qrypengaturan_sistem()->row();
    $flag_moving_in = $qrypengaturan_sistem->flag_moving_in;
    $flag_moving_out = $qrypengaturan_sistem->flag_moving_out;

    // untuk update ke aset master, output = 1 atau 4
    $status_id = $output;
    $room_id_asset = ($output == $flag_moving_in) ? $room_id : '';

    // untuk insert ke moving
    $output = ($output == $flag_moving_in) ? 'In' : 'Out';
    $room_id_asset_moving = ($status_id == $flag_moving_in) ? $room_id : '';

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
      'status' => $status_id, 
      'lokasi_moving' => $room_id_asset,
      'lokasi_terakhir' => $lokasi_terakhir,
      'nama_lokasi_terakhir' => $nama_lokasi_terakhir,
      'tipe_moving' => $is_legal_moving
    );

    $this->db->where('kode_tid', $rfid_tag_number);
    $this->db->update('tb_master_aset', $data_asset_master);
    
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

  function get_state($filter_id_parameter){

    $qrypengaturan_sistem = $this->qrypengaturan_sistem()->row();

    $global_integrasi_data = $qrypengaturan_sistem->global_integrasi_data;
    $field_for_comparison = $qrypengaturan_sistem->field_for_comparison;

    if ($global_integrasi_data == 'active') {
      $table_monitoring = 'tag_temp_table';
      $global_integrasi_data_mode = 0;
    } else if ($global_integrasi_data == 'passive') {
      $table_monitoring = 'tag_temp_table';
      $global_integrasi_data_mode = 1;
    } else {
      $table_monitoring = 'tag_temp_table';
      $global_integrasi_data_mode = 1;
    }

    if ($global_integrasi_data == 'active') {

      $ssql = "select b.nama_parameter, c.nama_variable, a.*
              from " . $table_monitoring . " a 
              join parameter b on b.id_parameter = a.parameter_id
              join variable c on c.id_variable = a.variable_id
              where a.is_parameter_active = 1 and a.is_data_passive = " . $global_integrasi_data_mode;

      if ($filter_id_parameter != '0') {
        $ssql .= " and a.parameter_id = $filter_id_parameter";
      }

      $ssql .= " order by a.state >= a." . $field_for_comparison . " desc";
      
    } else if ($global_integrasi_data == 'passive') {
     
      $ssql = "select b.nama_parameter, c.nama_variable, a.*
            from " . $table_monitoring . " a 
            join parameter b on b.id_parameter = a.parameter_id
            join variable c on c.id_variable = a.variable_id
            where a.is_done_play = 0";

      if ($filter_id_parameter != '0') {
        $ssql .= " and a.parameter_id = $filter_id_parameter";
      }

      $ssql .= " order by a.id_content desc";

    }

    // and a.state >= a.threshold_state_qty_active
    // where date(waktu)=CURDATE() and is_threshold_confirm = 0 and state >= threshold_state_qty";

    $query = $this->db->query($ssql);
		//echo $this->db->last_query();

		return $query;

  }

  function get_state_alert(){

    $qrypengaturan_sistem = $this->qrypengaturan_sistem()->row();

    $global_integrasi_data = $qrypengaturan_sistem->global_integrasi_data;
    $field_for_comparison = $qrypengaturan_sistem->field_for_comparison;

    if ($global_integrasi_data == 'active') {
      $table_monitoring = 'content';
      $global_integrasi_data_mode = 0;
    } else if ($global_integrasi_data == 'passive') {
      $table_monitoring = 'content_log';
      $global_integrasi_data_mode = 1;
    } else {
      $table_monitoring = 'content';
      $global_integrasi_data_mode = 1;
    }

    if ($global_integrasi_data == 'active') {

      $ssql = "SELECT e.* FROM
            (
              SELECT b.nama_parameter, c.nama_variable, a.*, CASE
              WHEN is_reverse_threshold = 0 AND a.state > a." . $field_for_comparison . " THEN 'abnormal'
              WHEN is_reverse_threshold = 1 AND a.state < a." . $field_for_comparison . " THEN 'abnormal'
              ELSE 'normal' 
              END AS status
              FROM " . $table_monitoring . " a 
              join parameter b on b.id_parameter = a.parameter_id
              join variable c on c.id_variable = a.variable_id
              where a.is_parameter_active = 1
            ) AS e
            where e.status = 'abnormal'
            order by e.is_reverse_threshold asc";

    } else if ($global_integrasi_data == 'passive') {

      $ssql = "
              SELECT b.nama_parameter, c.nama_variable, a.*
              FROM " . $table_monitoring . " a 
              join parameter b on b.id_parameter = a.parameter_id
              join variable c on c.id_variable = a.variable_id
              where a.is_done_play = 0
              order by a.id_content desc";
      
    } else {

      $ssql = "SELECT e.* FROM
            (
              SELECT b.nama_parameter, c.nama_variable, a.*, CASE
              WHEN is_reverse_threshold = 0 AND a.state > a." . $field_for_comparison . " THEN 'abnormal'
              WHEN is_reverse_threshold = 1 AND a.state < a." . $field_for_comparison . " THEN 'abnormal'
              ELSE 'normal' 
              END AS status
              FROM " . $table_monitoring . " a 
              join parameter b on b.id_parameter = a.parameter_id
              join variable c on c.id_variable = a.variable_id
              where a.is_parameter_active = 1
            ) AS e
            where e.status = 'abnormal'
            order by e.is_reverse_threshold asc";
      
    }

    $query = $this->db->query($ssql);
		//echo $this->db->last_query();

		return $query;

  }

  function getRunningText(){

    $qrypengaturan_sistem = $this->qrypengaturan_sistem()->row();

    $global_integrasi_data = $qrypengaturan_sistem->global_integrasi_data;
    $field_for_comparison = $qrypengaturan_sistem->field_for_comparison;

    if ($global_integrasi_data == 'active') {
      $table_monitoring = 'content';
      $global_integrasi_data_mode = 0;
    } else if ($global_integrasi_data == 'passive') {
      $table_monitoring = 'content_log';
      $global_integrasi_data_mode = 1;
    } else {
      $table_monitoring = 'content';
      $global_integrasi_data_mode = 1;
    }

    if ($global_integrasi_data == 'active') {

      $ssql = "SELECT e.* FROM
            (
              SELECT b.nama_parameter, c.nama_variable, a.*, CASE
              WHEN is_reverse_threshold = 0 AND a.state > a." . $field_for_comparison . " THEN 'abnormal'
              WHEN is_reverse_threshold = 1 AND a.state < a." . $field_for_comparison . " THEN 'abnormal'
              ELSE 'normal' 
              END AS status
              FROM " . $table_monitoring . " a 
              join parameter b on b.id_parameter = a.parameter_id
              join variable c on c.id_variable = a.variable_id
              where a.is_parameter_active = 1
            ) AS e
            where e.status = 'abnormal'
            order by e.is_reverse_threshold asc";

    } else if ($global_integrasi_data == 'passive') {

      $ssql = "SELECT b.nama_parameter, c.nama_variable, a.*
              FROM " . $table_monitoring . " a 
              join parameter b on b.id_parameter = a.parameter_id
              join variable c on c.id_variable = a.variable_id
              where a.is_done_play = 0
              order by a.id_content desc";
      
    } else {

      $ssql = "SELECT e.* FROM
            (
              SELECT b.nama_parameter, c.nama_variable, a.*, CASE
              WHEN is_reverse_threshold = 0 AND a.state > a." . $field_for_comparison . " THEN 'abnormal'
              WHEN is_reverse_threshold = 1 AND a.state < a." . $field_for_comparison . " THEN 'abnormal'
              ELSE 'normal' 
              END AS status
              FROM " . $table_monitoring . " a 
              join parameter b on b.id_parameter = a.parameter_id
              join variable c on c.id_variable = a.variable_id
              where a.is_parameter_active = 1
            ) AS e
            where e.status = 'abnormal'
            order by e.is_reverse_threshold asc";
      
    }

    $query = $this->db->query($ssql);
		//echo $this->db->last_query();

		return $query;

  }

  function getConfig($filter){

    $this->db->where('id_config', $filter);
    $query = $this->db->get('config');
    return $query;

  }

  function getJumlahProses()
  {
    $query = $this->db->query('SELECT count(id_proses) AS jum FROM flow_proses WHERE id_pemberi_tanggung_jawab = ' . $id_pemberi_tanggung_jawab . '');
  }

  function getNilai($rtms_id, $zona)
  {
    // $waktu_mulai = date('Y-m-d H').':00:00';
    // $waktu_selesai = date('Y-m-d H').':59:00';

    $ssql = "SELECT DeviceName, ZoneLabel,
    CASE WHEN SUM(Occupancy) = 0 THEN '0' ELSE CONVERT(VARCHAR, AVG(CASE WHEN Speed = 240 THEN '0' ELSE Speed END)) END AS Speed,
    SUM(CASE WHEN Volume < 0 THEN 0 ELSE COALESCE(Volume,0) END)
    + SUM(CASE WHEN [LongVeh] < 0 THEN 0 ELSE COALESCE([LongVeh],0) END)
    + SUM(CASE WHEN [Long2Veh] < 0 THEN 0 ELSE COALESCE([Long2Veh],0) END)
    + SUM(CASE WHEN [MidVeh] < 0 THEN 0 ELSE COALESCE([MidVeh],0) END)
    + SUM(CASE WHEN [Mid2Veh] < 0 THEN 0 ELSE COALESCE([Mid2Veh],0) END)
    + SUM(CASE WHEN [XLongVeh] < 0 THEN 0 ELSE COALESCE([XLongVeh],0) END) AS total_volume
    FROM [dbo].[RTMSData_RT_JAM]
\tWHERE RTMSSampleTime BETWEEN CONVERT(VARCHAR(10), CONVERT(DATE, GETDATE())) + ' ' + CONVERT(VARCHAR(2),getdate(),108)+':00:00' AND GETDATE()
\tAND RTMS_ID =  '" . $rtms_id . "' AND ZoneLabel = '" . $zona . "'
    GROUP BY DeviceName, ZoneLabel";

    $query = $this->db->query($ssql);
    $hasil = $query->result();
    $this->db->close();  // for second Connection
    return json_encode($hasil);

    /*
     * $json_fake = '[
     *     {
     *         "RTMS_ID": "'.$rtms_id.'",
     *         "DeviceName": "RUAS JALAN",
     *         "ZoneLabel": "'.$zona.'",
     *         "Speed": 30,
     *         "total_volume":30
     *     }
     *     ]';
     *     return $json_fake;
     */
  }

  function getHistory($rtms_id, $tanggal)
  {
    set_time_limit(0);

    /*
     * query database 1
     *       	$ssql = "EXEC sp_history_rtms
     *      @option = 1,
     *      @tgl_awal = '$tanggal',
     *      @tgl_akhir = '$tanggal',
     *      @rtms_id = $rtms_id";
     */

    /*
     * //database 1
     *         $query = $this->db->query($ssql);
     *         $hasil = $query->result();
     *         return json_encode($hasil);
     */

    $this->lap_db = $this->load->database('second', true);
    $ssql = "
\tSELECT RTMS_NAME AS DeviceName, ZoneLabel, CONVERT(VARCHAR(19), DateTimeStamp, 120) AS RTMSSampleTime,
    CASE WHEN SUM(Occupancy) = 0 THEN '0' ELSE CONVERT(VARCHAR, AVG(CASE WHEN Speed = 240 THEN '0' ELSE Speed END)) END AS Speed,

    SUM(CASE WHEN Volume < 0 THEN 0 ELSE COALESCE(Volume,0) END)
    + SUM(CASE WHEN Vol_Mid < 0 THEN 0 ELSE COALESCE(Vol_Mid,0) END)
    + SUM(CASE WHEN Vol_Mid2 < 0 THEN 0 ELSE COALESCE(Vol_Mid2,0) END)
    + SUM(CASE WHEN Vol_Long < 0 THEN 0 ELSE COALESCE(Vol_Long,0) END)
    + SUM(CASE WHEN Vol_Long2 < 0 THEN 0 ELSE COALESCE(Vol_Long2,0) END)
    + SUM(CASE WHEN Vol_Extra_Long < 0 THEN 0 ELSE COALESCE(Vol_Extra_Long,0) END) AS total_volume

    FROM TabelRTMS
    WHERE CONVERT(date, DateTimeStamp) BETWEEN '$tanggal' AND '$tanggal' AND RTMS_NETWORK_ID = $rtms_id AND (ZoneLabel = 'A' OR ZoneLabel = 'B')
    GROUP BY RTMS_NAME, ZoneLabel, DateTimeStamp
\tORDER BY ZoneLabel, DateTimeStamp ASC";
    $hasil = $this->lap_db->query($ssql)->result();
    $this->lap_db->close();  // for second Connection
    return json_encode($hasil);
  }
}
?>