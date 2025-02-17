@extends('layouts.app')

@section('breadcrumb')
<div class="d-flex align-items-center">
    <h1 class="text-dark fw-bolder my-1 fs-5">Master Customer</h1>
</div>
<ul class="breadcrumb fw-bold mb-1">
    <li class="breadcrumb-item text-muted">
        <a href="#" class="text-muted">Master</a>
    </li>
    <li class="breadcrumb-item text-dark">Customer</li>
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
                            <h5 class="card-title fw-semibold">Table Customer</h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap table-striped mb-0 align-middle w-100" id="tb">
                            <thead class="text-light fs-4 bg-royal">
                                <tr>
                                    <th class="col-bold">No.</th>
                                    <th class="col-bold">Plat Nomor</th>
                                    <th class="col-bold">Jenis Mobil</th>
                                    <th class="col-bold">Nama Customer</th>
                                    <th class="col-bold">No. Telp</th>
                                    <th class="col-bold">Total Kunjungan</th>
                                    <th class="col-bold">Updated At</th>
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
            url: '/master/customer/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,1,2,4,5,6] },
            { className: 'col-bold', targets: [0,1,2,4,5] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false},
            { data: 'plat_nomor' },
            { data: 'jenis_mobil' },
            { data: 'name' },
            { data: 'no_telepon' },
            { data: 'total_transaksi_count' },
            { data: 'updated_at', render: function(data) {
                return indonesiaDateFormat(data);
            } },
        ],
    });
</script>
@endsection