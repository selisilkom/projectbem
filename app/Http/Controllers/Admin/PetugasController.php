<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\Petugas;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title'                 => 'Petugas',
            'sidebar'               => 'petugas',
            'rows_petugas'          => Petugas::orderBy('level', 'ASC')->orderBy('nama_petugas', 'ASC')->simplePaginate(10)
        ];

        return view('admin.pages.petugas.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title'         => 'Tambah Petugas',
            'sidebar'       => 'petugas',
            'levels'        => ['admin', 'petugas'],
        ];

        return view('admin.pages.petugas.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'      => 'required|string|max:25',
            'nama_petugas'  => 'required|string|max:50',
            'password'      => 'required|string|min:8|confirmed',
            'level'         => 'required|string|in:admin,petugas',
            'photo'         => 'mimes:jpg,jpeg,png,svg,bmp'
        ], [
            'username.required'     => 'Username tidak boleh kosong',
            'username.string'       => 'Username harus bersifat text',
            'username.max'          => 'Username maksimal 25 karakter',
            'nama_petugas.required' => 'Nama petugas tidak boleh kosong',
            'nama_petugas.string'   => 'Nama petugas harus bersifat karakter',
            'nama_petugas.max'      => 'Nama petugas maksimal 50 karakter',
            'password.required'     => 'Password tidak boleh kosong',
            'password.string'       => 'Password harus bersifat karakter',
            'password.min'          => 'Password tidak minimal 8 karakter',
            'password.confirmed'    => 'Password konfirmasi tidak cocok',
            'level.required'        => 'Level tidak boleh kosong',
            'level.string'          => 'Level harus bersifat karakter',
            'level.in'              => 'Level tidak valid',
            'photo.mimes'           => 'Format file harus diantara jpg, jpeg, png, svg dan bmp'
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }

        if (Petugas::where('username', '=', $request->username)->exists()) {
            return back()->withInput()
                ->with('failed', 'Username sudah digunakan');
        }

        $photo = $request->file('photo') ? '' : null;

        if ($request->file('photo')) {
            $photo = $this->uploadFile('images/petugas', $request->file('photo'), $request->nama_petugas);
        }

        Petugas::create([
            'username'      => $request->username,
            'nama_petugas'  => $request->nama_petugas,
            'password'      => Hash::make($request->password),
            'level'         => $request->level,
            'photo'         => $photo,
        ]);

        return redirect('/app-admin/petugas')->with('success', 'Petugas ' . $request->nama_petugas . ' telah ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
                'title'         => 'Edit Petugas',
                'sidebar'       => 'petugas',
                'levels'        => ['admin', 'petugas'],
                'petugas'       => Petugas::find(decrypt($id)),
            ];

            return view('admin.pages.petugas.edit', $data);
        } catch (DecryptException $th) {
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
                'username'      => 'required|string|max:25',
                'nama_petugas'  => 'required|string|max:50',
                'level'         => 'required|string|in:admin,petugas',
                'photo'         => 'mimes:jpg,jpeg,png,svg,bmp',
                'password'      => 'string|min:8|confirmed|nullable',
            ], [
                'username.required'     => 'Username tidak boleh kosong',
                'username.string'       => 'Username harus bersifat text',
                'username.max'          => 'Username maksimal 25 karakter',
                'nama_petugas.required' => 'Nama petugas tidak boleh kosong',
                'nama_petugas.string'   => 'Nama petugas harus bersifat karakter',
                'nama_petugas.max'      => 'Nama petugas maksimal 50 karakter',
                'level.required'        => 'Level tidak boleh kosong',
                'level.string'          => 'Level harus bersifat karakter',
                'level.in'              => 'Level tidak valid',
                'photo.mimes'           => 'Format file harus diantara jpg, jpeg, png, svg dan bmp',
                'password.string'       => 'Password harus bersifat karakter',
                'password.min'          => 'Password tidak minimal 8 karakter',
                'password.confirmed'    => 'Password konfirmasi tidak cocok',
            ]);


            if ($validator->fails()) {
                return back()->withErrors($validator)
                    ->withInput();
            }

            $petugas = Petugas::find(decrypt($id));

            if (Petugas::where('username', '=', $request->username)->exists() && $request->username != $petugas->username) {
                return back()->withInput()
                    ->with('failed', 'Username sudah digunakan');
            }

            $photo = $request->file('photo') ? '' : $petugas->photo;

            if ($request->file('photo')) {
                $this->deleteFile('images/petugas' . $petugas->photo);
                $photo = $this->uploadFile('images/petugas', $request->file('photo'), $request->nama_petugas);
            }

            if ($request->password) {
                $petugas->update([
                    'username'      => $request->username,
                    'nama_petugas'  => $request->nama_petugas,
                    'level'         => $request->level,
                    'photo'         => $photo,
                    'password'      => Hash::make($request->password),
                ]);
            } else {
                $petugas->update([
                    'username'      => $request->username,
                    'nama_petugas'  => $request->nama_petugas,
                    'level'         => $request->level,
                    'photo'         => $photo,
                ]);
            }

            return redirect('/app-admin/petugas')->with('success', 'Petugas ' . $request->nama_petugas . ' telah diupdate');
        } catch (DecryptException $th) {
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
                $petugas = Petugas::find(decrypt($id));

                if (Petugas::destroy($petugas->id_petugas)) {
                    return back()->with('success', 'Petugas ' . $petugas->nama_petugas . ' telah dihapus');
                }
            } catch (\Throwable $th) {
                return back()->with('failed', 'Petugas ' . $petugas->nama_petugas . ' gagal dihapus karena memiliki relasi');
            }
            return back()->with('failed', 'Petugas ' . $petugas->nama_petugas . ' gagal dihapus');
        } catch (DecryptException $th) {
            return abort(404);
        }
    }
}
