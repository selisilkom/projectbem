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
                    <h4 class="mb-4">Tahun Akademik {{ $tahun_akademik->tahun_akademik }}</h4>
                    @if (Session::get('success'))
                        <x-alert-bootstrap status="success" :message="Session::get('success')" />
                    @endif
                    @if (Session::get('failed'))
                        <x-alert-bootstrap status="failed" :message="Session::get('failed')" />
                    @endif

                    <a href="{{ url('/app-admin/organisasi/tahun-akademik/' . encrypt($tahun_akademik_id) . '/create') }}"
                        class="btn btn-primary mb-4">Tambah Akademik</a>

                    @if ($classes->isEmpty())
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
                                        <th>Tahun Akademik</th>
                                        <th>Nama organisasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                    @foreach ($classes as $class)
                                        <tr>
                                            <td>{{ $loop->iteration + $classes->firstItem() - 1 }}</td>
                                            <td>{{ $class->tahun_akademik->tahun_akademik }}</td>
                                            <td>{{ $class->nama_organisasi }}</td>
                                            <td>
                                                <a href="{{ url('/app-admin/organisasi/' . encrypt($class->id)) . '/mahasiswa' }}"
                                                    class="btn btn-sm btn-success"><i class="fas fa-eye mr-1"></i> Lihat
                                                    Mahasiswa</a>
                                                <a href="{{ url('/app-admin/organisasi/' . encrypt($class->id)) . '/edit' }}"
                                                    class="btn btn-sm btn-primary mx-1"><i class="fas fa-edit mr-1"></i>
                                                    Edit</a>
                                                <a href="#"
                                                    onclick="deleteRow('Kelas {{ $class->nama_organisasi }}', '{{ url('/app-admin/organisasi/' . encrypt($class->id)) }}')"
                                                    class="btn btn-sm btn-danger"><i class="fas fa-trash mr-1"></i>
                                                    Hapus</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="card-footer text-left mb-4">
                    {{ $classes->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
