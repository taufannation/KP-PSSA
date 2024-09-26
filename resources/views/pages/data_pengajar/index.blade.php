@extends('layouts.template')
@section('title','Data Pengelolah')
@section('content')
<div class="section-header">
    <h1><i class="fa fa-users"></i> Data Pengelolah PSAA Fajar Harapan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a>Data Pengelolah</a></div>
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">

                    <h4 class="card-title">Data Pengelolah
                    </h4>
                    <div class="ml-auto">
                        <button type="button" class="btn btn-primary mt-3 mx-2" data-toggle="modal" data-target="#data_pengajar_create">
                            <i class="fa fa-plus"></i> Tambah
                        </button>
                        <button type="button" class="btn btn-success float-right mt-3 mx-2" data-toggle="modal" data-target="#excel" title="Import Excel">
                            <i class="fas fa-fw fa-file-excel"></i>
                            Import
                        </button>
                        <a href="{{ ('data_pengajar/export') }}" class="btn btn-info mt-3 mx-2" data-toggle="tooltip" title="Export Excel">
                            <i class="fa fa-file-csv"></i> Export
                        </a>
                        <a href="{{ asset('data_pengajar/print') }}" class="btn btn-danger mt-3 mx-2" data-toggle="tooltip" title="Print">
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
                                            <th scope="col">Foto</th>
                                            <th scope="col">No.KTP</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Jenis Kelamin</th>
                                            <th scope="col">Usia</th>
                                            <th scope="col">Alamat</th>
                                            <th scope="col">Jabatan</th>
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
@include('pages.data_pengajar.modal.create')
@include('pages.data_pengajar.modal.edit')
@include('pages.data_pengajar.modal.show')
@include('pages.data_pengajar._script')
@endpush