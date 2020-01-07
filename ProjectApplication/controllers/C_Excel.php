<?php
if (!defined('BASEPATH')) exit("No direct script access allowed!!");
class C_Excel extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(['third_party/PHPExcel/PHPExcel', 'third_party/PHPExcel/PHPExcel/IOFactory']);
    }

    function index()
    {

        $this->load->view('templates/header');
        $this->load->view('templates/aside');
        $this->load->view('uploadexcel');
        $this->load->view('templates/footer');
    }
}
