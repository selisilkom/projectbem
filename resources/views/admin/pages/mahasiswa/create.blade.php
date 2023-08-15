@extends('admin.layouts.app')

@section('content')
    <x-header-breadcrumb :header="$title" />
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $title }}</h4>
                </div>
                <div class="card-body">
                    @if (Session::get('failed'))
                        <x-alert-bootstrap status="failed" :message="Session::get('failed')" />
                    @endif
                    <form action="{{ url('/app-admin/mahasiswa') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama_organisasi" class="font-weight-bold">Kelas <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nama_organisasi"
                                class="form-control @error('nama_organisasi') is-invalid @enderror"
                                value="{{ $organisasi->nama_organisasi }}" placeholder="organisasi" autocomplete="off"
                                id="nama_organisasi" readonly>
                            <input type="hidden" name="id_organisasi"
                                class="form-control @error('id_organisasi') is-invalid @enderror"
                                value="{{ encrypt($organisasi->id_organisasi) }}" placeholder="organisasi"
                                autocomplete="off" id="id_organisasi">
                        </div>
                        <div class="form-group">
                            <label for="nim" class="font-weight-bold">NIM <span class="text-danger">*</span></label>
                            <input type="number" name="nim" class="form-control @error('nim') is-invalid @enderror"
                                value="{{ old('nim') }}" placeholder="nim" autocomplete="off" id="nim" required>

                            @error('nim')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama" class="font-weight-bold">Nama Mahasiswa <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}" placeholder="nama mahasiswa" autocomplete="off" id="nama"
                                required>

                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="font-weight-bold">Email <span class="text-danger">*</span></label>
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="email" autocomplete="off" id="email" required>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin" class="font-weight-bold">Jenis Kelamin <span
                                    class="text-danger">*</span></label>
                            <select class="form-control" name="jenis_kelamin" required="">
                                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                @foreach ($jenis_kelamins as $jenis_kelamin)
                                    <option value="{{ $jenis_kelamin }}"
                                        @if (old('jenis_kelamin')) {{ old('jenis_kelamin') == $jenis_kelamin ? 'selected' : '' }} @endif>
                                        {{ $jenis_kelamin }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_telp" class="font-weight-bold">No Telp <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror"
                                value="{{ old('no_telp') }}" placeholder="no telp" autocomplete="off" id="no_telp"
                                required>

                            @error('no_telp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="font-weight-bold">Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" style="height: 100px"
                                placeholder="alamat" required>{{ old('alamat') }}</textarea>

                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" class="form-control" name="photo">
                            @error('photo')
                                <span class="text-danger mt-2 d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <hr>
                        <div class="form-group d-flex justify-content-between">
                            <button class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="{{ url('/app-admin/mahasiswa/organisasi/' . encrypt($organisasi->id_organisasi)) }}"
                                class="btn btn-dark">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('stylesheet')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
