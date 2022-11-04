<!doctype html>
<html class="no-js" lang="en">

@php
    include 'dbconnect.php';
    // include 'cek.blade.php';
    require 'load_start_script.php';
    // require 'load_ajax_file_script.php';
    require 'load_file_script.php';

    if (!isset($_POST['filter_tipe'])) {
        $filter_tipe = "Semua";
    } else {
        $filter_tipe = $_POST['filter_tipe'];
    }

    if (!isset($_POST['filter_tahun']) || !$_POST['filter_tahun']) {
        $filter_tahun = 9999;
    } else {
        $filter_tahun = $_POST['filter_tahun'];
    }


    global $header, $current_user, $list_users;
    $current_user = Auth::user()->role;

    include 'list_user.php';

    $user_authorized = array($list_users["Admin"], $list_users["Bidang Lainnya"]);
    $admin_privilege = array($list_users["Admin"]);

    $jenis_usulan = array();
    $data=mysqli_query($conn,"SELECT * from jenis_usulan where id > 0");
    while($jenis=mysqli_fetch_array($data))
        $jenis_usulan[] = $jenis['jenis_usulan'];
@endphp

@if (!in_array($current_user, $user_authorized))
    @php
        header( "refresh:0;url=/unauthorized" );
    @endphp
@else

<title>{{ $header="Upload" }} | {{ $title="Usulan Data per Bidang" }}</title>

<head>
    <!-- custom -->
    <!-- <link rel="stylesheet" href="assets/css/custom-css.css">
    <link rel="stylesheet" href="assets/js/custom-js.js"> -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script> -->
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://www.google.com/">upgrade your browser</a> to improve your experience.</p>
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
                                    <h2>
                                        @if ($filter_tipe == "Semua")
                                            Daftar Semua Data
                                        @else
                                            Daftar Data di {{ $filter_tipe }}
                                        @endif
                                        <br>
                                        @if ($filter_tahun == 9999)
                                            
                                        @else
                                            di Tahun {{ $filter_tahun }}
                                        @endif
                                    </h2>
                                    
                                    @if (in_array($current_user, $admin_privilege))
                                        <button style="margin-bottom:10px" data-toggle="modal" data-target="#modalFilter" class="btn btn-success col-md-2">Filter Data</button>
                                    @endif
                                </div>
                                <div>
                                    <p align="right">
                                        <button style="margin-bottom:10px" data-toggle="modal" data-target="#modalUpload" class="btn btn-info col-md-2">Tambah Data</button>
                                    </p>
                                    @if (in_array($current_user, $admin_privilege))
                                    <p align="right">
                                        <button style="margin-bottom:10px" data-toggle="modal" data-target="#modalJenis" class="btn btn-info col-md-2">Tambah Jenis Usulan</button>
                                    </p>
                                    @endif
                                </div>
                                
                                <div class="market-status-table mt-4">
                                    <div class="data-tables table-responsive datatable-custom">
                                         <table id="dataTable3" class="display" style="width:100%"><thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul Data</th>
                                                <th>Pengusul</th>
                                                <th>Jenis Usulan</th>
                                                {{-- <th>Keywords</th> --}}
                                                <th>Keterangan</th>
                                                <th>Tanggal Upload</th>
                                                {{-- <th>Nama File</th> --}}
                                                {{-- <th>Tipe File</th> --}}
                                                {{-- <th>Ukuran</th> --}}
                                               
                                                
                                                <th>Opsi</th>
                                            </tr></thead><tbody>
                                            @php
                                                $data=mysqli_query($conn,"SELECT * from files_data fd order by fd.saved_date DESC");
                                                $no=1;
                                            @endphp
                                            @while($p=mysqli_fetch_array($data))
                                                @php
                                                    $id_file = $p['id'];
                                                    $tahun_upload = DateTime::createFromFormat("Y-m-d", $p['saved_date']);
                                                    $tahun_upload = $tahun_upload->format("Y");
                                                @endphp
                                                @if (($p['department'] == Auth::user()->firstname || in_array($current_user, $admin_privilege)) && ($p['assigned_by'] == $filter_tipe || $filter_tipe == 'Semua'))
                                                    @if ($tahun_upload == $filter_tahun || $filter_tahun == 9999)
                                                        @if ($p['assigned_place'] == $header)
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ $p['title'] }}</td>
                                                            <td>{{ $p['department'] }}</td>
                                                            <td>{{ $p['assigned_by'] }}</td>
                                                            {{-- <td>{{ $p['keywords'] }}</td> --}}
                                                            <td>{{ $p['description'] }}</td>
                                                            <td>{{ $p['saved_date'] }}</td>
                                                            {{-- <td>{{ $p['file_name'] }}</td> --}}
                                                            {{-- <td>.{{ $p['type'] }}</td> --}}
                                                            {{-- <td>{{ $p['size'] }}</td> --}}
                                                            {{-- @php
                                                                $folderurl = 'C:\Data\Project\Laravel\inventory\public\uploads\\';
                                                                // header("Content-type:application/pdf");
                                                                header('Content-Disposition: attachment; filename=' . $folderurl. $p['file_name']);
                                                                readfile( $folderurl . $p['file_name'] );
                                                            @endphp --}}
                                                            <td>
                                                                <a href="uploads/{{ $p['file_name'] }}" class="btn btn-xs btn-success" download><span><i class="ti-import"></i></span></a>
                                                                <a hidden href="{{route('getdownload', $p['file_name'])}}" class="btn btn-xs btn-success">Download</a>
                                                                <button data-toggle="modal" data-target="#edit{{ $id_file }}" class="btn btn-xs btn-warning"><span><i class="ti-pencil"></i></span></button>
                                                                @if (in_array($current_user, $admin_privilege))
                                                                    <button data-toggle="modal" data-target="#del{{ $id_file }}" class="btn btn-xs btn-danger"><span><i class="ti-trash"></i></span></button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    @endif
                                                @endif

                                                <!-- The Modal -->
                                                    <div class="modal fade" id="edit{{ $id_file }}">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <form action="/file_act/edit_files_act.php" method="post">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                            <h4 class="modal-title">Edit Barang <br>{{ $p['title'] }}</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            

                                                            <!-- Modal body -->
                                                            <div class="modal-body">

                                                                <div class="form-group">
                                                                    <label>Nama Data</label>
                                                                    <input required name="nama_data" type="text" class="form-control" placeholder="Nama Data" value="{{ $p['title'] }}">
                                                                </div>
                                                                @if (!in_array($current_user, $admin_privilege))
                                                                <div class="form-group">
                                                                    <label>Pengusul</label>
                                                                    {{-- <input disabled name="assigned_by" type="text" class="form-control" placeholder="Keywords"> --}}
                                                                    <input disabled type="text" id="departemen" name="departemen" class="form-control" value="{{ Auth::user()->firstname }}">
                                                                    <input name="departemen" type="hidden" class="form-control" value="{{ Auth::user()->firstname }}">
                                                                </div>
                                                                @else
                                                                <div class="form-group">
                                                                    <label>Pengusul</label>
                                                                    <select required style="height: 200%" name="departemen" class="custom-select form-control">
                                                                    <option selected>{{ Auth::user()->firstname }}</option>
                                                                    @foreach ($departments as $department)
                                                                        <option value="{{ $department }}">{{ $department }}</option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>
                                                                @endif
                                                                <div class="form-group">
                                                                    <label>Jenis Usulan</label>
                                                                    <select required style="height: 200%" name="assigned_by" class="custom-select form-control">
                                                                        <option selected>{{ $p['assigned_by'] }}</option>
                                                                        @foreach ($jenis_usulan as $jenis)
                                                                            <option value="{{ $jenis }}">{{ $jenis }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Keterangan</label>
                                                                    <input name="keterangan" type="text" min="0" class="form-control" placeholder="Keterangan" value="{{ $p['description'] }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="nama">Nama File</label>
                                                                    <input disabled type="text" id="nama_file" name="nama" class="form-control" value="{{ $p['file_name'] }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="tanggal_upload">Tanggal Upload</label>
                                                                    <input disabled type="date" id="tanggal_upload" name="tanggal_upload" min="2000" class="form-control" value="{{ date("Y-m-d", strtotime($p['saved_date'])) }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="ukuran">Ukuran File</label>
                                                                    <input disabled type="text" id="ukuran" name="ukuran" class="form-control" value="{{ $p['size'] }}">
                                                                </div>
                                                            
                                                                {{-- <input type="hidden" name="departemen" value="-"> --}}
                                                                <input type="hidden" name="tahun" value="-">
                                                                <input type="hidden" name="id" value="{{ $id_file }}">
                                                                <input type="hidden" name="assigned_place" value="{{ $header }}">
                                                                {{-- <input type="hidden" name="assigned_place" value="{{ $header }}"> --}}
                                                            
                                                            </div>
                                                            
                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-success" name="update">Simpan</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                        </div>
                                                    </div>



                                                    <!-- The Modal -->
                                                    <div class="modal fade" id="del{{ $id_file }}">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <form action="/file_act/delete_files_act.php" method="post">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Item <br>{{ $p['file_name'] }}</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus data ini dari usulan?
                                                            <input type="hidden" name="idbrg" value="{{ $id_file }}">
                                                            <input type="hidden" name="file_name" value="{{ $p['file_name'] }}">
                                                            <input type="hidden" name="assigned_place" value="{{ $p['assigned_place'] }}">
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
											@endwhile
										</tbody>
										</table>
                                    </div>
                                    {{-- <button disabled data-toggle="modal" data-target="#modalExport" class="btn btn-info">Export Data</button> --}}
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
    <div class="modal fade" id="modalJenis">
        <div class="modal-dialog">
        <div class="modal-content">
        <form action="/file_act/tambah_jenis_usulan_act.php" method="post">
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Tambah Jenis Usulan</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label>Jenis Usulan</label>
                    <input required name="jenis_baru" type="text" class="form-control" placeholder="Jenis Usulan Yang Ingin Ditambahkan">
                    <input name="assigned_place" type="hidden" class="form-control" value="{{ $header }}">
                </div>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success" name="submit">Simpan</button>
            </div>
            </form>
        </div>
        </div>
    </div>

    <!-- modal upload -->
    <div id="modalUpload" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload Files</h4>
                </div>
                <div class="modal-body">
                    @php
                        // require 'load_file_script.php';
                    @endphp
                    <form name="upload_form" enctype="multipart/form-data" action="file_act/upload_files_act.php" method="POST">
                    {{-- <form name="upload_form" enctype="multipart/form-data" action="upload_files_test.php" method="POST"> --}}
                        <div hidden class="form-group">
                            <label>Tanggal</label>
                            <input name="tanggal" type="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama Data</label>
                            <input required name="nama" type="text" class="form-control" placeholder="Nama Data">
                        </div>
                        {{-- <div class="form-group">
                            <label>Departemen Tujuan</label>
                            <select required style="height: 200%" name="departemen" class="custom-select form-control">
                            <option selected>Pilih Departemen</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department }}">{{ $department }}</option>
                            @endforeach
                            </select>
                        </div> --}}
                        @if (!in_array($current_user, $admin_privilege))
                        <div class="form-group">
                            <label>Pengusul</label>
                            {{-- <input disabled name="assigned_by" type="text" class="form-control" placeholder="Keywords"> --}}
                            <input disabled type="text" id="departemen" name="departemen" class="form-control" value="{{ Auth::user()->firstname }}">
                            <input name="departemen" type="hidden" class="form-control" value="{{ Auth::user()->firstname }}">
                        </div>
                        @else
                        <div class="form-group">
                            <label>Pengusul</label>
                            <select required style="height: 200%" name="departemen" class="custom-select form-control">
                            <option selected>{{ Auth::user()->firstname }}</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department }}">{{ $department }}</option>
                            @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="form-group">
                            <label>Jenis Usulan</label>
                            <select required style="height: 200%" name="assigned_by" class="custom-select form-control">
                                <option selected>Pilih Jenis Usulan</option>
                                @foreach ($jenis_usulan as $jenis)
                                    <option value="{{ $jenis }}">{{ $jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input name="keterangan" type="text" min="0" class="form-control" placeholder="Keterangan">
                        </div>
                        <div class="form-group">
                            <label>Upload File</label>
                            <div class="container" style="  padding: 10px;
                                                            border: 1px solid #D0D0D0;
                                                            -webkit-box-shadow: 0 0 8px #D0D0D0;">
                                <label>
                                    <input required style="margin-top:10px;" type="file" name="file1" id="upload_file1" readonly="true"/>
                                </label>
                            </div>
                            <i>*Ukuran file maksimal 10 MB</i>
                            <br>
                            <i>**Perlu diingat semakin besar ukuran file semakin lama proses uploadnya</i>
                        </div>
                        <div>&nbsp;</div>
                        <div class="modal-footer">
                            {{-- <input type="hidden" name="departemen" value="-"> --}}
                            <input type="hidden" name="tahun" value="-">
                            <input type="hidden" name="assigned_place" value="{{ $header }}">
                            {{-- <input type="hidden" name="assigned_by" value="{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}"> --}}
                            {{-- <input type="hidden" name="departemen" value="{{ Auth::user()->firstname }}"> --}}
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <input type="submit" class="btn btn-primary" name="upload" value="Upload">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- modal export --}}
    <div id="modalExport" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Export Data</h4>
                </div>
                <div class="modal-body">
                    <form action="/file_act/export_stock_barang.php" method="post">
                        <div class="form-group">
                            <label>Pilih Dinas</label>
                            <select style="height: 200%" name="filter_tipe" class="custom-select form-control" value="Semua">
                            <option selected>Semua</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department }}">{{ $department }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tahun Upload</label>
                            <input name="filter_tahun" type="number" min="2000" class="form-control" placeholder="Semua">
                            <i>*kosongkan untuk melihat semua tahun</i>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <input type="submit" class="btn btn-primary" value="Export">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- modal filter --}}
    <div id="modalFilter" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Filter Data</h4>
                </div>
                <div class="modal-body">
                    <form action="/upload" method="post">
                        <div class="form-group">
                            <label>Pilih Jenis Usulan</label>
                            <select style="height: 200%" name="filter_tipe" class="custom-select form-control" value="Semua">
                            <option selected>Semua</option>
                            @foreach ($jenis_usulan as $jenis)
                                <option value="{{ $jenis }}">{{ $jenis }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tahun Upload</label>
                            <input name="filter_tahun" type="number" min="2000" class="form-control" placeholder="Semua">
                            <i>*kosongkan untuk melihat semua tahun</i>
                        </div>
                        <div class="form-group" align="right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <input type="submit" name="submit" value="Pilih" class="btn btn-success">
                            @method('GET')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
	<!-- modal input -->
    {{-- <div id="modalInput" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Input Barang Masuk</h4>
                </div>
                <div class="modal-body">
                    <form action="/file_act/tambah_barang_masuk_act.php" method="post">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input name="tanggal" type="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <select name="barang" class="custom-select form-control">
                            <option selected>Pilih barang</option>
                            @php
                                $det=mysqli_query($conn,"select * from sstock_brg order by nama ASC")or die(mysqli_error());
                            @endphp
                            @while($d=mysqli_fetch_array($det))
                                @if ($d['jenis'] == $filter_tipe || $filter_tipe == 'Semua')
                                    @if ($tahun_stock == $filter_tahun || $filter_tahun == 9999)
                                        <option value="{{ $d['idx'] }}">{{ $d['nama'] }} - {{ $d['jenis'] }} - Rp. {{ $d['harga'] }}</option>
                                    @endif
                                @endif
                            @endwhile
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input name="qty" type="number" min="1" class="form-control" placeholder="Qty">
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input name="ket" type="text" class="form-control" placeholder="Keterangan">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
	<!-- modal stock -->
    {{-- <div id="modalStock" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Masukkan stok manual</h4>
                </div>
                <div class="modal-body">
                    <form action="/file_act/tambah_files_act.php" method="post">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input name="tanggal" type="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input name="nama" type="text" class="form-control" placeholder="Nama Barang" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis</label>
                            <select name="jenis" class="custom-select form-control">
                            <option selected>Pilih jenis barang</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department }}">{{ $department }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input name="harga" type="number" min="100" class="form-control" placeholder="Harga">
                        </div>
                        <div class="form-group">
                            <label>Stock</label>
                            <input name="stock" type="number" min="0" class="form-control" placeholder="Jumlah Barang">
                        </div>
                        <div class="form-group">
                            <label>Satuan</label>
                            <input name="satuan" type="text" class="form-control" placeholder="Satuan Barang (Unit, Kg, Rim, dll)">
                        </div>
                        <div class="form-group">
                            <label>Kode</label>
                            <input name="kode_barang" type="text" class="form-control" placeholder="Kode barang">
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input name="keterangan" type="text" class="form-control" placeholder="Keterangan barang">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
	
	<script>
		$(document).ready(function() {
		$('input').on('keydown', function(event) {
			if (this.selectionStart == 0 && event.keyCode >= 65 && event.keyCode <= 90 && !(event.shiftKey) && !(event.ctrlKey) && !(event.metaKey) && !(event.altKey)) {
			   var $t = $(this);
			   event.preventDefault();
			   var char = String.fromCharCode(event.keyCode);
			   $t.val(char + $t.val().slice(this.selectionEnd));
			   this.setSelectionRange(1,1);
			}
		});
	});
	
	// $(document).ready(function() {
    // $('#dataTable3').DataTable( {
    //     dom: 'Bfrtip',
    //     buttons: [
    //         'print'
    //     ]
    // } );
	// } );
	</script>
	
	@php
        require 'load_end_script.php';
    @endphp
	
</body>

</html>

@endif