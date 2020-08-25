<?php
class C_tblteman extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['html', 'form', 'url', 'text']);
    }
    public function index()
    {

        $this->load->library('table');
        // array_push($atlpteman, ["anggi", "0484684764"]);
        $atlpteman = [
            ["ilham", "086756755"],
            ["Sultoni", "038347367"],
            ["Rahtomi", "0723626276"],
            ["Unieee", "0284648474"],
            ["Parjoko", "03783366"],
            ["Wardoyo", "948474909"],
        ];

        $this->table->set_heading(["nama", "no.telepon"]);
        $data['vartbl'] = $this->table->generate($atlpteman);
        $data['judulApp'] = "Tabel data teman";
        $this->load->view('v_c_tblteman', $data);
    }
}
