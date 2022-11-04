<?php
include 'dbconnect.php';
//check if form is submitted
if (isset($_POST['submit']))
{
    
}
$filename = $_FILES['file1']['name'];
$path = '../uploads/';
$size = filesize_formatted($_FILES['file1']['size']);
$title = $_POST['nama'];
$department = $_POST['departemen'];
$tahun = $_POST['tahun'];
$description = $_POST['keterangan'];
$assigned_place = $_POST['assigned_place'];
$assigned_by = $_POST['assigned_by'];
if($assigned_place == "Database") $url = "database";
else if($assigned_place == "Upload") $url = "upload";

//upload file max 10 mb
if ($_FILES['file1']['size'] > 2*5242880){
    echo " <div class='alert alert-warning'>
    <strong>File exceeded the size limit!</strong> Redirecting you back in 1 seconds.
    </div>
    <meta http-equiv='refresh' content='1; url=/" . $url . "'>
    ";

}
else if($filename != '')
{
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $allowed = ['pdf', 'txt', 'doc', 'docx', 'png', 'jpg', 'jpeg',  'gif'];
    $created = @date('Y-m-d');
    while(file_exists($path . $filename)) {
        $filename = "_" . $filename;
    }
    $sql = "INSERT INTO files_data(title, keywords, department, description, type, file_name, size, saved_date, assigned_place, assigned_by) VALUES('$title', '$tahun', '$department', '$description', '$ext', '$filename', '$size', '$created', '$assigned_place', '$assigned_by')";
    $query = mysqli_query($conn, $sql);

    if($query)
    {
            
        move_uploaded_file($_FILES['file1']['tmp_name'],($path . $filename));
        
        echo   "<div class='alert alert-success'>
                <strong>Success!</strong> Redirecting you back in 1 seconds.
                </div>
            
                <meta http-equiv='refresh' content='1; url=/" . $url . "'> ";
    }
    else
    {
        echo " <div class='alert alert-warning'>
                <strong>Failed!</strong> Redirecting you back in 1 seconds.
                </div>
            
                <meta http-equiv='refresh' content='1; url=/" . $url . "'> ";
    }
}
else
    echo " <div class='alert alert-warning'>
            <strong>No File Uploaded!</strong> Redirecting you back in 1 seconds.
            </div>
        
            <meta http-equiv='refresh' content='1; url=/" . $url . "'> ";

function filesize_formatted($size) {
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}
?>

<head>
  <title>Upload Files</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>