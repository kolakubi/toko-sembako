<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Transaksi</title>
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/select2/css/select2.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/style/custom_style.css') ?>">
  <?php $this->load->view('partials/head'); ?>
  <style>
    @media(max-width: 576px){
      .nota{
        justify-content: center !important;
        text-align: center !important;
      }
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<!-- loading overlay  -->
<?php $this->load->view('partials/overlay'); ?>

<div class="wrapper">

  <?php $this->load->view('includes/nav'); ?>

  <?php $this->load->view('includes/aside'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col">
            <h1 class="m-0 text-dark">Pembelian</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <!-- <label>Barcode</label> -->
              <label>Barang</label>
              <div class="form-inline">
                <select id="barcode" placeholder="pilih barang" class="form-control select2 col-sm-6" onchange="getNama()"></select>
                <span class="ml-3 text-muted" id="nama_produk"></span>
              </div>
              <small class="form-text text-muted" id="sisa"></small>
            </div>
            <div class="form-group">
              <label>Jumlah</label>
              <input type="number" class="form-control col-sm-6" placeholder="Jumlah" id="jumlah" onchange="checkEmpty()">
            </div>
            <div class="form-group">
              <label>Harga Per Item</label>
              <input type="number" class="form-control col-sm-6" placeholder="harga per item" id="harga_per_item" value=0>
            </div>
            <div class="form-group">
              <button id="tambah" class="btn btn-success" onclick="checkStok()" disabled>Tambah</button>
              <button id="bayar" class="btn btn-success" data-toggle="modal" data-target="#modal" disabled>Bayar</button>
            </div>
          </div>
          <div class="col-sm-6 d-flex justify-content-end text-right nota">
            <div>
              <div class="mb-0">
                <!-- <b class="mr-2">Nota</b> <span id="nota"></span> -->
              </div>
              <span id="total" style="font-size: 1px; line-height: 1" class="text-danger">0</span>
              <br>
              <p id="total2" style="font-size: 70px; line-height: 1" class="text-danger">0</p>
            </div>
          </div>
        </div>
        </div>
        <div class="card-body">
          <table class="table w-100 table-bordered table-hover" id="transaksi">
            <thead>
              <tr>
                <!-- <th>Barcode</th> -->
                <th>Barang</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Actions</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

</div>

<div class="modal fade" id="modal">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title">Bayar</h5>
    <button class="close" data-dismiss="modal">
      <span>&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <form autocomplete="off" id="form">
      <div class="form-group">
        <label>Tanggal</label>
        <input type="text" class="form-control" name="tanggal" id="tanggal" required>
      </div>
      <div class="form-group">
        <label>Supplier</label>
        <select name="supplier" id="supplier" class="form-control select2" required></select>
      </div>
      <div class="form-group">
        <label>No. Nota</label>
        <input placeholder="nomor nota" id="no_nota" type="text" class="form-control" name="no_nota">
      </div>
      <div class="form-group">
        <label>Jumlah Uang Cash</label>
        <input placeholder="Jumlah Uang" type="number" class="form-control" value="0" name="jumlah_uang" onkeyup="kembalian()">
      </div>
      <div class="form-group">
        <label>Jumlah Uang Transfer</label>
        <input placeholder="Jumlah Uang Transfer" type="number" class="form-control" value="0" name="jumlah_uang_transfer" onkeyup="kembalian()">
      </div>
      <!-- <div class="form-group">
        <label>Metode Pembayaran</label>
        <select name="metode_pembayaran" id="metode_pembayaran" class="form-control">
          <option value="cash">Cash</option>
          <option value="transfer">Transfer</option>
        </select>
      </div> -->
      <div class="form-group" style="display: none;">
        <label>Diskon</label>
        <input placeholder="Diskon" type="number" class="form-control" onkeyup="kembalian()" name="diskon">
      </div>
      <div class="form-group">
        <label>Keterangan</label>
        <input placeholder="Item apa yang dijual" type="text" class="form-control" name="keterangan" id="keterangan">
      </div>
      <div class="form-group">
        <b>Total Bayar:</b> 
        <span class="total_bayar" style="font-size: 0.1px"></span>
        <span class="total_bayar2" style="font-weight: bold; color: red"></span>
      </div>
      <div class="form-group">
        <b>Kembalian:</b> <span class="kembalian"></span>
      </div>
      <button id="add" class="btn btn-success" type="submit" onclick="bayar()" disabled>Bayar</button>
      <button id="cetak" class="btn btn-success" type="submit" onclick="bayarCetak()" disabled style="display: none">Bayar Dan Cetak</button>
      <!-- <button id="invoice" class="btn btn-warning">Buat Invoice</button> -->
      <button class="btn btn-danger" data-dismiss="modal">Close</button>
    </form>
  </div>
</div>
</div>
</div>
<!-- ./wrapper -->
<?php $this->load->view('includes/footer'); ?>
<?php $this->load->view('partials/footer'); ?>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/select2/js/select2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/moment/moment.min.js') ?>"></script>
<script>
  var produkGetNamaUrl = '<?php echo site_url('produk/get_nama') ?>';
  var produkGetStokUrl = '<?php echo site_url('produk/get_stok') ?>';
  var addUrl = '<?php echo site_url('stok_masuk/add') ?>';
  var getBarcodeUrl = '<?php echo site_url('produk/get_barcode') ?>';
  var supplierSearchUrl = '<?php echo site_url('supplier/search') ?>';
  var cetakUrl = '<?php echo site_url('transaksi/cetak/') ?>';
</script>
<script src="<?php echo base_url('assets/js/unminify/stok_masuk.js') ?>"></script>
</body>
</html>
