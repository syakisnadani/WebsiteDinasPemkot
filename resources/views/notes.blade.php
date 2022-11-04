<!doctype html>
<html class="no-js" lang="en">

@php
    include 'dbconnect.php';
    // include 'cek.php';
    require 'load_start_script.php';

    $types=array("Asset","Stock");

    // $current_user = Auth::user()->name;

    global $header, $current_user, $list_users;
    $current_user = Auth::user()->role;

    include 'list_user.php';

    $user_authorized = array($list_users["Admin"], $list_users["Inventory"]);
    $admin_privilege = array($list_users["Admin"], $list_users["Inventory"]);
    $user_unauthorized = array($list_users["Presensi"]);

@endphp

@if (!in_array($current_user, $user_authorized) || in_array($current_user, $user_unauthorized))
    @php
        header( "refresh:0;url=/unauthorized" );
    @endphp
@else

<title>{{ $header="Inventory" }} | {{ $title="Notes" }}</title>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        @php
            require 'sidebar.php';
        @endphp
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="search-box pull-left">
                            <form action="#">
                                <h2></h2>
                            </form>
                        </div>
                    </div>
                    <!-- profile info & task notification -->
                    @php
                        require 'date.php';
                    @endphp
                </div>
            </div>
            <!-- header area end -->
			@php
                $periksa_bahan=mysqli_query($conn,"select * from sstock_brg where stock <1");
            @endphp
            @while($p=mysqli_fetch_array($periksa_bahan))	
                @if ($p['stock']<=1)
                    <script>
                        $(document).ready(function(){
                            $('#pesan_sedia').css("color","white");
                            $('#pesan_sedia').append("<i class='ti-flag'></i>");
                        });
                    </script>
                    <div class='alert alert-danger alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button>Stok <strong><u>{{ $p['nama'] }}</u> - <u>{{ $p['jenis'] }}</u> - Rp. <u>{{ $p['harga'] }}</u></strong> yang tersisa sudah habis</div>     
                @endif
            @endwhile
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix" style="padding: 20px; padding-left: 0px">
                            <h4 class="page-title pull-left">{{ $header }}</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="/">Home</a></li>
                                <li><span>{{ $title }}</span></li>
                            </ul>
                        </div>
                    </div>
                    {{-- <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right" style="color:black; padding:0px;">
                            <img src="/logodinas.jpg" width="110px" class="user-name dropdown-toggle" data-toggle="dropdown"\>
                        </div>
                    </div> --}}
                    <div class="col-sm-6 pull-right">
                        <h6 class="pull-right">
                            Logged in as <u>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</u>, 
                            <a class="" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                                <font size="+0">
                                    Logout
                                </font>
                            </a>
                            ?
                        </h6>
                        
                        <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                <!-- market value area start -->
                <div class="row mt-5 mb-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
									<h2>Notes</h2>
                                </div>
                                <div class="market-status-table mt-4">
                                    <div class="data-tables table-responsive datatable-custom">
                                        <table id="dataTable3" class="display" style="width:100%"><thead class="thead-dark">
										<tr>
                                            <th><center> No </center></th>
                                            <th><center> Tanggal </center></th>
                                            <th><center> Catatan </center></th>
                                            <th><center> Ditulis oleh </center></th>
                                            <th><center> Tujuan </center></th>
                                            <th><center> Action </center></th>
										</tr></thead>
                                        <form method ='POST' action = '/tambah_notes.php'>
                                        <tr class="table-info">
                                        <td><center><i class="ti-check-box"></i><input type = 'hidden'/></center></td>
                                        <td><center>{{ date('Y/m/d', time()) }}</center></td>
                                        <td><center> <input type = 'text' class='form-control' name = 'konten' required /></center> </td>
                                        <td><center><input type="hidden" name="user" value="{{ Auth::user()->firstname }}">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</center></td>
                                        <td><center>
                                            <select style="height: 200%" name="tujuan" class="custom-select form-control" value="Semua">
                                            <option selected>Semua</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type }}">{{ $type }}</option>
                                            @endforeach
                                            </select>    
                                        </center></td>
                                        {{--<td><center>Saya, <strong>{{ $_SESSION['user_login'] }}</strong> <span class="badge badge-secondary">{{ $_SESSION['role'] }}</span></center> </td> --}}
                                        <td><center><button type = 'submit' name = 'submit'  class='btn btn-primary btn-sm' >Add Note<i class="ti-save"></i></button></center></td>
                                        <tr>
                                        </form>
										@php
                                            // Perintah untuk menampilkan data
                                            $queri="Select * From notes where status='aktif' Order by id DESC" ;  //menampikan SEMUA data dari tabel

                                            $hasil=MySQLi_query ($conn,$queri);    //fungsi untuk SQL

                                            // nilai awal variabel untuk no urut
                                            $i = 1;

                                            // perintah untuk membaca dan mengambil data dalam bentuk array
                                        @endphp
										@while ($data = mysqli_fetch_array ($hasil))
                                            @php
                                                $id = $data['id'];
                                            @endphp
                                            <form method ='POST' action = 'done.php'>
                                            <tr>
                                            <td><center>{{ $i++ }}</center></td>
                                            <td><center>{{ $data['tanggal'] }}</center></td>
                                            <td><strong><center>{{ $data['contents'] }}</center></strong></td>
                                            <td><strong><center>{{ $data['admin'] }}</center></strong></td>
                                            <td><strong><center>{{ $data['tujuan'] }}</center></strong></td>
                                            <td><center><input type = 'hidden' name = 'id' value = '{{ $data['id'] }}'> <input type='submit' name = 'submit'  class='btn btn-danger btn-sm' value = 'Delete' formaction='/hapus_notes.php' /></center></td>
                                            </form></td>
                                            </tr> </form> 
										@endwhile
										</table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              
                
                <!-- row area start-->
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        @php
            require 'load_footer.php';
        @endphp
        <!-- footer area end-->
    </div>
    <!-- page container area end -->

    @php
        require 'load_end_script.php';
    @endphp
</body>

</html>

@endif