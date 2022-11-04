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

<title>{{ $header="Persediaan" }} | {{ $title="Barang Keluar" }}</title>

{{-- @extends('load.start_script') --}}

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start-->
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
                    <div class="col-sm-6">
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
                                        Barang Keluar
                                        @if ($filter_tipe != "Semua")
                                            Jenis {{ $filter_tipe }}
                                        @endif
                                        @if ($filter_tahun != 9999)
                                            <br>Tahun Stock {{ $filter_tahun }}
                                        @endif
                                    </h2>
                                    <button style="margin-bottom:10px" data-toggle="modal" data-target="#modalFilter" class="btn btn-success col-md-2">Filter Barang</button>
                                </div>
                                <div>
                                    <p align="right">
                                        <button style="margin-bottom:20px" data-toggle="modal" data-target="#modalKeluar" class="btn btn-info col-md-2">Tambah</button>
                                    </p>
                                </div>
                                <div class="market-status-table mt-4">
                                    <div class="data-tables table-responsive datatable-custom">
										 <table id="dataTable3" class="display"><thead>
											<tr>
												<th>No</th>
												<th>Tanggal Keluar</th>
												<th>Nama Barang</th>
                                                @if ($filter_tipe == "Semua")
    												<th>Jenis</th>
                                                @endif
                                                @if ($filter_tahun == 9999)
    												<th>Tahun Stock</th>                                                    
                                                @endif
												<th>Harga</th>
												<th>Jumlah</th>
                                                <th>Total</th>
												<th>Penerima</th>
												<th>Keterangan</th>
												
												<th>Opsi</th>
											</tr></thead><tbody>
											@php
                                                $brg=mysqli_query($conn,"SELECT * FROM sbrg_keluar sb, sstock_brg st where st.idx=sb.idx ORDER BY tgl DESC");
                                                $no=1;
                                            @endphp
											@while($b=mysqli_fetch_array($brg))
                                                @php
                                                    $id_barang = $b['idx'];
                                                    $id_item = $b['id'];
                                                    if (!$b['tahun'] || $b['tahun'] <= 0) {
                                                        $tahun_stock = DateTime::createFromFormat("Y-m-d", $b['tanggal']);
                                                        $tahun_stock = $tahun_stock->format("Y");
                                                    }
                                                    else {
                                                        $tahun_stock = $b['tahun'];
                                                    }
                                                @endphp
                                                @if ($b['jenis'] == $filter_tipe || $filter_tipe == 'Semua')
                                                    @if ($tahun_stock == $filter_tahun || $filter_tahun == 9999)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ date("Y-m-d", strtotime($b['tgl'])) }}</td>
                                                        <td>{{ $b['nama'] }}</td>
                                                        @if ($filter_tipe == "Semua")
                                                            <td>{{ $b['jenis'] }}</td>
                                                        @endif
                                                        @if ($filter_tahun == 9999)
                                                            <td>{{ $tahun_stock }}</td>                                                
                                                        @endif
                                                        <td>Rp. {{ $b['harga'] }}</td>
                                                        <td>{{ $b['jumlah'] }}</td>
                                                        <td>Rp. {{ $b['jumlah'] * $b['harga'] }}</td>
                                                        <td>{{ $b['penerima'] }}</td>
                                                        <td>{{ $b['ket_keluar'] }}</td>
                                                        <td>
                                                            <button data-toggle="modal" data-target="#edit{{ $id_item }}" class="btn btn-xs btn-warning"><span><i class="ti-pencil"></i></span></button> 
                                                            @if (in_array($current_user, $admin_privilege))
                                                                <button data-toggle="modal" data-target="#del{{ $id_item }}" class="btn btn-xs btn-danger"><span><i class="ti-trash"></i></span></button>
                                                            @endif
                                                        </td>
                                                        {{-- <td><button data-toggle="modal" data-target="#edit{{ $id_item }}" class="btn btn-warning">Edit</button> <button data-toggle="modal" data-target="#del{{ $id_item }}" class="btn btn-danger">Hapus</button></td> --}}
                                                    </tr>	
                                                    @endif
                                                @endif
                                                <!-- The Modal -->
                                                <div class="modal fade" id="edit{{ $id_item }}">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <form action="/stock_act/edit_barang_keluar_act.php" method="post">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                            <h4 class="modal-title">Edit Data</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Modal body -->
                                                            <div class="modal-body">

                                                            <label for="tanggal">Tanggal</label>
                                                            <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ $b['tgl'] }}">
                                                            
                                                            <label for="nama">Barang</label>
                                                            <input type="text" id="nama" name="nama" class="form-control" value="{{ $b['nama'] }} - {{ $b['jenis'] }}" disabled>

                                                            <label for="harga">Harga</label>
                                                            <input type="text" id="harga" name="harga" class="form-control" value="Rp. {{ $b['harga'] }}" disabled>

                                                            <label for="jumlah">Jumlah</label>
                                                            <input type="number" id="jumlah" name="jumlah" class="form-control" value="{{ $b['jumlah'] }}">

                                                            <label for="penerima">Penerima</label>
                                                            <input type="text" id="penerima" name="penerima" class="form-control" value="{{ $b['penerima'] }}">

                                                            <label for="keterangan">Keterangan</label>
                                                            <input type="text" id="keterangan" name="keterangan" class="form-control" value="{{ $b['ket_keluar'] }}">
                                                            <input type="hidden" name="id" value="{{ $id_item }}">
                                                            <input type="hidden" name="idx" value="{{ $id_barang }}">

                                                            
                                                            </div>
                                                            
                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success" name="update">Save</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                        </div>
                                                    </div>



                                                    <!-- The Modal -->
                                                    <div class="modal fade" id="del{{ $id_item }}">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <form action="/stock_act/hapus_barang_keluar_act.php" method="post">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                            <h5 class="modal-title">Hapus Barang <br>{{ $b['nama'] }} - {{ $b['jenis'] }} - Rp. {{ $b['harga'] }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus barang ini dari daftar stock?
                                                            <br>
                                                            <i>*Stock barang akan bertambah</i>
                                                            <input type="hidden" name="id" value="{{ $id_item }}">
                                                            <input type="hidden" name="idx" value="{{ $id_barang }}">
                                                            </div>
                                                            
                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-success" name="hapus">Hapus</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                        </div>
                                                    </div>
											@endwhile
										</tbody>
										</table>
                                    </div></div>
                                    <button data-toggle="modal" data-target="#modalExport" class="btn btn-info">Export Data</button>
									{{-- <a href="/stock_act/export_barang_keluar.php" target="_blank" class="btn btn-info">Export Data</a> --}}
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
    {{-- modal export --}}
    <div id="modalExport" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Export Data</h4>
                </div>
                <div class="modal-body">
                    <form action="/stock_act/export_barang_keluar.php" method="post">
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
	<!-- modal input -->
			<div id="modalKeluar" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Input Barang Keluar</h4>
						</div>
						<div class="modal-body">
							<form action="/stock_act/tambah_barang_keluar_act.php" method="post">
								<div class="form-group">
									<label>Tanggal Keluar</label>
									<input name="tanggal" type="date" class="form-control">
                                    <i>*kosongkan untuk mengisi tanggal saat ini</i>
								</div>
								<div class="form-group">
									<label>Nama Barang</label>
									<select required style="height: 200%" name="barang" class="custom-select form-control">
									<option selected>Pilih barang</option>
									@php
                                        $max_quantity = 0;
                                        $det=mysqli_query($conn,"select * from sstock_brg order by tanggal DESC")or die(mysqli_error());
                                    @endphp
									@while($d=mysqli_fetch_array($det))
                                        @php
                                            if (!$d['tahun'] || $d['tahun'] <= 0) {
                                                $tahun_stock = DateTime::createFromFormat("Y-m-d", $d['tanggal']);
                                                $tahun_stock = $tahun_stock->format("Y");
                                            }
                                            else {
                                                $tahun_stock = $d['tahun'];
                                            }
                                        @endphp
                                        @if ($tahun_stock == $filter_tahun || $filter_tahun == 9999)
                                            @if ($d['jenis'] == $filter_tipe || $filter_tipe == 'Semua')
                                                @if ($d['stock'] >= 1)
                                                    @php
                                                        if ($d['stock'] >= $max_quantity) {
                                                            $max_quantity = $d['stock'];
                                                        }
                                                    @endphp
                                                    <option value="{{ $d['idx'] }}">{{ $d['nama'] }} - 
                                                        @if ($tahun_stock <= 0)
                                                            <strong>Undefined</strong>
                                                        @else
                                                            {{ $tahun_stock }}
                                                        @endif
                                                        - Rp. {{ $d['harga'] }} --- Stock : {{ $d['stock'] }}</option>
                                                @endif
                                            @endif
                                        @endif
                                    @endwhile	
									</select>	
								</div>
								<div class="form-group">
									<label>Jumlah</label>
									<input required name="qty" type="number" min="1" max="{{ $max_quantity }}" class="form-control" placeholder="Qty">
								</div>
								<div class="form-group">
									<label>Penerima</label>
									<input required name="penerima" type="text" class="form-control" placeholder="Penerima barang">
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
	</script>
</body>

</html>
@endif