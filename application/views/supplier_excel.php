<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Supplier</title>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data Pendaftar Ganeksa Volley.xls");
	?>

  <center>
		<h1>Pendaftar Ganeksa Volley Club <br/> Update <?php echo date('d-m-Y') ?></h1>
	</center>

  <table border="1">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>No.Telp</th>
        <th>Keterangan</th>
      </tr>
    </thead>
		<tbody>
      <?php 
      // koneksi database
      $koneksi = mysqli_connect("localhost","root","","kasir");
  
      // menampilkan data pegawai
      $data = mysqli_query($koneksi,"select * from supplier");
      $no = 1;
      while($d = mysqli_fetch_array($data)){
      ?>
      <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $d['nama']; ?></td>
        <td><?php echo $d['alamat']; ?></td>
        <td><?php echo $d['telepon']; ?></td>
        <td><?php echo $d['keterangan']; ?></td>
      </tr>
      <?php 
      }
      ?>
    </tbody>
	</table>
  
</body>
</html>
