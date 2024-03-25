<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homemodel extends CI_Model
{
  function __construct()
  {
    // Call the Model constructor
    parent::__construct();
  }

  public function get_parameter(){
    $this->db->select('*');
    $this->db->from('parameter');
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

  function get_state($filter_id_parameter){

    $ssql = "select b.nama_parameter, b.total_data, c.nama_variable, a.*, d.* 
            from content a 
            join parameter b on b.id_parameter = a.parameter_id
            join variable c on c.id_variable = a.variable_id
            left join sound d on d.id_sound = a.sound_id
            where a.is_parameter_active = 1";

    if ($filter_id_parameter != '0') {
      $ssql .= " and a.parameter_id = $filter_id_parameter";
    }

    $ssql .= " order by a.state >= a.threshold_state_qty_active desc";

    // and a.state >= a.threshold_state_qty_active
    // where date(waktu)=CURDATE() and is_threshold_confirm = 0 and state >= threshold_state_qty";

    $query = $this->db->query($ssql);
		//echo $this->db->last_query();

		return $query;

  }

  function get_state_alert(){

    $ssql = "select b.nama_parameter, c.nama_variable, a.*, d.* 
            from content a 
            join parameter b on b.id_parameter = a.parameter_id
            join variable c on c.id_variable = a.variable_id
            left join sound d on d.id_sound = a.sound_id
            where a.is_parameter_active = 1
            and a.state >= a.threshold_state_qty_active
            order by a.state >= a.threshold_state_qty_active desc
            ";

            // where date(waktu)=CURDATE() and is_threshold_confirm = 0 and state >= threshold_state_qty";

    $query = $this->db->query($ssql);
		//echo $this->db->last_query();

		return $query;

  }

  function getRunningText(){

    $ssql = "select b.nama_parameter, c.nama_variable, a.*, d.* 
            from content a 
            join parameter b on b.id_parameter = a.parameter_id
            join variable c on c.id_variable = a.variable_id
            left join sound d on d.id_sound = a.sound_id
            where a.is_parameter_active = 1
            and a.state >= a.threshold_state_qty_active
            order by a.state >= a.threshold_state_qty_active desc
            ";

            // where date(waktu)=CURDATE() and is_threshold_confirm = 0 and state >= threshold_state_qty";

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