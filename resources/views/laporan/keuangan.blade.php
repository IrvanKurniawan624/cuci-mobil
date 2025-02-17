@extends('layouts.app')

@section('css')
<style>
    tfoot {
        background-color: #6E214A; /* Change to your desired color */
        color: white; /* Change to your desired text color */
    }
</style>
@endsection

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
                                    <th class="col-bold">Desc</th>
                                    <th class="col-bold">Debit</th>
                                    <th class="col-bold">Kredit</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
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
        "bPaginate": false,
        ajax: {
            url: "{{ route('laporan.keuangan') . '/datatables' }}",
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0] },
            { className: 'col-bold', targets: [0,1,2,3] },
            { className: 'text-right', targets: [2,3] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'desc' },
            { data: 'in', render: function(data) {
                return 'Rp. ' + fungsiRupiah(data);
            } },
            { data: 'out', render: function(data) {
                return 'Rp. ' + fungsiRupiah(data);
            } },
        ],
        footerCallback: function (row, data, start, end, display) {
        var api = this.api(), data;

        // Total in calculation
        totalIn = api.column(2, { search: 'applied' }).data().reduce(function (a, b) {
            return a + b;
        }, 0);

        // Total out calculation
        totalOut = api.column(3, { search: 'applied' }).data().reduce(function (a, b) {
            return a + b;
        }, 0);

        // Update footer
        $(api.column(2).footer()).html(
            'Rp. ' + fungsiRupiah(totalIn)
        );
        $(api.column(3).footer()).html(
            'Rp. ' + fungsiRupiah(totalOut)
        );
    }
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
