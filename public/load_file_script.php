<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <!-- <title>Files Save into MySQL Database using PHP</title> -->
        <!-- <style type="text/css">
            body {
                background-color: #fff;
                margin: 40px;
                font: 13px/20px normal Helvetica, Arial, sans-serif;
                color: #4F5155;
            }
            #body{
                margin: 0 15px 0 15px;
            }
            #container{
                margin: 10px;
                width: 600px;
                padding: 10px;
                border: 1px solid #D0D0D0;
                -webkit-box-shadow: 0 0 8px #D0D0D0;
            }
            .error {
                color: #E13300;
            }
            .info {
                color: gold;
            }
            .success {
                color: darkgreen;
            }
        </style> -->
        <!--<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>-->
		<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> -->
    </head>
    <body>
        
    </body>
</html>

<script type="text/javascript">
    $(document).ready(function () {
        $("input[id^='upload_file']").each(function () {
            var id = parseInt(this.id.replace("upload_file", ""));
            $("#upload_file" + id).change(function () {
                if ($("#upload_file" + id).val() !== "") {
                    $("#moreFileUploadLink").show();
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        var upload_number = 2;
        $('#attachMore').click(function () {
            //add more file
            var moreUploadTag = '';
            
			moreUploadTag += '<div class="element"><label for="upload_file"' + upload_number + '>Upload File ' + upload_number + '</label>';
            moreUploadTag += '&nbsp;<input type="file" id="upload_file' + upload_number + '" name="upload_file' + upload_number + '"/>';
            moreUploadTag += '&nbsp;<a href="javascript:void" style="cursor:pointer;" onclick="deletefileLink(' + upload_number + ')">Delete ' + upload_number + '</a></div>';
			
            $('<dl id="delete_file' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreFileUpload');
            
			upload_number++;
        });
    });
</script>

<script type="text/javascript">
    function deletefileLink(eleId) {
        if (confirm("Are you really want to delete ?")) {
            var ele = document.getElementById("delete_file" + eleId);
            ele.parentNode.removeChild(ele);
        }
    }
</script>