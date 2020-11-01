<?php

class M_NaiveBayes extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('crossvalidation');
    }

    public $numericData = ['age', 'time', 'number_of_warts', 'area', 'induration_diameter'];
    public $conditions = ['success', 'fail'];
    public $columName  = ['mean', 'std_deviation'];
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
        echo "<pre>";
        print_r($hasil);
        echo "</pre>";
        echo "called";
        echo "==================================================";
        foreach ($hasil->result_array() as $hsl) {
            $namaKolom = $hsl['namaAtribut'];

            foreach ($this->input->post() as $dataForm) {

                $totalKasus = $this->db->where([$namaKolom => $dataForm])->from('kasus')->count_all_results();
                if ($totalKasus == 0) {
                    continue;
                } else {
                }

                // if($dataForm == 'jml_')

                //get data play = yes
                $playYes = $this->db->where([$namaKolom => $dataForm, "play" => "yes"])->from('kasus')->count_all_results();
                // echo $dataForm . " : " . $playYes  . "<br/>";
                //get data play = no
                $playNo = $this->db->where([$namaKolom => $dataForm, "play" => "no"])->from('kasus')->count_all_results();

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


    function gaussDistribution($prop)
    {
        // get mean
        // insert tio mean table
        // get attributes
        // calculate standard deviation population for each attribute or single attribute

    }
    // get data prediksi for data penjualan
    // function getDataPrediksiPenjualan()
    // {
    //     $this->insertTablePerhitungan();
    //     // data tabel perhitungan
    //     $data['dataTabelPrediksi'] = $this->db->get('perhitungan')->result_array();

    //     //data hasil prediksi
    //     $data['hslPrediksi'] = $this->hasilPrediksiData();


    //     return $data;
    // }


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
    // function hasilPrediksiData()
    // {
    //     $query = $this->db->query('SELECT * FROM datapenjualan');
    //     $jumahTotalKasus =  $query->num_rows();
    //     $totalYes = $this->db->where(["status" => "laris"])->from('datapenjualan')->count_all_results();
    //     $totalNo = $this->db->where(["status" => "tidak laris"])->from('datapenjualan')->count_all_results();
    //     $totalKasus = $this->db->get('datapenjualan')->num_rows('datapenjualan');
    //     $this->db->select('jumlahKasus, probabilitasYes, probabilitasNo');
    //     $data['prediksi'] = $this->db->get('perhitungan');
    //     $resultYes = 1;
    //     $resultNo = 1;
    //     foreach ($data['prediksi']->result_array() as $dataPrediksi) {
    //         $resultYes *= $dataPrediksi['probabilitasYes'];
    //         $resultNo *= $dataPrediksi['probabilitasNo'];
    //     }
    //     $prediksiYes = ($resultYes > 0) ? $resultYes * ($totalYes / $totalKasus) : 0;
    //     $prediksiNo = ($resultNo > 0) ? $resultNo * ($totalNo / $totalKasus) : 0;


    //     $keterangan = ($prediksiYes > $prediksiNo) ? "status = Laris " : "Status = tidak Laris ";
    //     $data['prediksi'] = ["jumlahTotalKasus" => $jumahTotalKasus, "totalYes" => $totalYes, "totalNo" => $totalNo, "resultYes" => $resultYes, "resultNo" => $resultNo, "prediksiYes" => $prediksiYes, "prediksiNo" => $prediksiNo, "keterangan" => $keterangan];
    //     return $data;
    // }


    function singleData($id)
    {

        return $this->db->get_where('datapenjualan', ['id' => $id])->result_array();
    }


    // function for real case untuk memasukkan jumlah probabilitas 
    // function insertTablePerhitungan()
    // {

    //     $daftarAtribut = $this->db->select('namaatribut')->from('daftaratributprediksi')->get()->result_array();
    //     foreach ($daftarAtribut as $namaatribut) {
    //         $namaKolom = $namaatribut['namaatribut'];
    //         //mendapatkan jumlah total kasus dari setiap atribut
    //         // $totalKasus = $this->db->where();
    //         //for debugging purpose
    //         // echo "<pre>";
    //         // print_r($namaKolom);
    //         // echo "</pre>";
    //         // end of debugging
    //         foreach ($this->input->post() as $index => $dataForm) {
    //             $totalKasus = $this->db->where([$namaKolom => $dataForm])->from('datapenjualan')->count_all_results();
    //             echo $index . "<br>";

    //             if ($totalKasus == 0) {
    //                 continue;
    //             } else {
    //             }


    //             if ($index == 'jml_pembelian') {
    //                 $this->gaussDistribution($dataForm);
    //             }

    //             //get data status = laris
    //             $laris = $this->db->where([$namaKolom => $dataForm, "status" => "laris"])->from('datapenjualan')->count_all_results();
    //             $tidaklaris = $this->db->where([$namaKolom => $dataForm, "status" => "tidak laris"])->from('datapenjualan')->count_all_results();

    //             //debugging purpose

    //             $data = [
    //                 'id' => '',
    //                 'namaatribut' => $namaKolom,
    //                 'nilaiAtribut' => $dataForm,
    //                 'jumlahKasus' => $totalKasus,
    //                 'jumlahYes' => $laris,
    //                 'jumlahNo' => $tidaklaris,
    //                 'probabilitasYes' => 0,
    //                 'probabilitasNo' => 0
    //             ];
    //             $this->db->insert('perhitungan', $data);
    //         }
    //     }


    //     //menghitung jumlah probabilitas
    //     $this->db->select('namaAtribut, jumlahKasus, jumlahYes, jumlahNo');
    //     $dataJumlah = $this->db->get('perhitungan');

    //     foreach ($dataJumlah->result_array() as $data) {
    //         // echo "<pre>";
    //         // print_r($data);
    //         // echo "</pre>";
    //         $namaAtribut = $data['namaAtribut'];
    //         $probabilitasYes = ($data['jumlahYes'] == 0) ? 0 : $data['jumlahYes'] / $data['jumlahKasus'];
    //         $probabilitasNo = ($data['jumlahNo'] == 0) ? 0 : $data['jumlahNo'] / $data['jumlahKasus'];

    //         // update data perhitungan

    //         $data = [
    //             'probabilitasYes' => $probabilitasYes,
    //             'probabilitasNo' => $probabilitasNo
    //         ];

    //         $this->db->where('namaAtribut', $namaAtribut);
    //         $this->db->update('perhitungan', $data);
    //     }
    //     // die;
    // }


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

    function getDataAPI()
    {
        $apiKey = "a275dcb919a86da0506747f7720531b5";
        $apiName = "APIkey";
        $idCity = "1621177";
        date_default_timezone_set("Asia/Jakarta");
        $apiURL = "api.openweathermap.org/data/2.5/weather?id=" . $idCity . "&lang=en&units=mnetric&APPID=" . $apiKey;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $apiURL);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);

        return $data;
    }

    function crossValidation($data)
    {
        // looping for k = 5 times
    }
    function classification($mode)
    {
        $this->db->query("TRUNCATE posterior");
        $this->db->query("TRUNCATE mean_and_stdeviation");
        // $dataset = $this->splitData($mode);
        $table = ($mode == 'realincases') ? 'kasusrealdata' : 'kasus';
        // echo $table;
        // die;
        $this->db->order_by('iteration', 'ASC');
        $dataset = $this->db->get($table)->result_array();
        // looping for cross validation
        // get iteration data from mean and standard deviation table
        // $count = 0;
        for ($i = 0; $i < $this->session->userdata('kfold'); $i++) {
            $this->mean_std($table, $i);
            // echo "running ...." . br();
            foreach ($dataset as $data) {
                // $count++;
                if ($i != $data['iteration']) {
                    // $count = 0;
                    continue;
                }
                // echo "running......" . br();
                $this->posteriorCalculation($data, $i, $table);
            }
            // echo "count = " . $count . br();
        }
    }


    public function partition($mode)
    {

        $table = ($mode == 'realincases') ? 'kasusrealdata' : 'kasus';
        // echo $mode;
        // die;
        $datasets = $this->splitData($mode);
        // echo "<pre>";
        // print_r($datasets);
        // echo "</pre>";
        // die;

        if ($datasets != "ready") {
            foreach ($datasets as $key => $dataset) {
                echo "partisi ke-" . $key . br();
                echo "jumlah data = " . count($dataset) . br();
                foreach ($dataset as $attr => $data) {
                    $update = ['iteration' => $key];
                    $this->db->set($update);
                    $this->db->where('id', $data['id']);
                    $this->db->update($table);
                    // echo $attr  . "data with id = " . $data['id'] . " updated" . br();
                    // echo "id = " . $data['id'] . "." . br();
                }
            }
        }

        // die;
    }
    public function mean_std($table, $iteration)
    {
        $dataInsert = [];
        $this->db->select('AVG(age) as age, AVG(time) as time, AVG(number_of_warts) as number_of_warts, AVG(area) as area, AVG(induration_diameter) as induration_diameter');
        $this->db->where(['result_of_treatment' => 'success', 'iteration <>' => $iteration]);
        $mean['success'] = $this->db->get($table)->result_array();

        $this->db->select('AVG(age) as age, AVG(time) as time, AVG(number_of_warts) as number_of_warts, AVG(area) as area, AVG(induration_diameter) as induration_diameter');
        $this->db->where(['result_of_treatment' => 'fail', 'iteration <>' => $iteration]);
        $mean['fail'] = $this->db->get($table)->result_array();

        // end maintaining

        foreach ($this->numericData as $key => $numeric) {
            // calculate mean and standard deviation
            $dataInsert['attribute_name'] = $numeric;
            foreach ($this->conditions as $key => $condition) {
                // get mean
                $this->db->select($numeric);
                // $arr = $this->db->get_where('kasus', ['result_of_treatment' => $condition])->result_array();
                $arr = $this->db->get_where($table, ['result_of_treatment' => $condition, 'iteration <>' => $iteration])->result_array();
                $std = $this->standard_deviation($arr);
                $dataInsert['mean' . $condition] = $mean[$condition][0][$numeric];

                $dataInsert['std_deviation' . $condition] = $std;
            }
            $dataInsert['iteration'] = $iteration;
            $this->db->insert('mean_and_stdeviation', $dataInsert);
        }
    }

    public function posteriorCalculation($data, $iteration, $tablename)
    {
        $dataInsert = [];
        $posterior = [
            'success' => 1,
            'fail' => 1
        ];

        $prior = [
            'success' => [],
            'fail' => []
        ];
        // echo "iterasi ke-" . $iteration . br();
        foreach ($data as $keyattr => $attribute) {
            // echo "menghitung posterior" . br();
            // echo $keyattr . br();
            // echo "====================" . br();
            if (($keyattr != 'id') && ($keyattr != 'result_of_treatment') && ($keyattr != 'data_type') && ($keyattr != 'data_status') && ($keyattr != 'iteration')) {
                foreach ($this->conditions as $key => $condition) {
                    // echo "condition = " . $condition . br();
                    if (in_array($keyattr, $this->numericData)) {
                        $conds = ['attribute_name' => $keyattr, 'iteration' => $iteration];
                        $this->db->select('' . $this->columName[0] . $condition . ',' . $this->columName[1] . $condition . '');
                        $mean_std = $this->db->get_where('mean_and_stdeviation', $conds)->result_array();
                        // echo "data sekarang = " . $attribute . br();
                        // echo "<pre>";
                        // print_r($mean_std);
                        // echo "</pre>";
                        $mean = $mean_std[0][$this->columName[0] . $condition];
                        $std = $mean_std[0][$this->columName[1] . $condition];
                        $gaussianDstr = $this->gaussianDistribution($attribute, $mean, $std);
                        // echo "nilai gaussian = " . $gaussianDstr . br();
                        $prior[$condition][$keyattr] = $gaussianDstr;
                        $posterior[$condition] *= $gaussianDstr;
                        // echo "=====================" . br();
                        // echo $posterior[$condition] . br();
                        // echo "=====================" . br();
                    } else {
                        $totalData = $this->db->where(['iteration <>' => $iteration])->from($tablename)->count_all_results();
                        $totalOccurance = $this->db->where(['result_of_treatment' => $condition, 'iteration <>' => $iteration])->from($tablename)->count_all_results();
                        $occurance[$condition] = $this->db->where([$keyattr => $attribute, 'result_of_treatment' => $condition, 'iteration <>' => $iteration])->from($tablename)->count_all_results();
                        // echo "data sekarang = " . $attribute . br();

                        $prior[$condition][$keyattr] = $occurance[$condition] / $totalOccurance;
                        $prior[$condition]['total'] = $totalOccurance  / $totalData;
                        $posterior[$condition] *= ($occurance[$condition] / $totalOccurance) * ($totalOccurance / $totalData);
                        // echo "kemunculan atribut " . $keyattr . " dengan nilai " . $attribute . " = " . $occurance[$condition] . "pada kondisi = " . $condition . br();
                    }
                }
            } else {
                continue;
            }
        }

        // echo "<pre>";
        // print_r($posterior);
        // echo "</pre>";
        $datas['iteration'] =  $iteration;
        $datas['posteriorsuccess'] =  $posterior['success'];
        $datas['posteriorfail'] =  $posterior['fail'];
        $datas['result'] =  ($posterior['success'] > $posterior['fail']) ? 'success' : 'fail';
        $datas['real_result'] =  $data['result_of_treatment'];
        $newPosterior = [
            'success' => 1,
            'fail' => 1
        ];
        // echo "==============================" . br();
        // echo "hasil asli = " . $datas['real_result'] . br();
        // echo "hasil prediksi = " .  $datas['result'] . br();
        // echo "<pre>";
        // echo "==============================" . br();
        // print_r($datas);
        // echo "</pre>";
        // echo br();

        foreach ($this->conditions as $key => $condition) {
            foreach ($prior[$condition] as $key => $data) {
                // echo $newPosterior[$condition] . " x " . $data . " = " . $newPosterior[$condition] * $data . br();
                $newPosterior[$condition] *= $data;
            }
        }

        // echo ($newPosterior['success'] > $newPosterior['fail']) ? 'success' : 'fail' . br();
        // print_r($prior);
        $datas['result'] = ($newPosterior['success'] > $newPosterior['fail']) ? "success" : "fail";

        // echo "<pre>";
        // echo "dari array new prior : "  . br();
        // print_r($newPosterior);
        // echo br();
        // echo "result awal : ";
        // print_r($datas['result']);
        // echo br();
        // echo ($newPosterior['success'] > $newPosterior['fail']) ? "success" : "fail" . br();
        // echo "</pre>";
        // echo "<pre>";
        // print_r($prior);
        // echo "dari array posterior : "  . br();
        // print_r($posterior);
        // print_r($datas['result']);
        // echo "</pre>";
        $this->db->insert('posterior', $datas);
    }


    public function testingFun($table)
    {
        $this->db->query("TRUNCATE mean_and_stdeviation");
        $this->db->select('age');
        $arr = $this->db->get_where($table, ['result_of_treatment' => 'fail', 'data_status' => ''])->result_array();
        // get training data
        // foreach()
        $tempArr = [];
        foreach ($arr as $key => $a) {
            array_push($tempArr, $a['age']);
        }
        // echo "<pre>";
        // array_multisort($tempArr);
        // print_r($tempArr);
        // echo "</pre>";
        $mean = array_sum($tempArr) / count($tempArr);
        echo "mean of age = " . $mean . br();
        $this->db->select('*');
        $dataset = $this->db->get_where($table, ['data_status' => 'testing'])->result_array();
        // calculate mean and standard deviation
        // $this->mean_std($table);
        foreach ($dataset as $key => $data) {
            // echo "id = " . $data['id'] . br();
            $this->posteriorCalculation($data, 0, $table);
        }
        // die;
        // calculate prior
        // show result
    }
    /*
        standar deviasi
        std_p = 
    */
    function standard_deviation($arr)
    {

        $meanPow = 0;

        // die;
        $numberofItems = count($arr);
        // $meanPow = pow((array_sum($arr) / $numberofItems), 2);
        foreach ($arr as $key => $a) {
            foreach ($a as $key => $val) {
                $meanPow += $val;
            }
        }
        $meanPow = $meanPow / $numberofItems;
        $meanPow = pow($meanPow, 2);
        // echo  pow((array_sum($arr) / $numberofItems), 2) . br();
        $totalPow = 0;
        foreach ($arr as $a) {
            foreach ($a as $key => $value) {
                $totalPow += pow($value, 2);
            }
        }
        $variance = ((1 / $numberofItems) * $totalPow) - $meanPow;
        $standard_deviation = sqrt($variance);
        return $standard_deviation;
    }


    public function gaussianDistribution($xi, $mean, $standard_deviation)
    {
        // echo "nilai xi = " . $xi . br();
        $pi = pi();
        $div = (1 / (sqrt(2 * $pi) * $standard_deviation)); // acyually using this to replace 2.506
        // echo "div = " . $div . br();
        $substraction = 0 - pow(($xi - $mean), 2);
        $bottomDiv = 2 * pow($standard_deviation, 2);
        $gaussian = $div * exp(($substraction / $bottomDiv));
        $gaussian = ($gaussian);

        // echo "distribusi normal untuk " . $xi . " = " . $gaussian . br();
        return $gaussian;
    }

    function splitData($mode)
    {
        $tabel = '';
        if ($mode == 'resampled') {
            $tabel = 'kasus';
        } elseif ($mode == 'realincases') {
            $tabel = 'kasusrealdata';
        }
        $this->db->select('*')->from($tabel)->where(['result_of_treatment' => 'success']);
        $this->db->order_by('id', 'RANDOM');
        $dataset[0] = $this->db->get()->result_array();
        $this->db->select('*')->from($tabel)->where(['result_of_treatment' => 'fail']);
        $this->db->order_by('id', 'RANDOM');
        $dataset[1] = $this->db->get()->result_array();
        // if ($mode == 'real') {
        //     $this->db->select('*')->from('kasus')->where(['data_type' => 'original data']);
        //     $dataset = $this->db->get()->result_array();
        //     // shuffle($dataset);

        // } else if ($mode == 'resampled') {
        //     $dataset = $this->db->get('kasus')->result_array();
        // } else if ($mode == 'realincases') {
        //     // $this->db->select('*')->from('kasus')->where(['data_type' => 'original data']);
        //     // $this->db->where(['data_type' => 'testing']);
        //     $dataset[0] = $this->db->get('kasusrealdata')->result_array();
        // }
        // echo "</pre>";
        if (isset($dataset[0]['iteration'])) {
            return "ready";
        }
        $kfold =  $this->session->userdata('kfold');
        $this->crossvalidation->setKfold($kfold);
        $dataset = $this->crossvalidation->splitData($dataset);

        return $dataset;
    }

    public function changekfold($kfold)
    {
        $this->crossvalidation->setKfold($kfold);
    }
}
