<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// cek jika ada di hosting
if(!$_SERVER['REMOTE_ADDR']=='127.0.0.1'){
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

class Transaksi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('status') !== 'login' ) {
			redirect('/');
		}
		$this->load->helper('form');
		$this->load->model('transaksi_model');
	}

	public function index()
	{
		$this->load->view('transaksi');
	}

	public function read()
	{
		// header('Content-type: application/json');
		if ($this->transaksi_model->read()->num_rows() > 0) {
			foreach ($this->transaksi_model->read()->result() as $transaksi) {
				$barcode = explode(',', $transaksi->barcode);
				$tanggal = new DateTime($transaksi->tanggal);
				$data[] = array(
					'tanggal' => $tanggal->format('d-m-Y H:i:s'),
					'nama_produk' => '<table>'.$this->transaksi_model->getProduk($barcode, $transaksi->qty).'</table>',
					'total_bayar' => number_format($transaksi->total_bayar, 0, ',', '.'),
					'jumlah_uang' => number_format($transaksi->jumlah_uang, 0, ',', '.'),
					// 'diskon' => $transaksi->diskon,
					'pelanggan' => $transaksi->pelanggan,
					'action' => '<a class="btn btn-sm btn-success" href="'.site_url('transaksi/cetak/').$transaksi->id.'">Print Nota</a>'
					// 'action' => '<a class="btn btn-sm btn-success" href="'.site_url('transaksi/cetak/').$transaksi->id.'">Print</a> <button class="btn btn-sm btn-danger" onclick="remove('.$transaksi->id.')">Delete</button>'
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

	public function read_by_date()
	{
		$tanggalDari = $_POST['tanggal_dari'];
		$tanggalSampai = $_POST['tanggal_sampai'];
		$tanggalSampai = str_replace(' ', '/', $tanggalSampai);
		$tanggalSampai = date('Y-m-d', strtotime($tanggalSampai . "+1 days"));
		$nomor = 0;

		// header('Content-type: application/json');
		if ($this->transaksi_model->read_by_date($tanggalDari, $tanggalSampai)->num_rows() > 0) {
			foreach ($this->transaksi_model->read_by_date($tanggalDari, $tanggalSampai)->result() as $transaksi) {
				$barcode = explode(',', $transaksi->barcode);
				$tanggal = new DateTime($transaksi->tanggal);
				$data[] = array(
					'tanggal' => $tanggal->format('d-m-Y H:i:s'),
					'nama_produk' => '<table>'.$this->transaksi_model->getProduk($barcode, $transaksi->qty).'</table>',
					'total_bayar' => number_format($transaksi->total_bayar, 0, ',', '.'),
					'jumlah_uang' => number_format($transaksi->jumlah_uang, 0, ',', '.'),
					// 'diskon' => $transaksi->diskon,
					'pelanggan' => $transaksi->pelanggan,
					'action' => '<a class="btn btn-sm btn-success" target="_blank" href="'.site_url('transaksi/cetak/').$transaksi->id.'">Print Nota</a>',
					'nomor' => $nomor+=1,
					// 'action' => '<a class="btn btn-sm btn-success" href="'.site_url('transaksi/cetak/').$transaksi->id.'">Print</a> <button class="btn btn-sm btn-danger" onclick="remove('.$transaksi->id.')">Delete</button>'
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

	public function add()
	{
		$produk = json_decode($this->input->post('produk'));
		$labaArray = $this->labaArray($produk);
		$tanggal = new DateTime($this->input->post('tanggal'));
		$jumlahUang = $this->input->post('jumlah_uang');
		$jumlahUangTransfer = $this->input->post('jumlah_uang_transfer');
		$metodePembayaran = '';
		if($jumlahUang == 0){
			$metodePembayaran = 'transfer';
		}
		elseif($jumlahUangTransfer == 0){
			$metodePembayaran = 'cash';
		}
		else{
			$metodePembayaran = 'cash dan transfer';
		}

		foreach($produk as $item){
			$this->transaksi_model->removeStok($item->id, $item->stok);
			$terjualSaatIni = $this->transaksi_model->getTerjual($item->id)['terjual'];
			$terjualSaatIni += $item->terjual;
			$this->transaksi_model->addTerjual($item->id, $terjualSaatIni);
		}

		$data = array(
			'tanggal' => $tanggal->format('Y-m-d H:i:s'),
			'barcode' => implode(',', $this->input->post('produkId')),
			'qty' => implode(',', $this->input->post('qty')),
			'harga_per_item' => implode(',', $this->input->post('harga_per_item')),
			'laba' => implode(',', $labaArray),
			'total_bayar' => $this->input->post('total_bayar'),
			'jumlah_uang' => $jumlahUang,
			'jumlah_uang_transfer' => $jumlahUangTransfer,
			'diskon' => $this->input->post('diskon'),
			'pelanggan' => $this->input->post('pelanggan'),
			'nota' => $this->input->post('nota'),
			'kasir' => $this->session->userdata('id'),
			'keterangan' => $this->input->post('keterangan'),
			'metode_pembayaran' => $metodePembayaran
		);

		if ($this->transaksi_model->create($data)) {
			echo json_encode($this->db->insert_id());
		}
		$data = $this->input->post('form');
	}


	public function labaArray($produk){
		$labaPerItem = array();
		$labaArray = array();
		foreach ($produk as $key=>$item) {

			$stokAda = 0;
			$totalLabaItem = 0;
			// ambil 3 record pembelian terakhir
			$pembelianTerakhir = $this->transaksi_model->getHistoryPembelian($item->id);
			
			foreach($pembelianTerakhir as $listHarga){

				// cek jika ada double karakter
				// yg dipisahkan koma
				if(strpos($listHarga['barcode'], ',')){
					$kodeItem = explode(',', $listHarga['barcode']);
					$qty = explode(',', $listHarga['jumlah']);
					$hargaPerItem = explode(',', $listHarga['harga_per_item']);

					// modif array jika kodeItem sama
					// koma jadi hilang
					// tgl 1 kode barang yg diinginkan
					for($i=0; $i<count($kodeItem); $i++){
						if($kodeItem[$i] == $item->id){
							$listHarga = [
								'tanggal' => $listHarga['tanggal'],
								'barcode' => $kodeItem[$i],
								'jumlah' => $qty[$i],
								'harga_per_item' => $hargaPerItem[$i]
							];
						}
					}
				}

				// jika kode item match
				if($item->id == $listHarga['barcode']){

					// sisa stok pembelian
					$stokAda = $stokAda == 0 ? $item->terjual - $listHarga['jumlah'] : $stokAda - $listHarga['jumlah'];

					// jika stok masih tersedia
					if($stokAda > 0){
						array_push($labaPerItem, [
							'id' => $item->id,
							'jumlah_dijual' => $listHarga['jumlah'],
							'harga_beli' => $listHarga['harga_per_item'],
							'harga_jual' => $item->harga_per_item,
							'laba' => ($item->harga_per_item-$listHarga['harga_per_item'])*$listHarga['jumlah']
						]);
						
						// jumlahkan laba per item
						$totalLabaItem += ($item->harga_per_item-$listHarga['harga_per_item'])*$listHarga['jumlah'];
					}
					else{
						array_push($labaPerItem, [
							'id' => $item->id,
							'jumlah_dijual' => ($stokAda+$listHarga['jumlah']),
							'harga_beli' => $listHarga['harga_per_item'],
							'harga_jual' => $item->harga_per_item,
							'laba' => ($item->harga_per_item-$listHarga['harga_per_item'])*($stokAda+$listHarga['jumlah'])
						]);
						
						// jumlahkan laba per item
						$totalLabaItem += ($item->harga_per_item-$listHarga['harga_per_item'])*($stokAda+$listHarga['jumlah']);
						break;
					}
				}
			} // end foreach pembelianterakhir

			// push jumlah laba per Item
			// otomatis urut sesuai kode item
			array_push($labaArray, $totalLabaItem);
			// print_r($labaArray);
			// die();

		} // end foreach produk

		return $labaArray;
	}

	public function addInvoice()
	{
		$produk = json_decode($this->input->post('produk'));
		$tanggal = new DateTime($this->input->post('tanggal'));

		$data = array(
			'tanggal' => $tanggal->format('Y-m-d H:i:s'),
			'barcode' => implode(',', $this->input->post('produkId')),
			'qty' => implode(',', $this->input->post('qty')),
			'harga_per_item' => implode(',', $this->input->post('harga_per_item')),
			'total_bayar' => $this->input->post('total_bayar'),
			// 'jumlah_uang' => $this->input->post('jumlah_uang'),
			'diskon' => $this->input->post('diskon'),
			'pelanggan' => $this->input->post('pelanggan'),
			'nota' => $this->input->post('nota'),
			'kasir' => $this->session->userdata('id'),
			'keterangan' => $this->input->post('keterangan'),
			'metode_pembayaran' => $this->input->post('metode_pembayaran'),
			'status' => 0
		);
		if ($this->transaksi_model->createInvoice($data)) {
			echo json_encode($this->db->insert_id());
		}
		$data = $this->input->post('form');
	}

	public function delete()
	{
		$id = $this->input->post('id');
		if ($this->transaksi_model->delete($id)) {
			echo json_encode('sukses');
		}
	}

	public function cetak($id)
	{
		$produk = $this->transaksi_model->getAll($id);

		// echo '<pre>';
		// print_r($produk);
		// echo '</pre>';
		// die();
		
		$tanggal = new DateTime($produk->tanggal);
		$barcode = explode(',', $produk->barcode);
		$qty = explode(',', $produk->qty);
		$harga_per_item = explode(',', $produk->harga_per_item);

		$produk->tanggal = $tanggal->format('d m Y H:i:s');

		$dataProduk = $this->transaksi_model->getName($barcode);
		foreach ($dataProduk as $key => $value) {
			$value->total = $qty[$key];
			$value->harga = $value->harga * $qty[$key];
			$value->harga_per_item = number_format($harga_per_item[$key], 0, ',', '.');
			$value->total_harga_per_item = number_format( ($harga_per_item[$key]*$qty[$key]), 0, ',', '.');
		}

		$data = array(
			'nota' => $produk->nota,
			'tanggal' => $produk->tanggal,
			'produk' => $dataProduk,
			'harga_per_item' => $produk->harga_per_item,
			'total' => 'Rp '.number_format($produk->total_bayar, 0, ',', '.'),
			'bayar' => number_format($produk->jumlah_uang, 0, ',', '.'),
			'kembalian' => $produk->jumlah_uang - $produk->total_bayar,
			'kasir' => $produk->kasir
		);
		$this->load->view('cetak', $data);
	}

	public function penjualan_bulan()
	{
		header('Content-type: application/json');
		$day = $this->input->post('day');
		foreach ($day as $key => $value) {
			$now = date($day[$value].' m Y');
			if ($qty = $this->transaksi_model->penjualanBulan($now) !== []) {
				$data[] = array_sum($this->transaksi_model->penjualanBulan($now));
			} else {
				$data[] = 0;
			}
		}
		echo json_encode($data);
	}

	public function transaksi_hari()
	{
		header('Content-type: application/json');
		$now = date('d m Y');
		$total = $this->transaksi_model->transaksiHari($now);
		echo json_encode($total);
	}

	public function transaksi_terakhir($value='')
	{
		header('Content-type: application/json');
		$now = date('d m Y');
		foreach ($this->transaksi_model->transaksiTerakhir($now) as $key) {
			$total = explode(',', $key);
		}
		echo json_encode($total);
	}

}

/* End of file Transaksi.php */
/* Location: ./application/controllers/Transaksi.php */