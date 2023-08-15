<?php

namespace App\Http\Controllers\Auth\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.mahasiswa.login');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('nama', 'nim');
    }

    public function login(Request $request)
    {
        $mahasiswa = Mahasiswa::where('nama', $request->nama)->where('nim', $request->nim)->leftJoin('organisasi', 'organisasi.id_organisasi', '=', 'mahasiswa.id_organisasi')->where('organisasi.tahun_ajaran_id', TahunAjaran::findActivedTahunAjaran()->id)->first();

        if ($mahasiswa != null) {
            if (Auth::guard('mahasiswa')->loginUsingId($mahasiswa->nim)) {
                return redirect('/app-admin');
            }
        }

        return back()->withInput()
            ->with('failed', 'Nama dan NIM tidak cocok');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/app-admin/login');
    }
}
