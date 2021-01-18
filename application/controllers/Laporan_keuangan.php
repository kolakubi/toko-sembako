<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_keuangan extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->model('laporan_keuangan_model');
	}

	public function index()
	{
		$this->load->view('laporan_keuangan');
    }
    
    public function read(){

        if ($this->laporan_keuangan_model->read()->num_rows() > 0) {
			foreach ($this->laporan_keuangan_model->read()->result() as $transaksi) {
				$tanggal = new DateTime($transaksi->tgl_input);
				$data[] = array(
					'id_kas' => $transaksi->id_kas,
                    // 'jumlah_uang' => $transaksi->jumlah_uang,
                    // 'posisi_kas' => $transaksi->posisi_kas,
                    'keterangan_kas' => $transaksi->keterangan_kas,
                    'debet' => $transaksi->posisi_kas == "D" ? number_format($transaksi->jumlah_uang, 0, ',', '.') : 0,
                    'kredit' => $transaksi->posisi_kas == "K" ? number_format($transaksi->jumlah_uang, 0, ',', '.') : 0,
					'tgl_input' => $tanggal->format('d-m-Y H:i:s'),
					'metode_pembayaran' => $transaksi->metode_pembayaran
				);
			}
		} else {
			$data = array();
		}
		$transaksi = array(
			'data' => $data
		);
		echo json_encode($transaksi);
	}
	
	public function sisa_uang(){
		echo $this->laporan_keuangan_model->getSisaUangCash();
	}

	public function sisa_uang_transfer(){
		echo $this->laporan_keuangan_model->getSisaUangTransfer();
	}

}

/* End of file Laporan_penjualan.php */
/* Location: ./application/controllers/Laporan_penjualan.php */