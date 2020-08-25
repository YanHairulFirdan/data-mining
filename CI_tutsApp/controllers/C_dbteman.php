<?php
class C_dbteman extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('html', 'form', 'url', 'text');
        // $config['hostname'] = 'localhost:8080';
        // $config['username'] = 'root';
        // $config['password'] = '';
        // $config['dbdriver'] = 'mysqli';
        // $config['database'] = 'dbcibook';
        // $this->load->database($config);
    }

    function baca()
    {
        $sqlstr = "SELECT * FROM tblteman";
        $hslquery = $this->db->query($sqlstr);
        echo "Hasil Pembacaan Data Tabel Teman";
        echo br();
        echo "print_r:";
        echo br();
        print_r($hslquery);
        echo br();
        echo "var_dump:";
        echo br();
        var_dump($hslquery);
    }
    function libtable()
    {
        $this->load->library('table');
        $sqlstr = "SELECT * FROM tblteman";
        $hslquery = $this->db->query($sqlstr);
        echo "Tampil Hasil Pembacaan Data Dengan Libarary Tabel";
        echo br();
        $dataTBL = $this->table->generate($hslquery);
        echo $dataTBL;
    }
    function loopobj()
    {
        $sqlstr = "SELECT * FROM tblteman";
        $hslquery = $this->db->query($sqlstr);
        echo "Tampil Hasil Pembacaan dengan foreach()";
        echo br();
        foreach ($hslquery->result() as $row) {
            echo $row->noteman;
            echo $row->namateman;
            echo $row->notlpn;
            echo $row->email;

            echo br();
        }
    }
    function page($p = 0)
    {
        $jppage = 2;
        $this->load->model('M_dbcibook');
        $this->load->library('pagination');
        $config['base_url'] = site_url() . '/c_dbteman/page/';
        $config['total_rows'] = $this->M_dbcibook->getjtrecord();
        $config['per_page'] = $jppage;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['hslquery'] = $this->M_dbcibook->gettemanpage($p, $jppage);
        $data['judulApp'] = "Baca Tabel dengan Pagination";
        $this->load->view('v_c_dbteman_pagination', $data);
    }
}
