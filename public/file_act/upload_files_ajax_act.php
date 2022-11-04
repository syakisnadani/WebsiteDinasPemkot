<?php

if (isset($_FILES['files']) && !empty($_FILES['files'])) {
    $no_files = count($_FILES["files"]['name']);
    for ($i = 0; $i < $no_files; $i++) {
        if ($_FILES["files"]["error"][$i] > 0) {
            echo "Error: " . $_FILES["files"]["error"][$i] . "<br>";
        } else {
            if (file_exists('uploads/' . $_FILES["files"]["name"][$i])) {
                echo 'File already exists : uploads/' . $_FILES["files"]["name"][$i];
            } else {
                move_uploaded_file($_FILES["files"]["tmp_name"][$i], 'uploads/' . $_FILES["files"]["name"][$i]);
                echo 'File successfully uploaded : uploads/' . $_FILES["files"]["name"][$i] . ' ';
            }
        }
    }
} else {
    echo "<div class='alert alert-warning'>
        <strong>Failed! Please choose at least one file</strong> Redirecting you back in 1 seconds.
        </div>
        <meta http-equiv='refresh' content='1; url=/upload_ajax'> ";
    // echo 'Please choose at least one file';
}
    

/* 
 * End of script
 */

?>

<html>
<head>
  <title>Upload Files</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>