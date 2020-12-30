<?php
class Smote extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('login') != 'ok') {
			redirect(site_url('./user/login'));
		}
		$this->session->unset_userdata('train_msg');
		$this->load->model('M_Smote');
	}
	public function index()
	{
		$this->session->unset_userdata('data_type');
		$this->session->set_flashdata('msg', 'index');
		$this->session->set_flashdata('msg', 'sampled');
		// $this->M_Smote->smote(19, 400, M_Smote::kVal);
		$dataset['judul'] = 'data asli';
		$dataset['header'] = 'data awal';
		$dataset['dataset'] = $this->M_Smote->getAllRawData();
		$data = $this->M_Smote->getCount();
		$dataset['judul'] = 'resampling data';
		$dataset['count'] = $data;
		$dataset['labels'] = ['minoritas', 'mayoritas'];
		$this->load->view('templates/header', $dataset);
		$this->load->view('templates/aside');
		$this->load->view('smote/index', $dataset);
		$this->load->view('templates/footer');
	}
	public function resamplingdata()
	{
		$this->db->query("TRUNCATE posterior");
		$this->db->query("TRUNCATE rawdata");
		$this->session->unset_userdata('data_type');
		$this->session->set_flashdata('msg', 'simpan data');
		$persentase = intval($this->input->post('persentase'));
		$knn = intval($this->input->post('knn'));
		// $kfold = intval($this->input->post('kfold'));
		// $this->session->set_userdata('kfold', $kfold);
		$this->session->set_userdata("sampling_percentage", intval($this->input->post('persentase')));
		$this->session->set_userdata("amount_of_knn",  intval($this->input->post('knn')));
		// echo $this->session->flashdata('kfold');
		// die;
		$this->M_Smote->smote(19, $persentase, $knn);
		$dataset = $this->M_Smote->getsampleddata();
		$dataset['labels'] = ['minoritas', 'mayoritas'];
		$dataset['judul'] = 'resampling data';
		$dataset['header'] = 'data setelah sampling';
		$this->load->view('templates/header', $dataset);
		$this->load->view('templates/aside');
		$this->load->view('smote/index', $dataset);
		$this->load->view('templates/footer');
	}

	public function savedata()
	{
		$this->db->query("TRUNCATE kasus");
		// $persentase = intval($this->input->post('persentase'));
		// $knn = intval($this->input->post('knn'));
		// $kfold = intval($this->input->post('kfold'));

		// echo "persentasi : " . $persentase . br();
		// echo "knn : " . $knn . br();
		// // die;
		// echo '<pre>';
		// print_r(M_Smote::$syntheticData);
		// echo '</pre>';
		// die;
		// $this->M_Smote->smote(19, $persentase, $knn);
		$this->M_Smote->savedata();
		redirect('c_naivebayes/training');
	}
	function datatraining()
	{
		$this->session->unset_userdata('msg');
		$this->session->set_flashdata('data_type', 'data training');
		$data['dataset'] = $this->M_Smote->getAll();
		$data['judul'] = 'Data Training';
		$data['header'] = 'Data Training';
		$this->load->view('templates/header', $data);
		$this->load->view('templates/aside');
		$this->load->view('smote/index', $data);
		$this->load->view('templates/footer');
	}
	function hapusdata()
	{
		$this->db->query('TRUNCATE kasus');
		redirect('smote');
	}


	public function splitData()
	{
		$this->M_Smote->testSplitData();
		redirect('c_naivebayes/training');
	}

	public function testgetdata()
	{
		echo "<pre>";
		print_r($this->M_Smote->getsampleddata());
		echo "</pre>";
	}
	public function othertest()
	{
		echo "<pre>";
		print_r($this->session->userdata('kfold'));
		echo "</pre>";
	}

	public function insert()
	{
		$this->db->query('TRUNCATE kasusrealdata');
		$this->M_Smote->inputData();
		redirect('smote');
	}

	function testSmote()
	{
		$this->M_Smote->smote(5, 200, 2);
	}
}
