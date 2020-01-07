<?php

class M_NaiveBayes extends CI_Model
{
    function dataForm()
    {
        $namaProduk = [
            'Kemeja Flanel',
            'Hem Pendek Giordano',
            'Baju Kaos 3 Second',
            'Kemeja Motif',
            'Kaos Polos',
            'Kemeja Giordano',
            'Baju Koko',
            'Kemeja Jeans',
            'Baju Polo Jeans',
            'Kemeja Polo Panjang',
            'Kemeja Pantai Kasual',
            'Kemeja Kantor Alisan',
        ];
        $ukuran = [
            'S',
            'M',
            'L',
            'XL',
            'XXL'
        ];
        $daftarHarga = [
            'murah',
            'sedang',
            'mahal'

        ];
        $daftarWarna = [
            'Merah',
            'Kuning',
            'Hijau',
            'Putih',
            'Biru',
            'Navy',
            'Hitam',
            'Maroon',
            'Biru Langit',
            'Pink'
        ];

        $dataForm['namaproduk'] = $namaProduk;
        $dataForm['ukuran'] = $ukuran;
        $dataForm['daftarHarga'] = $daftarHarga;
        $dataForm['daftarWarna'] = $daftarWarna;
        return $dataForm;
    }
    function getDataTraining()
    {
        $table = "kasus";
        $kolom = "*";
        $hasil = $this->getData($table, $kolom);
        return $hasil;
    }

    //fungsi yang akan menampilkan data penjualan dalam bentuk tabel
    function getDataPenjualan()
    {
        return $this->db->get('datapenjualan');
    }

    function getDataHasil()
    {
        // $arr = [];
        $hasil = $this->getData("daftaratribut", "namaAtribut");


        foreach ($hasil->result_array() as $hsl) {
            // comment for temporary while calculate all of value for perhitungan's tabel

            // mengambil jumlah total kasus yang dari atribut yang nilainya sama dengan data baru
            $namaKolom = $hsl['namaAtribut'];
            // echo $namaKolom . "<br/>";
            foreach ($this->input->post() as $dataForm) {

                $totalKasus = $this->db->where([$namaKolom => $dataForm])->from('kasus')->count_all_results();
                if ($totalKasus == 0) {
                    continue;
                } else {
                    // echo $dataForm . " : " . $totalKasus  . "<br/>";
                }

                //get data play = yes
                $playYes = $this->db->where([$namaKolom => $dataForm, "play" => "yes"])->from('kasus')->count_all_results();
                // echo $dataForm . " : " . $playYes  . "<br/>";
                //get data play = no
                $playNo = $this->db->where([$namaKolom => $dataForm, "play" => "no"])->from('kasus')->count_all_results();
                // echo $dataForm . " : " . $playNo  . "<br/>";
                //  update tabel perhitungan
                $data = [
                    'id' => '',
                    'namaAtribut' => $namaKolom,
                    'nilaiAtribut' => $dataForm,
                    'jumlahKasus' => $totalKasus,
                    'jumlahYes' => $playYes,
                    'jumlahNo' => $playNo,
                    'probabilitasYes' => 0,
                    'probabilitasNo' => 0
                ];
                $this->db->insert('perhitungan', $data);
            }
        }


        // menghitung jumlah probabilitas yes dan no
        $this->db->select('namaAtribut, jumlahKasus, jumlahYes, jumlahNo');
        $dataJumlah = $this->db->get('perhitungan');

        foreach ($dataJumlah->result_array() as $data) {
            $namaAtribut = $data['namaAtribut'];
            $probabilitasYes = ($data['jumlahYes'] == 0) ? 0 : $data['jumlahYes'] / $data['jumlahKasus'];
            $probabilitasNo = ($data['jumlahNo'] == 0) ? 0 : $data['jumlahNo'] / $data['jumlahKasus'];

            echo "Probabilitas yes " . $probabilitasYes . "<br/>";
            echo "Probabilitas no " . $probabilitasNo . "<br/>";
            echo br(2);

            // update data perhitungan probabilitas
            $data = [
                'probabilitasYes' => $probabilitasYes,
                'probabilitasNo' => $probabilitasNo
            ];

            $this->db->where('namaAtribut', $namaAtribut);
            $this->db->update('perhitungan', $data);
        }
        // die;
    }

    function getDataPrediksi()
    {
        $this->getDataHasil();
        // data tabel perhitungan
        $data['dataTabelPrediksi'] = $this->db->get('perhitungan')->result_array();

        //data hasil prediksi
        $data['hslPrediksi'] = $this->hasilPrediksi();


        return $data;
    }

    // get data prediksi for data penjualan
    function getDataPrediksiPenjualan()
    {
        $this->insertTablePerhitungan();
        // data tabel perhitungan
        $data['dataTabelPrediksi'] = $this->db->get('perhitungan')->result_array();

        //data hasil prediksi
        $data['hslPrediksi'] = $this->hasilPrediksiData();


        return $data;
    }


    //prediksi untuk data percobaan
    function hasilPrediksi()
    {
        $query = $this->db->query('SELECT * FROM kasus');
        $jumahTotalKasus =  $query->num_rows();
        $totalYes = $this->db->where(["play" => "yes"])->from('kasus')->count_all_results();
        $totalNo = $this->db->where(["play" => "no"])->from('kasus')->count_all_results();
        $totalKasus = $this->db->get('kasus')->num_rows('kasus');
        $this->db->select('jumlahKasus, probabilitasYes, probabilitasNo');
        $data['prediksi'] = $this->db->get('perhitungan');
        $resultYes = 1;
        $resultNo = 1;
        foreach ($data['prediksi']->result_array() as $dataPrediksi) {
            $resultYes *= $dataPrediksi['probabilitasYes'];
            $resultNo *= $dataPrediksi['probabilitasNo'];
        }
        $prediksiYes = ($resultYes > 0) ? $resultYes * ($totalYes / $totalKasus) : 0;
        $prediksiNo = ($resultNo > 0) ? $resultNo * ($totalNo / $totalKasus) : 0;

        $keterangan = ($prediksiYes > $prediksiNo) ? "Play = yes " : "Play = no ";
        $data['prediksi'] = ["jumlahTotalKasus" => $jumahTotalKasus, "totalYes" => $totalYes, "totalNo" => $totalNo, "resultYes" => $resultYes, "resultNo" => $resultNo, "prediksiYes" => $prediksiYes, "prediksiNo" => $prediksiNo, "keterangan" => $keterangan];
        return $data;
    }

    // fungsi untuk menngambil data
    function getData($table, $column)
    {
        if (!empty($table) && !empty($column))
            $sqlStr = "select $column from $table";
        else
            echo "nama tabel dan kolom salah";
        $hasil = $this->db->query($sqlStr);
        return $hasil;
    }








    // hasil prediksi untuk data penjualan
    function hasilPrediksiData()
    {
        $query = $this->db->query('SELECT * FROM datapenjualan');
        $jumahTotalKasus =  $query->num_rows();
        $totalYes = $this->db->where(["status" => "laris"])->from('datapenjualan')->count_all_results();
        $totalNo = $this->db->where(["status" => "tidak laris"])->from('datapenjualan')->count_all_results();
        $totalKasus = $this->db->get('datapenjualan')->num_rows('datapenjualan');
        $this->db->select('jumlahKasus, probabilitasYes, probabilitasNo');
        $data['prediksi'] = $this->db->get('perhitungan');
        $resultYes = 1;
        $resultNo = 1;
        foreach ($data['prediksi']->result_array() as $dataPrediksi) {
            $resultYes *= $dataPrediksi['probabilitasYes'];
            $resultNo *= $dataPrediksi['probabilitasNo'];
        }
        $prediksiYes = ($resultYes > 0) ? $resultYes * ($totalYes / $totalKasus) : 0;
        $prediksiNo = ($resultNo > 0) ? $resultNo * ($totalNo / $totalKasus) : 0;


        $keterangan = ($prediksiYes > $prediksiNo) ? "status = Laris " : "Status = tidak Laris ";
        $data['prediksi'] = ["jumlahTotalKasus" => $jumahTotalKasus, "totalYes" => $totalYes, "totalNo" => $totalNo, "resultYes" => $resultYes, "resultNo" => $resultNo, "prediksiYes" => $prediksiYes, "prediksiNo" => $prediksiNo, "keterangan" => $keterangan];
        return $data;
    }


    function singleData($id)
    {

        return $this->db->get_where('datapenjualan', ['id' => $id])->result_array();
    }


    // function for real case
    function insertTablePerhitungan()
    {
        $daftarAtribut = $this->db->select('namaatribut')->from('daftaratributprediksi')->get()->result_array();
        foreach ($daftarAtribut as $namaatribut) {
            $namaKolom = $namaatribut['namaatribut'];
            //mendapatkan jumlah total kasus dari setiap atribut
            // $totalKasus = $this->db->where();
            //for debugging purpose

            // end of debugging
            foreach ($this->input->post() as $dataForm) {
                $totalKasus = $this->db->where([$namaKolom => $dataForm])->from('datapenjualan')->count_all_results();

                if ($totalKasus == 0) {
                    continue;
                } else {
                }

                //get data status = laris
                $laris = $this->db->where([$namaKolom => $dataForm, "status" => "laris"])->from('datapenjualan')->count_all_results();
                $tidaklaris = $this->db->where([$namaKolom => $dataForm, "status" => "tidak laris"])->from('datapenjualan')->count_all_results();

                //debugging purpose

                $data = [
                    'id' => '',
                    'namaatribut' => $namaKolom,
                    'nilaiAtribut' => $dataForm,
                    'jumlahKasus' => $totalKasus,
                    'jumlahYes' => $laris,
                    'jumlahNo' => $tidaklaris,
                    'probabilitasYes' => 0,
                    'probabilitasNo' => 0
                ];
                $this->db->insert('perhitungan', $data);
            }
        }


        //menghitung jumlah probabilitas
        $this->db->select('namaAtribut, jumlahKasus, jumlahYes, jumlahNo');
        $dataJumlah = $this->db->get('perhitungan');

        foreach ($dataJumlah->result_array() as $data) {
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            $namaAtribut = $data['namaAtribut'];
            $probabilitasYes = ($data['jumlahYes'] == 0) ? 0 : $data['jumlahYes'] / $data['jumlahKasus'];
            $probabilitasNo = ($data['jumlahNo'] == 0) ? 0 : $data['jumlahNo'] / $data['jumlahKasus'];

            // update data perhitungan

            $data = [
                'probabilitasYes' => $probabilitasYes,
                'probabilitasNo' => $probabilitasNo
            ];

            $this->db->where('namaAtribut', $namaAtribut);
            $this->db->update('perhitungan', $data);
        }
        // die;
    }


    //menangkap data baru
    function getDatabaru()
    {
        $namaproduk = $this->input->post('productname');
        $ukuran = $this->input->post('size');
        $warna = $this->input->post('color');
        $harga = $this->input->post('price');
        $jumlah = $this->input->post('sales');
        $status = $this->input->post('status');

        $data = [
            'namaproduk' => $namaproduk,
            'ukuran' => $ukuran,
            'warna' => $warna,
            'harga' => $harga,
            'jml_pembelian' => $jumlah,
            'status' => $status
        ];

        return $data;
    }

    //masukkan data baru ke tabel
    function tambahData()
    {
        $data = $this->getDatabaru();
        $this->db->insert('datapenjualan', $data);
    }

    function dataupdate()
    {

        $data = [
            'id' => $this->input->post('id'),
            'namaproduk' => $this->input->post('productname'),
            'ukuran' => $this->input->post('sizes'),
            'harga' => $this->input->post('prices'),
            'warna' => $this->input->post('colors'),
            'jml_pembelian' => $this->input->post('sale'),
            'status' => $this->input->post('keterangan')
        ];
        // var_dump($data);
        // die;
        $this->db->where(['id' => $data['id']]);
        $this->db->update('datapenjualan', $data);
    }

    function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('datapenjualan');
    }


    function searchingData()
    {
        $keyword = $this->input->post('keyword');
        $this->db->like('namaproduk', $keyword);
        $this->db->or_like('ukuran', $keyword);
        $this->db->like('warna', $keyword);
        $this->db->like('harga', $keyword);
        $this->db->like('jml_pembelian', $keyword);
        $this->db->like('status', $keyword);

        return $this->db->get('datapenjualan')->result_array();
    }

    function dataChart()
    {
        $query = "SELECT COUNT(namaproduk) as jumlah, namaproduk from datapenjualan GROUP BY namaproduk";

        $result = $this->db->query($query);
        $data = [];
        foreach ($result->result_array() as $datasingle) {
            $data['jml'][] = $datasingle['jumlah'];
            $data['namaproduk'][] = $datasingle['namaproduk'];
        }
        // while ($raw = $result->result_array()) {
        //     $data['jml'][] = $raw['jumlah'];
        //     $data['namaproduk'][] = $raw['namaproduk'];
        // }
        // var_dump($data);
        // die;
        return $data;
    }
}
