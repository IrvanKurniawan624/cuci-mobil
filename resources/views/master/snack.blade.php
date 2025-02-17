@extends('layouts.app')

@section('breadcrumb')
<div class="d-flex align-items-center">
    <h1 class="text-dark fw-bolder my-1 fs-5">Master Snack</h1>
</div>
<ul class="breadcrumb fw-bold mb-1">
    <li class="breadcrumb-item text-muted">
        <a href="#" class="text-muted">Master</a>
    </li>
    <li class="breadcrumb-item text-dark">Snack</li>
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
                            <h5 class="card-title fw-semibold">Table Snack</h5>
                        </div>
                        <div>
                            <button class="btn btn-warning" onclick="showAddModal('Tambah Snack')"><i class="ti ti-plus fw-bolder"></i> Tambah Snack</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap table-striped mb-0 align-middle w-100" id="tb">
                            <thead class="text-light fs-4 bg-royal">
                                <tr>
                                    <th class="col-bold">No.</th>
                                    <th class="col-bold">Nama Snack</th>
                                    <th class="col-bold">Stock</th>
                                    <th class="col-bold">Harga Beli</th>
                                    <th class="col-bold">Harga Jual</th>
                                    <th class="col-bold">Keuntungan</th>
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
    <div class="modal-dialog mw-650px">
        <div class="modal-content">
            <form class="form form_submit" action="{{ route('master.snack') . '/store-update' }}" id="form_submit" method="POST">
                <input type="text" name="id" hidden>
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="me-n7 pe-7 row">
                        <div class="col-12 col-md-8">
                            <label class="required fs-3 fw-bold mb-2">Nama Snack</label>
                            <input type="text" class="form-control form-control-solid" placeholder="" name="snack_name"/>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="required fs-3 fw-bold mb-2">Stock</label>
                            <input type="number" class="form-control form-control-solid" placeholder="" name="stock"/>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label class="required fs-3 fw-bold mb-2">Harga Beli</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="rp">Rp. </span>
                                    <input type="hidden" name="harga_beli">
                                    <input type="text" class="form-control" onkeypress="onKeypressAngka()" onkeyup="return onkeyupRupiah(this.id)" id="harga_beli" aria-describedby="rp">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label class="required fs-3 fw-bold mb-2">Harga Jual</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="rp">Rp. </span>
                                    <input type="hidden" name="harga_jual">
                                    <input type="text" class="form-control" onkeypress="onKeypressAngka()" onkeyup="return onkeyupRupiah(this.id)" id="harga_jual" aria-describedby="rp">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label class="required fs-3 fw-bold mb-2">Keuntungan</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="rp">Rp. </span>
                                    <input type="text" disabled class="form-control" name="keuntungan" id="keuntungan" aria-describedby="rp">
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
            url: '/master/snack/datatables',
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,2,3,4,5,6] },
            { className: 'col-bold', targets: [0,1,2,3,4,5] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false},
            { data: 'snack_name' },
            { data: 'stock' },
            { data: 'harga_beli', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp. ' ) },
            { data: 'harga_jual', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp. ' ) },
            { data: 'keuntungan', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp. ' ) },
            { data: null, searchable: false, orderable: false, },
        ],
        rowCallback : function(row, data){
            let url_edit   = "{{ route('master.snack') }}/detail/" + data.id;
            let url_delete = "{{ route('master.snack') }}/delete/" + data.id;
            $('td:eq(6)', row).html(`
                <button class="btn btn-info btn-sm me-1" onclick="editAction('${url_edit}', 'Edit Snack')"><i class="fa fa-edit"></i></button>
                <button class="btn btn-danger btn-sm" onclick="deleteAction('${url_delete}','${data.snack_name}')"><i class="fa fa-trash"> </i></button>
            `);
        }
    });

    $('#harga_beli, #harga_jual').on('keyup', function() {
        var harga_jual = parseFloat($('[name="harga_jual"]').val()) || 0;
        var harga_beli = parseFloat($('[name="harga_beli"]').val()) || 0; 
        var result = harga_jual - harga_beli;
        result = fungsiRupiah(result); 
        if(harga_beli > harga_jual){result = "- " + result;}
        $('#keuntungan').val(result);
    });
</script>
@endsection