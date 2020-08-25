<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class MY_form_validation extends CI_Form_validation
{
    function __construct()
    {
        parent::__construct();
    }

    function valid_username($username)
    {
        return ((preg_match("/^[a-zA-Z0-9_]+$/", $username)) ? true : false);
    }
}
