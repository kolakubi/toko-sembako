<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

}

/* End of file Laporan_stok_masuk.php */
/* Location: ./application/controllers/Laporan_stok_masuk.php */