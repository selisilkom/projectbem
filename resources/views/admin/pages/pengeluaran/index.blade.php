@extends('admin.layouts.app')

@section('content')
    <x-header-breadcrumb :header="$title" />
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4>List Data {{ $title }}</h4>
                </div>
                <div class="card-body">
                    @if (Auth::guard('petugas')->check())
                        <a href="{{ url('/app-admin/pengeluaran/create') }}" class="btn btn-primary mb-4">Tambah
                            {{ $title }}</a>
                    @endif
                    @if (Session::get('success'))
                        <x-alert-bootstrap status="success" :message="Session::get('success')" />
                    @endif
                    @if (Session::get('failed'))
                        <x-alert-bootstrap status="failed" :message="Session::get('failed')" />
                    @endif

                    @if ($rows_pengeluaran->isEmpty())
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <div class="row w-100">
                                <div class="col-10 offset-1 col-lg-4 offset-lg-4">
                                    <img src="{{ asset('/admin/assets/img/No data-amico.svg') }}" class="w-100">
                                </div>
                            </div>
                            <h2>Tidak ada data</h2>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pengeluaran</th>
                                        <th>Jumlah</th>
                                        <th>Deskripsi</th>
                                        <th>PDF</th>
                                        @if (Auth::guard('petugas')->check())
                                            <th>Aksi</th>
                                        @endif
                                    </tr>
                                    @foreach ($rows_pengeluaran as $pengeluaran)
                                        <tr>
                                            <td>{{ $loop->iteration + $rows_pengeluaran->firstItem() - 1 }}</td>
                                            <td>{{ $pengeluaran->nama_pengeluaran }}</td>
                                            <td>Rp. {{ number_format($pengeluaran->jumlah, 0, '.', '.') }}</td>
                                            <td>{{ $pengeluaran->deskripsi }}</td>
                                            <td><a target="_blank" href="{{ url('/storage/images/pengeluaran/' . $pengeluaran->pdf_file) }}" class="btn btn-sm btn-success"><i class="fas fa-download"></i> Download</a></td>
                                            @if (Auth::guard('petugas')->check())
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-danger" onclick="deleteRow('Pengeluaran {{ $pengeluaran->nama_pengeluaran }}', '{{ url('/app-admin/pengeluaran/' . encrypt($pengeluaran->id_pengeluaran)) }}')"><i class="fas fa-trash"></i> Hapus</a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
                <div class="card-footer text-left mb-4">
                    {{ $rows_pengeluaran->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
