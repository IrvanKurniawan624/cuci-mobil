<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CUCI MOBIL APP</title>
    <link rel="shortcut icon" type="image/png" href="/assets/images/logos/favicon.png" />

    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style-additional.css') }}" />
    <style>
        @media(min-width: 1200px) {
            .container {
                width: 1140px !important;
            }
        }

    </style>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="container d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6">
                        <div class="card mb-0">
                            <div class="card-body p-5">
                                <h1 class="text-dark fw-bold text-center"
                                    style="font-family: Poppins,Helvetica,sans-serif!important;font-size: 1.7rem;">Login
                                </h1>
                                <p class="text-center">Enter your email & password to login</p>
                                <form id="form_login">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" required name="email" class="form-control">
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" autocomplete="on" required name="password" id="password">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 fs-4 rounded-2">Login</button>
                                </form>
                                <hr>
                                <div class="text-center mt-2">
                                    © <a href="#">CUCI MOBIL APP</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert/sweetalert.js') }}"></script>

    @include('build.scriptjs')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                // 'Authorization': '{{session()->get('token_jwt')}}',
            }
        });

        $('#form_login').submit(function (e) {
            e.preventDefault();

            $("#modal_loading").modal('show');
            $.ajax({
                url: "/login",
                type: "POST",
                data: $('#form_login').serialize(),
                dataType: "JSON",
                success: function (response) {
                    setTimeout(function () {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    if (response.status === 201) {
                        Swal.fire('Berhasil!',response.message,'success');
                        window.location.href = response.link;
                    } else {
                      Swal.fire('Berhasil!',response.message,'error');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    setTimeout(function () {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
                }
            });
        })

    </script>

    @yield('js')
</body>

</html>
