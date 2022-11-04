<?php 
include 'dbconnect.php';
$nama=$_POST['nama'];
$jenis=$_POST['jenis'];
  if (!$jenis) {
    $jenis='Lain-lain';
  }
$harga=$_POST['harga'];
  if (!$harga) {
    $harga=1;
  }
$satuan=$_POST['satuan'];
  if (!$satuan) {
    $satuan='Unit';
  }
$stock=$_POST['stock'];
  if (!$stock) {
    $stock=1;
  }
$total=$harga * $stock;
$tanggal=$_POST['tanggal']; 
  if (!$tanggal) {
    $tanggal=date('Y-m-d');
  }
$tahun = DateTime::createFromFormat("Y-m-d", $tanggal); 
$tahun = $tahun->format('Y');
  if (!$tahun) {
    $tahun=date('Y');
  }
$kode_barang=$_POST['kode_barang'];
$keterangan=$_POST['keterangan'];
  if (!$keterangan) {
    $keterangan='-';
  }
	  
$query = mysqli_query($conn,"insert into sstock_brg values('','$nama','$tanggal','$tahun','$jenis','$harga','$stock','$satuan','$total','$kode_barang','$keterangan')");
if ($query){

echo " <div class='alert alert-success'>
    <strong>Success!</strong> Redirecting you back in 1 seconds.
  </div>
<meta http-equiv='refresh' content='1; url=/stock'>  ";
} else { echo "<div class='alert alert-warning'>
    <strong>Failed!</strong> Redirecting you back in 1 seconds.
  </div>
 <meta http-equiv='refresh' content='1; url=/stock'> ";
}
 
?>
 
  <html>
<head>
  <title>Tambah Barang</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>