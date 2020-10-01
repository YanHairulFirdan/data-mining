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
        $dataset = $this->splitData($mode);

        $dataInsert = [];
        $likehood = ["success" => 1, "fail" => 1];
        $occurance = ["success" => 1, "fail" => 1];
        // $likehoodNo = 0.0;
        // echo br();
        // echo 'jumlah kfold ' . count($dataset);
        // echo br();
        // die;
        // looping through the dataset, for training it will be only 9 data take from real case data's table
        for ($i = 0; $i < count($dataset); $i++) {
            // echo "jumlah data = " . count($dataset);
            // die;
            // comment for testing and if maintain was complete undo this comment
            foreach ($dataset[$i] as $key => $value) {
                $data_status  = ['data_status' => 'testing'];
                $this->db->where(['id' => $value['id']]);
                $this->db->update('kasus', $data_status);
            }
            // end foreach
            $dataInsert = [];
            // this was for real process
            // $this->db->select('AVG(age) as age, AVG(time) as time, AVG(number_of_warts) as number_of_warts, AVG(area) as area, AVG(induration_diameter) as induration_diameter');
            // $this->db->where(['result_of_treatment' => 'success', 'data_status' => '']);
            // $mean['success'] = $this->db->get('kasus')->result_array();

            // $this->db->select('AVG(age) as age, AVG(time) as time, AVG(number_of_warts) as number_of_warts, AVG(area) as area, AVG(induration_diameter) as induration_diameter');
            // $this->db->where(['result_of_treatment' => 'fail', 'data_status' => '']);
            // $mean['fail'] = $this->db->get('kasus')->result_array();

            // for maintaining only
            $this->db->select('AVG(age) as age, AVG(time) as time, AVG(number_of_warts) as number_of_warts, AVG(area) as area, AVG(induration_diameter) as induration_diameter');
            $this->db->where(['result_of_treatment' => 'success', 'data_type' => '']);
            $mean['success'] = $this->db->get('kasusrealdata')->result_array();

            $this->db->select('AVG(age) as age, AVG(time) as time, AVG(number_of_warts) as number_of_warts, AVG(area) as area, AVG(induration_diameter) as induration_diameter');
            $this->db->where(['result_of_treatment' => 'fail', 'data_type' => '']);
            $mean['fail'] = $this->db->get('kasusrealdata')->result_array();

            // end maintaining

            foreach ($this->numericData as $key => $numeric) {
                // calculate mean and standard deviation
                $dataInsert['attribute_name'] = $numeric;
                foreach ($this->conditions as $key => $condition) {
                    // get mean
                    $this->db->select($numeric);
                    // $arr = $this->db->get_where('kasus', ['result_of_treatment' => $condition])->result_array();
                    $arr = $this->db->get_where('kasusrealdata', ['result_of_treatment' => $condition, 'data_type' => ''])->result_array();
                    $std = $this->standard_deviation($arr);
                    $dataInsert['mean' . $condition] = $mean[$condition][0][$numeric];
                    // echo $mean[$condition][0][$numeric] . br();
                    // echo "jumlah atribut " . $numeric . " untuk kondisi " . $condition;
                    // echo "<pre>";
                    // print_r(count($arr));
                    // echo br();
                    // print_r($std);

                    $dataInsert['std_deviation' . $condition] = $std;
                }
                // die;
                $this->db->insert('mean_and_stdeviation', $dataInsert);
                // $dataInsert = [];
                // echo "<pre>";
                // print_r($dataInsert);
                // echo "<pre>";
            }

            // die;
            // looping through dataset-i $dataset[$i]
            foreach ($dataset as $keys => $data) {
                $this->posteriorCalculation($data, 0);
            }
            // die;
            $this->db->where(['data_status' => 'testing']);
            $this->db->update('kasus', ['data_status' => '']);
            $this->db->query("TRUNCATE mean_and_stdeviation");
            // die;
        }

        foreach ($dataset as $keys => $data) {
            $this->posteriorCalculation($data, 0);
        }
        die;
    }


    public function posteriorCalculation($data, $iteration)
    {


        $dataInsert = [];

        // $this->;
        $posterior = [
            'success' => 1,
            'fail' => 1
        ];



        // print_r($data);
        // die;
        foreach ($data as $keyattr => $attribute) {
            // echo "atribute = " . $keyattr . br();
            if (($keyattr != 'id') && ($keyattr != 'result_of_treatment') && ($keyattr != 'data_type') && ($keyattr != 'data_status')) {
                foreach ($this->conditions as $key => $condition) {
                    if (in_array($keyattr, $this->numericData)) {
                        $conds = ['attribute_name' => $keyattr];
                        $this->db->select('' . $this->columName[0] . $condition . ',' . $this->columName[1] . $condition . '');
                        $mean_std = $this->db->get_where('mean_and_stdeviation', $conds)->result_array();
                        // echo "<pre>";
                        // print_r($mean_std);
                        // echo "</pre>";
                        $mean = $mean_std[0][$this->columName[0] . $condition];
                        $std = $mean_std[0][$this->columName[1] . $condition];
                        $gaussianDstr = $this->gaussianDistribution($attribute, $mean, $std);
                        $posterior[$condition] *= $gaussianDstr;
                    } else {
                        // $totalOccurance = $this->db->where([$keyattr => $attribute])->from('kasus')->count_all_results();
                        // echo "kay attr : " . $keyattr . br();
                        // echo "attribut : " . $attribute . br();
                        $totalOccurance = $this->db->where(['data_type' => '', 'result_of_treatment' => $condition])->from('kasusrealdata')->count_all_results();
                        // $occurance[$condition] = $this->db->where([$keyattr => $attribute, 'result_of_treatment' => $condition])->from('kasus')->count_all_results();
                        $occurance[$condition] = $this->db->where([$keyattr => $attribute, 'result_of_treatment' => $condition, 'data_type' => ''])->from('kasusrealdata')->count_all_results();
                        $posterior[$condition] *= $occurance[$condition] / $totalOccurance;
                        // echo "total occurance for result of treatment in condition " . $condition . " = " . $totalOccurance . br();
                        // echo "<pre>";
                        // echo "total occurance " . " for " . $keyattr . " with value = " . $attribute . " in condition " . $condition . " = " . $occurance[$condition]  . br();
                        // // print_r($occurance[$condition]);
                        // echo br();
                        // print_r($posterior[$condition]);
                        // echo "</pre>";
                    }
                }
            } elseif ($keyattr == 'id') {

                $datas['id'] =  $attribute;
            } else {

                continue;
            }
        }
        // echo "posterior success " . $posterior['success'] . br();
        // echo "posterior fail " . $posterior['fail'] . br();
        // echo "result : " . ($posterior['success'] > $posterior['fail']) ? 'success' : 'fail' . br();

        // $datas['id'] =  '';
        $datas['iteration'] =  $iteration;
        $datas['posteriorsuccess'] =  $posterior['success'];
        $datas['posteriorfail'] =  $posterior['fail'];
        $datas['result'] =  ($posterior['success'] > $posterior['fail']) ? 'success' : 'fail';
        $datas['real_result'] =  $data['result_of_treatment'];
        echo "result : " . $datas['result'] . br();
        echo "real result : " . $datas['real_result'] . br();
        // $this->db->insert('posterior', $datas);
        // echo "<pre>";
        // print_r($datas);
        // echo "</pre>";
        // else
        // get the probability of the attribute's occurance
        // insert into table prior 
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
        $pi = pi();
        // echo "xi : " . $xi . br();
        // echo "mean : " . $mean . br();
        // echo "standard deviation : " . $standard_deviation . br();
        // $div = (1 / ($standard_deviation * sqrt(2 * $pi))); // acyually using this to replace 2.506
        $div = (1 / ($standard_deviation * sqrt(2 * $pi))); // acyually using this to replace 2.506
        // echo "div = " . $div . br();
        $exp = - (pow(($xi - $mean), 2) / (2 * pow($standard_deviation, 2)));
        $topDiv = - (pow(($xi - $mean), 2));
        // echo "top div " . $topDiv . br();
        // echo "exp = " . $exp . br();
        $bottomDiv = 2 * pow($standard_deviation, 2);
        // echo "bottom div " . $bottomDiv . br();
        $gaussian = $div * exp(($topDiv / $bottomDiv));
        // $gaussian = $div * pow(2.718, ($substraction / $bottomDiv));
        // $gaussian = (1 / $standard_deviation * 2.506) * exp((((pow(($xi - $mean), 2)) / (2 * pow($standard_deviation, 2)))));
        $gaussian = ($gaussian);

        // echo "distribusi normal untuk " . $xi . " = " . $gaussian . br();
        return $gaussian;
    }

    function splitData($mode)
    {

        if ($mode == 'real') {
            $this->db->select('*')->from('kasus')->where(['data_type' => 'original data']);
            $dataset = $this->db->get()->result_array();
            // shuffle($dataset);

        } else if ($mode == 'resampled') {
            $dataset = $this->db->get('kasus')->result_array();
        } else if ($mode == 'realincases') {
            // $this->db->select('*')->from('kasus')->where(['data_type' => 'original data']);
            // $this->db->where(['data_type' => 'testing']);
            $dataset = $this->db->get('kasusrealdata')->result_array();
            // echo "<pre>";
            // echo "<pre>";
            // print_r($dataset);
            // echo "</pre>";
            // // die;
            // return $dataset;
        }
        echo "before shuffled" . br();
        echo "<pre>";
        $i = 0;
        $success = $fail = 0;
        foreach ($dataset as $key => $data) {
            ($data["result_of_treatment"] == 'success') ? $success++ : $fail++;

            if ($i == 17) {
                echo "=======" . br();
                echo "success " . $success . br();
                echo "fail " . $fail . br();
                $i = 0;
                $success = $fail = 0;
            }
            $i++;
        }
        // echo "</pre>";

        $kfold =  $this->session->userdata('kfold');
        // $kfold = intval($kfold);
        // echo $kfold;
        // echo br();
        // die;
        $this->crossvalidation->setKfold($kfold);
        $dataset = $this->crossvalidation->splitData($dataset);
        return $dataset;
    }

    public function changekfold($kfold)
    {
        $this->crossvalidation->setKfold($kfold);
    }
}
