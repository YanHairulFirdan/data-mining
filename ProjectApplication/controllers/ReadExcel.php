<?php
if (!defined('BASEPATH')) exit("No direct script access allowed!!");
class ReadExcel extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('excel');
        // $this->load->library('upload');
    }

    function index()
    {

        echo base_url();
        $this->load->view('templates/header');
        $this->load->view('templates/aside');
        $this->load->view('uploadexcel');
        $this->load->view('templates/footer');
    }

    function upload()
    {

        $this->load->library('upload');
        $filename = time() . $_FILES['file']['name'];
        $config['upload_path'] = './fileexcel/';
        $config['file_name'] = $filename;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;

        $this->upload->initialize($config);
        if (!$this->upload->do_upload('file')) {
            $this->upload->display_errors();
        }
        // var_dump($this->upload->data('file'));
        $media = $this->upload->data('file');
        var_dump($filename);
        echo "<br>";
        // $inputFileName = base_url() . 'fileexcel/' . $filename;
        $inputFileName = 'fileexcel/' . $filename;


        try {
            $inputFileType = IOFactory::identify($inputFileName);
            $objReader = IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '":' . $e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($row = 2; $row < $highestRow; $row++) {

            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
            // echo $rowData[0][3] . "<br>";
            // die;
            // continue;
            if ($rowData[0][3] > 80000 && $rowData[0][3] <= 100000) {
                $rowData[0][3] = "murah";
            } elseif ($rowData[0][3] > 100000 && $rowData[0][3] <= 180000) {
                $rowData[0][3] = "sedang";
            } elseif ($rowData[0][3] > 180000 && $rowData[0][3] <= 300000) {
                $rowData[0][3] = "mahal";
            }
            // echo $rowData[0][3];
            // die;
            $data = [
                'id' => '',
                'namaproduk' => $rowData[0][0],
                'ukuran' => $rowData[0][1],
                'warna' => $rowData[0][2],
                'harga' => $rowData[0][3],
                'jml_pembelian' => $rowData[0][4],
                'status' => $rowData[0][5]
            ];
            $insert = $this->db->insert('datapenjualan', $data);
            // delete_files($media['file_path'], true);
        }
        redirect(site_url() . '/c_naivebayes/homedata');
    }
}
