@extends('layouts.app')

@section('breadcrumb')
<div class="d-flex align-items-center">
    <h1 class="text-dark fw-bolder my-1 fs-5">Laporan Pendapatan Karyawan</h1>
</div>
<ul class="breadcrumb fw-bold mb-1">
    <li class="breadcrumb-item text-muted">
        <a href="#" class="text-muted">Laporan</a>
    </li>
    <li class="breadcrumb-item text-dark">Pendapatan Karyawan</li>
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
                            <h5 class="card-title fw-semibold">Table Pendapatan Karyawan</h5>
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
                    <div class="table-responsive">
                        <table class="table text-nowrap table-striped mb-0 align-middle w-100" id="tb">
                            <thead class="text-light fs-4 bg-royal">
                                <tr>
                                    <th class="col-bold">No.</th>
                                    <th class="col-bold">Nama Karyawan</th>
                                    <th class="col-bold">No. Telp</th>
                                    <th class="col-bold">Pendapatan</th>
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
                <h4 class="modal-title">Detail Pendapatan Karyawan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-10 px-lg-17">
                <div class="me-n7 pe-7">
                    <h5 class="mb-4">Priode <span id="display_start_date"></span> - <span id="display_end_date"></span></h5>
                    <table class="table datatable-primary table-striped table-hover datatable-history-jquery" id="tb_detail" width="100%" cellspacing="0">
                            <thead class="text-light fs-4 bg-royal">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Layanan Jasa</th>
                                    <th>Plat Nomor</th>
                                    <th>Payment</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
    let tb_detail = $('#tb_detail').DataTable({
        processing: true,
        columnDefs: [
            { className: 'text-center', targets: [0,1,2,3,4,5] },
            { className: 'col-bold', targets: [0,1,2,3,4,5] },
        ],
        data: null,
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'created_at', render: function(data) {
                return indonesiaDateFormat(data);
            } },
            { data: 'transaksi.layanan_jasa' },
            { data: 'transaksi.master_customer_plat_nomor' },
            { data: 'transaksi.payment' },
            { data: 'pendapatan', render: function(data) {
                return 'Rp. ' + fungsiRupiah(data);
            } },
        ],
    });

    let tb = $('#tb').DataTable({
        processing: true,
        ajax: {
            url: "{{ route('laporan.pendapatan_karyawan') . '/datatables' }}",
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,2,3,4] },
            { className: 'col-bold', targets: [0,1,2,3] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'users.name' },
            { data: 'users.no_telepon' },
            { data: 'total_pendapatan', render: function(data) {
                return 'Rp. ' + fungsiRupiah(data);
            } },
            { data: null, searchable: false, orderable: false, },
        ],
        rowCallback : function(row, data){
            $('td:eq(4)', row).html(`
                <button class="btn btn-info btn-sm" onclick="detailPendapatan(${data.user_id})"><i class="fas fa-info-circle"></i></button>
            `);
        }
    });

    function detailPendapatan(id){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "{{ route('laporan.pendapatan_karyawan') . '/detail' }}",
            type: "GET",
            data: { id: id, startDate: $("[name=startDate]").val(), endDate: $("[name=endDate]").val()},
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                $('#modal').modal('show')
                $('#display_start_date').text(indonesiaDateFormat($("[name=startDate]").val()));
                $('#display_end_date').text(indonesiaDateFormat($("[name=endDate]").val()));
                let data = response.data;
                tb_detail.clear().draw();
                tb_detail.rows.add(data).draw();
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
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
            url : "{{ route('laporan.pendapatan_karyawan') . '/change-date' }}",
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