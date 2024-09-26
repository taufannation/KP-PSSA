@extends('layouts.template')
@section('title','Daftar Jenis Transaksi Tabungan')

@section('content')
<div class="section-header">
    <h1> Daftar Jenis Transaksi Tabungan</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ url('kaskecil') }}">Kas Kecil</a> / <a>Mata Anggaran</a></div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><a href="{{ asset('tabungan') }}" class="btn btn-danger float-right mt-3 mx-3">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a></h4>
                    <div class="ml-auto">
                        <button type="button" class="btn btn-primary float-right mt-3 mx-3" data-toggle="modal" data-target="#jenis-transaksi-tabungan_create"><i class="fa fa-plus"></i> Tambah</button>
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
                                            <th scope="col">Kode</th>
                                            <th scope="col">Nama</th>
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
@include('pages.jenis-transaksi-tabungan.modal.create')
@include('pages.jenis-transaksi-tabungan.modal.edit')
@include('pages.jenis-transaksi-tabungan.modal.show')
@include('pages.jenis-transaksi-tabungan._script')
@endpush