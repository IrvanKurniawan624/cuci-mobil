@extends('layouts.app')

@section('breadcrumb')
<div class="d-flex align-items-center">
    <h1 class="text-dark fw-bolder my-1 fs-5">Laporan Keuangan</h1>
</div>
<ul class="breadcrumb fw-bold mb-1">
    <li class="breadcrumb-item text-muted">
        <a href="#" class="text-muted">Laporan</a>
    </li>
    <li class="breadcrumb-item text-dark">Keuangan</li>
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
                            <h5 class="card-title fw-semibold">Table Keuangan</h5>
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
                                    <th class="col-bold">Jenis Jasa</th>
                                    <th class="col-bold">Owner</th>
                                    <th class="col-bold">Pekerja</th>
                                    <th class="col-bold">Modal dan Operasional</th>
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



@section('js')
<script>
    let tb = $('#tb').DataTable({
        processing: true,
        ajax: {
            url: "{{ route('laporan.keuangan') . '/datatables' }}",
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,2,3,4] },
            { className: 'col-bold', targets: [0,1,2,3,4] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'layanan_jasa' },
            { data: 'owner_percentage', render: function(data) {
                return 'Rp. ' + fungsiRupiah(data);
            } },
            { data: 'karyawan_percentage', render: function(data) {
                return 'Rp. ' + fungsiRupiah(data);
            } },
            { data: 'operasional_percentage', render: function(data) {
                return 'Rp. ' + fungsiRupiah(data);
            } },
        ],
    });

    $(document).ready(function(){
        currentDate = moment().format('YYYY-MM-DD');
        $('.priode-date').val(currentDate);
    });

    $('.priode-date').change(function(){
        $('#modal_loading').modal('show');
        $.ajax({
            url : "{{ route('laporan.keuangan') . '/change-date' }}",
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
