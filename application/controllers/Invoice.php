<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
        if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
        // $this->load->helper('form');
        $this->load->model('invoice_model');
	}

	public function index()
	{
		$this->load->view('invoice');
    }
    
    public function read(){

        if ($this->invoice_model->read()->num_rows() > 0) {
			foreach ($this->invoice_model->read()->result() as $invoice) {
				$tanggal = new DateTime($invoice->tanggal);
				$buttons = '<a class="btn btn-sm btn-success" href="'.site_url('invoice/cetak/').$invoice->id_invoice.'">Print Nota</a>';
				if(!$invoice->status){
					$buttons = $buttons.' <button class="btn btn-sm btn-info" onclick="edit('.$invoice->id_invoice.')">Bayar</button>';
				}
				$data[] = array(
                    'tanggal' => $tanggal->format('d-m-Y H:i:s'),
                    'id_invoice' => $invoice->id_invoice,
                    'pelanggan' => $invoice->pelanggan,
                    'total_bayar' => number_format($invoice->total_bayar, 0, ',', '.'),
                    'status' => $invoice->status ? "<strong style='color:green'>Lunas</strong>" : "<strong style='color:red'>Belum Lunas</strong>",
                    // 'action' => "<button>aksi</button>"
					'action' => $buttons,
					
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
	
	public function getEdit(){

		$id = $this->input->post('id');
		if ($this->invoice_model->read()->num_rows() > 0) {
			$invoice = $this->invoice_model->getAll($id);

			$data = array(
				'nota' => $invoice->nota,
				'pelanggan' => $invoice->pelanggan,
				'total' => $invoice->total_bayar,
				'keterangan' => $invoice->keterangan,
				'id_pelanggan' => $invoice->id_pelanggan,
				'barcode' => $invoice->barcode,
				'qty' => $invoice->qty,
				'id_kasir' => $invoice->id_kasir
			);
		}
		else{
			$data = array();
		}

		echo json_encode($data);
	}

	public function edit()
	{
		// $produk = json_decode($this->input->post('produk'));
		// $tanggal = new DateTime($this->input->post('tanggal'));
		// $barcode = array();
		// foreach ($produk as $produk) {
		// 	$this->transaksi_model->removeStok($produk->id, $produk->stok);
		// 	$this->transaksi_model->addTerjual($produk->id, $produk->terjual);
		// 	array_push($barcode, $produk->id);
		// }
		
		$barcodes = explode(",", $this->input->post('barcode'));
		$qtys = explode(",", $this->input->post('qty'));
		$productData = [];

		for($i=0; $i<count($barcodes); $i++){
			array_push($productData, 
				[
					'barcode' => $barcodes[$i],
					'qty' => $qtys[$i]
				]
			);
		}

		for($i=0; $i<count($productData); $i++){
			$dataProduk = $this->invoice_model->getDataProduk($productData[$i]['barcode']);

			$terjualDb = $dataProduk['terjual'];
			$stokDb = $dataProduk['stok'];
			$terjualReal = $productData[$i]['qty'];
			$stokReal = $productData[$i]['qty'];

			$terjual = intval($terjualDb)+intval($terjualReal);
			$stok = intval($stokDb)-intval($stokReal);
			$id = $productData[$i]['barcode'];

			$this->invoice_model->updateStokProduk($terjual, $stok, $id);
			
		}


		$data = array(
			'dataproduk' => $productData,
			// 'nama' => $this->input->post('nama'),
			// 'tanggal' => $tanggal->format('Y-m-d H:i:s'),
			'barcode' => $this->input->post('barcode'),
			'qty' => $this->input->post('qty'),
			'total_bayar' => $this->input->post('total_tagihan'),
			'jumlah_uang' => $this->input->post('jumlah_uang'),
			'pelanggan' => $this->input->post('id_pelanggan'),
			'nota' => $this->input->post('no_invoice'),
			'kasir' => $this->input->post('id_kasir'),
			'keterangan' => $this->input->post('keterangan'),
			'metode_pembayaran' => $this->input->post('metode_pembayaran'),
			'status' => 1,
			'tgl_edit' => date("Y-m-d H:i:s"),
		);
		// print_r($data);
		// die();

		if ($this->invoice_model->update($data)) {
			echo json_encode('sukses');
		}
		// echo json_encode('sukses');
	}
    
    public function cetak($id)
	{
		$produk = $this->invoice_model->getAll($id);
		
		$tanggal = new DateTime($produk->tanggal);
		$barcode = explode(',', $produk->barcode);
		$qty = explode(',', $produk->qty);

		$produk->tanggal = $tanggal->format('d m Y H:i:s');

		$dataProduk = $this->invoice_model->getName($barcode);
		foreach ($dataProduk as $key => $value) {
			$value->total = $qty[$key];
			$value->harga = $value->harga * $qty[$key];
		}

		$data = array(
			'nota' => $produk->nota,
			'tanggal' => $produk->tanggal,
			'produk' => $dataProduk,
			'total' => number_format($produk->total_bayar, 0, ',', '.'),
            'kasir' => $produk->kasir,
            'pelanggan' => $produk->pelanggan
		);
		$this->load->view('cetak_invoice', $data);
	}

	


}

/* End of file Laporan_penjualan.php */
/* Location: ./application/controllers/Laporan_penjualan.php */