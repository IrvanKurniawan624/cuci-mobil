<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>CUCI MOBIL APP</title>
  <link rel="shortcut icon" type="image/png" href="/assets/images/logos/favicon.png" />

  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/libs/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/izitoast/css/iziToast.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/select2/select2-bootstrap-5-theme.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style-additional.css') }}" />
  @yield('css')
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    @include('layouts.sidebar')
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item">
              @yield('breadcrumb')
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              {{-- <a class="nav-link nav-icon-hover fs-6 position-relative" href="javascript:void(0)">
                <i class="ti ti-bell-ringing"></i>
              </a> --}}
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="{{ asset('assets\images\avatar\avatar-4.png') }}" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">{{ Auth::user()->name }}</p>
                    </a>
                    <a href="{{ route('logout') }}" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
            @yield('content')
      </div>

      @yield('modal')
      <!-- Modal Load-->
      <div class="modal fade" role="dialog" id="modal_loading" role="dialog" data-bs-keyboard="false" data-bs-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body pt-0" style="background-color: rgb(245,247,249); border-radius: 6px;">
              <div class="text-center">
                <img style="border-radius: 4px; height: 140px;" src="{{ asset('assets/images/loading/loader_1.gif') }}" alt="Loading">
                <h6 style="position: absolute; bottom: 10%; left: 37%;" class="pb-2">Mohon Tunggu..</h6>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('assets/libs/sweetalert/sweetalert.js') }}"></script>
  <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/libs/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/libs/moment/moment.with.locales.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
  <script src="{{ asset('assets/libs/izitoast/js/iziToast.min.js') }}"></script>
  <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/js/app.min.js') }}"></script>

  @include('build.scriptjs')

  <script>
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          // 'Authorization': '{{session()->get('token_jwt')}}',
        }
    });

    function indonesiaDateFormat(originalDate){
      if(originalDate === null || originalDate === ''){
        return '-';
      }
      moment.locale('id');
      var parsedDate = moment(originalDate, "YYYY-MM-DD HH:mm:ss");

      // Format the date in Indonesian format
      var formattedDate = parsedDate.format("DD MMMM YYYY", 'id');
      return formattedDate;
    }

    function showAddModal(modalTitle){
        $('#modal').modal('show');
        $(".modal-title").text(modalTitle);
        $("#form_submit")[0].reset();
        resetAllSelect();
        $('#form_submit').find('input, textarea, select').each(function() {
            if ($(this).is('input[type="hidden"]')) {
                $(this).val(''); // Clear hidden input value
            }
        });
    }


  </script>

  @yield('js')
</body>

</html>