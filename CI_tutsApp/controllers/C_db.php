<?php
class C_db extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('html', 'form', 'url', 'text');
    }

    function cekkoneksi()
    {
        $config['hostname'] = 'localhost:8080';
        $config['dbdriver'] = 'mysqli';
        $config['username'] = 'root';
        $config['password'] = '';

        $this->load->database($config);
        echo "Koneksi DB OK";
    }
    function errkoneksi()
    {
        $config['hostname'] = 'localhost:8080';
        $config['dbdriver'] = 'mysqli';
        $config['username'] = 'root';
        $config['password'] = 'x';
        $config['db_debug'] = TRUE;


        $this->load->database($config);
        if (!$this->db->error()) echo "Koneksi DB OK";
        else echo "DB connection error";
    }
}
