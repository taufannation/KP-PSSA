@extends('layouts.template')
@section('title', 'Dashboard')

@section('content')
<div class="section-header">
    <h1><i class="fa fa-home"></i> Dashboard</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">Dashboard</div>
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info alert-styled-left alert-arrow-left alert-component">
                <h6 class="alert-heading text-semibold" id="greeting"></h6>
                Welcome Aplikasi PSAA Fajar Harapan
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-columns"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Asset</h4>
                    </div>
                    <div class="card-body">
                        {{ $comodities }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-fw fa-check-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Siswa</h4>
                    </div>
                    <div class="card-body">
                        {{ $data_siswas }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-fw fa-exclamation-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Pengelolah</h4>
                    </div>
                    <div class="card-body">
                        {{ $data_pengajars }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Your additional content here -->

    <div class="text-center pt-1 pb-1">
    </div>
</div>
</div>
</div>
</div>
</div>
@endsection

@push('js_internal')
@include('pages.dashboard._script')
@include('pages.dashboard.show')
<script type="text/javascript">
    $(document).ready(function() {
        $('#greeting').html(greeting());
    });
</script>
@endpush