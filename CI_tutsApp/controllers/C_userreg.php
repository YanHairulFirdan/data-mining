<?php
class C_userreg extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array("html", "form", "url", "text"));
    }

    public function form()
    {
        // echo "ini dari function form";
        $this->load->library('form_validation');
        $this->load->model("M_userreg");
        $data = $this->M_userreg->userdef();

        // $this->form_validation->set_rules("username", "Nama User", "trim|required|min_length[5]|max_length[15]");
        // $this->form_validation->set_rules("userpass", "Password", "trim|required|matches[userpassv]");
        // $this->form_validation->set_rules("userpassv", "Konfirmasi", "trim|required");
        // $this->form_validation->set_rules("useremail", "Email", "trim|required|valid_email");


        $this->form_validation->set_rules($this->M_userreg->userrules());
        $data['aksi'] = site_url() . "/c_userreg/form";
        if ($this->form_validation->run() == false) {
            $data['judulApp'] = "Registrasi Pengguna";
            $this->load->view("form/v_c_userreg_form", $data);
            // var_dump($this->form_validation->run());
        } else {
            $data['judulApp'] = "Registrasi Berhasil";
            $this->load->view("form/v_c_userreg_sukses", $data);
            var_dump($data);
        }
    }
    public function htmlForm()
    {
        $this->load->view("form/formView");
    }

    function formextval()
    {
        $this->load->library('form_validation');
        $this->load->model("m_userreg");
        $data = $this->m_userreg->userdef();
        $userrules = $this->m_userreg->userrulesext();
        $this->form_validation->set_rules($userrules);
        $data['aksi'] = site_url() . "/c_userreg/formextval";
        if ($this->form_validation->run() == false) {
            $data['judulApp'] = "Registrasi Pengguna dengan extended validation";
            $this->load->view("form/v_c_userreg_form", $data);
            // var_dump($this->form_validation->run());
        } else {
            $data['judulApp'] = "Registrasi Berhasil";
            $this->load->view("form/v_c_userreg_sukses", $data);
            var_dump($data);
        }
    }
}
