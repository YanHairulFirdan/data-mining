<?php

class M_dbcibook extends CI_Model
{
    function gettblteman()
    {
        $sqlstr = "SELECT * FROM tblteman";
        $hslquery = $this->db->query($sqlstr);
        return $hslquery;
    }
    function uruttblteman()
    {
        $sqlstr = "SELECT * FROM tblteman ORDER BY namateman DESC";
        $hslquery = $this->db->query($sqlstr);
        return $hslquery;
    }
    function getjtrecord()
    {
        return $this->db->count_all('tblteman');
    }

    function gettemanpage($p = 0, $jppage = 2)
    {
        $sqlstr = 'SELECT * FROM tblteman';
        $sqlstr .= " LIMIT $p, $jppage ";
        $hslquery = $this->db->query($sqlstr);
        return $hslquery;
    }
}
