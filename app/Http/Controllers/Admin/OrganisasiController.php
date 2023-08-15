<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Organisasi;
use App\Models\TahunAjaran;

class OrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title'                 => 'Kelas',
            'sidebar'               => 'kelas',
            'classes'               => Organisasi::orderBy('nama_organisasi', 'ASC')->where('tahun_ajaran_id', TahunAjaran::findActivedTahunAjaran()->id)->simplePaginate(10)
        ];

        return view('admin.pages.organisasi.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $data = [
                'title'                 => 'Tambah Kelas',
                'sidebar'               => 'kelas',
            ];

            return view('admin.pages.organisasi.create', $data);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_organisasi'    => 'required|string|max:30',
            ], [
                'nama_organisasi.required' => 'Nama kelas tidak boleh kosong',
                'nama_organisasi.string'   => 'Nama kelas harus bersifat text',
                'nama_organisasi.max'      => 'Nama kelas maksimal 30 karakter',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)
                    ->withInput();
            }

            if (Organisasi::where('nama_organisasi', '=', $request->nama_organisasi)->exists()) {
                return back()->withInput()
                    ->with('failed', 'Nama kelas sudah digunakan');
            }

            Organisasi::create([
                'nama_organisasi' => $request->nama_organisasi,
                'tahun_ajaran_id' => TahunAjaran::findActivedTahunAjaran()->id
            ]);

            return redirect('/app-admin/organisasi/')->with('success', 'Kelas ' . $request->nama_organisasi . ' telah ditambahkan');
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = [
                'title'      => 'Edit Kelas',
                'sidebar'    => 'kelas',
                'organisasi' => Organisasi::find(decrypt($id)),
            ];

            return view('admin.pages.organisasi.edit', $data);
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_organisasi'    => 'required|string|max:30',
            ], [
                'nama_organisasi.required' => 'Nama kelas tidak boleh kosong',
                'nama_organisasi.string'   => 'Nama kelas harus bersifat text',
                'nama_organisasi.max'      => 'Nama kelas maksimal 30 karakter',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)
                    ->withInput();
            }

            $organisasi = Organisasi::find(decrypt($id));

            if (Organisasi::where('nama_organisasi', '=', $request->nama_organisasi)->exists() && $request->nama_organisasi != $organisasi->nama_organisasi) {
                return back()->withInput()
                    ->with('failed', 'Nama kelas sudah digunakan');
            }

            $organisasi->update([
                'nama_organisasi' => $request->nama_organisasi,
            ]);

            return redirect('/app-admin/organisasi/')->with('success', 'Kelas ' . $request->nama_organisasi . ' telah diupdate');
        } catch (DecryptException $e) {
            return abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            try {
                $organisasi = Organisasi::find(decrypt($id));

                if (Organisasi::destroy($organisasi->id_organisasi)) {
                    return back()->with('success', 'Kelas ' . $organisasi->nama_organisasi . ' telah dihapus');
                }
            } catch (\Throwable $th) {
                return back()->with('failed', 'Kelas ' . $organisasi->nama_organisasi . ' gagal dihapus karena memiliki relasi');
            }
            return back()->with('failed', 'Kelas ' . $organisasi->nama_organisasi . ' gagal dihapus');
        } catch (DecryptException $e) {
            return back()->with('failed', 'Kelas gagal dihapus');
        }
    }
}
