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

    // $filter_tipe = "Semua";
    // $filter_tahun = 9999;

    $types=array("Sedang dipinjam","Sudah dikembalikan");

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

<title>{{ $header="Inventory" }} | {{ $title="Asset" }}</title>

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
                $periksa_bahan=mysqli_query($conn,"select * from asset_brg where stock <1");
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
                                        @if ($filter_tipe == "Semua")
                                            Peminjaman Asset
                                        @else
                                            Asset Yang {{ $filter_tipe }}
                                        @endif
                                        @if ($filter_tahun != 9999)
                                            <br>Tahun {{ $filter_tahun }}
                                        @endif
                                    </h2>
                                    <button style="margin-bottom:10px" data-toggle="modal" data-target="#modalFilter" class="btn btn-success col-md-2">Filter Barang</button>
                                </div>
                                <div>
                                    <p align="right">
                                        <button style="margin-bottom:20px" data-toggle="modal" data-target="#modalKeluar" class="btn btn-info col-md-2">Peminjaman Barang</button>
                                    </p>
                                </div>
                                <div class="market-status-table mt-4">
                                    <div class="data-tables table-responsive datatable-custom">
										 <table id="dataTable3" class="display"><thead>
											<tr>
												<th>No</th>
												<th>Tanggal Peminjaman</th>
												<th>Nama Barang</th>
                                                <th>Berita Acara</th>
												<th>Status Peminjaman</th>
                                                {{-- @if ($filter_tipe == "Semua")
    												<th>Jenis</th>
                                                @endif
                                                @if ($filter_tahun == 9999)
    												<th>Tahun Stock</th>                                                    
                                                @endif --}}
												{{-- <th>Harga</th>
												<th>Jumlah</th>
                                                <th>Total</th> --}}
												<th>Nama Peminjam</th>
												<th>Keterangan</th>
												{{-- <th>File</th> --}}
												
												{{-- <th>Action</th> --}}
												<th>Opsi</th>
											</tr></thead><tbody>
											@php
                                                $brg=mysqli_query($conn,"SELECT * FROM asset_keluar sb ORDER BY tgl DESC");
                                                $no=1;
                                            @endphp
											@while($b=mysqli_fetch_array($brg))
                                                @php
                                                    // $id_barang = $b['idx'];
                                                    $id_item = $b['id'];
                                                    $tahun_stock = DateTime::createFromFormat("Y-m-d", $b['tgl']);
                                                    $tahun_stock = $tahun_stock->format("Y");
                                                    // if (!$b['tahun'] || $b['tahun'] <= 0) {
                                                    // }
                                                    // else {
                                                    //     $tahun_stock = $b['tahun'];
                                                    // }
                                                @endphp
                                                @if ($b['status_peminjaman'] == $filter_tipe || $filter_tipe == 'Semua')
                                                    @if ($tahun_stock == $filter_tahun || $filter_tahun == 9999)
                                                    <tr
                                                    @if ($b['status_peminjaman'] == "Sedang dipinjam")
                                                        style="color: red"
                                                    @endif
                                                    >
                                                    {{-- <tr style="color: red"> --}}
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ date("Y-m-d", strtotime($b['tgl'])) }}</td>
                                                        <td>{{ $b['barang'] }}</td>
                                                        <td>{{ $b['berita_acara'] }}</td>
                                                        <td>{{ $b['status_peminjaman'] }}</td>
                                                        {{-- @if ($filter_tipe == "Semua")
                                                            <td>{{ $b['jenis'] }}</td>
                                                        @endif
                                                        @if ($filter_tahun == 9999)
                                                            <td>{{ $tahun_stock }}</td>                                                
                                                        @endif --}}
                                                        {{-- <td>Rp. {{ $b['harga'] }}</td> --}}
                                                        {{-- <td>{{ $b['jumlah'] }}</td>
                                                        <td>Rp. {{ $b['jumlah'] * $b['harga'] }}</td> --}}
                                                        <td>{{ $b['peminjam'] }}</td>
                                                        <td>{{ $b['ket_keluar'] }}</td>
                                                        {{-- <td>{{ $b['file'] }}</td> --}}
                                                        <td>
                                                            @if ($b['status_peminjaman'] == "Sedang dipinjam")
                                                                <button data-toggle="modal" data-target="#update_{{ $id_item }}" class="btn btn-xs btn-primary"><span><i class="ti-package"> </i><i class="ti-shift-right"></i><i class="ti-save"></i></span></button>
                                                            @endif
                                                        {{-- </td>
                                                        <td> --}}
                                                            <a href="/uploads/{{ $b['file'] }}" class="btn btn-xs btn-success" download><span><i class="ti-import"></i></span></a>
                                                            <button data-toggle="modal" data-target="#edit_{{ $id_item }}" class="btn btn-xs btn-warning"><span><i class="ti-pencil"></i></span></button> 
                                                            @if (in_array($current_user, $admin_privilege))
                                                            <button data-toggle="modal" data-target="#del_{{ $id_item }}" class="btn btn-xs btn-danger"><span><i class="ti-trash"></i></span></button>
                                                            @endif
                                                        </td>
                                                    </tr>	
                                                    @endif
                                                @endif

                                                <!-- The Modal -->
                                                <div class="modal fade" id="update_{{ $id_item }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            {{-- <form class="btn btn-white" style="padding: 0px" action="/asset_act/edit_status_peminjaman_act.php" method="post">
                                                                <input hidden type="text" id="status_peminjaman" name="status_peminjaman" value="{{ $b['status_peminjaman'] }}">
                                                                <button type="submit" class="btn btn-xs btn-primary" id="update" name="update"><i class="ti-package"> </i><i class="ti-shift-right"></i><i class="ti-save"></i></button>        
                                                            </form> --}}
                                                            <form action="/asset_act/edit_status_peminjaman_act.php" method="post">
                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Kembalikan barang <br>{{ $b['barang'] }}</h5>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>
                                                                
                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    Apakah Anda yakin ingin mengembalikan barang ini?
                                                                    <br>
                                                                    <i>*Nomor berita acara dari barang ini adalah </i><strong>{{ $b['berita_acara'] }}</strong>
                                                                    <input type="hidden" id="status_peminjaman" name="status_peminjaman" value="Sudah dikembalikan">
                                                                    <input type="hidden" name="id" value="{{ $id_item }}">
                                                                </div>
                                                                
                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary" name="update">Kembalikan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- The Modal -->
                                                <div class="modal fade" id="edit_{{ $id_item }}">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <form action="/asset_act/edit_barang_keluar_act.php" method="post">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                            <h4 class="modal-title">Edit Data</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Modal body -->
                                                            <div class="modal-body">

                                                            <label for="tanggal">Tanggal</label>
                                                            <input type="date" id="tanggal" name="tanggal" class="form-control" value="{{ $b['tgl'] }}">
                                                            
                                                            <label for="barang">Nama Barang</label>
                                                            <textarea type="text" id="barang" name="barang" class="form-control">{{ $b['barang'] }}</textarea>
                                                            
                                                            <label for="berita_acara">Berita Acara</label>
                                                            <input type="text" id="berita_acara" name="berita_acara" class="form-control" value="{{ $b['berita_acara'] }}">

                                                            <label for="status_peminjaman">Status Peminjaman</label>
                                                            <input disabled type="text" id="status_peminjaman" name="status_peminjaman" class="form-control" value="{{ $b['status_peminjaman'] }}">
                                                            <input hidden type="text" id="status_peminjaman" name="status_peminjaman" class="form-control" value="{{ $b['status_peminjaman'] }}">
                                                            
                                                            {{-- <label for="harga">Harga</label>
                                                            <input type="text" id="harga" name="harga" class="form-control" value="Rp. {{ $b['harga'] }}" disabled> --}}

                                                            {{-- <label for="jumlah">Jumlah</label>
                                                            <input type="number" id="jumlah" name="jumlah" class="form-control" value="{{ $b['jumlah'] }}"> --}}
                                                            
                                                            <label for="peminjam">Peminjam</label>
                                                            <input type="text" id="peminjam" name="peminjam" class="form-control" value="{{ $b['peminjam'] }}">

                                                            <label for="keterangan">Keterangan</label>
                                                            <input type="text" id="keterangan" name="keterangan" class="form-control" value="{{ $b['ket_keluar'] }}">
                                                            <input type="hidden" name="id" value="{{ $id_item }}">
                                                            <input type="hidden" name="file" value="{{ $b['file'] }}">
                                                            {{-- <input type="hidden" name="idx" value="{{ $id_barang }}"> --}}

                                                            
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
                                                    <div class="modal fade" id="del_{{ $id_item }}">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <form action="/asset_act/hapus_barang_keluar_act.php" method="post">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                            <h5 class="modal-title">Hapus Barang <br>{{ $b['barang'] }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus barang ini dari daftar stock?
                                                            <br>
                                                            <i>*Stock barang akan bertambah</i>
                                                            <input type="hidden" name="id" value="{{ $id_item }}">
                                                            {{-- <input type="hidden" name="idx" value="{{ $id_barang }}"> --}}
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
                                    <button hidden data-toggle="modal" data-target="#modalExport" class="btn btn-info">Export Data</button>
									{{-- <a href="/asset_act/export_barang_keluar.php" target="_blank" class="btn btn-info">Export Data</a> --}}
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
                            <label>Status Peminjaman</label>
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
                    <form action="/asset_act/export_barang_keluar.php" method="post">
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
							<h4 class="modal-title">Peminjaman Asset</h4>
						</div>
						<div class="modal-body">
							<form action="/asset_act/tambah_barang_keluar_act.php" enctype="multipart/form-data" method="post">
								<div class="form-group">
									<label>Tanggal Keluar</label>
									<input name="tanggal" type="date" class="form-control">
                                    <i>*kosongkan untuk mengisi tanggal saat ini</i>
								</div>
								<div class="form-group">
									<label>Nama Barang</label>
									<textarea required name="barang" class="form-control" rows="6" placeholder="Nama barang yang dipinjam beserta jumlahnya.&#10;Contoh:&#10;Laptop Asus: 1&#10;Monitor LG: 2&#10;..."></textarea>
								</div>
								{{-- <div hidden class="form-group">
									<label>Jumlah</label>
									<input required name="qty" type="number" min="1" class="form-control" placeholder="Qty">
								</div> --}}
								<div class="form-group">
									<label>Peminjam</label>
									<input required name="peminjam" type="text" class="form-control" placeholder="Nama Peminjam">
								</div>
								<div class="form-group">
									<label>Keterangan</label>
									<input name="keterangan" type="text" class="form-control" placeholder="Keterangan">
								</div>
								<div class="form-group">
									<label>Berita Acara</label>
									<input required name="berita_acara" type="text" class="form-control" placeholder="Nomor Berita Acara">
								</div>
								<div class="form-group">
									<label>Upload Berita Acara</label>
									<div    class="container form-control" 
                                            style=" padding: 10px;
                                                    border: 1px solid #D0D0D0;">
                                        <label>
                                            <input required style="margin-top:10px;" type="file" name="file1" id="upload_file1" readonly="true"/>
                                        </label>
                                    </div>
                                    {{-- <input style="height: 500px" name="file1" type="file" class="form-control" placeholder="Keterangan"> --}}
								</div>
                                <div id="moreFileUpload"></div>
                                <div style="clear:both;"></div>
                                <div id="moreFileUploadLink" style="display:none;margin-left: 10px;">
                                    <a href="javascript:void(0);" id="attachMore">Attach another file</a>
                                </div>
                                <div>&nbsp;</div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                    <input type="submit" class="btn btn-primary" name="upload" value="Simpan">
                                </div>
                            </form>
                        </div>
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