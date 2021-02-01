<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Invoice</title>
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/style/custom_style.css') ?>">
  <?php $this->load->view('partials/head'); ?>
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
            <h1 class="m-0 text-dark">Invoice</h1>

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
            <table class="table w-100 table-bordered table-hover" id="invoice">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Pelanggan</th> 
                  <th>Total bayar</th> 
                  <th>Status</th>
                  <th>Cetak</th>
                  <!-- <th>Action</th> -->
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Modal -->
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
                <label>No Invoice</label>
                <input class="form-control" type="text" value="adwhihFOI2ifhiho" name="no_invoice" readonly="true">
              </div>
              <div class="form-group">
                <label>Pelanggan</label>
                <input class="form-control" type="text" value="Berkah" name="pelanggan" readonly="true">
              </div>
              <div class="form-group">
                <label>Total Tagihan</label>
                <input class="form-control" type="number" name="total_tagihan" id="total_tagihan" readonly="true">
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
              <div class="form-group">
                <label>Keterangan</label>
                <input placeholder="Item apa yang dijual" type="text" class="form-control" name="keterangan" id="keterangan">
              </div>
              <div class="form-group">
                <b>Total Bayar:</b> 
                <span class="total_bayar" style="font-size: 0.1px"></span>
                <span class="total_bayar2" style="font-weight: bold; color: red"></span>
              </div>
              <!-- hidden field -->
              <div class=form-group>
                <input type="hidden" class="form-control" name="id_pelanggan" id="id_pelanggan" >
                <input type="hidden" class="form-control" name="barcode" id="barcode" >
                <input type="hidden" class="form-control" name="qty" id="qty" >
                <input type="hidden" class="form-control" name="id_kasir" id="id_kasir" >
              </div>
              <!-- end hidden field -->
              <div class="form-group">
                <b>Kembalian:</b> <span class="kembalian"></span>
              </div>
              <button id="add" class="btn btn-success" type="submit"  disabled>Bayar</button>
              <button class="btn btn-danger" data-dismiss="modal">Close</button>
            </form>

          </div>
        </div>
      </div>
    </div>
    <!-- / .Modal -->
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->
<?php $this->load->view('includes/footer'); ?>
<?php $this->load->view('partials/footer'); ?>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?php echo base_url('assets/vendor/adminlte/plugins/jquery-validation/jquery.validate.min.js') ?>"></script>

<!-- data table button plugin -->
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>

<script>
  var readUrl = '<?php echo site_url('invoice/read') ?>';
  var readEdit = '<?php echo site_url('invoice/getEdit') ?>';
  var editUrl = '<?php echo site_url('invoice/edit') ?>';
</script>
<script src="<?php echo base_url('assets/js/unminify/invoice.js') ?>"></script>
</body>
</html>

