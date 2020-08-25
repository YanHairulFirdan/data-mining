<?php

class M_dbqcrud extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function tambah($adata)
    {
        $daftarfield = '(';
        $daftarnilai = '(';
        $i = 0;
        echo "<br>";
        foreach ($adata as $data => $value) {
            if ($i > 0) {
                $daftarfield .= ',';
                $daftarnilai .= ',';
            }

            $daftarfield .= $data;
            $daftarnilai .= "'$value'";
            $i++;
        }
        $daftarnilai .= ' )';
        $daftarfield .= ' )';
        echo $daftarfield . "<br>";
        echo $daftarnilai . "<br>";
        $sqlstr = "INSERT INTO tblteman " . $daftarfield . " values " . $daftarnilai;
        $this->db->query($sqlstr);
        return (($this->db->affected_rows() > 0) ? true : false);
    }
    function getallrecord()
    {
        return $this->db->get('tblteman');
    }
    function getnamaemail()
    {
        $this->db->select('namateman, email');
        $hslquery = $this->db->get('tblteman');
        return $hslquery;
    }

    function readfilter()
    {
        $namafield = $this->input->post('namafields');
        $valfilters = $this->input->post('valfilters');
        return [
            'namafield' => $namafield,
            'valfilters' => $valfilters
        ];
    }

    function getfilterdata($data)
    {
        $this->db->like($data['namafield'], $data['valfilters']);
        return $this->db->get('tblteman');
    }
}
