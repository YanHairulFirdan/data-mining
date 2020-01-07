<?php
class C_naiveBayes extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("M_NaiveBayes");
        $this->load->helper('perhitungan_helper');
        $this->load->library('form_validation', 'graph');
    }

    function index()
    {
        $this->load->view('Login/loginView');
    }
    // untuk data percobaan
    function home()
    {
        $data['dataTraining'] = $this->M_NaiveBayes->getDataTraining();
        $this->load->view('templates/header');
        $this->load->view('templates/aside', $data);
        $this->load->view('home', $data);
        $this->load->view('templates/footer', $data);
    }

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

    //untuk data percobaan
    function predict()
    {

        $this->db->query("TRUNCATE perhitungan");
        // die;
        $data['dataTraining'] = $this->M_NaiveBayes->getDataTraining();
        $this->load->view('templates/header');
        $this->load->view('templates/aside', $data);
        $this->load->view('formPrediction', $data);
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


    // untuk data percobaan

    function hasilPrediksi()
    {

        // jumlah data kasus

        $query = $this->db->query('SELECT * FROM datapenjualan');

        $data['prediksi'] = $this->M_NaiveBayes->getDataPrediksi();
        $this->load->view('templates/header');
        $this->load->view('templates/aside', $data);
        $this->load->view('tampilHasil', $data);
        $this->load->view('templates/footer', $data);
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
    function logout()
    {
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('admin');
        redirect(site_url('user/login'));
    }
}
