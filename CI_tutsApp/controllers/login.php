<?php
class Login extends CI_Controller
{
    function index()
    {
        $this->load->view("login/LoginView");
        echo base_url();
    }

    function ShowData()
    {
        // $this->load->view("dataViews");
        echo "this page for showing data";
    }
}
