@php
    global $header, $current_user, $list_users;
    $current_user = Auth::user()->role;

    include 'list_user.php';

    $user_authorized = array($list_users["Admin"], $list_users["Presensi"]);
    $admin_privilege = array($list_users["Admin"], $list_users["Presensi"]);
    $user_unauthorized = array($list_users["Inventory"]);

@endphp

@if (!in_array($current_user, $user_authorized) || in_array($current_user, $user_unauthorized))
    @php
        header( "refresh:0;url=/unauthorized" );
    @endphp
@else

<!-- Extend Tamplate Master -->
@extends('layouts.master')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambahkan Data Waktu Kerja</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

    <!-- cotent disini     -->
    <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Masukkan Data Waktu Kerja</h6>
            </div>
            <div class="card-body">
                <form action="/storeKerja" method="POST" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    <div class="p-3 col-md-3">
                        <label for="in" class="form-label">Masuk</label>
                        <input type="time" class="form-control" name="in" id="in">
                    </div>
                    <div class="p-3 col-md-3">
                        <label for="out" class="form-label">Keluar</label>
                        <input type="time" class="form-control" name="out" id="out">
                    </div>
                    <div class="p-3 col-md-3">
                        <label for="shiff" class="form-label">Kerja</label>
                        <select class="form-control" name="shiff" id="shiff">
                            <option>Pilih Waktu Kerja</option>
                                <option value="0">Senin-Jumat</option>
                                <option value="1">Senin-Minggu</option>
                        </select>
                    </div>
                    <div class="p-3 col-md-6">
                        <label for="commant" class="form-label">Komentar</label>
                        <input type="text" class="form-control" name="commant" id="commant">
                    </div>
                    <div class="p-3 col-12">
                        <button type="submit" class="btn btn-primary">Tambahkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection

@endif