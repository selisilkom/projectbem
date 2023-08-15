<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LogPembayaran;
use App\Models\Mahasiswa;
use App\Models\MidtransPaymentIuran;
use App\Models\Pembayaran;
use App\Models\Petugas;
use App\Models\TahunAjaran;
use App\Models\TahunAjaranHasIuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransController extends Controller
{
    public function createSnapToken(Request $request)
    {
        $tahunAjaranIuran = TahunAjaranHasIuran::find($request->tahun_ajaran_has_iuran_id);
        $tahunAjaran = TahunAjaran::findActivedTahunAjaran();
        $mahasiswa = Mahasiswa::where('nim', $request->nim)->leftJoin('organisasi', 'organisasi.id_organisasi', '=', 'mahasiswa.id_organisasi')->where('tahun_ajaran_id', $tahunAjaran->id)->first();

        if (!$tahunAjaranIuran || !$mahasiswa) {
            return response()->json([
                'code' => 404,
                'msg' => 'Not found'
            ], 404);
        }

        $pembayaran = Pembayaran::where('tahun_ajaran_has_iuran_id', '=', $tahunAjaranIuran->id)->where('nim', '=', $mahasiswa->nim)->where('tahun_ajaran_id', '=', $tahunAjaran->id);
        $pembayaranStatus = $pembayaran->exists() ? $pembayaran->get()[0]->status : 'Belum Bayar';

        if ($pembayaranStatus == 'lunas') {
            return false;
        }

        $midtransTrx = MidtransPaymentIuran::create([
            'nim' => $mahasiswa->nim,
            'tahun_ajaran_has_iuran_id' => $tahunAjaranIuran->id,
            'amount' => $pembayaran->exists() ? $tahunAjaranIuran->nominal - $pembayaran->get()[0]->total_bayar : $tahunAjaranIuran->nominal,
            'status' => 'pending'
        ]);

        $params = array(
            'transaction_details' => array(
                'order_id' => $midtransTrx->id,
                'gross_amount' => $midtransTrx->amount,
            )
        );

        Config::$serverKey = config('app.midtrans_server_key');

        Config::$isProduction = config('app.env') == 'local' ? false : true;

        Config::$isSanitized = true;

        Config::$is3ds = false;

        $snapToken = Snap::getSnapToken($params);
        return response()->json($snapToken);
    }

    public function verifyMidtransPayment(Request $request)
    {
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . config('app.midtrans_server_key'));
        if ($hashed == $request->signature_key && $request->transaction_status == 'settlement') {
            $trxMidtrans = MidtransPaymentIuran::find($request->order_id);
            $tahunAjaranIuran = TahunAjaranHasIuran::find($trxMidtrans->tahun_ajaran_has_iuran_id);

            if ($pembayaran = Pembayaran::where('tahun_ajaran_id', TahunAjaran::findActivedTahunAjaran())->where('tahun_ajaran_has_iuran_id', $trxMidtrans->tahun_ajaran_has_iuran_id)->where('nim', $trxMidtrans->nim)->first()) {
                $pembayaran->update([
                    'total_bayar' => $pembayaran->total_bayar + $trxMidtrans->amount,
                    'status' => ($pembayaran->total_bayar + $trxMidtrans->amount) >= $tahunAjaranIuran->nominal ? 'Lunas' : 'Belum Lunas',
                ]);
            } else {

                $id_pembayaran = (string) rand();
                while ($id_pembayaran[0] == 0) {
                    $id_pembayaran = rand();
                }

                Pembayaran::create([
                    'id_pembayaran' => $id_pembayaran,
                    'nim' => $trxMidtrans->nim,
                    'tahun_ajaran_has_iuran_id' => $trxMidtrans->tahun_ajaran_has_iuran_id,
                    'total_bayar' => $trxMidtrans->amount,
                    'status' => $trxMidtrans->amount >= $tahunAjaranIuran->nominal ? 'Lunas' : 'Belum Lunas',
                    'tahun_ajaran_id' => TahunAjaran::findActivedTahunAjaran()->id
                ]);

                $id_log_pembayaran = (string) rand();
                while ($id_log_pembayaran[0] == 0) {
                    $id_log_pembayaran = rand();
                }

                LogPembayaran::create([
                    'id_log_pembayaran' => $id_log_pembayaran,
                    'id_pembayaran'     => $id_pembayaran,
                    'id_petugas'        => Petugas::where('username', 'system')->first->id_petugas,
                    'tgl_bayar'         => date('Y-m-d'),
                    'jumlah_bayar'      => $trxMidtrans->amount,
                ]);
            }

            $trxMidtrans->update([
                'payment_status' => 'accepted'
            ]);
        } else {
            var_dump('fail');
            die;
        }
    }
}
