<?php
class M_userreg extends CI_Model
{
    function userrules()
    {
        $userrules =  [
            [
                "field" => 'username',
                "label" => 'Nama User',
                "rules" => 'trim|required|min_length[5]|max_length[15]'
            ],
            [
                "field" => 'userpass',
                "label" => 'Password',
                "rules" => 'trim|required|matches[userpassv]'
            ],
            [
                "field" => 'userpassv',
                "label" => 'Konfirmasi',
                "rules" => 'trim|required'
            ],
            [
                "field" => 'useremail',
                "label" => 'Email',
                "rules" => 'trim|required|valid_email'
            ]
        ];

        return $userrules;
    }
    function userdef()
    {
        $username = [
            "name" => "username",
            "id" => "username",
            "size" => "10",
            "class" => "form-control",
            "maxlength" => "15",
            "value" => $this->input->post("username"),
            "style" => "background:cyan;"
        ];
        $userpass = [
            "name" => "userpass",
            "id" => "userpass",
            "size" => "10",
            "class" => "form-control",
            "maxlength" => "15",
            "value" => $this->input->post("userpass"),
            "style" => "background:red;"
        ];
        $userpassv = [
            "name" => "userpassv",
            "id" => "userpassv",
            "size" => "10",
            "class" => "form-control",
            "value" => $this->input->post("userpassv"),
            "style" => "background:red;"
        ];
        $useremail = [
            "name" => "useremail",
            "id" => "useremail",
            "size" => "10",
            "class" => "form-control",
            "maxlength" => "15",
            "value" => $this->input->post("useremail"),
            "style" => "background:red;"
        ];

        $auser["username"] = $username;
        $auser["userpass"] = $userpass;
        $auser["userpassv"] = $userpassv;
        $auser["useremail"] = $useremail;

        return $auser;
    }
    function userrulesext()
    {
        $arules = [
            [
                "field" => "username",
                "label" => "Nama user",
                "rules" => 'trim|required|min_length[5]|max_length[15]|valid_username'
            ],
            [
                "field" => "userpass",
                "label" => "Password",
                "rules" => 'trim|required|matches[useroassv]'
            ],
            [
                "field" => "userpassv",
                "label" => "Konfirmasi",
                "rules" => 'trim|required'
            ],
            [
                "field" => "useremail",
                "label" => "Email",
                "rules" => 'trim|required|valid_email'
            ]
        ];
        return $arules;
    }
}
