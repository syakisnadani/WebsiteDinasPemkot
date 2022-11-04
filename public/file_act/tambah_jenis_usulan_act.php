<?php
include 'dbconnect.php';
//check if form is submitted
if (isset($_POST['submit']))
{
    
}
$jenis_baru = $_POST['jenis_baru'];
$assigned_place = $_POST['assigned_place'];
if($assigned_place == "Database") $url = "database";
else if($assigned_place == "Upload") $url = "upload";

$sql = "INSERT INTO jenis_usulan(jenis_usulan) VALUES('$jenis_baru')";
$query = mysqli_query($conn, $sql);

if($query)
{
    echo   "<div class='alert alert-success'>
            <strong>Success!</strong> Redirecting you back in 1 seconds.
            </div>
        
            <meta http-equiv='refresh' content='1; url=/" . $url . "'> ";
}
else
{
    // header("Location: /upload?st=error");
    echo " <div class='alert alert-warning'>
            <strong>Failed!</strong> Redirecting you back in 1 seconds.
            </div>
        
            <meta http-equiv='refresh' content='1; url=/" . $url . "'> ";
}
?>

<head>
  <title>Tambah Jenis Usulan</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>