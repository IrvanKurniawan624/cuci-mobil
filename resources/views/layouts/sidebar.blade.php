<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
    <div class="brand-logo d-flex align-items-center justify-content-between" style="border-bottom: 7px solid #f3f4f5">
        <a href="/" class="text-nowrap w-100">
            <h3 class="fw-semibold m-0 text-center" style="font-family: Poppins,Helvetica,sans-serif; font-size: 1.3rem">CUCI MOBIL APP</h3>
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <   i class="ti ti-x fs-8"></i>
        </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
            @if(!empty(array_intersect(['/dashboard'], Auth::user()->hak_akses)))
            <li class="nav-small-cap" style="margin-top: 15px">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                    <span>
                        <i class="ti ti-layout-dashboard"></i>
                    </span>
                    <span class="hide-menu">Dashboard</span>
                </a>
            </li>
            @endif
            @if(!empty(array_intersect(['master/customer', 'master/karyawan', 'master/jenis-mobil', 'master/presentase'], Auth::user()->hak_akses)))
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Master</span>
            </li>
            @endif
            @if(!empty(array_intersect(['master/customer'], Auth::user()->hak_akses)))
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('master.customer') }}" aria-expanded="false">
                <span>
                    <i class="fas fa-user-tag"></i>
                </span>
                <span class="hide-menu">Customer</span>
                </a>
            </li>
            @endif
            @if(!empty(array_intersect(['master/karyawan'], Auth::user()->hak_akses)))
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('master.karyawan') }}" aria-expanded="false">
                <span>
                    <i class="fas fa-user-cog"></i>
                </span>
                <span class="hide-menu">Karyawan</span>
                </a>
            </li>
            @endif
            @if(!empty(array_intersect(['master/jenis-mobil'], Auth::user()->hak_akses)))
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('master.jenis_mobil') }}" aria-expanded="false">
                <span>
                    <i class="fas fa-car-side"></i>
                </span>
                <span class="hide-menu">Jenis Mobil</span>
                </a>
            </li>
            @endif
            @if(!empty(array_intersect(['master/presentase'], Auth::user()->hak_akses)))
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('master.presentase') }}" aria-expanded="false">
                <span>
                    <i class="fas fa-chart-bar"></i>
                </span>
                <span class="hide-menu">Presentase</span>
                </a>
            </li>
            @endif
            @if(!empty(array_intersect(['master/snack'], Auth::user()->hak_akses)))
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('master.snack') }}" aria-expanded="false">
                <span>
                    <img src="{{ asset("assets\images\icon\snack.png") }}" alt="snack_icon" class="icon-sidebar" style="width: 23px; height: 21px">
                </span>
                <span class="hide-menu">Snack</span>
                </a>
            </li>
            @endif
            @if(!empty(array_intersect(['main/transaksi', 'main/transaksi_snack'], Auth::user()->hak_akses)))
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Utama</span>
            </li>
            @endif
            @if(!empty(array_intersect(['main/transaksi'], Auth::user()->hak_akses)))
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('main.transaksi') }}" aria-expanded="false">
                <span>
                    <i class="ti ti-cash"></i>
                </span>
                <span class="hide-menu">Transaksi</span>
                </a>
            </li>
            @endif
            @if(!empty(array_intersect(['main/transaksi-snack'], Auth::user()->hak_akses)))
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('main.transaksi_snack') }}" aria-expanded="false">
                <span>
                    <img src="{{ asset("assets\images\icon\snack2.png") }}" alt="transaksi_snack_icon" class="icon-sidebar" style="width: 23px; height: 21px">
                </span>
                <span class="hide-menu">Transaksi Snack</span>
                </a>
            </li>
            @endif
            @if(!empty(array_intersect(['laporan/transaksi', 'laporan/keuangan', 'laporan/pendapatan-karyawan'], Auth::user()->hak_akses)))
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Laporan</span>
            </li>
            @endif
            @if(!empty(array_intersect(['laporan/transaksi'], Auth::user()->hak_akses)))
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('laporan.transaksi') }}" aria-expanded="false">
                <span>
                    <i class="fas fa-money-check"></i>
                </span>
                <span class="hide-menu">Laporan Transaksi</span>
                </a>
            </li>
            @endif
            @if(!empty(array_intersect(['laporan/pendapatan-karyawan'], Auth::user()->hak_akses)))
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('laporan.pendapatan_karyawan') }}" aria-expanded="false">
                <span>
                    <i class="fas fa-address-book"></i>
                </span>
                <span class="hide-menu">Pendapatan Karyawan</span>
                </a>
            </li>
            @endif
            @if(!empty(array_intersect(['laporan/keuangan'], Auth::user()->hak_akses)))
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('laporan.keuangan') }}" aria-expanded="false">
                <span>
                    <i class="fas fa-file-invoice-dollar"></i>
                </span>
                <span class="hide-menu">Laporan Keuangan</span>
                </a>
            </li>
            @endif
            @if(!empty(array_intersect(['config/hak-akses'], Auth::user()->hak_akses)))
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Config</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('config.hak_akses') }}" aria-expanded="false">
                <span>
                    <i class="fas fa-cog"></i>
                </span>
                <span class="hide-menu">Hak Akses</span>
                </a>
            </li>
            @endif
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
