@extends('admin.layouts.app')

@section('content')
    <x-header-breadcrumb :header="$title" />

    @if (Auth::guard('petugas')->check())
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Petugas</h4>
                        </div>
                        <div class="card-body"">
                            {{ $total_petugas }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Mahasiswa</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlah_mahasiswa }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-money-bill"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Sisa Dana</h4>
                        </div>
                        <div class="card-body">
                            Rp. {{ number_format($sisa_dana, 0, '.', '.') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Dana Pengeluaran</h4>
                        </div>
                        <div class="card-body">
                            Rp. {{ number_format($jml_dana_pengeluaran, 0, '.', '.') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-money-bill"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Dana Masuk</h4>
                        </div>
                        <div class="card-body">
                            Rp. {{ number_format($jml_dana_pembayaran, 0, '.', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col card p-5">
            <h2 class="text-center">Selamat Datang
                {{ Auth::guard('petugas')->check() ? Auth::guard('petugas')->user()->nama_petugas : Auth::guard('mahasiswa')->user()->nama }}
            </h2>
            <p class="mt-4">Selamat datang di aplikasi pembayaran Iuran. Di sini anda bisa mengelola data pembayaran iuran
                dengan mudah</p>
        </div>
    </div>
@endsection
