<?php 
    include 'dbconnect.php';
    $id = $_POST['id'];
    $idx = $_POST['idx'];

    $connect_stock_db = mysqli_query($conn,"select * from sstock_brg where idx='$idx'"); //lihat stock barang itu saat ini
    $stock_data = mysqli_fetch_array($connect_stock_db); //ambil datanya
    $curr_quantity = $stock_data['stock'];//jumlah stock_data skrg

    $lihatdataskrg = mysqli_query($conn,"select * from sbrg_keluar where id='$id'"); //lihat qty saat ini
    $preqtyskrg = mysqli_fetch_array($lihatdataskrg); 
    $qtyskrg = $preqtyskrg['jumlah'];//jumlah skrg

    $adjuststock = $curr_quantity+$qtyskrg;

    $queryx = mysqli_query($conn,"update sstock_brg set stock='$adjuststock' where idx='$idx'");
    $del = mysqli_query($conn,"delete from sbrg_keluar where id='$id'");

    
    //cek apakah berhasil
    if ($queryx && $del){

        echo " <div class='alert alert-success'>
            <strong>Success!</strong> Redirecting you back in 1 seconds.
          </div>
        <meta http-equiv='refresh' content='1; url=/stock/keluar'>  ";
        } else { echo "<div class='alert alert-warning'>
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