<!doctype html>
<html class="no-js" lang="en">

@php
    include 'dbconnect.php';
    // include 'cek.blade.php';
    require 'load_start_script.php';

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

<title>{{ $header="Inventory" }} | {{ $title="Stok Barang" }}</title>

<head>
    <!-- custom -->
    <!-- <link rel="stylesheet" href="assets/css/custom-css.css">
    <link rel="stylesheet" href="assets/js/custom-js.js"> -->
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
                                            
                                        @else
                                            di Tahun {{ $filter_tahun }}
                                        @endif
                                    </h2>
                                    
                                    <button style="margin-bottom:10px" data-toggle="modal" data-target="#modalFilter" class="btn btn-success col-md-2">Filter Barang</button>
                                </div>
                                <div>
                                    <p align="right">
                                        <button style="margin-bottom:10px" data-toggle="modal" data-target="#modalStock" class="btn btn-info col-md-2">Tambah Barang</button>
                                    </p>
                                    <p align="right">
                                        <button hidden style="margin-bottom:10px" data-toggle="modal" data-target="#modalInput" class="btn btn-info col-md-2">Masukkan Barang</button>
                                    </p>
                                </div>
                                
                                <div class="market-status-table mt-4">
                                    <div class="data-tables table-responsive datatable-custom">
                                         <table id="dataTable3" class="display" style="width:100%"><thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                {{-- <th>Tanggal</th> --}}
                                                <th>Tahun</th>
                                                <th>Harga</th>
                                                <th>Stock</th>
                                                <th>Satuan</th>
                                                <th>Total</th>
                                                <th>Kode Barang</th>
                                                <th>Keterangan</th>
                                               
                                                
                                                <th>Opsi</th>
                                            </tr></thead><tbody>
                                            @php
                                                $brgs=mysqli_query($conn,"SELECT * from sstock_brg order by tanggal DESC");
                                                $no=1;
                                            @endphp
                                            @while($p=mysqli_fetch_array($brgs))
                                                @php
                                                    $idb = $p['idx'];
                                                    if (!$p['tahun'] || $p['tahun'] <= 0) {
                                                        $tahun_stock = DateTime::createFromFormat("Y-m-d", $p['tanggal']);
                                                        $tahun_stock = $tahun_stock->format("Y");
                                                    }
                                                    else {
                                                        $tahun_stock = $p['tahun'];
                                                    }
                                                @endphp
                                                @if ($p['jenis'] == $filter_tipe || $filter_tipe == 'Semua')
                                                    @if ($tahun_stock == $filter_tahun || $filter_tahun == 9999)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $p['nama'] }}</td>
                                                        {{-- <td>{{ $p['tanggal'] }}</td> --}}
                                                        <td>
                                                            @if ($tahun_stock <= 0)
                                                                <strong>Undefined</strong>
                                                            @else
                                                                {{ $tahun_stock }}
                                                            @endif
                                                        </td>
                                                        <td>{{ "Rp. " . $p['harga'] }}</td>
                                                        <td>{{ $p['stock'] }}</td>
                                                        <td>{{ $p['satuan'] }}</td>
                                                        <td>{{ "Rp. ". $p['stock'] * $p['harga'] }}</td>
                                                        <td>{{ $p['kode_barang'] }}</td>
                                                        <td>{{ $p['keterangan'] }}</td>
                                                        <td>
                                                            <button data-toggle="modal" data-target="#edit{{ $idb }}" class="btn btn-xs btn-warning"><span><i class="ti-pencil"></i></span></button> 
                                                            @if (in_array($current_user, $admin_privilege))
                                                                <button data-toggle="modal" data-target="#del{{ $idb }}" class="btn btn-xs btn-danger"><span><i class="ti-trash"></i></span></button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                @endif


                                                <!-- The Modal -->
                                                    <div class="modal fade" id="edit{{ $idb }}">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <form action="/stock_act/edit_stock_barang_act.php" method="post">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                            <h4 class="modal-title">Edit Barang <br>{{ $p['nama'] }}-{{ $p['jenis'] }}-Rp. {{ $p['harga'] }}</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                            
                                                            <label for="nama">Nama</label>
                                                            <input type="text" id="nama" name="nama" class="form-control" value="{{ $p['nama'] }}">
                                                            
                                                            <label for="tahun_stock">Tahun Stock</label>
                                                            <input type="number" id="tahun_stock" name="tahun_stock" min="2000" class="form-control" value="{{ $tahun_stock }}">

                                                            <label>Jenis</label>
                                                            <select style="height: 200%" name="jenis" class="custom-select form-control">
                                                            <option selected>{{ $p['jenis'] }}</option>
                                                            <option value="Alat Tulis Kantor">Alat Tulis Kantor</option>
                                                            <option value="Listrik dan Elektronik">Listrik dan Elektronik</option>
                                                            <option value="Alat Kebersihan Kantor">Alat Kebersihan Kantor</option>
                                                            <option value="Persediaan Cetak">Persediaan Cetak</option>
                                                            <option value="Lain-lain">Lain-lain</option>
                                                            </select>

                                                            <label for="harga">Harga</label>
                                                            <input type="number" id="harga" name="harga" class="form-control" value="{{ $p['harga'] }}">

                                                            <label for="stock">Stock</label>
                                                            <input type="text" id="stock" name="stock" class="form-control" value="{{ $p['stock'] }}" disabled>

                                                            <label for="satuan">Satuan</label>
                                                            <input type="text" id="satuan" name="satuan" class="form-control" value="{{ $p['satuan'] }}">

                                                            <label for="total">Total</label>
                                                            <input type="text" id="total" name="total" class="form-control" value="{{ $p['stock'] * $p['harga'] }}"disabled>

                                                            <label for="kode_barang">Kode Barang</label>
                                                            <input type="text" id="kode_barang" name="kode_barang" class="form-control" value="{{ $p['kode_barang'] }}">

                                                            <label for="keterangan">Keterangan</label>
                                                            <input type="text" id="keterangan" name="keterangan" class="form-control" value="{{ $p['keterangan'] }}">
                                                            <input type="hidden" name="idbrg" value="{{ $idb }}">
                                                            <input type="hidden" name="stock" value="{{ $p['stock'] }}">
                                                            <input hidden type="date" name="tanggal" value="{{ $p['tanggal'] }}">
                                                            
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
                                                        <form action="/stock_act/hapus_stock_barang_act.php" method="post">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Barang <br>{{ $p['nama'] }}-{{ $p['jenis'] }}-Rp. {{ $p['harga'] }}</h4>
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

    {{-- modal export --}}
    <div id="modalExport" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Export Data</h4>
                </div>
                <div class="modal-body">
                    <form action="/stock_act/export_stock_barang.php" method="post">
                        <div class="form-group">
                            <label>Tipe Barang</label>
                            <select style="height: 200%" name="filter_tipe" class="custom-select form-control" value="Semua">
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
    <div id="modalFilter" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Filter Barang</h4>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-group">
                            <label>Tipe Barang</label>
                            <select style="height: 200%" name="filter_tipe" class="custom-select form-control" value="Semua">
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
    <div id="modalInput" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Input Barang Masuk</h4>
                </div>
                <div class="modal-body">
                    <form action="/stock_act/tambah_barang_masuk_act.php" method="post">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input name="tanggal" type="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <select style="height: 200%" name="barang" class="custom-select form-control">
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
                    <form action="/stock_act/tambah_stock_barang_act.php" method="post">
                        <div class="form-group">
                            <label>Tanggal Stock</label>
                            <input name="tanggal" type="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input name="nama" type="text" class="form-control" placeholder="Nama Barang" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis</label>
                            <select style="height: 200%" name="jenis" class="custom-select form-control">
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
    </div>
	
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
	
	$(document).ready(function() {
    $('#dataTable3').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'print'
        ]
    } );
	} );
	</script>
	
	@php
        require 'load_end_script.php';
    @endphp
	
</body>

</html>
@endif