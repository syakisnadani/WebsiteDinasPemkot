<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script> -->
<script type="text/javascript">
    $(document).ready(function (e) {
        $('#upload').on('click', function () {
            var form_data = new FormData();
            var ins = document.getElementById('multiFiles').files.length;
            for (var x = 0; x < ins; x++) {
                form_data.append("files[]", document.getElementById('multiFiles').files[x]);
            }
            $.ajax({
                url: 'php-multiple-files-upload.php', // point to server-side PHP script 
                dataType: 'text', // what to expect back from the PHP script
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (response) {
                    $('#msg').html(response); // display success response from the PHP script
                },
                error: function (response) {
                    $('#msg').html(response); // display error response from the PHP script
                }
            });
        });
    });
</script>