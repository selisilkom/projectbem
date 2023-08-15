<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Petugas;
use App\Models\Pembayaran;
use App\Models\Pengeluaran;
use App\Models\TahunAjaran;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'title'                 => 'Dashboard',
            'sidebar'               => 'dashboard',
            'total_petugas'         => Petugas::count(),
            'jumlah_mahasiswa'      => Mahasiswa::leftJoin('organisasi', 'organisasi.id_organisasi', '=', 'mahasiswa.id_organisasi')->where('tahun_ajaran_id', TahunAjaran::findActivedTahunAjaran()->id)->count(),
            'jml_dana_pembayaran'   => Pembayaran::where('tahun_ajaran_id', TahunAjaran::findActivedTahunAjaran()->id)->sum('total_bayar'),
            'jml_dana_pengeluaran'  => Pengeluaran::where('tahun_ajaran_id', TahunAjaran::findActivedTahunAjaran()->id)->sum('jumlah'),
            'sisa_dana'             => Pembayaran::where('tahun_ajaran_id', TahunAjaran::findActivedTahunAjaran()->id)->sum('total_bayar') - Pengeluaran::sum('jumlah'),
        ];

        return view('admin.pages.home.index', $data);
    }
}
