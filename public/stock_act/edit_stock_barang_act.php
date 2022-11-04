<?php 
    include 'dbconnect.php';
    $idx = $_POST['idbrg'];
    $nama = $_POST['nama'];
    $tahun = $_POST['tahun_stock'];
    $jenis = $_POST['jenis'];
    $harga = $_POST['harga'];
    $stock = $_POST['stock'];
    $total = $stock * $harga;
    $satuan = $_POST['satuan'];
    $kode_barang = $_POST['kode_barang'];
    $keterangan = $_POST['keterangan'];
    $tanggal=$_POST['tanggal']; 
    if (!$tanggal) {
        $tanggal=date('Y-m-d');
    }

    // echo "harga " . $harga . "/ stock " . $stock . "/ total " . $total;

    $updatedata = mysqli_query($conn,"update sstock_brg set nama='$nama', tanggal='$tanggal', tahun='$tahun', jenis='$jenis', total='$total', harga='$harga', satuan='$satuan', kode_barang='$kode_barang', keterangan='$keterangan' where idx='$idx'");
    
    //cek apakah berhasil
    if ($updatedata){

        echo " <div class='alert alert-success'>
            <strong>Success!</strong> Redirecting you back in 1 seconds.
            </div>
        
            <meta http-equiv='refresh' content='1; url=/stock'>  
        ";
        } else { echo "<div class='alert alert-warning'>
            <strong>Failed!</strong> Redirecting you back in 1 seconds.
            </div>
         
            <meta http-equiv='refresh' content='1; url=/stock'> 
        ";
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