<?php
class userModel extends CI_Model
{
    public function formValidation()
    {
        $username = $this->input->post('namauser');
        $password = $this->input->post('userpass');
        if (empty($username) && empty($password)) {
            // return "<script>alert('username dan password kosong')</script>";
            return "username dan password kosong";
        } else if (empty($username)) {
            return 'username kosong';
        } else if (empty($password)) {
            return 'password kosong';
        } else {
            $data = $this->getDataUser();
            // echo "<pre>";
            // echo $data[0]['username'] . "<br>";
            // print_r($data);
            // echo "</pre>";
            if ($username == $data[0]['username']) {
                if ($password != $data[0]['password']) {
                    return  'password salah';
                }
            } else if ($password == $data[0]['password']) {
                if ($username != $data[0]['username']) {
                    return  'username salah';
                }
            } else if (($username != $data[0]['username']) && ($password != $data[0]['password'])) {
                return  'username dan password salah';
            }
            //  else if (($username == $data[0]['username']) && ($password == $data[0]['password'])) {
            //     return true;
            // }
        }
    }
    public function getDataUser()
    {
        $data = $this->db->get('user')->result_array();
        return $data;
    }
    function matchInput($username, $password)
    {
        $data = $this->getDataUser();
        if ($username == $data[0]['username']) {
            if ($password != $data[0]['password']) {
                return  "<script>alert('password salah')</script>";
            }
        }
    }
}
