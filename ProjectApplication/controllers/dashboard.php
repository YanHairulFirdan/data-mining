<?php

class Dashboard extends CI_Controller
{
	
	function index()
	{
		$this->load->view("Login/LoginView");
		echo base_url();
	}
}