<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// uncomment jika di live server
// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

class Laporan_kartu_stok extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->model('laporan_kartu_stok_model');
	}

	public function index()
	{
		$this->load->view('laporan_kartu_stok');
    }
    
    public function read(){
        if ($this->laporan_kartu_stok_model->read()->num_rows() > 0) {
            foreach ($this->laporan_kartu_stok_model->read()->result() as $transaksi) {
                // $tanggal = new DateTime($transaksi->tanggal);
                $barcode = explode(',', $transaksi->id_produk);
                $data[] = array(
                    'tanggal' => $transaksi->tanggal ,
                    'nama' => '<table>'.$this->laporan_kartu_stok_model->getProduk($barcode, $transaksi->qty).'</table>',
                    // 'nama' => $transaksi->nama,
                    'masuk' => $transaksi->posisi == "D" ? $transaksi->qty : 0,
                    'keluar' => $transaksi->posisi == "K" ? $transaksi->qty : 0,
                    'keterangan' => $transaksi->keterangan
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

    public function get_stok_dari_date(){
        $tanggalDari = $_POST['tanggal_dari'];
        $tanggalSampai = $_POST['tanggal_sampai'];
        $idProduk = $_POST['id_produk'];
        $nomor = 0;
        $namaProduk = $this->laporan_kartu_stok_model->get_1_produk($idProduk)[0]['nama_produk'];

        if ($this->laporan_kartu_stok_model->read_by_date($tanggalDari, $tanggalSampai, $idProduk)->num_rows() > 0) {
            // print_r($this->laporan_kartu_stok_model->read_by_date($tanggalDari, $tanggalSampai, $idProduk)->result());
            
            foreach ($this->laporan_kartu_stok_model->read_by_date($tanggalDari, $tanggalSampai, $idProduk)->result() as $transaksi) {
                // $tanggal = new DateTime($transaksi->tanggal);
                $barcode = explode(',', $transaksi->id_produk);
                $pisahMultiItem = $this->laporan_kartu_stok_model->getProduk($barcode, $transaksi->qty, $idProduk);
                $data[] = array(
                    'tanggal' => $transaksi->tanggal ,
                    // 'nama' => '<table>'.$this->laporan_kartu_stok_model->getProduk($barcode, $transaksi->qty).'</table>',
                    'nama' => '<table>'.$pisahMultiItem->nama_produk.'</table>',
                    // 'nama' => $namaProduk,
                    // 'nama' => $transaksi->nama,
                    'masuk' => $transaksi->posisi == "D" ? $pisahMultiItem->qty : 0,
                    'keluar' => $transaksi->posisi == "K" ? $pisahMultiItem->qty : 0,
                    'keterangan' => $transaksi->keterangan,
                    'nomor' => $nomor+=1
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

}

/* End of file Laporan_stok_masuk.php */
/* Location: ./application/controllers/Laporan_stok_masuk.php */