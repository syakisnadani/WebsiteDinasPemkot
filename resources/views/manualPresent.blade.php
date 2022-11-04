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
        <h1 class="h3 mb-0 text-gray-800">Manual Present</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
    <div class="card-body">
                <form action="/showManualPresent" method="POST" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    <div class="p-3 col-md-3">
                    <select class="form-control" name="pin" id="pin">
                        <option>Pilih Nama Pegawai</option>
                        @foreach ($data as $value)
                            <option value="{{ $value->pin }}">
                                {{ $value->name }}
                            </option>
                        @endforeach
                    </select>
                    </div>
                    <div class="p-3 col-md-3">
                    <select class="form-control" name="month" id="month">
                        <option value="0">Pilih Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mai</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Augustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                    </div>
                    <div class="p-3 col-md-3">
                        <input type="number" class="form-control" name="year" id="year" placeholder="2022">
                    </div>
                    <div class="p-3 col-12">
                        <button type="submit" class="btn btn-primary">Lihat</button>
                    </div>
                </form>
            </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection

@endif