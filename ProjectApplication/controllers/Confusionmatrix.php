<?php
class Confusionmatrix extends CI_Controller
{

    public function index()
    {
        $this->load->model('M_ConfusionMatrix');
        $data['dataset'] = $this->M_ConfusionMatrix->performance();
        $data['judul'] = 'hasil performa';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/aside');
        $this->load->view('performances/index', $data);
        $this->load->view('templates/footer');
    }
}
