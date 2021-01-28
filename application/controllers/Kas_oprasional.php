<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// cek jika ada di hosting
if(!$_SERVER['REMOTE_ADDR']=='127.0.0.1'){
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

class Kas_oprasional extends CI_Controller {
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('kas_oprasional_model');
	}

	public function index(){
		$this->load->view('kas_oprasional');
	}

	public function read()
	{
		$nomor = 0;
		header('Content-type: application/json');
		if ($this->kas_oprasional_model->read()->num_rows() > 0) {
			foreach ($this->kas_oprasional_model->read()->result() as $kas) {
				$data[] = array(
					'nomor' => $nomor+=1,
					'tanggal' => $kas->tanggal,
					'nama' => $kas->orang,
					'keterangan' => $kas->keterangan,
					'debet' => $kas->posisi == "D" ? number_format($kas->jumlah_uang, 0, ',', '.') : 0,
					'kredit' => $kas->posisi == "K" ? number_format($kas->jumlah_uang, 0, ',', '.') :  0,
					'metode_pembayaran' => $kas->metode_pembayaran,
					'action' => '<button class="btn btn-sm btn-success" onclick="edit('.$kas->id_kas_oprasional.')">Edit</button> <button class="btn btn-sm btn-danger" onclick="remove('.$kas->id_kas_oprasional.')">Delete</button>'
				);
			}
		} else {
			$data = array();
		}
		$kas_oprasional = array(
			'data' => $data
		);
		echo json_encode($kas_oprasional);
	}

	public function add()
	{
		$data = array(
			'tanggal' => date('Y-m-d H:i:s'),
			'orang' => $this->input->post('nama'),
			'posisi' => $this->input->post('status'),
			'metode_pembayaran' => $this->input->post('metode_pembayaran'),
			'keterangan' => $this->input->post('keterangan'),
			'jumlah_uang' => $this->input->post('jumlah_uang'),
		);
		
		if($this->kas_oprasional_model->create($data)){
			echo json_encode('sukses');
			
		}else{
			echo json_encode('gagal');
		}
	}

}

/* End of file Kas_oprasional.php */
/* Location: ./application/controllers/Auth.php */