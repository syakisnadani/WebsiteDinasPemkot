<!doctype html>
<html class="no-js" lang="en">

@php
    include 'stock_act/dbconnect.php';
    // include 'cek.php';
    require 'load_start_script.php';

    global $header, $current_user, $list_users;
    $current_user = Auth::user()->role;

    include 'list_user.php';

    $user_authorized = array($list_users["Admin"], $list_users["Inventory"], $list_users["Asset"]);
    $admin_privilege = array($list_users["Admin"], $list_users["Inventory"], $list_users["Asset"]);
    $user_unauthorized = array($list_users["Presensi"]);

@endphp

@if (!in_array($current_user, $user_authorized) || in_array($current_user, $user_unauthorized))
    @php
        header( "refresh:0;url=/unauthorized" );
    @endphp
@else

<title>{{ $header="Inventory" }} | {{ $title="Pengembalian Barang" }}</title>

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
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li><h3><div class="date">
								<script type='text/javascript'>
						<!--
						var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
						var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
						var date = new Date();
						var day = date.getDate();
						var month = date.getMonth();
						var thisDay = date.getDay(),
							thisDay = myDays[thisDay];
						var yy = date.getYear();
						var year = (yy < 1000) ? yy + 1900 : yy;
						document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);		
						//-->
						</script></b></div></h3>

						</li>
                        </ul>
                    </div>
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
									<h2>Barang Masuk / Kembali</h2>
									<button style="margin-bottom:20px" data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-2"><span class="glyphicon glyphicon-plus"></span>Tambah</button>
                                </div>
                                <div class="market-status-table mt-4">
                                    <div class="table-responsive">
										 <table id="dataTable3" class="table table-hover"><thead class="thead-dark">
											<tr>
												<th>No</th>
												<th>Tanggal</th>
												<th>Nama Barang</th>
												<th>Jenis</th>
												<th>Harga</th>
												<th>Jumlah</th>
                                                <th>Total</th>
												<th>Keterangan</th>
												
												<th>Opsi</th>
											</tr></thead><tbody>
											@php
                                                $brg=mysqli_query($conn,"SELECT * from sbrg_masuk sb, sstock_brg st where st.idx=sb.idx order by sb.id DESC");
											    $no=1;
                                            @endphp
											@while($b=mysqli_fetch_array($brg))
                                                @php
                                                    $idb = $b['idx'];
                                                    $id = $b['id'];
                                                    $tanggals=$b['tgl'];
                                                @endphp
												<tr>
													<td>{{ $no++ }}</td>
													<td>{{ date("d-M-Y", strtotime($tanggals)) }}</td>
													<td>{{ $b['nama'] }}</td>
													<td>{{ $b['jenis'] }}</td>
													<td>Rp. {{ $b['harga'] }}</td>
													<td>{{ $b['jumlah'] }}</td>
                                                    <td>Rp. {{ $b['jumlah'] * $b['harga'] }}</td>
													<td>{{ $b['keterangan'] }}</td>
                                                    <td><button data-toggle="modal" data-target="#edit{{ $id }}" class="btn btn-warning">Edit</button> <button data-toggle="modal" data-target="#del{{ $id }}" class="btn btn-danger">Hapus</button></td>
												</tr>

                                                <!-- The Modal -->
                                                <div class="modal fade" id="edit{{ $id }}">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <form action="/stock_act/edit_barang_masuk_act.php" method="post">
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
                                                            <input type="text" id="nama" name="nama" class="form-control" value="{{ $b['nama'] }} | {{ $b['jenis'] }}" disabled>

                                                            <label for="harga">Harga</label>
                                                            <input type="text" id="harga" name="harga" class="form-control" value="Rp. {{ $b['harga'] }}" disabled>

                                                            <label for="jumlah">Jumlah</label>
                                                            <input type="number" id="jumlah" name="jumlah" class="form-control" value="{{ $b['jumlah'] }}">

                                                            <label for="keterangan">Keterangan</label>
                                                            <input type="text" id="keterangan" name="keterangan" class="form-control" value="{{ $b['keterangan'] }}">
                                                            <input type="hidden" name="id" value="{{ $id }}">
                                                            <input type="hidden" name="idx" value="{{ $idb }}">

                                                            
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
                                                    <div class="modal fade" id="del{{ $id }}">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <form action="/stock_act/hapus_barang_masuk_act.php" method="post">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                            <h5 class="modal-title">Hapus Barang <br>{{ $b['nama'] }} - {{ $b['jenis'] }} - Rp. {{ $b['harga'] }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus barang ini dari daftar stock  masuk?
                                                            <br>
                                                            *Stock barang akan berkurang
                                                            <input type="hidden" name="id" value="{{ $id }}">
                                                            <input type="hidden" name="idx" value="{{ $idb }}">
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
                                    </div>
									<a href="/stock_act/export_barang_masuk.php" target="_blank" class="btn btn-info">Export Data</a>
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
	
	<!-- modal input -->
			<div id="myModal" class="modal fade">
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
									<select name="barang" class="custom-select form-control">
									<option selected>Pilih barang</option>
									@php
                                        $det=mysqli_query($conn,"select * from sstock_brg order by nama ASC")or die(mysqli_error());
                                    @endphp
									@while($d=mysqli_fetch_array($det))
										<option value="{{ $d['idx'] }}">{{ $d['nama'] }} - {{ $d['jenis'] }} - Rp. {{ $d['harga'] }}</option>
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