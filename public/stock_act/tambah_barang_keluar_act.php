<?php 
include 'dbconnect.php';
$barang=$_POST['barang']; //id barang
$qty=$_POST['qty'];
$tanggal=$_POST['tanggal']; 
  if (!$tanggal) {
    $tanggal=date('Y-m-d');
  }
$penerima=$_POST['penerima'];
$ket=$_POST['ket']; 
if (!$ket) {
  $ket="-";
}

$dt=mysqli_query($conn,"select * from sstock_brg where idx='$barang'");
$data=mysqli_fetch_array($dt);
$sisa=$data['stock']-$qty;
$query1 = '';
$query2 = '';
if ($sisa >= 0) {
    $query1 = mysqli_query($conn,"update sstock_brg set stock='$sisa' where idx='$barang'");
    $query2 = mysqli_query($conn,"insert into sbrg_keluar (idx,tgl,jumlah,penerima,ket_keluar) values('$barang','$tanggal','$qty','$penerima','$ket')");
}
else {
    echo    "<div class='alert alert-warning'>
                <strong>Jumlah barang yang anda masukkan tidak tepat!</strong> <br '> Silahkan masukkan kembali jumlah barang dengan memperhatikan stock barang yang ada sekarang.
            </div>
            <meta http-equiv='refresh' content='1; url=/stock/keluar'> ";
} 



if($query1 && $query2){
    echo " <div class='alert alert-success'>
    <strong>Success!</strong> Redirecting you back in 1 seconds.
  </div>
<meta http-equiv='refresh' content='1; url=/stock/keluar'>  ";

} else {
    echo "<div class='alert alert-warning'>
    <strong>Failed!</strong> Redirecting you back in 1 seconds.
  </div>
 <meta http-equiv='refresh' content='1; url=/stock/keluar'> ";
}

?>

<html>
<head>
  <title>Barang Keluar</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>