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
                    <form action="{{ url('/app-admin/pengeluaran') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama_pengeluaran" class="font-weight-bold">Nama Pengeluaran <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pengeluaran" class="form-control @error('nama_pengeluaran') is-invalid @enderror" value="{{ old('nama_pengeluaran') }}" placeholder="nama pengeluaran" autocomplete="off" id="nama_pengeluaran">

                            @error('nama_pengeluaran')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jumlah" class="font-weight-bold">Jumlah <span class="text-danger">*</span></label>
                            <input type="text" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}" placeholder="jumlah" autocomplete="off" id="jumlah">

                            @error('jumlah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="deskripsi" class="font-weight-bold">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" style="height: 100px" placeholder="deskripsi" required>{{ old('deskripsi') }}</textarea>

                            @error('deskripsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="pdf_file" class="font-weight-bold">File PDF <span class="text-danger">*</span></label>
                            <input type="file" name="pdf_file" class="form-control @error('pdf_file') is-invalid @enderror" id="pdf_file" required accept="application/pdf">

                            @error('pdf_file')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <hr>
                        <div class="form-group d-flex justify-content-between">
                            <button class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="{{ url('/app-admin/petugas') }}" class="btn btn-dark">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const jumlah = document.getElementById('jumlah');
        jumlah.addEventListener('keydown', function(event) {
            return isNumberKey(event);
        });
        jumlah.addEventListener('keyup', function() {
            jumlah.value = convertRupiah(this.value, 'Rp. ');
        });
    </script>
@endsection
