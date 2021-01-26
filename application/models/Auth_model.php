<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// cek jika ada di hosting
if(!$_SERVER['REMOTE_ADDR']=='127.0.0.1'){
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

class Auth_model extends CI_Model {

	public function login()
	{
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		return $this->db->get('pengguna')->row();
	}

	public function getUser($username)
	{
		$this->db->where('username', $username);
		return $this->db->get('pengguna');
	}

	public function getToko()
	{
		$this->db->select('nama, alamat');
		return $this->db->get('toko')->row();
	}

}

/* End of file Auth_model.php */
/* Location: ./application/models/Auth_model.php */