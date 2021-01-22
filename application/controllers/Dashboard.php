<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// uncomment jika di live server
// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

class Dashboard extends CI_Controller {
	
	public function index()
	{
		if ($this->session->userdata('status') == 'login' ) {
			$this->load->view('dashboard');
		} else {
			$this->load->view('login');
		}
	}
}
