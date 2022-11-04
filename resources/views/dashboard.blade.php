@php
    global $header, $current_user, $list_users;
    $current_user = Auth::user()->role;

    include 'list_user.php';

    $allowed_inventory = array($list_users["Admin"], $list_users["Inventory"]);
    $allowed_asset = array($list_users["Admin"], $list_users["Inventory"]);
    $allowed_presensi = array($list_users["Admin"], $list_users["Presensi"]);
    $admin = array($list_users["Admin"]);
    $guest = array($list_users["Guest"]);
    $allowed_database = array($list_users["Admin"], $list_users["Bidang Lainnya"]);
    // global $level_user;
    // if ($current_user == "Admin") {
    //     $level_user = 0;
    // }
@endphp

<!-- Extend Tamplate Master -->
@extends('layouts.master-dashboard')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-success" style="text-shadow: 3px 3px 3px #00FF00;">Dashboard</h1>
        {{-- #00C851 --}}
    </div>

    @if (in_array($current_user, $guest))
    <div class="row" style="padding: 15px">
        <h3>You're currently logged in as guest and can't view anything yet <br> Please contact your Admin to get more access to the system</h3>
    </div>
    @else

    <div class="row">
        @if (in_array($current_user, $admin))
           <!-- Earnings (Monthly) Card Example -->
            <div onclick="window.open('/users','mywindow');" style="cursor: pointer;" class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                                {{-- <a href="/stock">Inventory </a> --}}
                                    User Settings
                                </div>
                                <!-- <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div> -->
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-plus fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        @endif
    </div>

    <div class="row">
        @if (in_array($current_user, $allowed_inventory))
           <!-- Earnings (Monthly) Card Example -->
            <div onclick="window.open('/stock','mywindow');" style="cursor: pointer;" class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                                {{-- <a href="/stock">Inventory </a> --}}
                                    Inventory
                                </div>
                                <!-- <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div> -->
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-archive fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        @endif
    
        @if (in_array($current_user, $allowed_inventory))
           <!-- Earnings (Monthly) Card Example -->
            <div onclick="window.open('/asset','mywindow');" style="cursor: pointer;" class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                                {{-- <a href="/stock">Inventory </a> --}}
                                    Tracking Asset
                                </div>
                                <!-- <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div> -->
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-barcode fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        @endif
    </div>

    <div class="row">
            
    </div>

    <!-- Content Row -->
    <div class="row">

        @if (in_array($current_user, $allowed_presensi))
            <!-- Earnings (Monthly) Card Example -->
            <div onclick="window.open('/staff','mywindow');" style="cursor: pointer;" class="col-xl-3 col-md-6 mb-4">
                {{-- &nbsp; --}}
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                                    {{-- <a href="/staff"> Rekap Presensi </a>     --}}
                                    Rekap Presensi
                                </div>
                                <!-- <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div> -->
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-bookmark fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif    

        @if (in_array($current_user, $allowed_database))
            <!-- Earnings (Monthly) Card Example -->
            <div onclick="window.open('/database','mywindow');" style="cursor: pointer;" class="col-xl-3 col-md-6 mb-4">
                {{-- &nbsp; --}}
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                                    {{-- <a href="/staff"> Rekap Presensi </a>     --}}
                                    Database DISPANGTAN
                                </div>
                                <!-- <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div> -->
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-database fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (in_array($current_user, $allowed_database))
            <!-- Earnings (Monthly) Card Example -->
            <div onclick="window.open('/upload','mywindow');" style="cursor: pointer;" class="col-xl-3 col-md-6 mb-4">
                {{-- &nbsp; --}}
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                                    {{-- <a href="/staff"> Rekap Presensi </a>     --}}
                                    Usulan Data per Bidang
                                </div>
                                <!-- <div class="h5 mb-90 font-weight-bold text-gray-800">$40,000</div> -->
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Earnings (Monthly) Card Example -->
        <!-- <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Earnings (Annual)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Earnings (Monthly) Card Example -->
        <!-- <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Pending Requests Card Example -->
        <!-- <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>

    @endif

</div>
<!-- /.container-fluid -->
@endsection 
