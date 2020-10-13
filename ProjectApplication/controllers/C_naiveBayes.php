<?php
class C_naiveBayes extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("M_NaiveBayes");
        $this->load->helper('perhitungan_helper');
        $this->load->library('form_validation', 'graph');
        $this->session->unset_userdata('msg');
    }

    function index()
    {
        // phpinfo();
        $this->load->view('Login/loginView');
    }
    // untuk data percobaan
    // function home()
    // {
    //     $data['dataTraining'] = $this->M_NaiveBayes->getDataTraining();
    //     $this->load->view('templates/header');
    //     $this->load->view('templates/aside', $data);
    //     $this->load->view('home', $data);
    //     $this->load->view('templates/footer', $data);
    // }

    //untuk data real
    function homedata()
    {
        if ($this->session->userdata('login') != 'ok') {
            redirect(site_url('./user/login'));
        }

        $data['dataTraining'] = $this->M_NaiveBayes->getDataPenjualan();
        $data['judul'] = "Halaman Home";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/aside');
        $this->load->view('tampilData', $data);
        $this->load->view('templates/footer', $data);
    }
    function sampleData()
    {

        $data['dataTraining'] = $this->M_NaiveBayes->getDataPenjualan();
        $data['judul'] = "Halaman Home";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/aside');
        $this->load->view('sampleView', $data);
        $this->load->view('templates/footer', $data);
    }


    //untuk data real
    function prediksi()
    {
        if ($this->session->userdata('login') != 'ok') {
            redirect(site_url('./user/login'));
        }
        $this->db->query("TRUNCATE perhitungan");
        $data['dataForm'] = $this->M_NaiveBayes->dataForm();
        $data['judul'] = "Halaman Prediksi";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/aside');
        $this->load->view('halamanPrediksi', $data);
        $this->load->view('templates/footer');
    }

    // untuk data real

    function hasilprediksidata()
    {
        if ($this->session->userdata('login') != 'ok') {
            redirect(site_url('./user/login'));
        }
        $query = $this->db->query('SELECT * FROM datapenjualan');
        $data['prediksi'] = $this->M_NaiveBayes->getDataPrediksiPenjualan();
        $this->load->view('templates/header');
        $this->load->view('templates/aside', $data);
        $this->load->view('showResult', $data);
        $this->load->view('templates/footer', $data);
    }

    function addData()
    {
        if ($this->session->userdata('login') != 'ok') {
            redirect(site_url('./user/login'));
        }
        $this->form_validation->set_rules('sales', 'jumlah produk', 'required');
        $this->form_validation->set_rules('status', 'status produk', 'required');

        if (!$this->form_validation->run()) {
            $data['dataForm'] = $this->M_NaiveBayes->dataForm();
            $data['judul'] = "Halaman Tambah Data";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/aside', $data);
            $this->load->view('halamantambahdata', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->set_flashdata('flash', "Ditambahkan");
            $data['keterangan'] = $this->M_NaiveBayes->tambahData();
            redirect('C_naivebayes/homedata');
        }
    }
    function insertdata()
    {
        $data = $this->M_NaiveBayes->getDatabaru();
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }



    function updateData($id)
    {
        if ($this->session->userdata('login') != 'ok') {
            redirect(site_url('./user/login'));
        }
        $data['updateData'] = $this->M_NaiveBayes->singleData($id);
        $data['dataForm'] = $this->M_NaiveBayes->dataForm();
        $this->form_validation->set_rules('sale', 'jumlah produk', 'required');
        $this->form_validation->set_rules('keterangan', 'status produk', 'required');

        if (!$this->form_validation->run()) {

            $data['judul'] = "Halaman Perbaharui Data   ";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/aside');
            $this->load->view('halamanupdate', $data);
            $this->load->view('templates/footer');
        } else {
            $data['update'] = $this->M_NaiveBayes->dataupdate();
            $this->session->set_flashdata('flash', 'diperbaharui');
            redirect('C_naivebayes/homedata');
        }
    }
    function getupdate()
    {
        $data = $this->input->post();
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }


    function delete($id)
    {
        if ($this->session->userdata('login') != 'ok') {
            redirect(site_url('./user/login'));
        }
        $this->M_NaiveBayes->hapus($id);
        $this->session->set_flashdata('flash', 'dihapus');
        redirect('C_naivebayes/homedata');
    }

    function searching()
    {
        $data['datasearching'] = $this->M_NaiveBayes->searchingData();
        $this->load->view('templates/header');
        $this->load->view('templates/aside');
        $this->load->view('halamansearching', $data);
        $this->load->view('templates/footer');
    }

    function chart()
    {
        if ($this->session->userdata('login') != 'ok') {
            redirect(site_url('./user/login'));
        }
        $data = $this->M_NaiveBayes->dataChart();
        $data['judul'] = "Halaman Informasi Grafik";
        echo "<pre>";
        print_r(json_encode($data));
        echo "</pre>";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/aside');
        $this->load->view('chart', $data);
        $this->load->view('templates/footer');
    }

    function hapusDataTable()
    {
        $this->db->truncate('datapenjualan');
        redirect('c_naivebayes/homedata');
    }

    function apidata()
    {
        $data["data"] = $this->M_NaiveBayes->getDataAPI();
        $data['currentTime'] = time();
        $data['judul'] = "landing page";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/aside');
        $this->load->view('dashboard', $data);
        $this->load->view('templates/footer');
    }

    public function classificationreal()
    {
        $this->M_NaiveBayes->classification('real');
        $this->session->set_userdata('mode', 'data asli');
        redirect('confusionmatrix/');
    }
    public function classificationresampled()
    {
        $this->session->set_userdata('mode', 'data hasil sampling');
        $this->M_NaiveBayes->classification('resampled');
        redirect('confusionmatrix/');
    }
    public function classificationtest()
    {

        $this->session->set_userdata('mode', 'realincases');
        if (empty($this->session->userdata('kfold'))) {
            $this->session->set_userdata('kfold', 5);
        }
        $this->M_NaiveBayes->classification('realincases');
        redirect('confusionmatrix/');

        // $this->M_NaiveBayes->testingFun('kasusrealdata');
    }



    public function training()
    {
        $this->load->model('m_smote');
        $dataset['dataset'] = $this->m_smote->getAll();
        $dataset['judul'] = 'Data training';
        $dataset['header'] = 'Data training';
        $this->session->set_flashdata('data_type', 'data training');
        $this->session->set_flashdata('train_msg', 'klasifikasi');
        $this->load->view('templates/header', $dataset);
        $this->load->view('templates/aside');
        $this->load->view('smote/index', $dataset);
        $this->load->view('templates/footer', $dataset);
    }

    function logout()
    {
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('admin');
        redirect(site_url('user/login'));
    }


    // public function posterior()
    // {
    //     $this->db->query('TRUNCATE mean_and_stdeviation');
    //     $data = $this->db->get_where('kasus', ['id' => 138])->result_array();

    //     // print_r($data);
    //     $this->M_NaiveBayes->posteriorCalculation($data);
    // }
    function changeKFold()
    {
        // echo "called";
        // if ($this->input->method(TRUE) == 'POST') {
        // echo $this->input->post('newkfold');
        $this->session->set_userdata('kfold', intval($this->input->post('newkfold')));
        // $this->session->unset_userdata('kfold');
        // echo br();
        // echo $this->session->userdata('newkfold');
        // die;
        //     // $kfold = $this->input->post('newkfold');
        //     if (!empty($this->input->post('newkfold'))) {
        //         echo $this->input->post('newkfold');
        //     } else {
        //         echo 'empty';
        //     }
        // }
        redirect($_SERVER['HTTP_REFERER']);

        // $this->M_NaiveBayes->changekfold($kfold);
    }
}
