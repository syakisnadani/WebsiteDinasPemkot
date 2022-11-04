<!doctype html>
<html class="no-js" lang="en">

<?php 
	// include 'cek.php';
	include 'dbconnect.php';

	if (!isset($_POST['filter_tipe'])) {
        $filter_tipe = "Semua";
    } else {
        $filter_tipe = $_POST['filter_tipe'];
    }

    if (!isset($_POST['filter_tahun']) || !$_POST['filter_tahun']) {
        $filter_tahun = 9999;
    } else {
        $filter_tahun = $_POST['filter_tahun'];
    }
	?>

<html>
<head>
<title>Data Stock Barang</title>
<link rel="icon" 
      type="image/png" 
      href="favicon.png">
	   <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-144808195-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-144808195-1');
	</script>

</head>

<body>
		<div class="container">
			<h2>Stock Bahan</h2>
			<h4>(Inventory)</h4>
				<div class="data-tables datatable-dark">
					<table id="dataTable3" class="display" style="width:100%"><thead class="thead-dark">
											<tr>
												<th>Tanggal_Stock</th>
												<th>No</th>
												<th>Nama Barang</th>
												<th>Tahun</th>
												<th>Jenis</th>
												<th>Harga</th>
												<th>Stock</th>
												<th>Satuan</th>
												<th>Total</th>
												<th>Kode Barang</th>
												<th>Keterangan</th>
												
												<!--<th>Opsi</th>-->
											</tr></thead><tbody>
											<?php 
											$brgs=mysqli_query($conn,"SELECT * from sstock_brg order by tanggal ASC");
											$no=1;
											$jumlah_barang_keseluruhan = 0;
											$jumlah_harga_keseluruhan = 0;
											while($p=mysqli_fetch_array($brgs)){
												if (!$p['tahun'] || $p['tahun'] <= 0) {
													$tahun_stock = DateTime::createFromFormat("Y-m-d", $p['tanggal']);
													$tahun_stock = $tahun_stock->format("Y");
												}
												else {
													$tahun_stock = $p['tahun'];
												}
												if ($p['jenis'] == $filter_tipe || $filter_tipe == 'Semua') {
													if ($tahun_stock == $filter_tahun || $filter_tahun == 9999) {
														$jumlah_barang_keseluruhan += $p['stock']; 
														$jumlah_harga_keseluruhan += $p['stock'] * $p['harga']; 
											?>
														<tr>
															<td><?php echo $p['tanggal'] ?></td>
															<td><?php echo $no++ ?></td>
															<td><?php echo $p['nama'] ?></td>
															<?php
																if ($tahun_stock < 0)
															?>
															<td><?php 	if ($tahun_stock < 0) echo "Undefined";
																		else echo $tahun_stock ?></td>
															<td><?php echo $p['jenis'] ?></td>
															<td><?php echo 'Rp.' . $p['harga'] ?></td>
															<td><?php echo $p['stock'] ?></td>
															<td><?php echo $p['satuan'] ?></td>
															<td><?php echo 'Rp.' . $p['stock'] * $p['harga'] ?></td>
															<td><?php echo $p['kode_barang'] ?></td>
															<td><?php echo $p['keterangan'] ?></td>
														</tr>		
											<?php 
													}
												}
											}
											?>
											<!-- </tbody> -->
											<!-- this way is more readable but won't get printed -->
											<!-- <tbody> -->
											<tr>
												<td>&weierp;&raquo;</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td><b>Total: </b></td>
												<td><u><?php echo $jumlah_barang_keseluruhan ?></u></td>
												<td><b>Total: </b></td>
												<td><u><?php echo 'Rp.' . $jumlah_harga_keseluruhan ?></u></td>
												<td></td>
												<td></td>
											</tr>
										</tbody>
										</table>
								</div>
						</div>
	
<script>
$(document).ready(function() {
    $('#dataTable3').DataTable( {
        dom: 'Bfrtip',
        buttons: [
           'copy', 'csv', 'excel', 'pdf', 'print',
        ]
    } );
} );

</script>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

	

</body>

</html>