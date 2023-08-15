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
                    <h3 class="mb-4">Kelas {{ $organisasi->nama_organisasi }}</h3>

                    @if (Auth::guard('petugas')->user()->level == 'admin')
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ url('/app-admin/mahasiswa/' . encrypt($organisasi->id_organisasi) . '/create') }}"
                                    class="btn btn-primary mb-4">Tambah {{ $title }}</a>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <button type="button" class="btn btn-success mb-4" data-toggle="modal"
                                    data-target="#exampleModal"><i class='fas fa-download'></i>
                                    {{ __('Import Mahasiswa') }}
                                </button>
                            </div>
                        </div>
                    @endif
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Failed!</strong>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (Session::get('success'))
                        <x-alert-bootstrap status="success" :message="Session::get('success')" />
                    @endif
                    @if (Session::get('failed'))
                        <x-alert-bootstrap status="failed" :message="Session::get('failed')" />
                    @endif

                    @if ($rows_mahasiswa->isEmpty())
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
                                <tbody id="table-body">
                                    <tr>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Email</th>
                                        <th>NIM</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No HP</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                    @foreach ($rows_mahasiswa as $mahasiswa)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{ $mahasiswa->photo != null ? asset('/storage/images/mahasiswa/' . $mahasiswa->photo) : asset('/images/icons/no-photo-rounded.png') }}"
                                                    alt=""
                                                    style="width: 75px; object-fit: cover; object-position: center"
                                                    class="rounded"></td>
                                            <td>{{ $mahasiswa->nama }}</td>
                                            <td>{{ $mahasiswa->email }}</td>
                                            <td>{{ $mahasiswa->nim }}</td>
                                            <td>{{ $mahasiswa->jenis_kelamin }}</td>
                                            <td>{{ $mahasiswa->no_telp }}</td>
                                            <td>{{ $mahasiswa->alamat }}</td>
                                            <td style="white-space: nowrap">
                                                <a href="{{ url('/app-admin/mahasiswa/' . encrypt($mahasiswa->nim) . '/lihat-iuran') }}"
                                                    class="btn btn-sm btn-success"><i class="fas fa-edit"></i> Lihat
                                                    Iuran</a>
                                                @if (Auth::guard('petugas')->user()->level == 'admin')
                                                    <a href="{{ url('/app-admin/mahasiswa/' . encrypt($mahasiswa->nim) . '/edit') }}"
                                                        class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                                    <a href="#" class="btn btn-sm btn-danger"
                                                        onclick="deleteRow('Mahasiswa {{ $mahasiswa->nama }}', '{{ url('/app-admin/mahasiswa/' . encrypt($mahasiswa->nim)) }}')"><i
                                                            class="fas fa-trash"></i> Hapus</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
                <div class="card-footer text-left mb-4">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Mahasiswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST"
                    action="{{ url('/app-admin/mahasiswa/organisasi/' . encrypt($organisasi->id_organisasi) . '/action-import-mahasiswa') }}"
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <input type="file" class="form-control" id="import_mahasiswa"
                                aria-describedby="import_mahasiswa" name="import_mahasiswa" accept=".xlsx" required>
                            <div id="downloadFormat" class="form-text"> <a href="#"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download Format</a> </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal --}}
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>

    <script>
        const showLoading = function() {
            swal({
                title: 'Now loading',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 2000,
                onOpen: () => {
                    swal.showLoading();
                }
            }).then(
                () => {},
                (dismiss) => {
                    if (dismiss === 'timer') {
                        console.log('closed by timer!!!!');
                        swal({
                            title: 'Finished!',
                            type: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        })
                    }
                }
            )
        };

        $(document).on('click', '#downloadFormat', function(event) {
            event.preventDefault();
            downloadFormat();

        });

        var downloadFormat = function() {
            var url = '/app-admin/mahasiswa/download-format-mahasiswa';
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {},
                xhrFields: {
                    responseType: 'blob'
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Please Wait !',
                        html: 'Sedang melakukan download format import',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });

                },
                success: function(data) {
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(data);
                    var nameFile = 'import_mahasiswa.xlsx'
                    console.log(nameFile)
                    link.download = nameFile;
                    link.click();
                    swal.close()
                },
                error: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'error',
                        title: "Download Format Import failed",
                        text: "Please check",
                        allowOutsideClick: false,
                    })
                }
            });
        }
    </script>
@endsection
