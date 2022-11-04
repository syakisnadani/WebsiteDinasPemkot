@php
    global $header, $current_user, $list_users;
    $current_user = Auth::user()->role;

    include 'list_user.php';

    $allowed_inventory = array($list_users["Admin"], $list_users["Inventory"]);
    $allowed_asset = array($list_users["Admin"], $list_users["Inventory"], $list_users["Asset"]);
    $allowed_presensi = array($list_users["Admin"], $list_users["Presensi"]);
    $admin = array($list_users["Admin"]);
    $guest = array($list_users["Guest"]);
    $allowed_database = array($list_users["Admin"], $list_users["Bidang Lainnya"]);
    // global $level_user;
    // if ($current_user == "Admin") {
    //     $level_user = 0;
    // }
    $help = 'sup';
    if (isset($_GET['me'])) {
        $help = $_GET['me'];
    }
    
@endphp

<!-- Extend Tamplate Master -->
@extends('layouts.master-dashboard')

@section('content')

<script>
    document.title = "Hello there";
</script>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-success" style="text-shadow: 3px 3px 3px #00FF00;">Hello</h1>
        {{-- #00C851 --}}
    </div>

    @if (!in_array($current_user, $admin))
    <div class="row" style="padding: 15px">
        <h3>You're currently logged in as guest and can't view anything yet <br> Please contact your Admin to get more access to the system</h3>
    </div>
    @else
    
    @if ($help == "NO")
        <div class="row" style="padding: 15px">
            <p>Wow you're so heartless</p>
        </div>
    @else
    
    <div class="row" style="padding: 15px">
        <h4>I am well aware that the system I made is far from perfect, <br> And currently there's a clear limitation of what I can do, as I'm currently in studying myself.</h4>
    </div>
    <div class="row" style="padding: 15px">
            <form style="padding: 0px" action="" method="get">
                <h4 style="display: inline;">If there's someone who wants to make it better, I would gladly offer my assistance. <br> You can reach me
                @if ($help == 'sup')
                <button type="submit" name="me" value="YES" 
                    style=" background: none;
                            border: none;
                            outline: none;
                            text-shadow: 2px 2px 2px #00FF00;
                            text-decoration: inherit;
                            color: inherit;
                            cursor: pointer;
                            padding: 0px">
                    here
                </button>
                @else
                here
                @endif
                </h4>
                @if ($help == 'sup')
                <h4 style="opacity: 0.5; display: inline;">
                    {{-- <s> --}}
                    or click
                    <button type="submit" name="me" value="NO" 
                        style=" background: none;
                                border: none;
                                outline: none;
                                text-shadow: 2px 2px 2px #00FF00;
                                text-decoration: inherit;
                                color: inherit;
                                cursor: pointer;
                                padding: 0px;">
                        here
                    </button>
                    to shut me up
                    {{-- </s> --}}
                </h4>
                @endif
            </form>
    </div>
    @if ($help == "YES")
    <div class="row">
        @if (!in_array($current_user, $guest))
           <!-- Earnings (Monthly) Card Example -->
           {{-- I put my number here if there's someone who want to develop the system in the future --}}
            <div title="Developer's Number&#10;I put my number here if there's someone who want to develop the system in the future&#10;This is a private information so I hope no one misused it" 
                onclick="window.open('https:/\/wa.me/6281249563975','new');" style="cursor: pointer;" class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-lg font-weight-bold text-success mb-1">
                                {{-- <a href="/stock">Inventory </a> --}}
                                    WhatsApp
                                </div>
                                <!-- <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div> -->
                            </div>
                            <div class="col-auto">
                                <i class="fa-brands fa-whatsapp fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        @endif
        @if (!in_array($current_user, $guest))
           <!-- Earnings (Monthly) Card Example -->
            <div title="Developer's Email&#10;I put my email here if there's someone who want to develop the system in the future&#10;This is a private information so I hope no one misused it" 
                onclick="window.open('mailto:tsumwashere@student.ub.ac.id','new');" style="cursor: pointer;" class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-lg font-weight-bold text-success mb-1">
                                {{-- <a href="/stock">Inventory </a> --}}
                                    Email
                                </div>
                                <!-- <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div> -->
                            </div>
                            <div class="col-auto">
                                <i class="fa-regular fa-envelope fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        @endif
        @if (!in_array($current_user, $guest))
           <!-- Earnings (Monthly) Card Example -->
            <div title="Developer's Instagram Account&#10;I put my Insta here in case my number and email is unreachable&#10;This is a private information so I hope no one misused it" 
                onclick="window.open('https:/\/www.instagram.com/____tsum/','new');" style="cursor: pointer;" class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2" >
                                <div class="text-lg font-weight-bold text-success mb-1">
                                {{-- <a href="/stock">Inventory </a> --}}
                                    Instagram
                                </div>
                                <!-- <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div> -->
                            </div>
                            <div class="col-auto">
                                <i class="fa-brands fa-instagram fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        @endif
    </div>
    @endif
    @endif
    @if ($help == 'YES')
    <div class="row" style="padding: 15px">
        <h6>Oh and if there's anyone who found this secret page I made, I'm always available even if you just wanna talk</h6>
    </div>
    @endif
    @if ($help == 'NO')
    <div class="row" style="padding: 15px; display: inline-block">
        <h6><s>Oh and if there's anyone who found this secret page I made, I'm always available even if you just wanna talk</s></h6>
        <h6>Scratch it, let's fight instead <i class="fa-regular fa-face-angry"></i></h6>
    </div>
    @endif

    @endif

</div>
<!-- /.container-fluid -->
@endsection 
