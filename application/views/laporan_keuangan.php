<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Keuangan</title>
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <?php $this->load->view('partials/head'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php $this->load->view('includes/nav'); ?>

  <?php $this->load->view('includes/aside'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        
          <div class="col-md-6 col-sm-12">
            <h1 class="m-0 text-dark">Laporan Keuangan</h1>

            <div class="col-md-6 col-sm-12 mt-4">
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Sisa Uang Cash</h3>
                </div>
                <div class="card-body">
                  <h3 id="sisa_uang"></h4>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-sm-12 mt-4">
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Sisa Uang Transfer</h3>
                </div>
                <div class="card-body">
                  <h3 id="sisa_uang_transfer"></h4>
                </div>
              </div>
            </div>

          </div><!-- /.col -->

          <!-- Form Tanggal -->
          <div class="col-md-6 col-sm-12">
            <form>
              <div class="form-group">
                <label>Dari: </label>
                <input type="date" name="tanggaldari" id="tanggal_dari" class="form-control">
              </div>

              <div class="form-group">
                <label>Sampai: </label>
                <input type="date" name="tanggalsampai" id="tanggal_sampai" class="form-control" id="datepembelian">
              </div>

              <div class="form-group">
                <button type="submit" name="submit-date" id="submit-date" class="btn btn-info btn-block">Cari</button>
              </div>
            </form>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <table class="table w-100 table-bordered table-hover" id="laporan_keuangan">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Pelanggan/Supplier</th>
                  <th>Produk</th>
                  <th>Metode Bayar</th>
                  <th>Debet</th> 
                  <th>Kredit</th> 
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
<!-- ./wrapper -->
<?php $this->load->view('includes/footer'); ?>
<?php $this->load->view('partials/footer'); ?>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>

<!-- data table button plugin -->
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>

<script>
  var readUrl = '<?php echo site_url('laporan_keuangan/read') ?>';
  var readModif = '<?php echo site_url('laporan_keuangan/read_modif') ?>';
  var readSisaUang = '<?php echo site_url('laporan_keuangan/sisa_uang') ?>'
  var readSisaUangTransfer = '<?php echo site_url('laporan_keuangan/sisa_uang_transfer') ?>'
  var readDariDate = '<?php echo site_url('laporan_keuangan/read_by_date') ?>';
//   var deleteUrl = '<?php echo site_url('laporan_keuangan/delete') ?>';
</script>
<script src="<?php echo base_url('assets/js/unminify/laporan_keuangan.js') ?>"></script>
</body>
</html>