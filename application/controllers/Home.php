<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Aset Controller
*
*	@author Ridwan Sapoetra | sm4rtschool@gmail.com | 082113332009
*
*/

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// profiler ini untuk menampilkan debug
		// $this->output->enable_profiler(TRUE);

		//$this->load->database();
		//$this->load->helper('url');
		$this->load->library('fungsi');
		$this->load->model('Homemodel', 'home');
		$this->load->model('Contentmodel');
	}

	public function index()
	{
		
		//$this->getList();

		/*
		$data['area'] = array(
		    1 => 'Monitoring ATM',
		    2 => 'Monitoring SLA',
		    3 => 'Monitoring COM Down'
		);
		*/

		$parameter = $this->home->get_parameter();

		$array_parameter = array();
		foreach ($parameter as $val){
			$array_parameter[$val->id_parameter] = $val->nama_parameter;
		}
		
		$data['area'] = $array_parameter;
		
		$data['ruas'] = array(
		    60 => 'KM 09+200 CIKUNIR 4',
		    61 => 'KM 26+400 Cibitung'
		);
		
		$variable = $this->home->get_variable_by_id();

		$array_variable = array();
		foreach ($variable->result() as $val){
			$array_variable[$val->id_variable] = $val->nama_variable;
		}

		/*
		echo '<pre>';
		print_r($data['area']);
		//echo json_encode($array_variable);
		echo '</pre>';
		exit;
		*/

		$qryGetSound = $this->Contentmodel->getSoundToPlay()->result();
        $data['sound'] = $qryGetSound;

		$filter_config = 1;
		$qrygetConfig = $this->home->getConfig($filter_config)->row();
		$data['config_list_data'] = $qrygetConfig;

		$filter_config_trigger = 2;
		$qrygetConfigTrigger = $this->home->getConfig($filter_config_trigger)->row();
		$data['config_trigger'] = $qrygetConfigTrigger;

		$filter_config_global_sound = 3;
		$qrygetConfigGlobalSound = $this->home->getConfig($filter_config_global_sound)->row();
		$data['config_global_sound'] = $qrygetConfigGlobalSound;

		$filter_config_apis_url_play_sound = 4;
		$qrygetConfigApisUrlPlaySound = $this->home->getConfig($filter_config_apis_url_play_sound)->row();
		$data['config_apis_url_play_sound'] = $qrygetConfigApisUrlPlaySound;

		$filter_config_apis_url_web_socket = 5;
		$qrygetConfigApisUrlWebSocket = $this->home->getConfig($filter_config_apis_url_web_socket)->row();
		$data['config_apis_url_web_socket'] = $qrygetConfigApisUrlWebSocket;

		$filter_config_global_light_color = 6;
		$qrygetConfigGlobalLightColor = $this->home->getConfig($filter_config_global_light_color)->row();
		$data['config_global_light_color'] = $qrygetConfigGlobalLightColor;

		$this->load->view('partials/_mydashboard_header', $data);
		$this->load->view('home/home', $data);

	}

	public function get_state(){

		$filter_id_parameter = $this->uri->segment('3');
		$query = $this->home->get_state($filter_id_parameter);

		$array_variable = array();
		foreach($query->result() as $val) {
			$array_variable[] = $val->nama_variable;
		}

		echo json_encode($query->result());

		/*
		echo '<pre>';
		//print_r($array_variable);
		echo json_encode($query->result());
		echo '</pre>';
		exit;
		*/
		
	}

	public function get_state_alert(){

		$query = $this->home->get_state_alert();

		$array_variable = array();
		foreach($query->result() as $val) {
			$array_variable[] = $val->nama_variable;
		}

		echo json_encode($query->result());

		/*
		echo '<pre>';
		//print_r($array_variable);
		echo json_encode($query->result());
		echo '</pre>';
		exit;
		*/
		
	}

	public function getRunningText(){

		$query = $this->home->getRunningText();

		$array_variable = array();
		foreach($query->result() as $val) {
			$array_variable[] = $val->nama_variable;
		}

		echo json_encode($query->result());

		/*
		echo '<pre>';
		//print_r($array_variable);
		echo json_encode($query->result());
		echo '</pre>';
		exit;
		*/
		
	}

	public function getConfig(){

		$filter = $this->uri->segment('3');
		$query = $this->home->getConfig($filter)->row();

		//$array_variable = array();
		echo json_encode($query);

		/*
		echo '<pre>';
		//print_r($array_variable);
		echo json_encode($query);
		echo '</pre>';
		exit;
		*/
		
	}

	public function getList()
	{
		
		//$data['area'] = array(1 => 'ATM Down', 2 => 'SLA', 3 => 'COM Down');
		//$data['ruas'] = array(60 => 'KM 09+200 CIKUNIR 4', 65 => 'KM 11+800', 66 => 'KM 14+000', 67 => 'KM 17+000', 61 => 'KM 26+400 Cibitung', 62 => 'KM 32+200 Cikarang', 63 => 'KM 66+750 Dawuan', 64 => 'KM 72+900 Sadang');
		
		$data['area'] = array(
		    1 => 'ATM Down',
		    2 => 'SLA',
		    3 => 'COM Down'
		);
		
		$data['ruas'] = array(
		    60 => 'KM 09+200 CIKUNIR 4',
		    61 => 'KM 26+400 Cibitung'
		);
		
		$variable = $this->home->get_variable_by_id();

		$array_variable = array();
		foreach ($variable->result() as $val){
			$array_variable[$val->id_variable] = $val->nama_variable;
		}

		//$data['ruas'] = $array_variable;

		/*
		echo '<pre>';
		print_r($array_variable);
		echo '</pre>';
		exit;
		*/

		$this->load->view('home/home', $data);
	}

	public function monitoring(){
		$this->load->view('home/monitoring');
	}

	public function getListDalam()
	{
		$data['area'] = array(2 => 'DALAM KOTA', 1 => 'CIKAMPEK');
		$data['ruas'] = array(14 => 'Tebet 2', 13 => 'Kuningan 1');
		$this->load->view('home/home', $data);
	}

	public function getListHistory()
	{
		// $data['ruas'] =  array(60 => 'KM 09+200 CIKUNIR 4', 65 => 'KM 11+800', 66 => 'KM 14+000', 67 => 'KM 17+000', 61 => 'KM 26+400 Cibitung', 62 => 'KM 32+200 Cikarang', 63 => 'KM 66+750 Dawuan', 64 => 'KM 72+900 Sadang');
		$data['ruas'] = array(80 => 'KM 09+200 CIKUNIR 4', 85 => 'KM 11+800', 86 => 'KM 14+000', 87 => 'KM 17+000', 81 => 'KM 26+400 Cibitung', 82 => 'KM 32+200 Cikarang', 83 => 'KM 66+750 Dawuan', 84 => 'KM 72+900 Sadang', 14 => 'Tebet 2', 13 => 'Kuningan 1');
		$this->load->view('home/history', $data);
	}

	public function getData()
	{
		$rtms_id = $this->uri->segment(3);
		$zona = $this->uri->segment(4);
		$result = '';
		$result = $this->home->getNilai($rtms_id, $zona);
		echo $result;
	}

	public function getHistory()
	{
		$rtms_id = $this->uri->segment(3);
		$tanggal = $this->uri->segment(4);
		$result = '';
		$result = $this->home->getHistory($rtms_id, $tanggal);
		echo $result;
	}

	public function triggerOn(){
		$this->load->view('home/trigger_on');
	}
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */