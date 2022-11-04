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
<title>Data Bahan Keluar</title>
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
			<h2>Transaksi Bahan : Keluar</h2>
			<h4>(Inventory)</h4>
				<div class="data-tables datatable-dark">
					<table class="display" id="dataTable3" style="width:100%"><thead class="thead-dark">
											<tr>
												<th>Tanggal_Keluar</th>
												<th>No</th>
												<th>Nama_Barang</th>
												<th>Jenis</th>
												<th>Harga</th>
												<th>Jumlah</th>
												<th>Satuan</th>
												<th>Total_Harga</th>
												<th>Penerima</th>
												<th>Keterangan</th>
												
												<!--<th>Opsi</th>-->
											</tr></thead><tbody>
											<?php 
											$brg=mysqli_query($conn,"SELECT * FROM sbrg_keluar sb, sstock_brg st where sb.idx=st.idx ORDER BY tgl ASC");
											$no=1;
											$jumlah_barang_keseluruhan = 0;
											$jumlah_harga_keseluruhan = 0;
											while($b=mysqli_fetch_array($brg)){
												if (!$b['tahun'] || $b['tahun'] <= 0) {
													$tahun_stock = DateTime::createFromFormat("Y-m-d", $b['tanggal']);
													$tahun_stock = $tahun_stock->format("Y");
												}
												else {
													$tahun_stock = $b['tahun'];
												}
												if ($b['jenis'] == $filter_tipe || $filter_tipe == 'Semua') {
													if ($tahun_stock == $filter_tahun || $filter_tahun == 9999) {
														$jumlah_barang_keseluruhan += $b['jumlah']; 
														$jumlah_harga_keseluruhan += $b['jumlah'] * $b['harga']; 
												?>
													<tr>
														<td><?php $tanggals=$b['tgl']; echo date("Y-m-d", strtotime($tanggals)) ?></td>
														<td><?php echo $no++ ?></td>
														<td><?php echo $b['nama'] ?></td>
														<td><?php echo $b['jenis'] ?></td>
														<td><?php echo 'Rp.' . $b['harga'] ?></td>
														<td><?php echo $b['jumlah'] ?></td>
														<td><?php echo $b['satuan'] ?></td>
														<td><?php echo 'Rp.' . $b['jumlah'] * $b['harga'] ?></td>
														<td><?php echo $b['penerima'] ?></td>
														<td><?php echo $b['ket_keluar'] ?></td>
													</tr>		
											<?php 
													}
												}
											}
											?>
											<tr>
												<td>&weierp;&raquo;</td>
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
										<!-- <tbody align="justify">
											<tr>
												<th>tess1</th>
												<th>tess2</th>
											</tr>
											<tr>
												<td>test1</td>
												<td>test2</td>
											</tr>
										</tbody> -->
										</table>
										<!-- <table>
											<thead class="thead-dark">
											<tr>
												<th>No</th>
												<th>Tanggal</th>
												<th>Nama Barang</th>
												<th>Jenis</th>
												<th>Harga</th>
												<th>Jumlah</th>
												<th>Satuan</th>
												<th>Total</th>
												<th>Penerima</th>
												<th>Keterangan</th>
												
												<th>Opsi</th>
											</tr></thead>
										</table> -->
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