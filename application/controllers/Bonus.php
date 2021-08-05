<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// cek jika ada di hosting
if(!$_SERVER['REMOTE_ADDR']=='127.0.0.1'){
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

class Bonus extends CI_Controller {
	

	public function __construct()
	{
        parent::__construct();
        if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
        // $this->load->helper('form');
        $this->load->model('bonus_model');
	}

	public function index()
	{
		$this->load->view('bonus');
    }

    public function read_by_date(){
        $tanggalDari = $_POST['tanggal_dari'];
		$tanggalSampai = $_POST['tanggal_sampai'];
        $tanggalSampai = str_replace(' ', '/', $tanggalSampai);
		$tanggalSampai = date('Y-m-d', strtotime($tanggalSampai . "+1 days"));

        // ambil array id produk
        $produkIdList = $this->bonus_model->getProductList();

        $detailProduk;
        $pisahMultiItem = [];
        $dataPerItem = [];
        $qtyPerItem = 0;
        $namaItem = '';
        $hasil = [];

        foreach($produkIdList as $key => $value){
            $detailProduk = $this->bonus_model->read_by_date($tanggalDari, $tanggalSampai, $value->id);
            $qtyPerItem = 0;
            $tanggalTransaksi = '';
            foreach($detailProduk as $produk){
                $barcode = explode(',', $produk->id_produk);
                $hasil = $this->bonus_model->getProduk($barcode, $produk->qty, $value->id);
                $qtyPerItem += $hasil->qty;
            }
            
            $detailProdukTerpilih = $this->bonus_model->get_product_name($value->id);
            array_push($dataPerItem, 
            
                [
                    'id_produk'=> $value->id,
                    'nama_produk' => $detailProdukTerpilih->nama_produk,
                    'qty'=> $qtyPerItem,
                    'bonus' => $detailProdukTerpilih->bonus_penjualan,
                    'total_bonus' => $qtyPerItem*$detailProdukTerpilih->bonus_penjualan
                ]
            );

        }
        $data = array();
        $transaksi = array(
            'data' => $dataPerItem
        );

        echo json_encode($transaksi);
    }
}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */