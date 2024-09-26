@extends('layouts.template')
@section('title','Tabungan Bri')
@section('content')
<div class="section-header">
    <h1><i class="fa-solid fa-file-invoice-dollar"></i> Tabungan BRI</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a>Tabungan BRI / <a href="{{ url ('kodebri')}}" class="active">Kode Transaksi</a></div>
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <form action="#" id="form_filter" method="get" class="mr-2">
                        @csrf
                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-auto mb-3">
                                    <a href="/kodebri" class="btn btn-success mt-2">Kode Transaksi</a>
                                </div>
                                <div class="col-auto mb-3 px-0">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" id="enableFilter" name="enable_filter" title="Beri Centang Untuk Filter Menggunakan Tanggal">
                                        <label class="form-check-label" for="enableFilter">&nbsp; </label>
                                    </div>
                                </div>
                                <div class="col mb-3 px-0">
                                    <div class="d-flex">
                                        <input type="text" class="form-control tanggal-filter" name="start_date" id="startDate" value="{{ date('01-m-Y') }}" disabled>
                                        <input type="text" class="form-control tanggal-filter ml-2" name="end_date" id="endDate" value="{{ date('t-m-Y') }}" disabled>
                                    </div>
                                </div>
                                <div class="col-auto mb-3">
                                    <select name="kode_bri_id" id="filter_kode_bri_id" class="form-control form-control-sm">
                                        <option value="">- Pilih Kode Transaksi -</option>
                                        @foreach($kode_bris as $kode_bri)
                                        <option value="{{ $kode_bri->id }}">{{ $kode_bri->nama . ' [' . $kode_bri->kode . ']' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto mb-3">
                                    <button type="button" class="btn btn-danger btn-filter-action mb-1" data-url="{{ route('kaskecil.print') }}">
                                        <i class="fa fa-file-pdf mr-1"></i>Print
                                    </button>
                                    <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#tabunganbri_create">
                                        <i class="fa fa-plus mr-1"></i> Tambah
                                    </button>
                                    <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#excel">
                                        <i class="fa fa-file-excel mr-1"></i>Import
                                    </button>
                                    <button type="button" class="btn btn-info btn-filter-action" data-url="{{ url('kaskecil/export') }}" data-toggle="tooltip" title="Export Excel">
                                        <i class="fa fa-file-csv mr-1"></i> Export
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row px-3 py-3">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="datatable" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Tgl Transaksi</th>
                                            <th scope="col">Kode</th>
                                            <th scope="col">Keterangan</th>
                                            <th scope="col">Debet</th>
                                            <th scope="col">Kredit</th>
                                            <th scope="col">Sisa Saldo</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js_internal')
@include('pages.tabunganbri.modal.create')
@include('pages.tabunganbri.modal.edit')
@include('pages.tabunganbri.modal.show')
@include('pages.tabunganbri.modal.import')
@include('pages.tabunganbri._script')
@endpush