<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// cek jika ada di hosting
if(!$_SERVER['REMOTE_ADDR']=='127.0.0.1'){
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

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
