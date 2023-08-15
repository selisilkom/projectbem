<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encrytion\DecryptException;
use Illuminate\Http\Request;

use App\Models\Iuran;
use App\Models\TahunAjaran;
use App\Models\TahunAjaranHasIuran;
use Illuminate\Contracts\Encryption\DecryptException as EncryptionDecryptException;

class IuranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title'      => 'Iuran',
            'sidebar'    => 'iuran',
            'rows_iuran' => TahunAjaranHasIuran::where('tahun_ajaran_id', TahunAjaran::findActivedTahunAjaran()->id)->orderBy('semester', 'ASC')->get()
        ];

        return view('admin.pages.iuran.index', $data);
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
            $iuran = TahunAjaranHasIuran::find(decrypt($id));
            $data = [
                'title'         => 'Edit Iuran',
                'sidebar'       => 'iuran',
                'iuran'         => $iuran,
            ];

            return view('admin.pages.iuran.edit', $data);
        } catch (EncryptionDecryptException $th) {
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
                'nominal'           => 'required',
            ], [
                'nominal.required'          => 'Nominal tidak boleh kosong',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)
                    ->withInput();
            }

            $iuran = TahunAjaranHasIuran::find(decrypt($id));

            $iuran->update([
                'nominal'           =>  $this->parsingRupiahToInteger($request->nominal),
            ]);

            return redirect('/app-admin/iuran')->with('success', 'Iuran tahun telah diupdate');
        } catch (EncryptionDecryptException $th) {
            return abort(404);
        }
    }
}
