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
                <form action="/updateKerja/{{ $data->id }}" method="POST" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    <div class="p-3 col-md-3">
                        <label for="in" class="form-label">Masuk</label>
                        <input type="time" class="form-control" name="in" id="in" value="{{ $data->in }}">
                    </div>
                    <div class="p-3 col-md-3">
                        <label for="out" class="form-label">Keluar</label>
                        <input type="time" class="form-control" name="out" id="out" value="{{ $data->out }}">
                    </div>
                    <div class="p-3 col-md-3">
                        <label for="shiff" class="form-label">Kerja</label>
                        <select class="form-control" name="shiff" id="shiff">
                            <option value="{{ $data->shiff }}">Pilih Waktu Kerja</option>
                                <option value="0">Senin-Jumat</option>
                                <option value="1">Senin-Minggu</option>
                        </select>
                    </div>
                    <div class="p-3 col-md-6">
                        <label for="commant" class="form-label">Komentar</label>
                        <input type="text" class="form-control" name="commant" id="commant" value="{{ $data->commant }}">
                    </div>
                    <div class="p-3 col-12">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection