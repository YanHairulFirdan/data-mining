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
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        $data['judul'] = "landing page";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/aside');
        $this->load->view('dashboard', $data);
        $this->load->view('templates/footer');
    }

    // function continuousdata(){
    //     $arr = [1,2,3,4];
    //     $num = [ 850, 1100, 1150, 1250, 750, 900];

    //     echo array_sum($num)."<br>";
    //     $mean = array_sum($arr)/count($arr);
    //     $n = count($arr);
    //     // $std_deviation = stats_variance($arr);
    //     $temp  = 0;
    //     foreach ($arr as $i) {
    //         $temp += pow(($i - $mean), 2);
    //     }
    //     $std_deviation = sqrt(($temp/$n));
    //     echo $mean;
    //     echo "<br>";
    //     echo $std_deviation;
    // }

    function logout()
    {
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('admin');
        redirect(site_url('user/login'));
    }
}
