<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
          <div class="col">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6 col-sm-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3 id="transaksi_hari">0</h3>
                <p>Penjualan Hari Ini</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <a href="<?php echo site_url('laporan_penjualan') ?>" class="small-box-footer">
                More Info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- <div class="col-lg-4 col-sm-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 id="transaksi_terakhir">0</h3>
                <p>Produk Transaksi Terakhir</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-bill"></i>
              </div>
              <a href="<?php echo site_url('laporan_penjualan') ?>" class="small-box-footer">
                More Info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div> -->
          <div class="col-lg-6 col-sm-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 id="stok_hari">0</h3>
                <p>Pembelian Hari Ini</p>
              </div>
              <div class="icon">
                <i class="fas fa-archive"></i>
              </div>
              <a href="<?php echo site_url('laporan_stok_masuk') ?>" class="small-box-footer">
                More Info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>


          <div class="col-md-6 col-sm-12">

            <!-- <div class="col-md-12 col-sm-12 mt-4"> -->
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Sisa Uang Cash</h3>
                </div>
                <div class="card-body">
                  <h3 id="sisa_uang"></h4>
                </div>
              </div>
            <!-- </div> -->

            <!-- <div class="col-md-12 col-sm-12 mt-4"> -->
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Sisa Uang Transfer</h3>
                </div>
                <div class="card-body">
                  <h3 id="sisa_uang_transfer"></h4>
                </div>
              </div>
            <!-- </div> -->

          </div><!-- /.col -->

          <div class="col-md-6">
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Stok Produk</h3>
              </div>
              <div class="card-body">
                <div class="chart">
                  <ul class="list-group" id="stok_produk"></li>
                  </ul>
                </div>
                <a href="<?php echo site_url('laporan_kartu_stok') ?>" class="small-box-footer">
                  More Info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-12">
            <h1 class="mt-2 mb-3 h2 text-dark">Grafik</h1>
          </div>
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Produk Terlaris</h3>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="produkTerlaris" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Penjualan Bulan Ini</h3> 
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="bulanIni" style="min-height: 250px; height: 450px; max-height: 450px; max-width: 100%"></canvas>
                </div>
              </div>
            </div>
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
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/chart.js/Chart.min.js') ?>"></script>
<script>
  var transaksi_hariUrl = '<?php echo site_url('transaksi/transaksi_hari') ?>';
  var transaksi_terakhirUrl = '<?php echo site_url('transaksi/transaksi_terakhir') ?>';
  var stok_hariUrl = '<?php echo site_url('stok_masuk/stok_hari') ?>';
  var produk_terlarisUrl = '<?php echo site_url('produk/produk_terlaris') ?>';
  var data_stokUrl = '<?php echo site_url('produk/data_stok') ?>';
  var penjualan_bulanUrl = '<?php echo site_url('transaksi/penjualan_bulan') ?>';
  var readSisaUang = '<?php echo site_url('laporan_keuangan/sisa_uang') ?>'
  var readSisaUangTransfer = '<?php echo site_url('laporan_keuangan/sisa_uang_transfer') ?>'
</script>
<script src="<?php echo base_url('assets/js/unminify/dashboard.js') ?>"></script>
</body>
</html>
