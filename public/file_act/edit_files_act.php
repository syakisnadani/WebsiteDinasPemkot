<?php 
    include 'dbconnect.php';
    $id_file = $_POST['id'];
    $title = $_POST['nama_data'];
    $department = $_POST['departemen'];
    $jenis_usulan = $_POST['assigned_by'];
    $tahun = $_POST['tahun'];
    $description = $_POST['keterangan'];
    $assigned_place = $_POST['assigned_place'];
    if($assigned_place == "Database") $url = "database";
    else if($assigned_place == "Upload") $url = "upload";


    $updatedata = mysqli_query($conn,"update files_data set title='$title', assigned_by='$jenis_usulan', department='$department', keywords='$tahun', description='$description' where id='$id_file'");
    
    //cek apakah berhasil
    if ($updatedata){

        echo "  <div class='alert alert-success'>
                <strong>Success!</strong> Redirecting you back in 1 seconds.
                </div>
            
                <meta http-equiv='refresh' content='1; url=/" . $url . "'>  
        ";
        } else { echo " <div class='alert alert-warning'>
                        <strong>Failed!</strong> Redirecting you back in 1 seconds.
                        </div>
                    
                        <meta http-equiv='refresh' content='1; url=/" . $url . "'> 
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