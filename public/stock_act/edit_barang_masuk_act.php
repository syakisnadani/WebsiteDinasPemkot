<?php 
    include 'dbconnect.php';
    $id = $_POST['id']; //iddata
    $idx = $_POST['idx']; //idbarang
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];
    $tanggal = $_POST['tanggal'];

    $lihatstock = mysqli_query($conn,"select * from sstock_brg where idx='$idx'"); //lihat stock barang itu saat ini
    $stocknya = mysqli_fetch_array($lihatstock); //ambil datanya
    $stockskrg = $stocknya['stock'];//jumlah stocknya skrg

    $lihatdataskrg = mysqli_query($conn,"select * from sbrg_masuk where id='$id'"); //lihat qty saat ini
    $preqtyskrg = mysqli_fetch_array($lihatdataskrg); 
    $qtyskrg = $preqtyskrg['jumlah'];//jumlah skrg

    if($jumlah >= $qtyskrg){
        //ternyata inputan baru lebih besar jumlah masuknya, maka tambahi lagi stock barang
        $hitungselisih = $jumlah-$qtyskrg;
        $tambahistock = $stockskrg+$hitungselisih;

        $queryx = mysqli_query($conn,"update sstock_brg set stock='$tambahistock' where idx='$idx'");
        $updatedata1 = mysqli_query($conn,"update sbrg_masuk set tgl='$tanggal',jumlah='$jumlah',keterangan='$keterangan' where id='$id'");
        
        //cek apakah berhasil
        if ($updatedata1 && $queryx){

            echo " <div class='alert alert-success'>
                <strong>Success!</strong> Redirecting you back in 1 seconds.
            </div>
            <meta http-equiv='refresh' content='1; url=/stock/masuk'>  ";
            } else { echo "<div class='alert alert-warning'>
                <strong>Failed!</strong> Redirecting you back in 3 seconds.
            </div>
            <meta http-equiv='refresh' content='3; url=/stock/masuk'> ";
            };

    } else {
        //ternyata inputan baru lebih kecil jumlah masuknya, maka kurangi lagi stock barang
        $hitungselisih = $qtyskrg-$jumlah;
        $kurangistock = $stockskrg-$hitungselisih;

        $query1 = mysqli_query($conn,"update sstock_brg set stock='$kurangistock' where idx='$idx'");

        $updatedata = mysqli_query($conn,"update sbrg_masuk set tgl='$tanggal', jumlah='$jumlah', keterangan='$keterangan' where id='$id'");
        
        //cek apakah berhasil
        if ($query1 && $updatedata){

            echo " <div class='alert alert-success'>
                <strong>Success!</strong> Redirecting you back in 1 seconds.
            </div>
            <meta http-equiv='refresh' content='1; url=/stock/masuk'>  ";
            } else { echo "<div class='alert alert-warning'>
                <strong>Failed!</strong> Redirecting you back in 3 seconds.
            </div>
            <meta http-equiv='refresh' content='3; url=/stock/masuk'> ";
            };

    };
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