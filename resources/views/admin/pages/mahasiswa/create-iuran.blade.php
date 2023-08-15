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
                    <form action="{{ url('app-admin/mahasiswa/' . $mahasiswa->nim . '/bayar/' . encrypt($iuran->id) . '/' . $iuran->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nim" class="font-weight-bold">Nama Mahasiswa <span class="text-danger">*</span></label>
                            <input type="text" placeholder="nama mahasiswa" class="form-control" autocomplete="off" readonly="" value="{{ $mahasiswa->nama }}">
                            <input type="hidden" name="nim" value="{{ encrypt($mahasiswa->nim) }}">
                        </div>
                        <div class="form-group">
                            <label for="id_iuran" class="font-weight-bold">Iuran Tahun Akademik <span class="text-danger">*</span></label>
                            <input type="text" placeholder="tahun akademik" class="form-control" autocomplete="off" readonly="" value="{{ \App\Models\TahunAjaran::findActivedTahunAjaran()->start_year }} / {{ \App\Models\TahunAjaran::findActivedTahunAjaran()->end_year }}">
                            <input type="hidden" name="id_iuran" value="{{ encrypt($iuran->id_iuran) }}">
                        </div>
                        <div class="form-group">
                            <label for="id_iuran" class="font-weight-bold">Iuran Semester <span class="text-danger">*</span></label>
                            <input type="text" placeholder="semester" class="form-control" autocomplete="off" readonly="" value="{{ $semester }}">
                            <input type="hidden" name="semester_iuran" value="{{ $semester }}">
                        </div>
                        <div class="form-group">
                            <label for="id_iuran" class="font-weight-bold">Nominal Iuran<span class="text-danger">*</span></label>
                            <input type="text" placeholder="nominal iuran" class="form-control" autocomplete="off" readonly="" value="Rp. {{ number_format($iuran->nominal, 0, '.', '.') }}">
                        </div>
                        <div class="form-group">
                            <label for="jumlah_bayar" class="font-weight-bold">Jumlah Bayar</label>
                            <input type="text" name="jumlah_bayar" class="form-control @error('jumlah_bayar') @enderror" placeholder="jumlah bayar" value="{{ old('jumlah_bayar') }}" id="jumlah_bayar" autocomplete="off" required max="{{ $iuran->nominal }}">
                        </div>
                        <hr>
                        <div class="form-group d-flex justify-content-between">
                            <button class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="{{ url('/app-admin/mahasiswa/' . encrypt($mahasiswa->nim) . '/lihat-iuran') }}" class="btn btn-dark">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@section('script')
    <script>
        const jumlah_bayar = document.getElementById('jumlah_bayar');
        jumlah_bayar.addEventListener('keydown', function(event) {
            return isNumberKey(event);
        });
        jumlah_bayar.addEventListener('keyup', function() {
            jumlah_bayar.value = convertRupiah(this.value, 'Rp. ');
        });
    </script>
@endsection
@endsection
