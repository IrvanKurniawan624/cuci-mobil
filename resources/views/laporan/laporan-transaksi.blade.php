@extends('layouts.app')

@section('css')
<style>
    .custom-radio input[type="radio"]:not(:checked) + label:hover  {
        background-color: #f9f9f9;
        color: #b9b9b9;
    }
    .form-control:disabled{
        color: black;
    }

    .mw-25{
        width: 5%!important;
    }
</style>
@endsection

@section('breadcrumb')
<div class="d-flex align-items-center">
    <h1 class="text-dark fw-bolder my-1 fs-5">Laporan Transaksi</h1>
</div>
<ul class="breadcrumb fw-bold mb-1">
    <li class="breadcrumb-item text-muted">
        <a href="#" class="text-muted">Laporan</a>
    </li>
    <li class="breadcrumb-item text-dark">Transaksi</li>
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
                            <h5 class="card-title fw-semibold">Table Transaksi</h5>
                        </div>
                        <div>
                            <div class="form-group d-flex align-items-center" style="flex-direction: row; gap: 12px">
                                <label class="required fs-3 fw-bold mb-0">Priode</label>
                                <input type="date" class="form-control form-control-solid priode-date" placeholder="" name="startDate"/>
                                -
                                <input type="date" class="form-control form-control-solid priode-date" placeholder="" name="endDate"/>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive w-100 d-block">    
                        <table class="table text-nowrap table-striped mb-0 align-middle w-100" id="tb">
                            <thead class="text-light fs-4 bg-royal">
                                <tr>
                                    <th class="col-bold">No.</th>
                                    <th class="col-bold">Tanggal</th>
                                    <th class="col-bold">Plat Nomor</th>
                                    <th class="col-bold">Customer</th>
                                    <th class="col-bold">Layanan Jasa</th>
                                    <th class="col-bold">Karyawan</th>
                                    <th class="col-bold">Total Harga</th>
                                    <th class="col-bold">Detail</th>
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
            <div class="modal-header">
                <h4 class="modal-title">Detail Transaksi</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-10 px-lg-17">
                <div class="me-n7 pe-7">
                    <form id="form_clear">
                        <div class="row">
                            <input type="text" hidden name="id" id="id_transaksi">
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label class="required fs-3 fw-bold mb-2">Jenis Jasa</label>
                                    <input type="text" class="form-control" disabled readonly name="layanan_jasa">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="required fs-3 fw-bold mb-2">Plat Nomor</label>
                                    <input type="text" class="form-control" disabled readonly name="master_customer_plat_nomor">
                                </div>
                                <div class="card-custom mb-4">
                                    <h5 class="fw-bold detail-heading-text" style="border-bottom: 6px solid #F3F4F5">Detail Info</h5>
                                    <div class="detail-body">
                                        <div class="form-group mb-3">
                                            <label class="required fs-3 fw-bold mb-2">Pilih Jenis Mobil</label>
                                            <input type="text" class="form-control" disabled readonly id="jenis_mobil" name="jenis_mobil">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="required fs-3 fw-bold mb-2">Tipe Mobil</label>
                                            <input type="text" class="form-control" disabled readonly name="mobil" id="mobil">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="required fs-3 fw-bold mb-2">Nama Customer</label>
                                            <input type="text" class="form-control" disabled readonly id="customer">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="required fs-3 fw-bold mb-2">No. Telepon</label>
                                            <input type="text" class="form-control" disabled readonly id="nomor_telepon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 position-relative">
                                <div class="form-group mb-3">
                                    <label class="required fs-3 fw-bold mb-2">Pilih Pegawai</label>
                                    <div id="karyawan">

                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="required fs-3 fw-bold mb-2">Pembayaran</label>
                                    <div class="form-group custom-radio d-flex justify-content-center">
                                        <input type="radio" id="tunai" disabled value="tunai"><label for="tunai" style="border-right: none; text-align: center">Tunai</label>
                                        <input type="radio" id="qris" disabled value="qris"><label for="qris" style="text-align: center">Qris</label>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="required fs-3 fw-bold mb-2">Biaya</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="rp">Rp. </span>
                                        <input type="text" class="form-control" disabled readonly name="total_harga" aria-describedby="rp">
                                    </div>
                                </div>
                                <div class="form-group mb-3 mt-4 justify-content-end d-flex">
                                    <button type="button" class="btn btn-danger" id="button_cancel_transaksi" onclick="cancelTransaksi()">Cancel Transaksi</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer flex-center">
                <button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    let tb = $('#tb').DataTable({
        processing: true,
        ajax: {
            url: "{{ route('laporan.transaksi') . '/datatables' }}",
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1,2,3,4,5] },
            { className: 'col-bold', targets: [0,2,3,4,5,6] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'created_at', render: function(data) {
                return indonesiaDateFormat(data);
            } },
            { data: 'master_customer_plat_nomor' },
            { data: 'master_customer.name' },
            { data: 'layanan_jasa' },
            { data: 'master_customer_plat_nomor' },
            { data: 'total_harga', render: function(data) {
                return 'Rp. ' + fungsiRupiah(data);
            } },
            { data: null, searchable: false, orderable: false, },
        ],
        rowCallback : function(row, data){

            let karyawan_list = ``;
            data.transaksi_karyawan.forEach(element => {
                karyawan_list += `<span class="badge rounded-pill me-2 mb-2 fw-bold" style="background: #4E73DF!important;font-size: .75rem">${element.users.name}</span><br>`
            });

            $('td:eq(5)', row).html(karyawan_list);
            $('td:eq(7)', row).html(`<button class="btn btn-info btn-sm" onclick="detail_transaksi(${data.id})"><i class="fas fa-info-circle"></i></button>`);
        },
    });

    function detail_transaksi(id){
        $("#modal_loading").modal('show');
        $('#karyawan').empty();
        $('#form_clear')[0].reset();
        resetAllSelect();
        $.ajax({
            url : "{{ route('laporan.transaksi') . '/detail/' }}" + id,
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                Object.keys(response).forEach(function (key) {
                    $(`[name=${key}]`).val(response[key]);
                });
                $('#customer').val(response.master_customer.name);
                $('#mobil').val(response.master_customer.mobil);
                $('#nomor_telepon').val(response.master_customer.no_telepon);
                $('#jenis_mobil').val(response.master_customer.jenis_mobil);
                response.payment === 'tunai' ? $('#tunai').prop('checked', true) : $('#qris').prop('checked', true);
                response.transaksi_karyawan.forEach(element => {
                    $('#karyawan').append(`<span class="badge rounded-pill bg-primary me-2 fw-bold" style="font-size: .75rem">${element.users.name}</span>`)
                });
                $('#modal').modal('show')
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
            }
        });
    }

    function cancelTransaksi(){
        Swal.fire({
             title: 'Anda yakin ingin menghapus Transaksi ini ?',
             text: 'Pastikan anda menghapus Transaksi yang benar...',
             cancelButtonColor: '#d33',
             showCancelButton: true,
             confirmButtonText: 'Ya, Hapus Transaksi!'
         }).then((result) => {
            if (result.value) {
            $("#modal_loading").modal('show');
            $.ajax({
                url : "{{ route('laporan.transaksi') }}" + "/delete/" + $('[name=id]').val(),
                type: "DELETE",
                dataType: "JSON",
                success: function(response){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    if(response.code === 200){
                        Swal.fire('Berhasil!',response.message,'success').then(function(){
                            $("#modal").modal('hide');
                            tb.ajax.reload(null, false);
                            currentDate = moment().format('YYYY-MM-DD');
                            $('.priode-date').val(currentDate);
                        });
                    }else{
                        Swal.fire('Oops!',response.message,'error');
                    }

                },error: function (jqXHR, textStatus, errorThrown){
                    setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                    Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
                }
            });
            }
       });
    }

    $(document).ready(function(){
        currentDate = moment().format('YYYY-MM-DD');
        $('.priode-date').val(currentDate);
    });

    $('.priode-date').change(function(){
        $('#modal_loading').modal('show');
        $.ajax({
            url : "{{ route('laporan.transaksi') . '/change-date' }}",
            type: "GET",
            data: {startDate: $("[name=startDate]").val(), endDate: $("[name=endDate]").val()},
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                let data = response.data;
                tb.clear().draw();
                tb.rows.add(data).draw();
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
            }
        });
    })
</script>
@endsection
