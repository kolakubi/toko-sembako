<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pelanggan</title>
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2/sweetalert2.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/style/custom_style.css') ?>">
  <?php $this->load->view('partials/head'); ?>
  <?php $role = $this->session->userdata('role'); ?>
  <?php
    if($role == 'kasir'){
      echo "<style>
        table thead tr th:nth-child(6),
        table tbody tr td:nth-child(6){
          display: none;
        }
      </style>";
    }
  ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">

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
            <h1 class="m-0 text-dark">Kas Oprasional</h1>
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
            <button class="btn btn-success" data-toggle="modal" data-target="#modal" onclick="add()">Add</button>
          </div>
          <div class="card-body">
            <table class="table w-100 table-bordered table-hover" id="pelanggan">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Nama</th>
                  <th>Keterangan</th>
                  <th>Debet</th>
                  <th>Kredit</th>
                  <th>Metode</th>
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
    <h5 class="modal-title">Add Data Kas Oprasional</h5>
    <button class="close" data-dismiss="modal">
      <span>&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <form id="form">
      <input type="hidden" name="id">
      <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" placeholder="Nama" name="nama" required>
      </div>
      <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
          <option value="K">Uang Keluar</option>
          <option value="D">Uang Masuk</option>
        </select>
      </div>
      <div class="form-group">
        <label>Metode Pembayaran</label>
        <select name="metode_pembayaran" class="form-control">
          <option value="cash">Cash</option>
          <option value="transfer">Transfer</option>
        </select>
      </div>
      <div class="form-group">
        <label>Keterangan</label>
        <input type="text" class="form-control" placeholder="Keterangan" name="keterangan" required>
      </div>
      <div class="form-group">
        <label>Jumlah Uang</label>
        <input type="number" class="form-control" placeholder="jumlah uang" name="jumlah_uang" required>
      </div>
      <button class="btn btn-success" type="submit">Add</button>
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
<script>
  var readUrl = '<?php echo site_url('kas_oprasional/read') ?>';
  var addUrl = '<?php echo site_url('kas_oprasional/add') ?>';
  var deleteUrl = '<?php echo site_url('kas_oprasional/delete') ?>';
  var editUrl = '<?php echo site_url('kas_oprasional/edit') ?>';
  var get_kas_oprasionalUrl = '<?php echo site_url('kas_oprasional/get_kas_oprasional') ?>';
</script>
<script src="<?php echo base_url('assets/js/unminify/kas_oprasional.js') ?>"></script>
</body>
</html>
