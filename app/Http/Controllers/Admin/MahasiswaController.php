<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SendEmailHelper;
use App\Http\Controllers\Controller;
use App\FormatImports\GenerateMahasiswaFormat;
use App\Http\Requests\ImportMahasiswaRequest;
use App\Imports\MahasiswaImport;
use App\Models\Iuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;

use App\Models\Pembayaran;
use App\Models\LogPembayaran;
use App\Models\Mahasiswa;
use App\Models\Organisasi;
use App\Models\TahunAjaran;
use App\Models\TahunAjaranHasIuran;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_organisasi)
    {
        try {
            $data = [
                'title'          => 'Mahasiswa',
                'sidebar'        => 'mahasiswa',
                'organisasi'     => Organisasi::find(decrypt($id_organisasi)),
                'rows_mahasiswa' => Mahasiswa::where('id_organisasi', decrypt($id_organisasi))->orderBy('nama', 'ASC')->get(),
            ];

            return view('admin.pages.mahasiswa.index', $data);
        } catch (DecryptException $th) {
            return abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_organisasi)
    {
        try {
            $data = [
                'title'             => 'Tambah Mahasiswa',
                'sidebar'           => 'organisasi',
                'jenis_kelamins'    => ['Laki-laki', 'Perempuan'],
                'organisasi'        => Organisasi::find(decrypt($id_organisasi)),
            ];

            return view('admin.pages.mahasiswa.create', $data);
        } catch (DecryptException $th) {
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
                'nim'           => 'required|string|max:20',
                'nama'          => 'required|string|max:50',
                'email'         => 'required|email|max:50',
                'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
                'no_telp'       => 'required|string|max:16',
                'alamat'        => 'required',
                'photo'         => 'mimes:jpg,jpeg,png,svg,bmp|nullable'
            ], [
                'nim.required'           => 'NIM tidak boleh kosong',
                'nim.string'             => 'NIM harus bersifat text',
                'nim.max'                => 'NIM maksimal 20 karakter',
                'nama.required'          => 'Nama tidak boleh kosong',
                'nama.string'            => 'Nama harus bersifat karakter',
                'nama.max'               => 'Nama maksimal 50 karakter',
                'email.required'         => 'Email tidak boleh kosong',
                'email.string'           => 'Email harus bersifat karakter',
                'email.max'              => 'Email maksimal 50 karakter',
                'email.email'            => 'Email tidak valid',
                'no_telp.required'       => 'No Telp tidak boleh kosong',
                'no_telp.string'         => 'No Telp harus bersifat karakter',
                'no_telp.max'            => 'No Telp tidak maksimal 16 karakter',
                'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong',
                'jenis_kelamin.string'   => 'Jenis kelamin harus bersifat karakter',
                'jenis_kelamin.in'       => 'Jenis kelamin tidak valid',
                'alamat.required'        => 'Alamat tidak boleh kosong',
                'photo.mimes'            => 'Format foto harus diantara jpg, jpeg, png, svg dan bmp'
            ]);


            if ($validator->fails()) {
                return back()->withErrors($validator)
                    ->withInput();
            }

            if (Mahasiswa::where('nim', '=', $request->nim)->exists()) {
                return back()->withInput()
                    ->with('failed', 'NIM sudah digunakan');
            }

            if (Mahasiswa::where('email', '=', $request->Email)->exists()) {
                return back()->withInput()
                    ->with('failed', 'Email sudah digunakan');
            }

            $photo = $request->file('photo') ? '' : null;

            if ($request->file('photo')) {
                $photo = $this->uploadFile('images/mahasiswa', $request->file('photo'), $request->nama);
            }

            Mahasiswa::create([
                'nim'           => $request->nim,
                'email'          => $request->email,
                'nama'          => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_telp'       => $request->no_telp,
                'alamat'        => $request->alamat,
                'photo'         => $photo,
                'id_organisasi' => decrypt($request->id_organisasi),
            ]);

            return redirect('/app-admin/mahasiswa/organisasi/' . $request->id_organisasi)->with('success', 'Mahasiswa ' . $request->nama . ' telah ditambahkan');
        } catch (DecryptException $th) {
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
        $mahasiswa = Mahasiswa::find(decrypt($id));
        try {
            $data = [
                'title'             => 'Edit Mahasiswa',
                'sidebar'           => 'organisasi',
                'jenis_kelamins'    => ['Laki-laki', 'Perempuan'],
                'organisasi'        => Organisasi::where('id_organisasi', '=', $mahasiswa->id_organisasi)->first(),
                'mahasiswa'         => $mahasiswa,
            ];

            return view('admin.pages.mahasiswa.edit', $data);
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
                'nim'           => 'required|string|max:20',
                'nama'          => 'required|string|max:50',
                'email'         => 'required|email:dns|max:50',
                'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
                'no_telp'       => 'required|string|max:16',
                'photo'         => 'mimes:jpg,jpeg,png,svg,bmp'
            ], [
                'nim.required'           => 'NIM tidak boleh kosong',
                'nim.string'             => 'NIM harus bersifat text',
                'nim.max'                => 'NIM maksimal 20 karakter',
                'nama.required'          => 'Nama tidak boleh kosong',
                'nama.string'            => 'Nama harus bersifat karakter',
                'nama.max'               => 'Nama maksimal 50 karakter',
                'email.required'         => 'Email tidak boleh kosong',
                'email.string'           => 'Email harus bersifat karakter',
                'email.max'              => 'Email maksimal 50 karakter',
                'email.email'            => 'Email tidak valid',
                'no_telp.required'       => 'No telp tidak boleh kosong',
                'no_telp.string'         => 'No telp harus bersifat karakter',
                'no_telp.max'            => 'No telp tidak maksimal 16 karakter',
                'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong',
                'jenis_kelamin.string'   => 'Jenis kelamin harus bersifat karakter',
                'jenis_kelamin.in'       => 'Jenis kelamin tidak valid',
                'alamat.required'        => 'Alamat tidak boleh kosong',
                'photo.mimes'            => 'Format foto harus diantara jpg, jpeg, png, svg dan bmp'
            ]);


            if ($validator->fails()) {
                return back()->withErrors($validator)
                    ->withInput();
            }

//            if (strlen($request->nim) > 10) {
  //              return back()->withInput()
    //                ->with('failed', 'NIM maksimal sepuluh karakter');
      //      }

            $mahasiswa = Mahasiswa::find(decrypt($id));

            if (Mahasiswa::where('nim', '=', $request->nim)->exists() && $request->nim != $mahasiswa->nim) {
                return back()->withInput()
                    ->with('failed', 'NIM sudah digunakan');
            }

            if (Mahasiswa::where('email', '=', $request->email)->exists() && $request->email != $mahasiswa->email) {
                return back()->withInput()
                    ->with('failed', 'Email sudah digunakan');
            }

            $photo = $request->file('photo') ? '' : $mahasiswa->photo;

            if ($request->file('photo')) {
                $this->deleteFile('images/mahasiswa' . $mahasiswa->photo);
                $photo = $this->uploadFile('images/mahasiswa', $request->file('photo'), $request->mahasiswa);
            }

            $mahasiswa->update([
                'nim'          => $request->nim,
                'nama'          => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_telp'       => $request->no_telp,
                'alamat'        => $request->alamat,
                'photo'         => $photo,
                'id_organisasi' => decrypt($request->id_organisasi),
            ]);

            return redirect('/app-admin/mahasiswa/organisasi/' . encrypt($mahasiswa->id_organisasi))->with('success', 'Mahasiswa ' . $request->nama . ' telah diupdate');
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
                $mahasiswa = Mahasiswa::find(decrypt($id));

                if (Mahasiswa::destroy($mahasiswa->nim)) {
                    return back()->with('success', 'Mahasiswa ' . $mahasiswa->nama . ' telah dihapus');
                }
            } catch (\Throwable $th) {
                return back()->with('failed', 'Mahasiswa ' . $mahasiswa->nama . ' gagal dihapus karena memiliki relasi');
            }
            return back()->with('failed', 'Mahasiswa ' . $mahasiswa->nama . ' gagal dihapus');
        } catch (DecryptException $th) {
            return abort(404);
        }
    }

    public function getSemesters()
    {
        return TahunAjaranHasIuran::where('tahun_ajaran_id', TahunAjaran::findActivedTahunAjaran()->id)->get();
    }

    public function lihatIuran($nim)
    {
        try {
            $tahunAjaran = TahunAjaran::findActivedTahunAjaran();
            $mahasiswa = Mahasiswa::find(decrypt($nim));
            $semesters = $this->getSemesters();

            $all_iuran_payments = [];

            foreach ($semesters as $key => $semester) {
                $pembayaran = Pembayaran::where('tahun_ajaran_has_iuran_id', '=', $semester->id)->where('nim', '=', $mahasiswa->nim)->where('tahun_ajaran_id', '=', $tahunAjaran->id);

                $semester['status'] = $pembayaran->exists() ? $pembayaran->get()[0]->status : 'Belum Bayar';
                $semester['total_bayar'] = $pembayaran->exists() ? $pembayaran->get()[0]->total_bayar : 0;
                $semester['link_add_pembayaran']          = $pembayaran->exists() ? url('/app-admin/mahasiswa/' . encrypt($mahasiswa->nim) . '/bayar/' . encrypt($semester->id) . '/' . $semester->semester . '/' . $pembayaran->get()[0]->id_pembayaran) : url('/app-admin/mahasiswa/' . encrypt($mahasiswa->nim) . '/bayar/' . encrypt($tahunAjaran->id) . '/' . $semester->semester . '/create');
                $semester['link_send_email_notification'] = url('/app-admin/mahasiswa/' . encrypt($mahasiswa->nim) . '/bayar/' . encrypt($tahunAjaran->id) . '/' . $semester->id . '/email-notification');
                $semester['id_pembayaran']                = $pembayaran->exists() ? $pembayaran->get()[0]->id_pembayaran : '';
                $semester['kekurangan']                   = $pembayaran->exists() ? $semester->nominal - $pembayaran->get()[0]->total_bayar : 0;

                $all_iuran_payments[] = $semester;
            }

            $data = [
                'title'              => 'Lihat Iuran',
                'sidebar'            => 'mahasiswa',
                'mahasiswa'          => $mahasiswa,
                'all_iuran_payments' => $all_iuran_payments,
                'midtransLocalKey' => config('app.midtrans_client_key'),
                'appEnv' => config('app.env')
            ];

            return view('admin.pages.mahasiswa.lihat-iuran', $data);
        } catch (DecryptException $th) {
            return abort(404);
        }
    }

    public function createPembayaranIuran($nim, $id_iuran, $semester)
    {
        try {
            $data = [
                'title'     => 'Create Iuran Mahasiswa',
                'sidebar'   => 'mahasiswa',
                'mahasiswa' => Mahasiswa::find(decrypt($nim)),
                'iuran'     => TahunAjaranHasIuran::find(decrypt($id_iuran)),
                'semester'  => $semester,
            ];

            return view('admin.pages.mahasiswa.create-iuran', $data);
        } catch (DecryptException $th) {
            return abort(404);
        }
    }

    public function storePembayaranIuran(Request $request, $nim, $id_iuran, $semester)
    {
        try {
            $validator = Validator::make($request->all(), [
                'jumlah_bayar'          => 'required',
            ], [
                'jumlah_bayar.required' => 'Jumlah bayar tidak boleh kosong',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)
                    ->withInput();
            }

            if (!in_array($semester, $this->getSemesters()->pluck('id')->toArray())) {
                return back()->withInput()
                    ->with('failed', 'Semester Iuran tidak valid');
            }

            $tahunAjaranIuran        = TahunAjaranHasIuran::find(decrypt($id_iuran));
            $jumlah_bayar = $this->parsingRupiahToInteger($request->jumlah_bayar);

            if ($jumlah_bayar > $tahunAjaranIuran->nominal) {
                return back()->withInput()
                    ->with('failed', 'Jumlah bayar tidak boleh melebihi biaya Iuran');
            }

            $id_pembayaran = (string) rand();
            while ($id_pembayaran[0] == 0) {
                $id_pembayaran = rand();
            }

            Pembayaran::create([
                'id_pembayaran'  => $id_pembayaran,
                'nim'            => $nim,
                'tahun_ajaran_id' => TahunAjaran::findActivedTahunAjaran()->id,
                'tahun_ajaran_has_iuran_id'       => $tahunAjaranIuran->id,
                'total_bayar'    => $jumlah_bayar >= $tahunAjaranIuran->nominal ? $tahunAjaranIuran->nominal : $jumlah_bayar,
                'status'         => $jumlah_bayar >= $tahunAjaranIuran->nominal ? 'Lunas' : 'Belum Lunas',
            ]);

            $id_log_pembayaran = (string) rand();
            while ($id_log_pembayaran[0] == 0) {
                $id_log_pembayaran = rand();
            }

            LogPembayaran::create([
                'id_log_pembayaran' => $id_log_pembayaran,
                'id_pembayaran'     => $id_pembayaran,
                'id_petugas'        => Auth::guard('petugas')->user()->id_petugas,
                'tgl_bayar'         => date('Y-m-d'),
                'jumlah_bayar'      => $jumlah_bayar,
            ]);

            return redirect('/app-admin/mahasiswa/' . encrypt($nim) . '/lihat-iuran')->with('success', 'Pembayaran telah ditambakan');
        } catch (DecryptException $th) {
            return abort(404);
        }
    }

    public function editPembayaranIuran(Request $request, $nim, $id_iuran, $semester, $id_pembayaran)
    {
        try {
            $data = [
                'title'      => 'Buat Pembayaran Iuran Mahasiswa',
                'sidebar'    => 'mahasiswa',
                'mahasiswa'  => Mahasiswa::find(decrypt($nim)),
                'iuran'      => TahunAjaranHasIuran::find(decrypt($id_iuran)),
                'pembayaran' => Pembayaran::find($id_pembayaran),
                'kekurangan' => $request->kekurangan,
                'semester'   => $semester,
            ];

            return view('admin.pages.mahasiswa.edit-iuran', $data);
        } catch (DecryptException $th) {
            return abort(404);
        }
    }

    public function UpdatePembayaranIuran(Request $request, $nim, $id_iuran, $semester, $id_pembayaran)
    {
        try {
            $validator = Validator::make($request->all(), [
                'jumlah_bayar'          => 'required',
            ], [
                'jumlah_bayar.required' => 'Jumlah bayar tidak boleh kosong',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)
                    ->withInput();
            }

            if (!in_array(
                decrypt($id_iuran),
                $this->getSemesters()->pluck('id')->toArray()
            )) {
                return back()->withInput()
                    ->with('failed', 'Semester Iuran tidak valid');
            }

            $tahunAjaranIuran        = TahunAjaranHasIuran::find(decrypt($id_iuran));

            $pembayaran   = Pembayaran::find($id_pembayaran);
            $jumlah_bayar = $this->parsingRupiahToInteger($request->jumlah_bayar);

            if ($jumlah_bayar > $tahunAjaranIuran->nominal - $pembayaran->total_bayar) {
                return back()->withInput()
                    ->with('failed', 'Jumlah bayar tidak boleh melebihi biaya Iuran');
            }

            $pembayaran->update([
                'total_bayar'   => $jumlah_bayar + $pembayaran->total_bayar >= $tahunAjaranIuran->nominal ? $tahunAjaranIuran->nominal : $jumlah_bayar + $pembayaran->total_bayar,
                'status'        => $jumlah_bayar + $pembayaran->total_bayar >= $tahunAjaranIuran->nominal ? 'Lunas' : 'Belum Lunas',
            ]);

            $id_log_pembayaran = (string) rand();

            while ($id_log_pembayaran[0] == 0) {
                $id_log_pembayaran = rand();
            }

            LogPembayaran::create([
                'id_log_pembayaran' => $id_log_pembayaran,
                'id_pembayaran'     => $id_pembayaran,
                'id_petugas'        => Auth::guard('petugas')->user()->id_petugas,
                'tgl_bayar'         => date('Y-m-d'),
                'jumlah_bayar'      => $jumlah_bayar,
            ]);

            return redirect('/app-admin/mahasiswa/' . encrypt($nim) . '/lihat-iuran')->with('success', 'Pembayaran telah ditambakan');
        } catch (DecryptException $th) {
            return abort(404);
        }
    }

    public function emailNotification(Request $request, $nim, $id_iuran, $semester)
    {
        try {

            $nim = decrypt($nim);
            $mahasiswa = DB::select('SELECT mahasiswa.*, organisasi.nama_organisasi
                                    FROM mahasiswa
                                    LEFT JOIN organisasi ON mahasiswa.id_organisasi = organisasi.id_organisasi
                                    WHERE mahasiswa.nim = ' . $nim);
            $mahasiswa = array_shift($mahasiswa);
            $tahunAjaranIuran     = TahunAjaranHasIuran::find(decrypt($id_iuran));
            $kekurangan = $request->kekurangan;

            if ($kekurangan == 0) {
                SendEmailHelper::sendEmail($mahasiswa, $tahunAjaranIuran->nominal, $tahunAjaranIuran->semester, TahunAjaran::findActivedTahunAjaran());
            } else {
                SendEmailHelper::sendEmail($mahasiswa, $kekurangan, $tahunAjaranIuran->semester, TahunAjaran::findActivedTahunAjaran());
            }

            return redirect('/app-admin/mahasiswa/' . encrypt($nim) . '/lihat-iuran')->with('success', 'Email notifikasi telah terkirim');
        } catch (DecryptException $th) {
            return abort(404);
        }
    }

    public function formatImport()
    {
        $date = date('d-m-Y');
        $nameFile = 'import_mahasiswa' . $date;
        return Excel::download(new GenerateMahasiswaFormat(), $nameFile . '.xlsx');
    }

    public function import(ImportMahasiswaRequest $request)
    {
        Excel::import(new MahasiswaImport, $request->file('import_mahasiswa'));

        return back()->with('success', 'Mahasiswa Telah ditambahkan');
    }
}
