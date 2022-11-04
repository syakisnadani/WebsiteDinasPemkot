@php
    /*
    admin is authorized for every action in the whole server
    bu ari is authorized for every action in "inventory" only (not fully implemented, "asset" page still doesnt have any authorization system)
    pak zen is authorized for every action in "rekap presensi" only (not fully implemented, only "staff" page has any authorization system)
    other "dinas" are authorized for "database" and "usulan" page only, 
        and alhtough can add and edit the data, cannot delete any data from the server




    */
    header( "refresh:1;url=/" );
@endphp

<html>
    <head>
        <title>Warning</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      </head>
    <div class='alert alert-warning'>
        <strong>You are unauthorized for this!</strong> Redirecting you back in 1 seconds.
    </div>
</html>
