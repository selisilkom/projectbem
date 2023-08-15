<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use PDF;
use App\Models\LogPembayaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class HistoriPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title'                 => 'Histori Pembayaran',
            'sidebar'               => 'histori-pembayaran',
            'logPembayarans'        => LogPembayaran::join('pembayaran', 'log_pembayaran.id_pembayaran', '=', 'pembayaran.id_pembayaran')
                ->join('tahun_ajaran_has_iuran', 'pembayaran.tahun_ajaran_has_iuran_id', '=', 'tahun_ajaran_has_iuran.id')
                ->join('petugas', 'log_pembayaran.id_petugas', '=', 'petugas.id_petugas')
                ->leftJoin('mahasiswa', 'pembayaran.nim', '=', 'mahasiswa.nim')
                ->orderBy('log_pembayaran.created_at', 'DESC')
                ->where(function ($q) {
                    $q->whereNull('pembayaran.nim')->orWhere('tahun_ajaran_has_iuran.tahun_ajaran_id', TahunAjaran::findActivedTahunAjaran()->id);
                })
                ->when($request->start_date && $request->end_date, function ($q) use ($request) {
                    $q->whereBetween('tgl_bayar', [$request->start_date, $request->end_date]);
                })
                ->simplePaginate(10)
        ];

        return view('admin.pages.histori-pembayaran.index', $data);
    }

    public function show($id)
    {
        $data = [
            'title'         => 'Detail Histori Pembayaran',
            'sidebar'       => 'histori-pembayaran',
            'pembayaran'    => LogPembayaran::join('pembayaran', 'log_pembayaran.id_pembayaran', '=', 'pembayaran.id_pembayaran')
                ->join('tahun_ajaran_has_iuran', 'pembayaran.tahun_ajaran_has_iuran_id', '=', 'tahun_ajaran_has_iuran.id')
                ->join('petugas', 'log_pembayaran.id_petugas', '=', 'petugas.id_petugas')
                ->join('mahasiswa', 'pembayaran.nim', '=', 'mahasiswa.nim')->where('id_log_pembayaran', '=', $id)
                ->join('organisasi', 'mahasiswa.id_organisasi', '=', 'organisasi.id_organisasi')
                ->first(),
        ];

        return view('admin.pages.histori-pembayaran.show', $data);
    }

    public function showByNim($nim)
    {
        $data = [
            'title'                 => 'Histori Pembayaran',
            'sidebar'               => 'histori-pembayaran',
            'logPembayarans'        => LogPembayaran::join('pembayaran', 'log_pembayaran.id_pembayaran', '=', 'pembayaran.id_pembayaran')
                ->join('tahun_ajaran_has_iuran', 'pembayaran.tahun_ajaran_has_iuran_id', '=', 'tahun_ajaran_has_iuran.id')
                ->join('petugas', 'log_pembayaran.id_petugas', '=', 'petugas.id_petugas')
                ->join('mahasiswa', 'pembayaran.nim', '=', 'mahasiswa.nim')
                ->where('mahasiswa.nim', '=', $nim)
                ->orderBy('log_pembayaran.created_at', 'DESC')->simplePaginate(10)
        ];

        return view('admin.pages.histori-pembayaran.index', $data);
    }

    public function showByPembayaranId($id_pembayaran)
    {
        $data = [
            'title'                 => 'Histori Pembayaran',
            'sidebar'               => 'histori-pembayaran',
            'logPembayarans'        => LogPembayaran::join('pembayaran', 'log_pembayaran.id_pembayaran', '=', 'pembayaran.id_pembayaran')
                ->join('tahun_ajaran_has_iuran', 'pembayaran.tahun_ajaran_has_iuran_id', '=', 'tahun_ajaran_has_iuran.id')
                ->join('petugas', 'log_pembayaran.id_petugas', '=', 'petugas.id_petugas')
                ->join('mahasiswa', 'pembayaran.nim', '=', 'mahasiswa.nim')
                ->where('pembayaran.id_pembayaran', '=', $id_pembayaran)
                ->orderBy('log_pembayaran.created_at', 'DESC')->simplePaginate(10)
        ];

        return view('admin.pages.histori-pembayaran.index', $data);
    }

    public function cetakIndex()
    {
        $pembayarans = LogPembayaran::join('pembayaran', 'log_pembayaran.id_pembayaran', '=', 'pembayaran.id_pembayaran')
            ->join('tahun_ajaran_has_iuran', 'pembayaran.tahun_ajaran_has_iuran_id', '=', 'tahun_ajaran_has_iuran.id')
            ->join('petugas', 'log_pembayaran.id_petugas', '=', 'petugas.id_petugas')
            ->join('mahasiswa', 'pembayaran.nim', '=', 'mahasiswa.nim')
            ->orderBy('log_pembayaran.created_at', 'DESC')
            ->where('tahun_ajaran_has_iuran.tahun_ajaran_id', TahunAjaran::findActivedTahunAjaran()->id)
            ->get();

        $pdf = PDF::loadview('admin.pages.histori-pembayaran.cetak-pembayaran', ['pembayarans' => $pembayarans]);
        return $pdf->stream('laporan-histori-pembayaran.pdf');
    }

    public function showKuitansi($id)
    {
        $pembayaran = LogPembayaran::join('pembayaran', 'log_pembayaran.id_pembayaran', '=', 'pembayaran.id_pembayaran')
            ->join('tahun_ajaran_has_iuran', 'pembayaran.tahun_ajaran_has_iuran_id', '=', 'tahun_ajaran_has_iuran.id')
            ->join('petugas', 'log_pembayaran.id_petugas', '=', 'petugas.id_petugas')
            ->join('mahasiswa', 'pembayaran.nim', '=', 'mahasiswa.nim')
            ->join('organisasi', 'mahasiswa.id_organisasi', '=', 'organisasi.id_organisasi')
            ->where('id_log_pembayaran', '=', $id)
            ->first();

        $data = [
            'pembayaran'    => $pembayaran,
            'terbilang'     => $this->toRupiah($pembayaran->jumlah_bayar . ',0', 0)
        ];

        $pdf = PDF::loadview('admin.pages.histori-pembayaran.kuitansi', $data);
        return $pdf->stream('kuitansi.pdf');
    }

    private function toRupiah($angka, $debug)
    {
        $angka = str_replace('.', ',', $angka);
        $terbilang = '';
        list($angka, $desimal) = explode(',', $angka);
        $panjang = strlen($angka);
        for ($b = 0; $b < $panjang; $b++) {
            $myindex = $panjang - $b - 1;
            $a_bil[$b] = substr($angka, $myindex, 1);
        }
        if ($panjang > 9) {
            $bil = $a_bil[9];
            if ($panjang > 10) {
                $bil = $a_bil[10] . $bil;
            }

            if ($panjang > 11) {
                $bil = $a_bil[11] . $bil;
            }
            if ($bil != '' && $bil != '000') {
                $terbilang .= $this->rp_satuan($bil, $debug) . ' milyar';
            }
        }

        if ($panjang > 6) {
            $bil = $a_bil[6];
            if ($panjang > 7) {
                $bil = $a_bil[7] . $bil;
            }

            if ($panjang > 8) {
                $bil = $a_bil[8] . $bil;
            }
            if ($bil != '' && $bil != '000') {
                $terbilang .= $this->rp_satuan($bil, $debug) . ' juta';
            }
        }

        if ($panjang > 3) {
            $bil = $a_bil[3];
            if ($panjang > 4) {
                $bil = $a_bil[4] . $bil;
            }

            if ($panjang > 5) {
                $bil = $a_bil[5] . $bil;
            }
            if ($bil != '' && $bil != '000') {
                $terbilang .= $this->rp_satuan($bil, $debug) . ' ribu';
            }
        }

        $bil = $a_bil[0];
        if ($panjang > 1) {
            $bil = $a_bil[1] . $bil;
        }

        if ($panjang > 2) {
            $bil = $a_bil[2] . $bil;
        }
        //die($bil);
        if ($bil != '' && $bil != '000') {
            $terbilang .= $this->rp_satuan($bil, $debug);
        }
        return trim($terbilang);
    }

    private function rp_satuan($angka, $debug)
    {
        $a_str['1'] = 'Satu';
        $a_str['2'] = 'Dua';
        $a_str['3'] = 'Tiga';
        $a_str['4'] = 'Empat';
        $a_str['5'] = 'Lima';
        $a_str['6'] = 'Enam';
        $a_str['7'] = 'Tujuh';
        $a_str['8'] = 'Delapan';
        $a_str['9'] = 'Sembilan';

        $terbilang = '';

        $panjang = strlen($angka);
        for ($b = 0; $b < $panjang; $b++) {
            $a_bil[$b] = substr($angka, $panjang - $b - 1, 1);
        }

        if ($panjang > 2) {
            if ($a_bil[2] == '1') {
                $terbilang = ' Seratus';
            } else if ($a_bil[2] != '0') {
                $terbilang = ' ' . $a_str[$a_bil[2]] . ' ratus';
            }
        }

        if ($panjang > 1) {
            if ($a_bil[1] == '1') {
                if ($a_bil[0] == '0') {
                    $terbilang .= ' Sepuluh';
                } else if ($a_bil[0] == '1') {
                    $terbilang .= ' Sebelas';
                } else {
                    $terbilang .= ' ' . $a_str[$a_bil[0]] . ' belas';
                }
                return $terbilang;
            } else if ($a_bil[1] != '0') {
                $terbilang .= ' ' . $a_str[$a_bil[1]] . ' puluh';
            }
        }

        if ($a_bil[0] != '0') {
            $terbilang .= ' ' . $a_str[$a_bil[0]];
        }
        return $terbilang;
    }
}
