<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_keuangan_model extends CI_Model {

	private $table = 'kas';

	public function read()
	{
		$this->db->select();
		$this->db->from($this->table);
		return $this->db->get();
	}

	public function read_by_date($dataDari, $dataSampai){
		$this->db->select();
		$this->db->where('tgl_input >=', $dataDari);
        $this->db->where('tgl_input <=', $dataSampai);
		$this->db->from($this->table);
		return $this->db->get();
	}


	public function penjualanBulan($date)
	{
		$qty = $this->db->query("SELECT qty FROM transaksi WHERE DATE_FORMAT(tanggal, '%d %m %Y') = '$date'")->result();
		$d = [];
		$data = [];
		foreach ($qty as $key) {
			$d[] = explode(',', $key->qty);
		}
		foreach ($d as $key) {
			$data[] = array_sum($key);
		}
		return $data;
	}

	public function transaksiHari($hari)
	{
		return $this->db->query("SELECT COUNT(*) AS total FROM transaksi WHERE DATE_FORMAT(tanggal, '%d %m %Y') = '$hari'")->row();
	}

	public function transaksiTerakhir($hari)
	{
		return $this->db->query("SELECT transaksi.qty FROM transaksi WHERE DATE_FORMAT(tanggal, '%d %m %Y') = '$hari' LIMIT 1")->row();
	}

	public function getAll($id)
	{
		$this->db->select('transaksi.nota, transaksi.tanggal, transaksi.barcode, transaksi.qty, transaksi.total_bayar, transaksi.jumlah_uang, pengguna.nama as kasir');
		$this->db->from('transaksi');
		$this->db->join('pengguna', 'transaksi.kasir = pengguna.id');
		$this->db->where('transaksi.id', $id);
		return $this->db->get()->row();
	}

	public function getName($barcode)
	{
		foreach ($barcode as $b) {
			$this->db->select('nama_produk, harga');
			$this->db->where('id', $b);
			$data[] = $this->db->get('produk')->row();
		}
		return $data;
	}

	public function getSisaUangCash(){

		$data = $this->db->get_where('uang', ['metode' => 'cash'])->row_array();
		if($data){
			return $data['jumlah_uang'];
		}
		return 0;
	}

	public function getSisaUangTransfer(){

		$data = $this->db->get_where('uang', ['metode' => 'transfer'])->row_array();
		if($data){
			return $data['jumlah_uang'];
		}
		return 0;
	}

}

/* End of file Transaksi_model.php */
/* Location: ./application/models/Transaksi_model.php */