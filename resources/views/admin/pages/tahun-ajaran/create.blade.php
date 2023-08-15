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
                    <form action="{{ url('/app-admin/tahun-ajaran') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="tahun_ajaran" class="font-weight-bold">Tahun Ajaran <span class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-5">
                                            <input type="number" maxlength="4" oninput="this.value=this.value.slice(0,this.maxLength)" class="form-control @error('start_year') is-invalid @enderror" name="start_year" id="start_year" placeholder="tahun awal" value="{{ old('start_year') }}" autocomplete="off" min="1000" max="9999">
                                            @error('start_year')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-1">
                                            <h4>/</h4>
                                        </div>
                                        <div class="col-5">
                                            <input type="number" maxlength="4" oninput="this.value=this.value.slice(0,this.maxLength)" class="form-control @error('end_year') is-invalid @enderror" name="end_year" id="end_year" placeholder="tahun akhir" value="{{ old('end_year') }}" autocomplete="off" min="1000" max="9999">
                                            @error('end_year')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group d-flex justify-content-between">
                            <button class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="{{ url('/app-admin/tahun-ajaran') }}" class="btn btn-dark">Kembali</a>
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
    <script>
        const nominal = document.getElementById('nominal');
        nominal.addEventListener('keydown', function(event) {
            return isNumberKey(event);
        });
        nominal.addEventListener('keyup', function() {
            nominal.value = convertRupiah(this.value, 'Rp. ');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
