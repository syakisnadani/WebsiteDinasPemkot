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

    $user_authorized = array($list_users["Admin"]);
    $admin_privilege = array($list_users["Admin"]);
    // $user_unauthorized = array($list_users["Presensi"]);

@endphp

@if (!in_array($current_user, $user_authorized))
    @php
        header( "refresh:0;url=/unauthorized" );
    @endphp
@else

<title>{{ $header="Admin" }} | {{ $title="User Settings" }}</title>

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
            @while($p=mysqli_fetch_array($periksa_bahan) && false)	
                @if ($p['stock']<=1)
                    <script>
                        $(document).ready(function(){
                            $('#pesan_sedia').css("color","white");
                            $('#pesan_sedia').append("<i class='ti-flag'></i>");
                        });
                    </script>
                    <div hidden class='alert alert-danger alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button>Stok <strong><u>{{ $p['nama'] }}</u> - <u>{{ $p['jenis'] }}</u> - Rp. <u>{{ $p['harga'] }}</u></strong> yang tersisa sudah habis</div>     
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
									<h2>User Settings</h2>
                                    <button data-toggle="modal" data-target="#modalPetunjuk" class="btn btn-info">Petunjuk Penggunaan</button>
                                </div>
                                <div class="market-status-table mt-4">
                                    <div class="data-tables table-responsive datatable-custom">
                                        <table id="dataTable3" class="display" style="width:100%"><thead class="thead-dark">
										<tr>
                                            <th><center> No </center></th>
                                            <th><center> First Name </center></th>
                                            <th><center> Last Name </center></th>
                                            <th><center> Username </center></th>
                                            <th><center> Email </center></th>
                                            <th style="min-width: 170px"><center> User Role </center></th>
                                            <th><center> Action </center></th>
                                        </tr></thead>
										@php
                                            // Perintah untuk menampilkan data
                                            $query="Select * From users Order by created_at DESC" ;  //menampikan SEMUA data dari tabel

                                            $hasil=MySQLi_query ($conn,$query);    //fungsi untuk SQL

                                            // nilai awal variabel untuk no urut
                                            $i = 1;

                                            // perintah untuk membaca dan mengambil data dalam bentuk array
                                        @endphp
										@while ($data = mysqli_fetch_array ($hasil))
                                        @if (Auth::user()->username != $data['username'])
                                            
                                        {{-- @else --}}
                                            @php
                                                $id = $data['id'];
                                                $users_temp = $users;
                                                unset($users_temp[$list_users["Admin"]]);
                                                unset($users_temp[$data['role']]);
                                            @endphp
                                            {{-- <form action='/edit_roles.php' method ='post'> --}}
                                            <tr>
                                            <td><center>{{ $i++ }}</center></td>
                                            <td><center>{{ $data['firstname'] }}</center></td>
                                            <td><center>{{ $data['lastname'] }}</center></td>
                                            <td><center>{{ $data['username'] }}</center></td>
                                            <td><center>{{ $data['email'] }}</center></td>
                                            <td><center>{{ $users[$data['role']] }}
                                                {{-- <select @if ($data['role'] == $list_users["Admin"]) disabled @endif style="height: 200%" name="role" class="custom-select form-control" value="{{ $data['role'] }}">
                                                <option selected>{{ $users[$data['role']] }}</option>
                                                @foreach ($users_temp as $user)
                                                    <option value="{{ $user }}">{{ $user }}</option>
                                                @endforeach
                                                </select> --}}
                                            </center></td>
                                            <td><center>
                                                <input type = 'hidden' name = 'id' value = '{{ $data['id'] }}'/>
                                                {{-- <a href="/help" class="btn btn-success btn-xs">Test</a> --}}
                                                {{-- <input type = 'submit' name = 'submit'  class='btn btn-primary btn-xs' value = 'Add Note'/> --}}
                                                <button @if ($data['role'] == $list_users["Admin"]) disabled @endif type="button" data-toggle="modal" data-target="#edit_{{ $id }}" name="save" class="btn btn-success btn-xs"><i class="ti-save"></i></button>
                                                <button @if ($data["role"] == $list_users["Admin"]) disabled @endif type="button" data-toggle="modal" data-target="#del_{{ $id }}" name = 'delete'  class='btn btn-danger btn-xs'><i class="ti-trash"></i></button>
                                            </center></td>
                                            </tr>
                                            {{-- </form>  --}}



                                            <!-- The Modal -->
                                            <div class="modal fade" id="edit_{{ $id }}">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                <form action="/edit_roles.php" method="post">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Edit Role <u>{{ $data['firstname'] }} {{ $data['lastname'] }} <br></u> </h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Role Akun</label>
                                                            <select @if ($data['role'] == $list_users["Admin"]) disabled @endif style="height: 200%" name="role" class="custom-select form-control" value="{{ $data['role'] }}">
                                                            <option selected>{{ $users[$data['role']] }}</option>
                                                            @foreach ($users_temp as $user)
                                                                <option value="{{ $user }}">{{ $user }}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    </div>
                                                    
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success" name="simpan">Simpan</button>
                                                    </div>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>

                                            <!-- The Modal -->
                                            <div class="modal fade" id="del_{{ $id }}">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                <form action="/delete_user.php" method="post">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Akun <u>{{ $data['firstname'] }} {{ $data['lastname'] }} <br></u> </h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus akun ini secara permanen?
                                                    <br><br><i>*Akun yang telah dihapus tidak bisa dipulihkan</i>
                                                    <input type="hidden" name="id" value="{{ $id }}">
                                                    </div>
                                                    
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                                                    </div>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                        @endif
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

    <!-- The Modal -->
    <div class="modal fade" id="modalPetunjuk">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/help" method="post">
                    <input type="hidden" name="_method" value="GET">
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Petunjuk Penggunaan <br> </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <br> Setiap akun pada tabel memiliki <i>role</i>-nya masing-masing. 
                        <br> <br> Role inilah yang menentukan bagian sistem mana yang bisa diakses oleh akun tersebut. 
                        <br> <br> Berikut merupakan list dari semua <i>role</i> akun beserta bagian sistem yang bisa diakses oleh akun tersebut. 
                        <br> - Admin: Bisa mengakses bagian manapun pada sistem, termasuk bagian pengaturan akun ini yang secara eks
                        <br> - Guest: Tidak bisa mengakses bagian manapun kecuali dashboard
                        <br> - Inventory: Untuk saat ini bisa mengakses bagian sistem Inventory dan Asset
                        <br> - Presensi: Hanya bisa mengakses bagian sistem Rekap Presensi
                        <br> - Asset: Hanya bisa mengakses bagian sistem Asset
                        <br> - Bidang Lainnya: Bisa mengakses bagian sistem Database dan Usulan Data per Bidang
                    {{-- <input type="hidden" name="id" value="{{ $id }}"> --}}
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <a hidden href="/help" type="button" class="btn btn-secondary" name="help">Saya kurang mengerti</a>
                    <button type="button" class="btn btn-block btn-info" data-dismiss="modal">Baik, saya mengerti</button>
                    {{-- <button type="submit" class="btn btn-danger" name="hapus">Hapus</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>

    @php
        require 'load_end_script.php';
    @endphp
</body>

</html>

@endif