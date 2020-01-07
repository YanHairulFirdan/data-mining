<?php

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->library('form_validation');
    }
    function login()
    {
        echo $this->session->userdata('login');
        // var_dump($this->load->library('form_validation'));
        $this->load->library('form_validation');
        // $this->load->library('form_validation');
        $rules['namauser'] = 'required';
        $rules['userpass'] = 'required';
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login/loginView');
        }
    }
    function validation()
    {
        $this->load->model('userModel');
        $data['alert'] = $this->userModel->formValidation();

        $this->load->model('userModel');
        if (!empty($data['alert'])) {
            $this->session->set_flashdata('alert', $data['alert']);
            redirect('user/login');
        } else {
            $this->session->set_userdata('login', 'ok');
            $this->session->set_userdata('admin', $this->input->post('namauser'));

            redirect(site_url() . '/c_naivebayes/homedata');
        }
    }
}
