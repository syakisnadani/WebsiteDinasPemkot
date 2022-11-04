<?php 
    include 'dbconnect.php';
    $id = $_POST['idbrg'];
    $file_name = $_POST['file_name'];
    $assigned_place = $_POST['assigned_place'];
    if($assigned_place == "Database") $url = "database";
    else if($assigned_place == "Upload") $url = "upload";

    $delete = mysqli_query($conn,"delete from files_data where id='$id'");
    unlink("../uploads/" . $file_name);
    //hapus juga semua data barang ini di tabel keluar-masuk
    
    //cek apakah berhasil
    if ($delete){

        echo " <div class='alert alert-success'>
            <strong>Success!</strong> Redirecting you back in 1 seconds.
          </div>
        <meta http-equiv='refresh' content='1; url=/" . $url . "'>  ";
        } else { echo "<div class='alert alert-warning'>
            <strong>Failed!</strong> Redirecting you back in 1 seconds.
          </div>
         <meta http-equiv='refresh' content='1; url=/" . $url . "'> ";
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