<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function displaypre($teks = "")
{
    $preteks = "<pre>";
    $preteks .= $teks;
    $preteks .= "</pre>";
    return $preteks;
}

function showmessage($teks = "", $tmsg = "normal")
{
    $astyle = [
        "err" => "red",
        "warn" => "orange",
        "normal" => "white"
    ];

    $boxmsg = "<div style='background: {$astyle[$tmsg]};'>";
    $boxmsg .= ($tmsg != "normal") ? $tmsg . "! " : "";
    $boxmsg .= $teks;
    $boxmsg .= "</div>";

    return $boxmsg;
}
