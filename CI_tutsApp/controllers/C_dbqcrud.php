<?php
class C_dbqcrud extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['html', 'form', 'url', 'text']);
        $this->load->model("M_dbqcrud", "tabel");
    }
    function tambahdata()
    {
        $adata = [
            'noteman' => 7,
            'namateman' => "Sabiq",
            'notlpn' => '08555555550',
            'email' => "sabiq@gmail.com"
        ];
        $data['hslquery'] = $this->M_dbqcrud->tambah($adata);
        $data['judulApp'] = 'Tambah Data';
        $hsltambah = ($data['hslquery']) ? "Berhasil Ditambahkan!" : "Gagal Ditmabahkan!";
        echo $data['judulApp'];
        echo $hsltambah;
        echo anchor("C_dbteman/baca", "Tampil Seluruh Data");
    }

    function showAllRecord()
    {
        $data['hslquery'] = $this->tabel->getallrecord();
        $data['judulApp'] = "Show All With Query Builder";
        $this->load->view('v_queryBuilder_allrecord', $data);
    }

    function shownamaemail()
    {
        $data['hslquery'] = $this->tabel->getnamaemail();
        $data['judulApp'] = "Show nama & email iwth query builder";
        $this->load->view('v_namaEmail', $data);
    }


    function showfilter()
    {
        $data = $this->tabel->readfilter();
        if (!empty($this->input->post())) {
            $data['hslquery'] = $this->tabel->getfilterdata($data);
        }
        $data['judulApp'] = "Input Filter Untuk Query Builder";
        $data['scriptaksi'] = "c_dbqcrud/showfilter";
        $this->load->view('v_filter_form', $data);
    }
}
