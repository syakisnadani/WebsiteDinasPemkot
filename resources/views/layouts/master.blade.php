@php
    global $header, $current_user, $list_users;
    $current_user = Auth::user()->role;

    include 'list_user.php';

    $user_authorized = array($list_users["Admin"], $list_users["Presensi"]);
    $admin_privilege = array($list_users["Admin"]);
    $user_unauthorized = array($list_users["Inventory"]);

@endphp

@if (!in_array($current_user, $user_authorized))
    @php
        header( "refresh:0;url=/unauthorized" );
    @endphp
@else

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistem Presensi</title>
    <link rel="icon" type="image/ico" sizes="48x48" href="/favicon/favicon.ico">

    <!-- Custom fonts for this template-->
    <link href="/vendor/fontawesome-free/css/all.css" rel="stylesheet" type="text/css">
    {{-- <link href="/vendor/fontawesome-free/css/brands.css" rel="stylesheet" type="text/css"> --}}
    <link defer src="/vendor/fontawesome-free/js/all.js">
    {{-- <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/brands.js" integrity="sha384-sCI3dTBIJuqT6AwL++zH7qL8ZdKaHpxU43dDt9SyOzimtQ9eyRhkG3B7KMl6AO19" crossorigin="anonymous"></script> --}}
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

     <!-- Custom styles for this page -->
     <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                {{-- <div class="fa-3x">
                    <i class="fas fa-solid fa-snowboarding fa-rotate-90"></i>
                </div> --}}
                {{-- <div class="sidebar-brand-icon" style=" -webkit-transform: rotate(270deg);
                                                        -moz-transform: rotate(270deg);
                                                        -ms-transform: rotate(270deg);
                                                        -o-transform: rotate(270deg);
                                                        transform: rotate(270deg);   ">
                    <i>S</i>
                </div> --}}
                {{-- <div class="sidebar-brand-icon rotate-n-15">
                    <i>S</i>
                </div> --}}
                <div class="sidebar-brand-text mx-3">
                    Sistem Presensi
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="/">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            @if (in_array($current_user, $admin_privilege))
                <!-- Heading -->
                <div class="sidebar-heading">
                    Admin Privilege
                </div>

                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="/users">
                        <i class="fas fa-fw fa-user-plus"></i>
                        <span>User Settings</span></a>
                </li>

                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="/stock">
                        <i class="fas fa-fw fa-archive"></i>
                        <span>Inventory</span></a>
                </li>

                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="/asset">
                        <i class="fas fa-fw fa-barcode"></i>
                        <span>Tracking Asset</span></a>
                </li>

                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="/database">
                        <i class="fas fa-fw fa-database"></i>
                        <span>Database DISPANGTAN</span></a>
                </li>
                
                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="/upload">
                        <i class="fas fa-fw fa-comments"></i>
                        <span>Usulan Data per Bidang</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">
            @endif

            <!-- Heading -->
            <div class="sidebar-heading">
                Sistem Absensi
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="/staff">
                    <i class="fas fa-calendar"></i>
                    <span>Data Staff</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/jamKerja">
                    <i class="fa fa-users"></i>
                    <span>Jam Kerja</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/manualPresent">
                    <i class="fa fa-users"></i>
                    <span>Manual Present</span>
                </a>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="/present">
                    <i class="fa fa-users"></i>
                    <span>Cetak Rekap Absensi</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="/uploadPresent">
                    <i class="fa fa-users"></i>
                    <span>Upload Data Absensi</span>
                </a>
            </li>

            <!-- Divider -->
            <!-- <hr class="sidebar-divider"> -->

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                Sistem Surat Masuk & Keluar
            </div> -->

            <!-- Nav Item - Pages Collapse Menu -->
            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="/cashflow">
                    <i class="fa fa-credit-card"></i>
                    <span>Surat Masuk</span>
                </a>
            </li> -->

            <!-- Nav Item - Charts -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="/laporan">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Surat Keluar</span></a>
            </li> -->

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
                                <img class="img-profile"
                                    src="/favicon/favicon.ico"/>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                {{-- <div class="dropdown-divider"></div> --}}
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('content')

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <a href="/help" style="color: inherit; text-decoration: inherit;"><span>Copyright &copy; Universitas Brawijaya</span></a>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="btn btn-primary" href="route('logout')" 
                            onclick="event.preventDefault();
                                this.closest('form').submit();">
                            Logout
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/js/demo/chart-area-demo.js"></script>
    <script src="/js/demo/chart-pie-demo.js"></script>

    <!-- Page level plugins -->
    <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/js/demo/datatables-demo.js"></script>

</body>

</html>

@endif