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
                    <a href="{{ url('/app-admin/tahun-ajaran/create') }}" class="btn btn-primary mb-4">Tambah {{ $title }}</a>

                    @if (Session::get('success'))
                        <x-alert-bootstrap status="success" :message="Session::get('success')" />
                    @endif
                    @if (Session::get('failed'))
                        <x-alert-bootstrap status="failed" :message="Session::get('failed')" />
                    @endif

                    @if ($rows_tahun->isEmpty())
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
                                        <th>Tahun Ajaran</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                    @foreach ($rows_tahun as $tahun)
                                        <tr>
                                            <td>{{ $loop->iteration + $rows_tahun->firstItem() - 1 }}</td>
                                            <td>{{ $tahun->start_year }}/{{ $tahun->end_year }}</td>
                                            <td>{!! $tahun->is_active ? '<span class="badge bg-success text-white"><i class="fas fa-check"></i> Aktif</span>' : '' !!}</td>
                                            <td>
                                                <div class="d-flex" style="gap: .4rem">
                                                    <a href="{{ url('/app-admin/tahun-ajaran/' . encrypt($tahun->id) . '/edit') }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="#" class="btn btn-sm btn-danger" onclick="deleteRow('Tahun ajaran {{ $tahun->start_year }}', '{{ url('/app-admin/tahun-ajaran/' . encrypt($tahun->id)) }}')"><i class="fas fa-trash"></i> Hapus</a>

                                                    @if (!$tahun->is_active)
                                                        <form action="{{ url('app-admin/tahun-ajaran/' . encrypt($tahun->id) . '/set-active') }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn-sm btn-warning"><i class="fas fa-check"></i> Atur aktif</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
                <div class="card-footer text-left mb-4">
                    {{ $rows_tahun->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
