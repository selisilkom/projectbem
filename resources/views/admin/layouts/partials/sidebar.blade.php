<?php
use App\Models\Organisasi;
use App\Models\TahunAjaran;

$sidebarOrganisasis = Organisasi::where('tahun_ajaran_id', TahunAjaran::findActivedTahunAjaran()->id)
    ->orderBy('nama_organisasi', 'ASC')
    ->get();

?>
<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/app-admin') }}">Aplikasi Iuran</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/app-admin') }}">Iuran</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>

            <li class="{{ $sidebar == 'dashboard' ? 'active' : '' }}"><a class="nav-link" href="{{ url('/app-admin') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>

            @if (Auth::guard('petugas')->check())
                @if (Auth::guard('petugas')->user()->level == 'admin')
                    <li class="{{ $sidebar == 'kelas' ? 'active' : '' }}"><a class="nav-link" href="{{ url('/app-admin/organisasi') }}"><i class="fas fa-school"></i>
                            <span>Kelas</span></a></li>
                    <li class="{{ $sidebar == 'iuran' ? 'active' : '' }}"><a class="nav-link" href="{{ url('/app-admin/iuran') }}"><i class="fas fa-money-bill"></i>
                            <span>Iuran</span></a>
                    </li>
                @endif

                <li class="{{ $sidebar == 'petugas' ? 'active' : '' }}"><a class="nav-link" href="{{ url('/app-admin/petugas') }}"><i class="fas fa-user"></i> <span>Petugas</span></a>
                </li>
            @endif
            @if (Auth::guard('mahasiswa')->check())
                <li class="{{ $title == 'Lihat Iuran' ? 'active' : '' }}"><a class="nav-link" href="{{ url('/app-admin/mahasiswa/' . encrypt(Auth::guard('mahasiswa')->user()->nim) . '/lihat-iuran') }}"><i class="fas fa-money-bill"></i> <span>Lihat Iuran</span></a></li>
            @endif
            <li class="{{ $sidebar == 'histori-pembayaran' ? 'active' : '' }}"><a class="nav-link" href="{{ Auth::guard('petugas')->check() ? url('/app-admin/histori-pembayaran') : url('/app-admin/histori-pembayaran/mahasiswa/' . Auth::guard('mahasiswa')->user()->nim) }}"><i class="fas fa-laptop-code"></i> <span>Histori Pembayaran</span></a></li>
            @if (Auth::guard('petugas')->check())
                <li class="{{ $sidebar == 'mahasiswa' ? 'active' : '' }} nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-graduation-cap"></i><span>Mahasiswa</span></a>
                    <ul class="dropdown-menu">
                        @foreach ($sidebarOrganisasis as $sidebarOrganisasi)
                            <li><a class="nav-link" href="{{ url('/app-admin/mahasiswa/organisasi/' . encrypt($sidebarOrganisasi->id_organisasi)) }}">{{ $sidebarOrganisasi->nama_organisasi }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            <li class="{{ $sidebar == 'pengeluaran' ? 'active' : '' }}"><a class="nav-link" href="{{ url('/app-admin/pengeluaran') }}"><i class="fas fa-shopping-cart"></i>
                    <span>Pengeluaran</span></a></li>
            @if (Auth::guard('petugas')->check())
                <li class="{{ $sidebar == 'tahun-ajaran' ? 'active' : '' }}"><a class="nav-link" href="{{ url('/app-admin/tahun-ajaran') }}"><i class="fas fa-calendar"></i>
                        <span>Tahun Ajaran</span></a></li>
            @endif
        </ul>
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="#" class="btn btn-danger btn-lg btn-block btn-icon-split" onclick="logoutAction()">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>
</div>
