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
                    @if (Session::get('success'))
                        <x-alert-bootstrap status="success" :message="Session::get('success')" />
                    @endif
                    @if (Session::get('failed'))
                        <x-alert-bootstrap status="failed" :message="Session::get('failed')" />
                    @endif

                    @if ($rows_iuran->isEmpty())
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
                                        <th>Semester</th>
                                        <th>Nominal Iuran</th>
                                        <th>Aksi</th>
                                    </tr>
                                    @foreach ($rows_iuran as $index => $iuran)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $iuran->semester }}</td>
                                            <td>Rp. {{ number_format($iuran->nominal, 0, '.', '.') }}</td>
                                            <td>
                                                <a href="{{ url('/app-admin/iuran/' . encrypt($iuran->id) . '/edit') }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
