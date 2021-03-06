<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// cek jika ada di hosting
if(!$_SERVER['REMOTE_ADDR']=='127.0.0.1'){
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

class Auth extends CI_Controller {
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
	}

	public function login()
	{
		if ($this->session->userdata('status') !== 'login' ) {
			if ($this->input->post('username')) {
				$username = $this->input->post('username');
				if ($this->auth_model->getUser($username)->num_rows() > 0) {
					$data = $this->auth_model->getUser($username)->row();
					$toko = $this->auth_model->getToko();
					if (password_verify($this->input->post('password'), $data->password)) {
						$peran = $data->role;
						switch($peran){
							case '1':
								$peran = 'admin';
								break;
							case '2':
								$peran = 'kasir';
								break;
							case '3':
								$peran = 'bos';
								break;
							case '4':
								$peran = 'sales';
								break;
							case '5':
								$peran = 'asisten bos';
								break;
						}
						$userdata = array(
							'id' => $data->id,
							'username' => $data->username,
							'password' => $data->password,
							'nama' => $data->nama,
							'role' => $peran,
							// 'role' => $data->role == '1' ? 'admin' : 'kasir',
							'status' => 'login',
							'toko' => $toko
						);
						$this->session->set_userdata($userdata);
						echo json_encode('sukses');
					} else {
						echo json_encode('passwordsalah');
					}
				} else {
					echo json_encode('tidakada');
				}
			} else {
				$this->load->view('login');
			}
		} else {
			redirect('/');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}

}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */