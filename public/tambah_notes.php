<!DOCTYPE html>
<html lang="en">
<head>
  <title>Notes</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">

<?php
session_start();
include_once 'stock_act/dbconnect.php';

// $res=mysqli_query($conn,"SELECT * FROM notes WHERE id = ".$_SESSION['id']);

$konten = $_POST['konten'];
$tujuan = $_POST['tujuan'];

if (isset($_POST['user'])) {
  $oleh = $_POST['user'];
} else {
  $oleh='User';
}


$update = "INSERT INTO notes (contents, admin, tujuan) VALUES ('$konten','$oleh','$tujuan')";
$hasil = mysqli_query($conn,$update);


if ($hasil){
//header ('location:view.php');
echo " <div class='alert alert-success'>
    <strong>Success!</strong> Redirecting you back in 1 seconds.
  </div>
<meta http-equiv='refresh' content='1; url=/notes'>  ";
} else { echo "<div class='alert alert-warning'>
    <strong>Failed!</strong> Redirecting you back in 1 seconds.
  </div>
 <meta http-equiv='refresh' content='1; url=/notes'> ";
}
?>

</body>
</html>