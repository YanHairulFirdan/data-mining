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
		$this->session->unset_userdata('data_type');
		$this->load->model('M_Smote');
		$this->session->set_flashdata('msg', 'index');
		$this->session->set_flashdata('msg', 'sampled');
		$this->M_Smote->smote(19, 400, M_Smote::kVal);
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
		$this->session->unset_userdata('data_type');
		$this->session->set_flashdata('msg', 'simpan data');
		$this->load->model('M_Smote');
		$this->M_Smote->smote(19, 200, M_Smote::kVal);
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
		$this->load->model('M_Smote');
		$this->M_Smote->smote(19, 200, M_Smote::kVal);
		$this->M_Smote->savedata();
		redirect('smote/datatraining');
	}
	function datatraining()
	{
		$this->session->unset_userdata('msg');
		$this->session->set_flashdata('data_type', 'data training');
		$this->load->model('M_Smote');
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
}
