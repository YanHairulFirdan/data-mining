<?php
class C_dbmteman extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(['html', 'form', 'url', 'text']);
        $this->load->model('m_dbcibook');
    }

    function baca()
    {

        $data['hslquery'] = $this->m_dbcibook->gettblteman();
        $data['judulApp'] = "Baca Tabel dengan model dan view";
        $this->load->view('v_cdbmteman', $data);
        //     $sqlstr = "SELECT * FROM tblteman";
        //     $hslquery = $this->db->query($sqlstr);

        //     return $hslquery;
    }
    function baca2arr()
    {

        $data['hslquery'] = $this->m_dbcibook->gettblteman();
        $data['judulApp'] = "Baca Tabel diproses dengan array";
        $this->load->view('v_cdbmteman', $data);
        //     $sqlstr = "SELECT * FROM tblteman";
        //     $hslquery = $this->db->query($sqlstr);

        //     return $hslquery;
    }
    function urutnamamundur()
    {

        $data['hslquery'] = $this->m_dbcibook->uruttblteman();
        $data['judulApp'] = "Baca Tabel Teman dengan Diurut";
        $this->load->view('v_cdbmteman', $data);
        //     $sqlstr = "SELECT * FROM tblteman";
        //     $hslquery = $this->db->query($sqlstr);

        //     return $hslquery;
    }
}
