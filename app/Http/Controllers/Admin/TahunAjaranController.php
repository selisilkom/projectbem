<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use App\Models\TahunAjaranHasIuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TahunAjaranController extends Controller
{
    public function __construct()
    {
        //dd(Auth::guard('petugas')->user());
        // if (!Auth::guard('petugas')->check()) {
        //   return abort(403);
        //}
    }

    public function index()
    {
        if (!Auth::guard('petugas')->check()) {
            return abort(403);
        }

        $data = [
            'title' => 'Tahun Ajaran',
            'sidebar' => 'tahun-ajaran',
            'rows_tahun' => TahunAjaran::orderBy('is_active', 'DESC')->orderBy('start_year', 'DESC')->paginate(10)
        ];

        return view('admin.pages.tahun-ajaran.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Tahun Ajaran',
            'sidebar' => 'tahun-ajaran',
        ];

        return view('admin.pages.tahun-ajaran.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_year'     => 'required|unique:tahun_ajaran,start_year|numeric|min:1000,max:9999|lt:' . $request->end_year,
            'end_year'       => 'required|numeric|min:1000,max:9999|gt:' . $request->start_year,
        ], [
            'nominal.required'          => 'Nominal tidak boleh kosong',
            'start_year.numeric'     => 'Tahun awal harus bersifat angka',
            'start_year.min'         => 'Tahun awal minimal 1000',
            'start_year.max'         => 'Tahun awal maksimal 9999',
            'start_year.lt'          => 'Tahun awal harus kurang dari tahun akhir',
            'start_year.required'    => 'Tahun awal tidak boleh kosong',
            'end_year.required'      => 'Tahun akhir tidak boleh kosong',
            'end_year.numeric'       => 'Tahun akhir harus bersifat angka',
            'end_year.min'           => 'Tahun akhir minimal 1000',
            'end_year.max'           => 'Tahun akhir maksimal 9999',
            'end_year.gt'            => 'Tahun akhir harus lebih dari tahun awal',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }

        $tahunAjaran = TahunAjaran::create([
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'is_active' => TahunAjaran::where('is_active', true)->count() > 0 ? false : true
        ]);

        TahunAjaranHasIuran::create([
            'tahun_ajaran_id' => $tahunAjaran->id,
            'semester' => 'UAS',
            'nominal' => 50000,
        ]);

        return redirect('app-admin/tahun-ajaran')->with('success', 'Tahun ajaran telah ditambahkan');
    }

    public function edit($tahunAjaranId)
    {
        $data = [
            'title' => 'Edit Tahun Ajaran',
            'sidebar' => 'tahun-ajaran',
            'tahunAjaran' => TahunAjaran::find(decrypt($tahunAjaranId))
        ];

        return view('admin.pages.tahun-ajaran.edit', $data);
    }

    public function update(Request $request, $encId)
    {
        $validator = Validator::make($request->all(), [
            'start_year'     => 'required|unique:tahun_ajaran,start_year,' . decrypt($encId) . '|numeric|min:1000,max:9999|lt:' . $request->end_year,
            'end_year'       => 'required|numeric|min:1000,max:9999|gt:' . $request->start_year,
        ], [
            'nominal.required'          => 'Nominal tidak boleh kosong',
            'start_year.numeric'     => 'Tahun awal harus bersifat angka',
            'start_year.min'         => 'Tahun awal minimal 1000',
            'start_year.max'         => 'Tahun awal maksimal 9999',
            'start_year.lt'          => 'Tahun awal harus kurang dari tahun akhir',
            'start_year.required'    => 'Tahun awal tidak boleh kosong',
            'end_year.required'      => 'Tahun akhir tidak boleh kosong',
            'end_year.numeric'       => 'Tahun akhir harus bersifat angka',
            'end_year.min'           => 'Tahun akhir minimal 1000',
            'end_year.max'           => 'Tahun akhir maksimal 9999',
            'end_year.gt'            => 'Tahun akhir harus lebih dari tahun awal',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }

        $tahunAjaran = TahunAjaran::find(decrypt($encId));

        $tahunAjaran->update([
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
        ]);

        return redirect('app-admin/tahun-ajaran')->with('success', 'Tahun ajaran telah diupdate');
    }

    public function destroy($encId)
    {
        $tahunAjaran = TahunAjaran::find(decrypt($encId));

        if ($tahunAjaran->is_active) {
            return back()->with('failed', 'Tahun ajaran masih aktif, tidak dapat dihapus');
        }

        TahunAjaranHasIuran::where('tahun_ajaran_id', $tahunAjaran->id)->delete();

        $tahunAjaran->delete();

        return back()->with('success', 'Tahun ajaran telah dihapus');
    }

    public function setActive($encId)
    {
        $tahunAjaran = TahunAjaran::find(decrypt($encId));

        DB::statement("UPDATE tahun_ajaran SET is_active = false WHERE is_active = true");
        $tahunAjaran->update([
            'is_active' => true
        ]);

        return back()->with('success', 'Tahun ajaran telah diaktifkan');
    }
}
