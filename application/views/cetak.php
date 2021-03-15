<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Cetak</title>
</head>
<body>
	<div style="width: 500px; margin: auto;">
		<br>
		<center>
			<?php echo $this->session->userdata('toko')->nama; ?><br>
			<?php echo $this->session->userdata('toko')->alamat; ?><br><br>
			<table width="100%">
				<tr>
					<td><?php echo $nota ?></td>
					<td align="right"><?php echo $tanggal ?></td>
				</tr>
			</table>
			<hr>
			<table width="100%">
				<tr>
					<td width="50%">Nama Produk</td>
					<td width="3%"></td>
					<td width="10%" align="right">Jmlh</td>
					<td width="10%" align="right">Harga</td>
					<td width="15%" align="right">Total Harga</td>
				</tr>
				<?php foreach ($produk as $key): ?>
					<tr>
						<td><?php echo $key->nama_produk ?></td>
						<td></td> 
						<td align="right"><?php echo $key->total ?> Dus</td>
						<td align="right"><?php echo $key->harga_per_item ?></td>
						<td align="right"><?php echo $key->total_harga_per_item ?></td>
					</tr>
				<?php endforeach ?>
			</table>
			<hr>
			<table width="100%">
				<tr>
					<td width="76%" align="right">
						Harga Jual
					</td>
					<td width="23%" align="right">
						<?php echo $total ?>
					</td>
				</tr>
			</table>
			<hr>
			<table width="100%">
				<tr>
					<td width="76%" align="right">
						Total
					</td>
					<td width="23%" align="right">
						<?php echo $total ?>
					</td>
				</tr>
			</table>
			<br>
			Terima Kasih <br>
			<?php echo $this->session->userdata('toko')->nama; ?>
		</center>
	</div>
	<script>
		window.print()
	</script>
</body>
</html>