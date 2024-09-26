@extends('layouts.template')
@section('title','Data Barang')
@section('content')
<div class="section-header">
    <h1><i class="fa fa-building"></i> Data Asset PSAA Fajar Harapan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a>Data Asset</a> / <a href="{{ url('comodity_locations') }}">Data Ruangan</a></div>
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><a href="{{ asset('comodity_locations') }}" class="btn btn-info btn-ruangan float-right mt-3 mx-3" data-toggle="tooltip" title="Ruangan">
                            <i class="fas fa-door-open"></i> Data Ruangan</a></h4>
                    <div class="ml-auto">
                        <button type="button" class="btn btn-primary mt-3 mx-2" data-toggle="modal" data-target="#comodities_create">
                            <i class="fa fa-plus"></i> Tambah
                        </button>
                        <button type="button" class="btn btn-success float-right mt-3 mx-2" data-toggle="modal" data-target="#excel" title="Import Excel">
                            <i class="fas fa-fw fa-file-excel"></i>
                            Import
                        </button>
                        <a href="{{ ('comodities/export') }}" class="btn btn-info mt-3 mx-2" data-toggle="tooltip" title="Export Excel">
                            <i class="fa fa-file-csv"></i> Export
                        </a>
                        <a href="{{ asset('barang/print') }}" class="btn btn-danger mt-3 mx-2" data-toggle="tooltip" title="Print">
                            <i class="fa fa-file-pdf mr-1"></i> Print </a>

                    </div>
                </div>

                <div class="card-body">
                    <div class="row px-3 py-3">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Kode Barang</th>
                                            <th scope="col">Nama Barang</th>
                                            <th scope="col">Tanggal Peroleh</th>
                                            <th scope="col">Kondisi</th>
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
@include('pages.comodities.modal.create')
@include('pages.comodities.modal.edit')
@include('pages.comodities.modal.show')
@include('pages.comodities.modal.import')
@include('pages.comodities._script')
@endpush