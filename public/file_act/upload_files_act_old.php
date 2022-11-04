<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload'])) {
    if ($_FILES['upload_file1']['size'] <= 0) {
        echo "  <div class='alert alert-warning'>
                <strong>Failed! Please choose at least 1 file.</strong> Redirecting you back in 1 seconds.
                </div>
            
                <meta http-equiv='refresh' content='1; url=/upload'> ";
    } else {
        foreach ($_FILES as $key => $value) {
            if (0 < $value['error']) {
                echo 'Error during file upload ' . $value['error'];
            } else if (!empty($value['name'])) {
                $dbConn = mysqli_connect("localhost","root","","inventory") or die('MySQL connect failed. ' . mysqli_connect_error());
                
                $file = "insert into files_data(file_name, type, size, content, saved_date) values('".$value['name']."', '".$value['type']."', '".filesize_formatted($value['size'])."', '".mysqli_escape_string($dbConn, file_get_contents($value['tmp_name']))."', '".date('Y-m-d')."')";
                
                $result = mysqli_query($dbConn, $file) or die(mysqli_error($dbConn));
                
                // $info = "insert into files_info(id)";

                if($result) {
                    echo   "<div class='alert alert-success'>
                            <strong>Success!</strong> Redirecting you back in 1 seconds.
                            </div>
                        
                            <meta http-equiv='refresh' content='1; url=/upload'> ";
                }
                else echo " <div class='alert alert-warning'>
                            <strong>Failed!</strong> Redirecting you back in 1 seconds.
                            </div>
                        
                            <meta http-equiv='refresh' content='1; url=/upload'> ";
            }
            else echo " <div class='alert alert-warning'>
                        <strong>Failed!</strong> Redirecting you back in 1 seconds.
                        </div>
                    
                        <meta http-equiv='refresh' content='1; url=/upload'> ";
        }
    }
}
else echo " <div class='alert alert-warning'>
            <strong>Failed!</strong> Redirecting you back in 1 seconds.
            </div>

            <meta http-equiv='refresh' content='1; url=/upload'> ";

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