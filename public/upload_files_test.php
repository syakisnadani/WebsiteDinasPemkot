<?php
include 'dbconnect.php';
//check if form is submitted
if (isset($_POST['submit']))
{
    $filename = $_FILES['file1']['name'];

    //upload file
    if($filename != '')
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $allowed = ['pdf', 'txt', 'doc', 'docx', 'png', 'jpg', 'jpeg',  'gif'];
    
        //check if file type is valid
        // if (in_array($ext, $allowed))
        if(1)
        {
            // get last record id
            $sql = 'select max(id) as id from tbl_files';
            $result = mysqli_query($con, $sql);
            if (!$result)
                $filename = '1' . '-' . $filename;
            else
            {
                $row = mysqli_fetch_array($result);
                $filename = ($row['id']+1) . '-' . $filename;
            }

            //set target directory
            $path = 'uploads/';
                
            $created = @date('Y-m-d H:i:s');
            move_uploaded_file($_FILES['file1']['tmp_name'],($path . $filename));
            
            // insert file details into database
            $sql = "INSERT INTO tbl_files(filename, created) VALUES('$filename', '$created')";
            mysqli_query($con, $sql);
            header("Location: /upload_test?st=success");
        }
        else
        {
            header("Location: /upload_test?st=error");
        }
    }
    else
        header("Location: /upload_test");
}
?>