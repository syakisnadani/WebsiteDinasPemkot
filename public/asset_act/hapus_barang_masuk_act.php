<?php 
    include 'dbconnect.php';
    $id = $_POST['id'];
    $idx = $_POST['idx'];

    $lihatstock = mysqli_query($conn,"select * from asset_brg where idx='$idx'"); //lihat stock barang itu saat ini
    $stocknya = mysqli_fetch_array($lihatstock); //ambil datanya
    $stockskrg = $stocknya['stock'];//jumlah stocknya skrg

    $lihatdataskrg = mysqli_query($conn,"select * from asset_masuk where id='$id'"); //lihat qty saat ini
    $preqtyskrg = mysqli_fetch_array($lihatdataskrg); 
    $qtyskrg = $preqtyskrg['jumlah'];//jumlah skrg

    $adjuststock = $stockskrg-$qtyskrg;

    $queryx = mysqli_query($conn,"update asset_brg set stock='$adjuststock' where idx='$idx'");
    $del = mysqli_query($conn,"delete from asset_masuk where id='$id'");

    
    //cek apakah berhasil
    if ($queryx && $del){

        echo " <div class='alert alert-success'>
            <strong>Success!</strong> Redirecting you back in 1 seconds.
          </div>
        <meta http-equiv='refresh' content='1; url=/asset/masuk'>  ";
        } else { echo "<div class='alert alert-warning'>
            <strong>Failed!</strong> Redirecting you back in 1 seconds.
          </div>
         <meta http-equiv='refresh' content='1; url=/asset/masuk'> ";
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