@extends('layouts.app')

@section('breadcrumb')
<div class="d-flex align-items-center">
    <h1 class="text-dark fw-bolder my-1 fs-5">Master Karyawan</h1>
</div>
<ul class="breadcrumb fw-bold mb-1">
    <li class="breadcrumb-item text-muted">
        <a href="#" class="text-muted">Master</a>
    </li>
    <li class="breadcrumb-item text-dark">Karyawan</li>
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
                            <h5 class="card-title fw-semibold">Table Karyawan</h5>
                        </div>
                        <div>
                            <button class="btn btn-warning" onclick="showAddModal('Tambah Karyawan')"><i class="ti ti-plus fw-bolder"></i> Tambah Karyawan</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap table-striped mb-0 align-middle w-100" id="tb">
                            <thead class="text-light fs-4 bg-royal">
                                <tr>
                                    <th class="col-bold">No.</th>
                                    <th class="col-bold">Nama Karyawan</th>
                                    <th class="col-bold">Email</th>
                                    <th class="col-bold">No. Telp</th>
                                    <th class="col-bold">Alamat</th>
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
            <form class="form form_submit" action="{{ route('master.karyawan') . '/store-update' }}" id="form_submit" method="POST">
                <input type="text" name="id" hidden>
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="me-n7 pe-7 row">
                        <div class="col-12 col-md-8">
                            <label class="required fs-3 fw-bold mb-2">Nama Karyawan</label>
                            <input type="text" class="form-control form-control-solid" placeholder="" name="name"/>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="required fs-3 fw-bold mb-2">No. Telepon</label>
                            <input type="text" class="form-control form-control-solid" placeholder="" name="no_telepon"/>
                        </div>
                        <div class="col-12">
                            <label class="required fs-3 fw-bold mb-2">Email</label>
                            <input type="email" class="form-control form-control-solid" placeholder="" name="email"/>
                        </div>
                        <div class="col-12">
                            <label class="required fs-3 fw-bold mb-2">Alamat</label>
                            <textarea name="alamat" class="form-control" style="min-height: 70px"></textarea>
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
            url: "{{ route('master.karyawan') . '/datatables' }}",
            type: 'GET'
        },
        columnDefs: [
            { className: 'text-center', targets: [0,2,3,4,5] },
            { className: 'col-bold', targets: [0,1,2,3] },
            { className: 'text-wrap', targets: [1,4] },
        ],
        columns: [
            { data: 'DT_RowIndex',searchable: false, orderable: false},
            { data: 'name' },
            { data: 'email' },
            { data: 'no_telepon' },
            { data: 'alamat'},
            { data: null, searchable: false, orderable: false, },
        ],
        rowCallback : function(row, data){
            let url_edit   = "{{ route('master.karyawan') }}/detail/" + data.id;
            let url_delete = "{{ route('master.karyawan') }}/delete/" + data.id;
            $('td:eq(5)', row).html(`
                <button class="btn btn-info btn-sm me-1" onclick="editAction('${url_edit}', 'Edit Karyawan')"><i class="fa fa-edit"></i></button>
                <button class="btn btn-danger btn-sm" onclick="deleteAction('${url_delete}','${data.name}')"><i class="fa fa-trash"> </i></button>
            `);
        }
    });
</script>
@endsection