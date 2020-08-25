<?php
class C_mycal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('text');
    }

    function index()
    {
        $this->load->library('calendar');
        $data['varkal'] = $this->calendar->generate();
        $data['judulApp'] = "Kalender dengan library calendar";
        $this->load->view('v_c_mycal', $data);
        // var_dump(site_url());
        // var_dump(base_url());
    }
    function haribesar()
    {

        $this->load->library('calendar');
        $this->load->model('M_calendar');
        $data['hari'] = $this->M_calendar->dataHariBesar();
        //data inside of controller
        // var_dump($data['hari']); 
        // $tahun = 2019;
        // $bulan = '11';
        // $aharibesar = [
        //     10 => site_url() . "/c_mycal/infohari/$tahun/$bulan/10"
        // ];
        // $data['varkal'] = $this->calendar->generate($tahun, $bulan, $aharibesar);
        // using data from model
        $data['varkal'] = $this->calendar->generate($data['hari']['tahun'], $data['hari']['bulan'], $data['hari']['atanggal']);


        $data['judulApp'] = "Kalender dengan hari besar";
        $this->load->view('v_c_mycal', $data);
    }
    function infohari($tahun, $bulan, $tanggal)
    {
        $ainfohari = [
            '20191110' => "Hari Pahlawan Nasional"
        ];
        $data['infohari'] = $ainfohari[$tahun . $bulan . $tanggal];
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['tanggal'] = $tanggal;
        $data['judulApp'] = "info hari besar";
        $this->load->view('v_c_mycal_haribesar', $data);
    }
    function show()
    {
        $prefs = [
            'show_next_prev' => TRUE,
            'next_prev_url' => site_url() . "/c_mycal/show"
        ];
        $this->load->library('calendar', $prefs);
        $data['varkal'] = $this->calendar->generate($this->uri->segment(3), $this->uri->segment(4));
        $data['judulApp'] = "Navigasi Kalender";
        $this->load->view('v_c_mycal', $data);
    }
    public function tahun($tahun = 2019)
    {
        $this->load->library('calendar');
        $abulan = array();
        for ($i = 1; $i < 13; $i++) {
            $bulan = str_pad($i, 2, '0', STR_PAD_LEFT);
            $abulan[$bulan] = $this->calendar->generate($tahun, $bulan);
            // var_dump($abulan);
        }
        // var_dump($abulan);   
        $data['varkal'] = $abulan;
        // var_dump($data['varkal']);
        $data['judulApp'] = "Kalender Tahun $tahun";
        $this->load->view('v_c_mycal_tahun', $data);
    }

    function mytpl()
    {
        $prefs = [
            'show_next_prev' => TRUE,
            'next_prev_url' => site_url() . "/c_mycal/mytpl"
        ];

        $prefs['template'] = '
        {table_open}<table border="0" cellpadding="0" cellspacing="0" width="400px" height="400px">{/table_open}
        {heading_row_start}<tr>{/heading_row_start}
        {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
        {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
        {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
        {heading_row_end}</tr>{/heading_row_end}
        {week_row_start}<tr>{/week_row_start}
        {week_day_cell}<th>{week_day}</th>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}
        {cal_row_start}<td>{/cal_row_start}
        {cal_cell_start}<td>{/cal_cell_start}
        {cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}
        {cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}     
        {cal_cell_no_content}{day}{/cal_cell_no_content}
        {cal_cell_no_content_today}<div class="highlight"><a href="
        {content}">{day}</a></div>{/cal_cell_no_content_today}
        {cal_cell_blank}&nbsp;{cal_cell_blank}
        {cal_cell_end}</td>{/cal_cell_end}
        {cal_row_end}</tr>{/cal_row_end}
        {table_close}</table>{/table_close}
       ';

        $this->load->library('calendar',  $prefs);
        $data['varkal'] = $this->calendar->generate($this->uri->segment(3), $this->uri->segment(4));
        $data['judulApp'] = "Template Kalendar";
        $this->load->view('v_c_mycal', $data);
    }
}
