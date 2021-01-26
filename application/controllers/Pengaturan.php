<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// cek jika ada di hosting
if(!$_SERVER['REMOTE_ADDR']=='127.0.0.1'){
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

class Pengaturan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
	}
	
	public function index()
	{
		$toko = $this->db->get('toko')->row();
		$data['toko'] = $toko;
		$this->load->view('pengaturan', $data);
	}

	public function set_toko()
	{
		$data = array(
			'nama' => $this->input->post('nama'),
			'alamat' => $this->input->post('alamat')
		);
		$this->db->where('id', 1);
		if ($this->db->update('toko', $data)) {
			$this->db->select('nama, alamat');
			$toko = $this->db->get('toko')->row();
			$this->session->set_userdata('toko', $toko);
			echo json_encode('sukses');
		}
	}
}
