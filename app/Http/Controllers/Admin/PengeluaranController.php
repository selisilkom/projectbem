<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pengeluaran;
use App\Models\TahunAjaran;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title'                 => 'Pengeluaran',
            'sidebar'               => 'pengeluaran',
            'rows_pengeluaran'      => Pengeluaran::where('tahun_ajaran_id', TahunAjaran::findActivedTahunAjaran()->id)->orderBy('nama_pengeluaran', 'ASC')->simplePaginate(10)
        ];

        return view('admin.pages.pengeluaran.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::guard('petugas')->check()) {
            return abort(403);
        }

        $data = [
            'title'         => 'Tambah Pengeluaran',
            'sidebar'       => 'pengeluaran',
            'levels'        => ['admin', 'pengeluaran'],
        ];

        return view('admin.pages.pengeluaran.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jumlah = $this->parsingRupiahToInteger($request->jumlah);

        $validator = Validator::make($request->all(), [
            'nama_pengeluaran' => 'required|string',
            'jumlah'           => 'required',
            'deskripsi'        => 'required|string',
            'pdf_file'        => 'required|mimes:pdf',
        ], [
            'nama_pengeluaran.required' => 'Nama pengeluaran tidak boleh kosong',
            'nama_pengeluaran.string'   => 'Nama pengeluaran harus bersifat text',
            'jumlah.required'           => 'Jumlah tidak boleh kosong',
            'deskripsi.required'        => 'Deskripsi tidak boleh kosong',
            'deskripsi.string'          => 'Deskripsi harus bersifat karakter',
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }

        if (Pengeluaran::where('nama_pengeluaran', '=', $request->nama_pengeluaran)->exists()) {
            return back()->withInput()
                ->with('failed', 'Nama Pengeluaran sudah digunakan');
        }

        $jml_dana_pembayaran = Pembayaran::sum('total_bayar');

        if ($jumlah > $jml_dana_pembayaran) {
            return back()->withInput()
                ->with('failed', 'Jumlah Pengeluaran tidak boleh melebihi Jumlah Dana Iuran');
        }


        Pengeluaran::create([
            'nama_pengeluaran' => $request->nama_pengeluaran,
            'jumlah'           => $jumlah,
            'deskripsi'         => $request->deskripsi,
            'tahun_ajaran_id' => TahunAjaran::findActivedTahunAjaran()->id,
            'pdf_file' => $this->uploadFile('images/pengeluaran', $request->file('pdf_file'), $request->nama_pengeluaran)
        ]);

        return redirect('/app-admin/pengeluaran')->with('success', 'Pengeluaran ' . $request->nama_pengeluaran . ' telah ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            try {
                $pengeluaran = Pengeluaran::find(decrypt($id));

                if (Pengeluaran::destroy($pengeluaran->id_pengeluaran)) {
                    return back()->with('success', 'Pengeluaran ' . $pengeluaran->nama_pengeluaran . ' telah dihapus');
                }
            } catch (\Throwable $th) {
                return back()->with('failed', 'Pengeluaran ' . $pengeluaran->nama_pengeluaran . ' gagal dihapus karena memiliki relasi');
            }
            return back()->with('failed', 'Pengeluaran ' . $pengeluaran->nama_pengeluaran . ' gagal dihapus');
        } catch (DecryptException $th) {
            return abort(404);
        }
    }
}
