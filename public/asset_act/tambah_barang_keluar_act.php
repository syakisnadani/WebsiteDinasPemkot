<?php 
include 'dbconnect.php';
$filename = $_FILES['file1']['name'];
if($filename == '')
    echo " <div class='alert alert-warning'>
    <strong>No File Uploaded!</strong> Redirecting you back in 1 seconds.
    </div>
    <meta http-equiv='refresh' content='1; url=/asset/keluar'> ";
else {
  $barang=$_POST['barang'];
  $tanggal=$_POST['tanggal']; 
    if (!$tanggal) {
      $tanggal=date('Y-m-d');
    }
  $peminjam=$_POST['peminjam'];
  $keterangan=$_POST['keterangan']; 
  if (!$keterangan) {
    $keterangan="-";
  }
  $berita_acara=$_POST['berita_acara']; 
  if (!$berita_acara) {
    $berita_acara="-";
  }
  $status_peminjaman = "Sedang dipinjam";
  $path = '../uploads/';
  while(file_exists($path . $filename)) {
    $filename = "_" . $filename;
  }
  
  $query = '';
  $query = mysqli_query($conn,"insert into asset_keluar (tgl,barang,status_peminjaman,peminjam,ket_keluar,berita_acara,file) values('$tanggal','$barang','$status_peminjaman','$peminjam','$keterangan','$berita_acara','$filename')");
  
  
  if($query){
      move_uploaded_file($_FILES['file1']['tmp_name'],($path . $filename));
      echo " <div class='alert alert-success'>
      <strong>Success!</strong> Redirecting you back in 1 seconds.
    </div>
  <meta http-equiv='refresh' content='1; url=/asset/keluar'>  ";
  
  } else {
      echo "<div class='alert alert-warning'>
      <strong>Failed!</strong> Redirecting you back in 1 seconds.
    </div>
   <meta http-equiv='refresh' content='1; url=/asset/keluar'> ";
  }
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