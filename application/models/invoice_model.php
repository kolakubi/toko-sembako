<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_model extends CI_Model {

	private $table = 'invoice';

	public function read()
	{
		$this->db->select('invoice.id_invoice, invoice.tanggal, invoice.barcode, invoice.qty, invoice.total_bayar, invoice.jumlah_uang, invoice.diskon, invoice.keterangan, pelanggan.nama as pelanggan, invoice.status');
		$this->db->from($this->table);
		$this->db->join('pelanggan', 'invoice.pelanggan = pelanggan.id', 'left outer');
		
		return $this->db->get();
	}

	public function getAll($id)
	{
		$this->db->select('invoice.nota, invoice.tanggal, invoice.barcode, invoice.qty, invoice.total_bayar, invoice.jumlah_uang, invoice.keterangan, invoice.kasir, invoice.metode_pembayaran, invoice.pelanggan as id_pelanggan, invoice.kasir as id_kasir, pengguna.nama as kasir, pelanggan.nama as pelanggan');
		$this->db->from('invoice');
		$this->db->join('pengguna', 'invoice.kasir = pengguna.id');
		$this->db->join('pelanggan', 'invoice.pelanggan = pelanggan.id');
		$this->db->where('invoice.id_invoice', $id);
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

	public function update($data){

		// update invoice
		$this->db->set('jumlah_uang', $data['jumlah_uang']);
		$this->db->set('metode_pembayaran', $data['metode_pembayaran']);
		$this->db->set('status', $data['status']);
		$this->db->set('tgl_edit', $data['tgl_edit']);
		$this->db->where('nota', $data['nota']);
		
		if($this->db->update($this->table)){

			if($this->createTransaksi($data)){

				return true;

			}
		}
	}

	public function createTransaksi($data){
		return $this->db->insert('transaksi', 
			[
				'barcode' => $data['barcode'],
				'qty' => $data['qty'],
				'total_bayar' => $data['total_bayar'],
				'jumlah_uang' => $data['jumlah_uang'],
				'pelanggan' => $data['pelanggan'],
				'nota' => $data['nota'],
				'kasir' => $data['kasir'],
				'keterangan' => $data['keterangan'],
				'metode_pembayaran' => $data['metode_pembayaran'],
			]
		);
	}

	public function updateStokProduk($terjual, $stok, $id){

		$this->db->set('stok', $stok);
		$this->db->set('terjual', $terjual);
		$this->db->where('id', $id);
		$this->db->update('produk');

		return true;
		
	}

	public function getDataProduk($data){
		return $this->db->get_where('produk', 
			[
				'id' => $data
			]
		)->row_array();
	}

}

/* End of file Transaksi_model.php */
/* Location: ./application/models/Transaksi_model.php */

// isi $productData
		// Array
		// (
		// 	[0] => Array
		// 		(
		// 			[barcode] => 8
		// 			[qty] => 5
		// 		)
		// 	[1] => Array
		// 		(
		// 			[barcode] => 9
		// 			[qty] => 5
		// 		)
		// )

		// foreach($productData as $produk){
		// 	$dataProduk = $this->db->get_where('produk', 
		// 		[
		// 			'id' => $produk['barcode']
		// 		])->row_array();
		// 	$terjual = $dataProduk['terjual'];
		// 	$qty = $dataProduk['stok'];

		// 	$this->db->set('stok', $qty-$produk['qty']);
		// 	$this->db->set('terjual', $terjual+$produk['qty']);
		// 	$this->db->update('produk');
		// }