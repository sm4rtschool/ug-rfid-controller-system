<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Homemodel extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getJumlahProses(){
    $query = $this->db->query('SELECT count(id_proses) AS jum FROM flow_proses WHERE id_pemberi_tanggung_jawab = '.$id_pemberi_tanggung_jawab.'');
		}

    function getNilai($rtms_id,$zona){

    $waktu_mulai = date('Y-m-d H').':00:00';
    $waktu_selesai = date('Y-m-d H').':59:00';
    $query = $this->db->query("SELECT RTMS_ID , DeviceName, ZoneLabel,
    CASE WHEN SUM(Occupancy) = 0 THEN '0' ELSE CONVERT(VARCHAR, AVG(CASE WHEN Speed = 240 THEN '0' ELSE Speed END)) END AS Speed,
    SUM(CASE WHEN Volume < 0 THEN 0 ELSE COALESCE(Volume,0) END)
    + SUM(CASE WHEN [LongVeh] < 0 THEN 0 ELSE COALESCE([LongVeh],0) END)
    + SUM(CASE WHEN [Long2Veh] < 0 THEN 0 ELSE COALESCE([Long2Veh],0) END)
    + SUM(CASE WHEN [MidVeh] < 0 THEN 0 ELSE COALESCE([MidVeh],0) END)
    + SUM(CASE WHEN [Mid2Veh] < 0 THEN 0 ELSE COALESCE([Mid2Veh],0) END)
    + SUM(CASE WHEN [XLongVeh] < 0 THEN 0 ELSE COALESCE([XLongVeh],0) END) AS total_volume
    FROM [dbo].[RTMSData_RT]
    WHERE RTMSSampleTime BETWEEN '".$waktu_mulai."' AND  '".$waktu_selesai."' AND RTMS_ID =  '".$rtms_id."' AND ZoneLabel = '".$zona."'
    GROUP BY RTMS_ID ,DeviceName, ZoneLabel");
    $hasil = $query->result();
    return json_encode($hasil);

    /*
    $json_fake = '[
        {
            "RTMS_ID": "'.$rtms_id.'",
            "DeviceName": "RUAS JALAN",
            "ZoneLabel": "'.$zona.'",
            "Speed": 30,
            "total_volume":30
        }
        ]';
        return $json_fake;

        */
    }
}
?>
