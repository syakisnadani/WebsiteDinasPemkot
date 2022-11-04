<?php 
    include 'dbconnect.php';
    $id = $_POST['id']; //iddata               
    // $idx = $_POST['idbrg'];
    $barang = $_POST['barang'];
    $tanggal = $_POST['tanggal'];
    $status_peminjaman = $_POST['status_peminjaman'];
    $berita_acara = $_POST['berita_acara'];
    // $kode_barang = $_POST['kode_barang'];
    $keterangan = $_POST['keterangan'];
    $peminjam = $_POST['peminjam'];
    $file = $_POST['file'];
    $peminjam = $_POST['peminjam'];
    

    $updatedata = mysqli_query($conn,"update asset_keluar set barang='$barang', tgl='$tanggal', status_peminjaman='$status_peminjaman', peminjam='$peminjam', ket_keluar='$keterangan', berita_acara='$berita_acara', file='$file' where id='$id'");

    if ($updatedata){

        echo " <div class='alert alert-success'>
            <strong>Success!</strong> Redirecting you back in 1 seconds.
        </div>
        <meta http-equiv='refresh' content='1; url=/asset/keluar'>  ";
        } else { echo "<div class='alert alert-warning'>
            <strong>Failed!</strong> Redirecting you back in 3 seconds.
        </div>
        <meta http-equiv='refresh' content='3; url=/asset/keluar'> ";
        };

    // $connect_stock_db = mysqli_query($conn,"select * from asset_brg where idx='$idx'"); //lihat stock barang itu saat ini
    // $stock_data = mysqli_fetch_array($connect_stock_db); //ambil datanya
    // $curr_quantity = $stock_data['stock'];//jumlah stock_data skrg

    /*$lihatdataskrg = mysqli_query($conn,"select * from  asset_keluar where id='$id'"); //lihat qty saat ini
    $preqtyskrg = mysqli_fetch_array($lihatdataskrg); 
    $qtyskrg = $preqtyskrg['jumlah'];//jumlah skrg

    if($jumlah >= $qtyskrg){
        //ternyata inputan baru lebih besar jumlah keluarnya, maka kurangi lagi stock barang
        $hitungselisih = $jumlah-$qtyskrg;
        $kurangistock = $curr_quantity-$hitungselisih;

        $queryx = mysqli_query($conn,"update asset_brg set stock='$kurangistock' where idx='$idx'");
        $updatedata1 = mysqli_query($conn,"update asset_keluar set tgl='$tanggal',jumlah='$jumlah',peminjam='$peminjam',ket_keluar='$keterangan' where id='$id'");
        
        //cek apakah berhasil
        if ($updatedata1 && $queryx){

            echo " <div class='alert alert-success'>
                <strong>Success!</strong> Redirecting you back in 1 seconds.
            </div>
            <meta http-equiv='refresh' content='1; url=/asset/keluar'>  ";
            } else { echo "<div class='alert alert-warning'>
                <strong>Failed!</strong> Redirecting you back in 3 seconds.
            </div>
            <meta http-equiv='refresh' content='3; url=/asset/keluar'> ";
            };

    } else {
        //ternyata inputan baru lebih kecil jumlah keluarnya, maka tambahi lagi stock barang
        $hitungselisih = $qtyskrg-$jumlah;
        $tambahistock = $curr_quantity+$hitungselisih;

        $query1 = mysqli_query($conn,"update asset_brg set stock='$tambahistock' where idx='$idx'");

        $updatedata = mysqli_query($conn,"update asset_keluar set tgl='$tanggal', jumlah='$jumlah', peminjam='$peminjam', ket_keluar='$keterangan' where id='$id'");
        
        //cek apakah berhasil
        if ($query1 && $updatedata){

            echo " <div class='alert alert-success'>
                <strong>Success!</strong> Redirecting you back in 1 seconds.
            </div>
            <meta http-equiv='refresh' content='1; url=/asset/keluar'>  ";
            } else { echo "<div class='alert alert-warning'>
                <strong>Failed!</strong> Redirecting you back in 3 seconds.
            </div>
            <meta http-equiv='refresh' content='3; url=/asset/keluar'> ";
            };

    };
    */
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