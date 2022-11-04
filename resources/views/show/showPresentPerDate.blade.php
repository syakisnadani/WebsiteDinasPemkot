<!-- Extend Tamplate Master -->
@extends('layouts.master')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h4 mb-0 text-gray-800">Masukkan Manual Data Present</h1>
    <p class="mb-4">
        Nama : {{ $dataStaff->name }}
    </p>

    <!-- Content Row -->
    <div class="row">
        
    <!-- cotent disini     -->
    <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Masukkan Manual Data Present</h6>
            </div>
            <div class="card-body">
                <form action="/updateManualDate/{{ $dataStaff->pin }}" method="POST" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    <div class="p-3 col-6">
                        <label for="in" class="form-label">Masuk</label>
                        <input type="time" class="form-control" name="in" id="in" value="{{ $inClock }}">
                    </div>
                    <div class="p-3 col-6">
                        <label for="out" class="form-label">Pulang</label>
                        <input type="time" class="form-control" name="out" id="out" value="{{ $outClock }}">
                    </div>
                    <div class="p-3 col-md-6">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" value="{{ $keterangan }}">
                    </div>
                    <input type="hidden" class="form-control" name="date" id="date" value="{{ $date }}">
                    <input type="hidden" class="form-control" name="idIn" id="idIn" value="{{ $inDate}}">
                    <input type="hidden" class="form-control" name="idOut" id="idOut" value="{{ $outDate }}">
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