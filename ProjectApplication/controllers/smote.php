<?php
class Smote extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('login') != 'ok') {
			redirect(site_url('./user/login'));
		}
	}
	public function index()
	{
		$this->load->model('M_Smote');

		$this->M_Smote->smote(19, 400, M_Smote::kVal);

		$dataset['judul'] = 'resampling data';
		$dataset['header'] = 'data asli';
		$dataset['dataset'] = $this->M_Smote->getAllRawData();
		$data = $this->M_Smote->getCount();
		$this->session->set_flashdata('msg', 'sampled');

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
		$this->load->model('M_Smote');

		$this->M_Smote->smote(19, 200, M_Smote::kVal);

		$dataset['judul'] = 'resampling data';
		$dataset = $this->M_Smote->getsampleddata();

		$dataset['labels'] = ['minoritas', 'mayoritas'];
		$this->session->set_flashdata('msg', 'simpan data');
		$dataset['header'] = 'data setelah sampling';
		$this->load->view('templates/header', $dataset);
		$this->load->view('templates/aside');
		$this->load->view('smote/index', $dataset);
		$this->load->view('templates/footer');
	}

	public function savedata()
	{
		$this->load->model('M_Smote');
		$this->M_Smote->smote(19, 200, M_Smote::kVal);
		$this->M_Smote->savedata();

		redirect('smote/datatraining');
	}
	function datatraining()
	{
		$this->load->model('M_Smote');
		echo "<pre>";
		print_r($this->M_Smote->getAll());
		echo "</pre>";
	}
	function hapusdata()
	{
		$this->db->query('TRUNCATE kasus');
		redirect('smote');
	}
}
