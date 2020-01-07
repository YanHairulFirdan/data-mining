<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function namaBulan($noBulan = " ")
{
    $bulan = [
        "01" => "Januari",
        "02" => "Feruari",
        "03" => "Maret",
        "04" => "April",
        "05" => "Mei",
        "06" => "Juni",
        "07" => "Juli",
        "08" => "Agustus",
        "09" => "September",
        "10" => "oktober",
        "11" => "November",
        "12" => "Desember"
    ];

    $anoBulan = array_keys($bulan);
    $retval =  in_array($noBulan, $anoBulan) ? $bulan[$noBulan] : false;
    return $retval;
}
function namaHari($noHari = -1)
{
    $ahari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
    $retval = (($noHari >= 0) && ($noHari < 6)) ? $ahari[$noHari] : false;
    return $retval;
}
