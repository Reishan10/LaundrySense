<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu leftside-menu-detached">

    <div class="leftbar-user">
        <a href="javascript: void(0);">
            <img src="{{ asset('assets') }}/images/avatar.png" alt="user-image" height="42"
                class="rounded-circle shadow-sm">
            <span class="leftbar-user-name">{{ auth()->user()->name }}</span>
        </a>
    </div>

    <!--- Sidemenu -->
    <ul class="side-nav">

        <li class="side-nav-title side-nav-item">Menu</li>

        <li class="side-nav-item">
            <a href="{{ route('beranda.index') }}" class="side-nav-link">
                <i class="uil-home-alt"></i>
                <span> Beranda </span>
            </a>
        </li>

        <li class="side-nav-item">
            <a href="{{ route('pelanggan.index') }}" class="side-nav-link">
                <i class="uil-users-alt"></i>
                <span> Pelanggan </span>
            </a>
        </li>

        <li class="side-nav-item">
            <a href="{{ route('transaksi.index') }}" class="side-nav-link">
                <i class="uil-shopping-cart-alt"></i>
                <span> Transaksi </span>
            </a>
        </li>

        <li class="side-nav-item">
            <a href="{{ route('laporan.index') }}" class="side-nav-link">
                <i class="uil-file"></i>
                <span> Laporan </span>
            </a>
        </li>

        <li class="side-nav-item">
            <a data-bs-toggle="collapse" href="#sidebarEcommerce" aria-expanded="false" aria-controls="sidebarEcommerce"
                class="side-nav-link">
                <i class="mdi mdi-account-edit"></i>
                <span> Pengaturan </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="sidebarEcommerce">
                <ul class="side-nav-second-level">
                    <li>
                        <a href="{{ route('ganti-password.index') }}">Ganti Password</a>
                    </li>
                    <li>
                        <a href="{{ route('jenisPakaian.index') }}">Jenis Pakaian</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="side-nav-item">
            <a href="{{ route('logout') }}" class="side-nav-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="mdi mdi-logout me-1"></i>
                <span> Keluar </span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>

    <!-- End Sidebar -->

    <div class="clearfix"></div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
