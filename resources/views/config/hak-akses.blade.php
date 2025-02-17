@extends('layouts.app')

@section('breadcrumb')
<div class="d-flex align-items-center">
    <h1 class="text-dark fw-bolder my-1 fs-5">Hak Akses</h1>
</div>
<ul class="breadcrumb fw-bold mb-1">
    <li class="breadcrumb-item text-muted">
        <a href="#" class="text-muted">Config</a>
    </li>
    <li class="breadcrumb-item text-dark">Hak Akses</li>
</ul>
@endsection

@section('content')
<section class="content">
<div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Table Hak Akses</h5>
                        </div>
                        <div>
                            <button class="btn btn-warning" onclick="showAddModalCustom('Tambah Hak Akses')"><i class="ti ti-plus fw-bolder"></i> Tambah Hak Akses</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap table-striped mb-0 align-middle w-100" id="tb">
                            <thead class="text-light fs-4 bg-royal">
                                <tr>
                                    <th class="col-bold">No.</th>
                                    <th class="col-bold">Nama</th>
                                    <th class="col-bold">Email</th>
                                    <th class="col-bold">Hak Akses</th>
                                    <th class="col-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody>                 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('modal')
<div class="modal fade" id="modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form class="form form_submit" action="{{ route('config.hak_akses') . '/store-update' }}" id="form_submit" method="POST">
                <input type="text" name="id" hidden>
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="me-n7 pe-7 row">
                        <div class="col-12 col-md-6">
                            <label class="required fs-3 fw-bold mb-2">Nama</label>
                            <input type="text" class="form-control form-control-solid" placeholder="" name="name"/>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="required fs-3 fw-bold mb-2">Email</label>
                            <input type="email" class="form-control form-control-solid" placeholder="" name="email"/>
                        </div>
                        <div class="col-12 col-md-6 password">
                            <label class="required fs-3 fw-bold mb-2">Password</label>
                            <span class="fs-2 float-end text-danger mb-2 d-inline-block">* Tidak perlu diisi jika password tidak diubah</span>
                            <input type="password" class="form-control form-control-solid" placeholder="" name="password" autocomplete="on"/>
                        </div>
                        <div class="col-12 col-md-6 confirm-password">
                            <label class="required fs-3 fw-bold mb-2">Confirm Password</label>
                            <input type="password" class="form-control form-control-solid" placeholder="" name="confirm_password" autocomplete="on"/>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="card-dark-purple">
                                <div class="w-100 d-flex justify-content-between">
                                    <h3 class="fw-bolder text-light">Pilih Hak Akses</h3>
                                    <label class="form-check-label" for="check_all">
                                        <div class="badge-content">
                                            <div class="badge bg-caffe badge-custom">
                                                <div class="form-check d-flex align-items-center" style="gap: 8px;">
                                                    <input class="form-check-input" type="checkbox" id="check_all">
                                                    <span class="text-dark">Pilih Semua</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="pt-20px">
                                    <div class="w-100"><p class="text-light label-badge">Menu Utama</p></div>
                                    <label class="form-check-label" for="dashboard">
                                        <div class="badge-content">
                                            <div class="badge bg-caffe badge-custom">
                                                <div class="form-check d-flex align-items-center" style="gap: 8px;">
                                                    <input class="form-check-input custom-check-input" type="checkbox" value="/dashboard" id="dashboard" name="hak_akses[]">
                                                    <span class="text-dark">Dashboard</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="form-check-label" for="config">
                                        <div class="badge-content">
                                            <div class="badge bg-caffe badge-custom">
                                                <div class="form-check d-flex align-items-center" style="gap: 8px;">
                                                    <input class="form-check-input custom-check-input" type="checkbox" value="config/hak-akses" id="config" name="hak_akses[]">
                                                    <span class="text-dark">Config</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="pt-20px">
                                    <div class="w-100"><p class="text-light label-badge">Master</p></div>
                                    <label class="form-check-label" for="customer">
                                        <div class="badge-content">
                                            <div class="badge bg-caffe badge-custom">
                                                <div class="form-check d-flex align-items-center" style="gap: 8px;">
                                                    <input class="form-check-input custom-check-input" type="checkbox" value="master/customer" id="customer" name="hak_akses[]">
                                                    <span class="text-dark">Customer</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="form-check-label" for="karyawan">
                                        <div class="badge-content">
                                            <div class="badge bg-caffe badge-custom">
                                                <div class="form-check d-flex align-items-center" style="gap: 8px;">
                                                    <input class="form-check-input custom-check-input" type="checkbox" value="master/karyawan" id="karyawan" name="hak_akses[]">
                                                    <span class="text-dark">Karyawan</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="form-check-label" for="jenis-mobil">
                                        <div class="badge-content">
                                            <div class="badge bg-caffe badge-custom">
                                                <div class="form-check d-flex align-items-center" style="gap: 8px;">
                                                    <input class="form-check-input custom-check-input" type="checkbox" value="master/jenis-mobil" id="jenis-mobil" name="hak_akses[]">
                                                    <span class="text-dark">Jenis Mobil</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="form-check-label" for="presentase">
                                        <div class="badge-content">
                                            <div class="badge bg-caffe badge-custom">
                                                <div class="form-check d-flex align-items-center" style="gap: 8px;">
                                                    <input class="form-check-input custom-check-input" type="checkbox" value="master/presentase" id="presentase" name="hak_akses[]">
                                                    <span class="text-dark">Presentase</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="form-check-label" for="snack">
                                        <div class="badge-content">
                                            <div class="badge bg-caffe badge-custom">
                                                <div class="form-check d-flex align-items-center" style="gap: 8px;">
                                                    <input class="form-check-input custom-check-input" type="checkbox" value="master/snack" id="snack" name="hak_akses[]">
                                                    <span class="text-dark">Snack</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="pt-20px">
                                    <div class="w-100"><p class="text-light label-badge">Transaksi</p></div>
                                    <label class="form-check-label" for="transaksi">
                                        <div class="badge-content">
                                            <div class="badge bg-caffe badge-custom">
                                                <div class="form-check d-flex align-items-center" style="gap: 8px;">
                                                    <input class="form-check-input custom-check-input" type="checkbox" value="main/transaksi" id="transaksi" name="hak_akses[]">
                                                    <span class="text-dark">Transaksi</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="form-check-label" for="transaksi_snack">
                                        <div class="badge-content">
                                            <div class="badge bg-caffe badge-custom">
                                                <div class="form-check d-flex align-items-center" style="gap: 8px;">
                                                    <input class="form-check-input custom-check-input" type="checkbox" value="main/transaksi-snack" id="transaksi_snack" name="hak_akses[]">
                                                    <span class="text-dark">Transaksi Snack</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="form-check-label" for="change_date_transaksi">
                                        <div class="badge-content">
                                            <div class="badge bg-caffe badge-custom">
                                                <div class="form-check d-flex align-items-center" style="gap: 8px;">
                                                    <input class="form-check-input custom-check-input" type="checkbox" value="changeDateTransaksi" id="change_date_transaksi" name="hak_akses[]">
                                                    <span class="text-dark">Ubah Tanggal Transaksi</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="pt-20px">
                                    <div class="w-100"><p class="text-light label-badge">Laporan</p></div>
                                    <label class="form-check-label" for="laporan-transaksi">
                                        <div class="badge-content">
                                            <div class="badge bg-caffe badge-custom">
                                                <div class="form-check d-flex align-items-center" style="gap: 8px;">
                                                    <input class="form-check-input custom-check-input" type="checkbox" value="laporan/transaksi" id="laporan-transaksi" name="hak_akses[]">
                                                    <span class="text-dark">Laporan Transaksi</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="form-check-label" for="laporan-keuangan">
                                        <div class="badge-content">
                                            <div class="badge bg-caffe badge-custom">
                                                <div class="form-check d-flex align-items-center" style="gap: 8px;">
                                                    <input class="form-check-input custom-check-input" type="checkbox" value="laporan/keuangan" id="laporan-keuangan" name="hak_akses[]">
                                                    <span class="text-dark">Laporan Keuangan</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="form-check-label" for="pendapatan-karyawan">
                                        <div class="badge-content">
                                            <div class="badge bg-caffe badge-custom">
                                                <div class="form-check d-flex align-items-center" style="gap: 8px;">
                                                    <input class="form-check-input custom-check-input" type="checkbox" value="laporan/pendapatan-karyawan" id="pendapatan-karyawan" name="hak_akses[]">
                                                    <span class="text-dark">Pendapatan Karyawan</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">Close</button>
                    <button type="submit" class="btn btn-primary" id="button_submit">
                        <span class="indicator-label">Simpan</span>
                        <div class="loading-button">
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    let tb = $('#tb').DataTable({
        processing: true,
        ajax: {
            url: '/config/hak-akses/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,2,3,4] },
            { className: 'col-bold', targets: [0,1,2] },
            { targets: 3, width: '450px' },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false},
            { data: 'name' },
            { data: 'email' },
            { data: 'hak_akses' },
            { data: null},
        ],
        rowCallback : function(row, data){

            let hak_akses_list = `<div class="d-flex flex-wrap justify-content-center">`;
            if (data.hak_akses !== null && data.hak_akses.length > 0) {
                const allAccess = data.hak_akses.length === $('.custom-check-input').length;
                hak_akses_list += allAccess
                    ? `<span class="badge rounded-pill me-2 mb-2 fw-bold" style="background: #0A9447!important;font-size: .75rem; padding-bottom: 8px">All Access</span>`
                    : data.hak_akses.map(element => `<span class="badge rounded-pill me-2 mb-2 fw-bold" style="background: #4E73DF!important;font-size: .75rem; padding-bottom: 8px">${element.replace(/\//g, ' ').replace(/-/g, ' ')}</span>`).join('');
            }
            hak_akses_list += `</div>`;
            $('td:eq(3)', row).html(hak_akses_list);

            if(data.id !== 3){
                let url_edit   = "{{ route('config.hak_akses') . '/detail/' }}" + data.id;
                let url_delete = "{{ route('config.hak_akses') . '/delete/' }}" + data.id;
                $('td:eq(4)', row).html(`
                    <button class="btn btn-info btn-sm me-1" onclick="editActionCustom('${url_edit}', 'Edit Hak Akses')"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm" onclick="deleteAction('${url_delete}','${data.name}')"><i class="fa fa-trash"> </i></button>
                `);
            } else {
                $('td:eq(4)', row).html(
                    `<span class="badge rounded-pill me-2 mb-2 fw-bold bg-danger" style="background: !important;font-size: .75rem; padding-bottom: 8px">Tidak Bisa Diubah</span>`
                );
            }

        },
    });

    $('#check_all').change(function(){
        $('.form-check-input').prop('checked', $(this).prop('checked'));
    });

    $('.form-check-input').change(function(){
        $('#check_all').prop('checked', $('.custom-check-input:checked').length === $('.custom-check-input').length);
    });

    $('#transaksi').change(function(){
        if(!$(this).is(':checked')){
            $('#change_date_transaksi').prop('checked', false);
        }
    });

    $('#change_date_transaksi').change(function(){
        if($(this).is(':checked') && !$('#transaksi').is(':checked')){
            $('#transaksi').prop('checked', true);
        }
    });

    function showAddModalCustom(modalTitle){
        $('#modal').modal('show');
        $(".modal-title").text(modalTitle);
        $("#form_submit")[0].reset();
        resetAllSelect();
        $(".confirm-password").removeClass('d-none');
        $(".password label").text('Password');
        $(".password span").addClass('d-none');
    }

    function editActionCustom(url, modal_text){
       save_method = 'edit';
       $("#modal").modal('show');
       $(".modal-title").text(modal_text);
       $("#form_submit")[0].reset();
       $(".confirm-password").addClass('d-none');
       $(".password label").text('Change Password');
       $(".password span").removeClass('d-none');
       $('.invalid-feedback').remove();
       $('input.is-invalid').removeClass('is-invalid');
       $("#modal_loading").modal('show');
       $.ajax({
          url : url,
          type: "GET",
          dataType: "JSON",
          success: function(response){
             setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
             Object.keys(response.data).forEach(function (key) {
                if(key === 'hak_akses' && response.data[key] !== null){
                    response.data[key].forEach(value => {
                        $('input[type="checkbox"][value="' + value + '"]').prop('checked', true).trigger('change'); 
                    });
                }
                var elem_name = $('[name=' + key + ']');
                elem_name.val(response.data[key]);
             });
          },error: function (jqXHR, textStatus, errorThrown){
            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
            Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
          }
       });
    }

    
</script>
@endsection