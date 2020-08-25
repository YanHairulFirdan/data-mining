<?php

class M_calendar extends CI_Model
{
    function dataHariBesar()
    {
        $aharibesar = [
            "tahun" => "2019",
            "bulan" => "11",
            "atanggal" => [
                10 => site_url() . "/c_mycal/infohari/2019/11/10"
            ]
        ];
        return $aharibesar;
    }
}
