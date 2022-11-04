<!doctype html>
<html class="no-js" lang="en">

@php
    include 'file_act/dbconnect.php';
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

    $types=array("Alat Tulis Kantor","Listrik dan Elektronik","Alat Kebersihan Kantor","Persediaan Cetak","Lain-lain");

@endphp

<title>{{ $header="Inventory" }} | {{ $title="Stok Barang" }}</title>

<head>
    <!-- custom -->
    <!-- <link rel="stylesheet" href="assets/css/custom-css.css">
    <link rel="stylesheet" href="assets/js/custom-js.js"> -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script> -->
    
    <p id="msg"></p>
    <input type="file" id="multiFiles" name="files[]" multiple="multiple"/>
    <button id="upload">Upload</button>

    <div id="container">
        <form name="upload_form" enctype="multipart/form-data" action="file_act/upload_files_act.php" method="POST">
            <fieldset>
                <legend>Files Save into MySQL database using PHP</legend>
                <section>
                    <label>Browse a file</label>
                    <label>
                        <input type="file" name="upload_file1" id="upload_file1" readonly="true"/>
                    </label>
                    <div id="moreFileUpload"></div>
                    <div style="clear:both;"></div>
                    <div id="moreFileUploadLink" style="display:none;margin-left: 10px;">
                        <a href="javascript:void(0);" id="attachMore">Attach another file</a>
                    </div>
                </section>
            </fieldset>
            <div>&nbsp;</div>
            <footer>
                <input type="submit" name="upload" value="Upload"/>
            </footer>
        </form>
    </div>
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
                                    <h2>
                                        @if ($filter_tipe == "Semua")
                                            Daftar Semua Jenis Barang
                                        @else
                                            Daftar Barang Jenis {{ $filter_tipe }}
                                        @endif
                                        <br>
                                        @if ($filter_tahun == 9999)
                                            di Semua Tahun
                                        @else
                                            di Tahun {{ $filter_tahun }}
                                        @endif
                                    </h2>
                                    
                                    <button style="margin-bottom:10px" data-toggle="modal" data-target="#modalFilter" class="btn btn-success col-md-2">Filter Barang</button>
                                </div>
                                <div>
                                    <p align="right">
                                        <button style="margin-bottom:10px" data-toggle="modal" data-target="#modalUpload" class="btn btn-info col-md-2">Tambah Stock</button>
                                    </p>
                                    <p align="right">
                                        <button hidden style="margin-bottom:10px" data-toggle="modal" data-target="#modalInput" class="btn btn-info col-md-2">Masukkan Barang</button>
                                    </p>
                                </div>
                                
                                <div class="market-status-table mt-4">
                                    <div class="data-tables table-responsive datatable-dark">
                                         <table id="dataTable3" class="display" style="width:100%"><thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama File</th>
                                                <th>Tanggal</th>
                                                <th>Ukuran</th>
                                                <th>Keterangan</th>
                                               
                                                
                                                <th>Opsi</th>
                                            </tr></thead><tbody>
                                            @php
                                                $data=mysqli_query($conn,"SELECT * from files_data order by name ASC");
                                                $no=1;
                                            @endphp
                                            @while($p=mysqli_fetch_array($data))
                                                @php
                                                    $idb = $p['id'];
                                                @endphp
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $p['name'] }}</td>
                                                    <td>{{ $p['saved_date'] }}</td>
                                                    <td>{{ $p['size'] }}</td>
                                                    <td>-</td>
                                                    {{-- @php
                                                        $folderurl = 'C:\Data\Project\Laravel\inventory\public\uploads\\';
                                                        // header("Content-type:application/pdf");
                                                        header('Content-Disposition: attachment; filename=' . $folderurl. $p['name']);
                                                        readfile( $folderurl . $p['name'] );
                                                    @endphp --}}
                                                    <td>
                                                        <a href="{{route('getdownload', $p['name'])}}" class="btn btn-success">Download</a>
                                                        <button data-toggle="modal" data-target="#edit{{ $idb }}" class="btn btn-warning">Edit</button>
                                                        <button data-toggle="modal" data-target="#del{{ $idb }}" class="btn btn-danger">Hapus</button>
                                                    </td>
                                                </tr>


                                                <!-- The Modal -->
                                                    <div class="modal fade" id="edit{{ $idb }}">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <form action="/file_act/edit_files_act.php" method="post">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                            <h4 class="modal-title">Edit Barang <br>{{ $p['name'] }}</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                            
                                                            <label for="nama">Nama</label>
                                                            <input type="text" id="nama" name="nama" class="form-control" value="{{ $p['name'] }}">
                                                            
                                                            <label for="tahun_stock">Tahun</label>
                                                            <input type="date" id="tahun_stock" name="tahun_stock" min="2000" class="form-control" value="{{ date("Y-m-d", strtotime($p['saved_date'])) }}">

                                                            <label for="keterangan">Keterangan</label>
                                                            <input type="text" id="keterangan" name="keterangan" class="form-control" value="-">
                                                            <input type="hidden" name="idbrg" value="{{ $idb }}">
                                                            
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
                                                    <div class="modal fade" id="del{{ $idb }}">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <form action="/file_act/delete_files_act.php" method="post">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Barang <br>{{ $p['name'] }}</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus barang ini dari daftar stock?
                                                            <input type="hidden" name="idbrg" value="{{ $idb }}">
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
                                    <button data-toggle="modal" data-target="#modalExport" class="btn btn-info">Export Data</button>
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

    <!-- modal upload -->
    <div id="modalUpload" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload Files</h4>
                </div>
                <div class="modal-body">
                    <p id="msg"></p>
                    <input type="file" id="multiFiles" name="files[]" multiple="multiple"/>
                    <button id="upload">Upload</button>  
                    <form action="/file_act/upload_files_act.php" method="post">
                        <p id="msg"></p>
                        <input type="file" id="multiFiles" name="files[]" multiple="multiple"/>
                        {{-- <button id="upload">Upload</button>   --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Upload</button>
                            {{-- <input type="submit" class="btn btn-primary" value="Upload"> --}}
                        </div>
                        {{-- @method('PUT') --}}
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
                            <label>Tipe Barang</label>
                            <select name="filter_tipe" class="custom-select form-control" value="Semua">
                            <option selected>Semua</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tahun Stock</label>
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
    {{-- <div id="modalFilter" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Filter Barang</h4>
                </div>
                <div class="modal-body">
                    <form action="/" method="post">
                        <div class="form-group">
                            <label>Tipe Barang</label>
                            <select name="filter_tipe" class="custom-select form-control" value="Semua">
                            <option selected>Semua</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tahun Stock</label>
                            <input name="filter_tahun" type="number" min="2000" class="form-control" placeholder="Semua">
                            <i>*kosongkan untuk melihat semua tahun</i>
                        </div>
                        <div class="form-group" align="right">
                            <input type="submit" name="submit" value="Pilih" class="btn btn-success">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            @method('GET')
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
	<!-- modal input -->
    <div id="modalInput" class="modal fade">
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
    </div>
	<!-- modal stock -->
    <div id="modalStock" class="modal fade">
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
                            @foreach ($types as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
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
