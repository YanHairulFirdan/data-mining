<?php
class Membilang
{
    function bilangancacah($angka)
    {
        $satuan = ['nol ', 'satu ', 'dua ', 'tiga ', 'empat ', 'lima ', 'enam ', 'tujuh ', 'delapan ', 'sembilan '];
        $angka = intval($angka);
        return $satuan[$angka];
    }

    function bilanganangka($angka)
    {
        $satuan = ['', 'se ', 'nol ', 'satu ', 'dua ', 'tiga ', 'empat ', 'lima ', 'enam ', 'tujuh ', 'delapan',  'sembilan '];
        $angka = intval($angka);
        return $satuan[$angka];
    }

    function bilanganbelasan($angka)
    {
        return bilanganangka($angka) . " belas";
    }


    function bilangantigadigit($angka)
    {
        $retstr = "";
        $seratus = 100;
        $sepuluh = 10;
        $sisa = $angka % $seratus;
        $ratusan = ($angka - $sisa) / $seratus;
        $angka = $sisa;
        $sisa = $angka % $sepuluh;
        $puluhan = ($angka - $sisa) / $sepuluh;
        $angka = $sisa;

        if ($ratusan > 1) {
            $retstr .= $this->bilanganangka($ratusan) . ' ratus ';
        } else if ($ratusan > 0) {
            $retstr .= " seratus ";
        }

        if ($puluhan > 1) {
            $retstr . $this->bilanganangka($puluhan) . ' puluh ';
        }

        if ($angka > 0) {
            if ($puluhan == 1) {
                $retstr .= $this->bilanganbelasan($angka);
            } else $retstr .= $this->bilangancacah($angka);
        } else {
            if ($puluhan == 1) {
                $retstr .= ' sepuluh ';
            }
        }
        return $retstr;
    }

    function terbilang($bil)
    {
        $retstr = '';

        if (!empty($bil)) {
            if (is_numeric($bil)) {
                $bil = trim($bil);
                $bil = (substr($bil, 0, 1) == "-") ? substr($bil, 0) : $bil;
                $bilang = [
                    [-15, "triliyun"],
                    [-12, "milyar"],
                    [-9, "juta"],
                    [-6, "ribu"],
                    [-3, ""]
                ];
                $sz = strlen($bil) % 3; //12345678
                // echo $sz;
                $bil = str_repeat("0", $sz + 1) . $bil;
                // echo $bil . "<br>";  
                //now bil's length is 9
                for ($i = 0; $i < sizeof($bilang); $i++) {
                    $row = $bilang[$i];
                    $index = $i + 1;
                    if (abs($row[0]) <= strlen($bil)) {
                        $angka = substr($bil, $row[0], 3);
                        echo "perulangan ke-" . $index . " angka =  " . $angka . "<br>";
                        if ($angka > 1) {
                            $retstr .= $this->bilangantigadigit($angka) . $row[1] . " ";
                            // echo $retstr;
                            // echo "perulangan ke-" . $index . " angka =  " . $angka . "<br>";
                        } else if ($angka > 0) $retstr .= (empty($row[1]) ? $this->bilangancacah($angka) : $this->bilanganangka($angka)) . $row[1];
                    }
                }
            } else $retstr = "Maaf bukan bilangan";
        }
        return ucfirst($retstr);
    }

    function membilanginteger($angka)
    {
        $retstr = '';
        if (!empty($angka)) {
            if (is_numeric($angka)) {
                $angka = ($angka > 0) ? $angka : $angka * (-1);
                $bilang = [
                    [1000000000000000, "triliyun"],
                    [100000000000, "milyar"],
                    [1000000000, "juta"],
                    [1000, "ribu"],
                    [1, ""]
                ];

                for ($i = 0; $i < sizeof($bilang); $i++) {
                    $row = $bilang[i];
                    $sisa = $angka % $row[0];
                    $angka = ($angka - $sisa) / $row[0];
                    if ($angka > 1) {
                        $retstr .= $this->bilangantigadigit($angka) . $row[1] . " ";
                    } else if ($angka > 0) {
                        $retstr .= (($row[0] == 1) ? $this->bilangancacah($angka) : $this->bilanganangka($angka)) . $row[0];
                        $angka = $sisa;
                    }
                }
            } else $retstr = "Maaf Bukan Bilangan";
        }
        return $retstr;
    }


    function rupiah($bil, $cbil = "Rp. ", $jdec = 0, $cth = ".", $cdec = ",")
    {
        return $cbil . $this->number_format($bil, $jdec, $cdec, $cth);
    }
}
