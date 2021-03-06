<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// cek jika ada di hosting
if(!$_SERVER['REMOTE_ADDR']=='127.0.0.1'){
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

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
					'metode_pembayaran' => $transaksi->metode_pembayaran,
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

	public function read_by_date(){
		$tanggalDari = $_POST['tanggal_dari'];
		$tanggalSampai = $_POST['tanggal_sampai'];
		$tanggalSampai = str_replace(' ', '/', $tanggalSampai);
		$tanggalSampai = date('Y-m-d', strtotime($tanggalSampai . "+1 days"));
		$nomor = 0;

		if ($this->laporan_keuangan_model->read_by_date($tanggalDari, $tanggalSampai)->num_rows() > 0) {
			foreach ($this->laporan_keuangan_model->read_by_date($tanggalDari, $tanggalSampai)->result() as $transaksi) {
				$tanggal = new DateTime($transaksi->tgl_input);
				$data[] = array(
					'id_kas' => $transaksi->id_kas,
                    // 'jumlah_uang' => $transaksi->jumlah_uang,
                    // 'posisi_kas' => $transaksi->posisi_kas,
                    'keterangan_kas' => $transaksi->keterangan_kas,
                    'debet' => $transaksi->posisi_kas == "D" ? number_format($transaksi->jumlah_uang, 0, ',', '.') : 0,
                    'kredit' => $transaksi->posisi_kas == "K" ? number_format($transaksi->jumlah_uang, 0, ',', '.') : 0,
					'tgl_input' => $tanggal->format('d-m-Y H:i:s'),
					'metode_pembayaran' => $transaksi->metode_pembayaran,
					'nomor' => $nomor+=1,
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

	public function read_modif(){
		$tanggalDari = $_POST['tanggal_dari'];
		$tanggalSampai = $_POST['tanggal_sampai'];
		$tanggalSampai = str_replace(' ', '/', $tanggalSampai);
		$tanggalSampai = date('Y-m-d', strtotime($tanggalSampai . "+1 days"));
		$nomor = 0;
		$data = [];

		if ($this->laporan_keuangan_model->read_by_date($tanggalDari, $tanggalSampai)->num_rows() > 0) {
			foreach ($this->laporan_keuangan_model->read_by_date($tanggalDari, $tanggalSampai)->result() as $transaksi) {
				
				$tanggal = new DateTime($transaksi->tgl_input);

				if($transaksi->id_pembelian){
					$result = $this->laporan_keuangan_model->read_kas_debet($transaksi->id_kas);
					
					foreach($result as $result){
						$barcode = explode(',', $result->barcode);
						$data[] = array(
							// 'id_kas' => $result->id_kas,
							// 'keterangan_kas' => $result->keterangan_kas,
							'debet' => $result->posisi_kas == "D" ? number_format($result->jumlah_uang, 0, ',', '.') : 0,
							'kredit' => $result->posisi_kas == "K" ? number_format($result->jumlah_uang, 0, ',', '.') : 0,
							'orang' => $result->nama,
							'nama_produk' => '<table>'.$this->laporan_keuangan_model->getProduk($barcode, $result->jumlah).'</table>',
							// 'jumlah' => $result->jumlah, 
							'tgl_input' => $tanggal->format('d-m-Y H:i:s'),
							'metode_pembayaran' => $result->metode_pembayaran,
							'nomor' => $nomor+=1,
						);
					}
				}

				if($transaksi->id_penjualan){
					$result = $this->laporan_keuangan_model->read_kas_kredit($transaksi->id_kas);

					// echo json_encode($result);
					
					foreach($result as $result){
						$barcode = explode(',', $result->barcode);
						$data[] = array(
							// 'id_kas' => $result->id_kas,
							// 'keterangan_kas' => $result->keterangan_kas,
							'debet' => $result->posisi_kas == "D" ? number_format($result->jumlah_uang, 0, ',', '.') : 0,
							'kredit' => $result->posisi_kas == "K" ? number_format($result->jumlah_uang, 0, ',', '.') : 0,
							'orang' => $result->nama,
							'nama_produk' => '<table>'.$this->laporan_keuangan_model->getProduk($barcode, $result->qty).'</table>',
							// 'jumlah' => $result->qty, 
							'tgl_input' => $tanggal->format('d-m-Y H:i:s'),
							'metode_pembayaran' => $result->metode_pembayaran,
							'nomor' => $nomor+=1,
						);
					}
				}

				// modal awal
				if($transaksi->id_penjualan == 0 &&	 $transaksi->id_pembelian==0){
				    
					$data[] = array(
						// 'id_kas' => $result->id_kas,
						// 'keterangan_kas' => $result->keterangan_kas,
						'debet' => $transaksi->posisi_kas == "D" ? number_format($transaksi->jumlah_uang, 0, ',', '.') : 0,
						'kredit' => $transaksi->posisi_kas == "K" ? number_format($transaksi->jumlah_uang, 0, ',', '.') : 0,
						'orang' => 'Pak Firman',
						'nama_produk' => $transaksi->keterangan_kas,
						'tgl_input' => $tanggal->format('d-m-Y H:i:s'),
						'metode_pembayaran' => $transaksi->metode_pembayaran,
						'nomor' => $nomor+=1,
					);
				}
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