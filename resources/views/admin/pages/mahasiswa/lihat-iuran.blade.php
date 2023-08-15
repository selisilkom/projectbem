@extends('admin.layouts.app')

@section('content')
    <div id="loadingOverElement" class="d-none" style="position: fixed; top: 0; left: 0; width: 100%; height: 100vh; display: flex; align-items: center; justify-content: center; background: rgba(0, 0, 0, .5); z-index: 98990999">
        <div v-if="loading" class="spinner">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4>List Data {{ $title }}</h4>
                </div>
                <div class="card-body">
                    <h3 class="mb-4">Iuran Mahasiswa : {{ $mahasiswa->nama }}</h3>
                    <h3 class="mt-5 mb-3">TAHUN AJARAN {{ \App\Models\TahunAjaran::findActivedTahunAjaran()->start_year }} / {{ \App\Models\TahunAjaran::findActivedTahunAjaran()->end_year }}</h3>

                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <thead>
                                <tr>
                                    <th>Semester</th>
                                    <th>Status</th>
                                    <th>Nominal Iuran</th>
                                    <th>Total Bayar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($all_iuran_payments as $iuran_payment)
                                    <tr>
                                        <td>{{ $iuran_payment->semester }}</td>
                                        <td>
                                            @if ($iuran_payment['status'] == 'Belum Bayar')
                                                <button class="btn btn-sm btn-danger">{{ $iuran_payment['status'] }}</button>
                                            @elseif($iuran_payment['status'] == 'Belum Lunas')
                                                <button class="btn btn-sm btn-primary">{{ $iuran_payment['status'] }}</button>
                                                <button class="btn btn-sm btn-warning">Kekurangan Rp.
                                                    {{ number_format($iuran_payment->nominal - $iuran_payment['total_bayar'], 0, '.', '.') }}</button>
                                            @elseif($iuran_payment['status'] == 'Lunas')
                                                <button class="btn btn-sm btn-success">{{ $iuran_payment['status'] }}</button>
                                            @endif
                                            <button class="btn btn-sm btn-"></button>
                                        </td>
                                        <td>Rp. {{ number_format($iuran_payment->nominal) }}</td>
                                        <td>Rp. {{ number_format($iuran_payment['total_bayar'], 0, '.', '.') }}</td>
                                        <td>
                                            @if ($iuran_payment['status'] != 'Lunas')
                                                @if (Auth::guard('petugas')->check())
                                                    <a class="btn btn-sm btn-success" href="{{ $iuran_payment['link_add_pembayaran'] . '?kekurangan=' . $iuran_payment['kekurangan'] }}">Bayar
                                                        Sekarang</a>
                                                    <a class="btn btn-sm btn-info" href="{{ $iuran_payment['link_send_email_notification'] . '?kekurangan=' . $iuran_payment['kekurangan'] }}">Send
                                                        Email</a>
                                                @else
                                                    <button type="button" onclick="createPayment('{{ $iuran_payment['id'] }}')" class="btn btn-sm btn-success">Bayar Sekarang</button>
                                                @endif
                                            @endif

                                            @if ($iuran_payment['status'] != 'Belum Bayar')
                                                <a class="btn btn-sm btn-primary" href="{{ url('/app-admin/histori-pembayaran/mahasiswa/' . $iuran_payment['id_pembayaran'] . '/pembayaran') }}">Lihat
                                                    Histori</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('stylesheet')
    @if (Auth::guard('mahasiswa')->check())
        <script type="text/javascript" src="https://app.{{ $appEnv == 'local' ? 'sandbox.' : '' }}midtrans.com/snap/snap.js" data-client-key="{{ $midtransLocalKey }}"></script>
    @endif
    <style>
        .spinner {
            margin: 100px auto;
            width: 50px;
            height: 60px;
            text-align: center;
            font-size: 10px;
        }

        .spinner>div {
            background-color: #00d1b2;
            height: 100%;
            width: 6px;
            display: inline-block;
            -webkit-animation: stretchDelay 1.2s infinite ease-in-out;
            animation: stretchDelay 1.2s infinite ease-in-out;
        }

        .spinner .rect2 {
            -webkit-animation-delay: -1.1s;
            animation-delay: -1.1s;
        }

        .spinner .rect3 {
            -webkit-animation-delay: -1s;
            animation-delay: -1s;
        }

        .spinner .rect4 {
            -webkit-animation-delay: -0.9s;
            animation-delay: -0.9s;
        }

        .spinner .rect5 {
            -webkit-animation-delay: -0.8s;
            animation-delay: -0.8s;
        }

        @-webkit-keyframes stretchDelay {

            0%,
            40%,
            100% {
                -webkit-transform: scaleY(0.4);
            }

            20% {
                -webkit-transform: scaleY(1);
            }
        }

        @keyframes stretchDelay {

            0%,
            40%,
            100% {
                transform: scaleY(0.4);
                -webkit-transform: scaleY(0.4);
            }

            20% {
                transform: scaleY(1);
                -webkit-transform: scaleY(1);
            }
        }
    </style>
@endsection

@section('script')
    @if (Auth::guard('mahasiswa')->check())
        <script>
            function createPayment(tahunAjaranHasIuranId) {

                const loadingOverElement = document.getElementById('loadingOverElement')

                loadingOverElement.classList.contains('d-none') ? loadingOverElement.classList.remove('d-none') : '';
                fetch('/api/midtrans/create-snap-token', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            'tahun_ajaran_has_iuran_id': tahunAjaranHasIuranId,
                            nim: '{{ Auth::guard('mahasiswa')->user()->nim }}'
                        })
                    }).then((res) => res.json())
                    .then((response) => {
                        !loadingOverElement.classList.contains('d-none') ? loadingOverElement.classList.add('d-none') : '';
                        window.snap.pay(response, {
                            onSuccess: function(result) {
                                window.location.reload();
                            },
                            onPending: function(result) {},
                            onError: function(result) {
                                alert('Error');
                            },
                            onClose: function() {}
                        });

                    })
            }
        </script>
    @endif
@endsection
