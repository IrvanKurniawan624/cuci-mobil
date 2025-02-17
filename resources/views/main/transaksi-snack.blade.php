@extends('layouts.app')

@section('breadcrumb')
<div class="d-flex align-items-center">
    <h1 class="text-dark fw-bolder my-1 fs-5">Transaksi Snack</h1>
</div>
<ul class="breadcrumb fw-bold mb-1">
    <li class="breadcrumb-item text-muted">
        <a href="#" class="text-muted">Utama</a>
    </li>
    <li class="breadcrumb-item text-dark">Transaksi Snack</li>
</ul>
@endsection

@section('css')
<style>
    .btn-delete-keranjang{
        width: 38px;
        height: 40px;
    }
    .btn-delete-keranjang i{
        position: relative;
        display: flex;
        padding-left: 1px;
        justify-content: center;
    }
    div.dataTables_wrapper div.dt-row{
        margin-top: -20px!important;
    }
    table.dataTable tbody{
        overflow-x: auto;
    }
    .card{
        margin-bottom: 0!important;
    }
    #keranjang_kosong{
        position: absolute;
        right: 50%;
        transform: translate(50%, -50%);
        top: 50%;
        font-weight: bold;
        font-size: 1rem;
        color: #b7b7b7;
    }
    .total-box{
        background: #6E214A;
        color: white;
        font-size: 1rem;
        font-weight: 700;
        gap: 15px;
        padding: 15px;
        vertical-align: middle;
        margin-top: -16px;
        margin-bottom: 18px;
    }
    #tb_filter{
        display: none;
    }
    .dataTables_info{
        position: absolute;
    }
    #tb_wrapper{
        padding-bottom: 13px;
    }
    #current_order_list.with-date{
        height: 405px!important;
    }
    #current_order_list li{
        display: flex;
        align-content: center;
        padding: 5px;
        border-bottom: 1px solid #ebebeb;
    }
    #current_order_list li .snack-name{
        width: 170px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: black;
        font-size: 1rem;
        padding: 13px 0!important;
        font-weight: 500;
    }
    #current_order_list li .subtotal{
        font-size: 1rem;
        color: #009ef7 !important;
        display: flex;
        align-content: center;
        justify-content: center;
        text-align: center;
        padding-right: 10px!important;
        font-weight: 600;
        width: 155px;
        flex-wrap: wrap;
    }
    #current_order_list li .qty-btn{
        padding-right: 0px!important;
        display: flex;
        align-items: center;
    }
    #current_order_list li .button{
        padding: 0!important;
        display: flex;
        align-items: center;
    }
    #current_order_list{
        height: 485px;
        display: block;
        overflow-y: scroll;
    }
    .kembalian-container{
        background: #41474e;
        padding: 17px 25px;
    }
    #input_uang{
        background: white;
    }
    .btn-action{
        flex: 1;
        height: 50px;
        font-weight: 700;
        font-size: 1rem;
    }
</style>
@endsection

@section('content')
<section class="content">
<div class="row">
    <div class="col-lg-6 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0 w-100 d-flex justify-content-between align-items-center" style="border-bottom: 6px solid #F3F4F5;padding-bottom: 9px;">
                        <h5 class="card-title fw-semibold m-0">List Snack</h5>
                        <div class="d-flex align-items-center position-relative my-1">
                            <div id="tb_filter_cust"><label class="d-flex" style="gap: 12px">Search:<input type="search" class="form-control form-control-sm" data-table-filter="search" ></label></div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table text-nowrap table-striped mb-0 align-middle w-100" id="tb">
                        <thead class="text-light fs-4 bg-royal">
                            <tr>
                                <th class="col-bold">Nama Snack</th>
                                <th class="col-bold">Harga Jual</th>
                                <th class="col-bold">Stok</th>
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
    <div class="col-lg-6 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0 w-100">
                        <h4 class="card-title fw-semibold">Current Order</h4>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="required fs-3 fw-bold mb-2">Pembayaran</label>
                    <div class="form-group custom-radio d-flex justify-content-center">
                        <input type="radio" id="tunai" name="payment" value="tunai" checked=""><label for="tunai" style="border-right: none; text-align: center">Tunai</label>
                        <input type="radio" id="qris" name="payment" value="qris"><label for="qris" style="text-align: center">Qris</label>
                    </div>
                </div>
                @if(!empty(array_intersect(['changeDateTransaksi'], Auth::user()->hak_akses)))
                <div class="form-group mb-3">
                    <label class="required fs-3 fw-bold mb-2">Tanggal Transaksi</label>
                    <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" class="form-control">
                </div>
                @endif
                <div class="position-relative">
                    <ul id="current_order_list" class="@if(!empty(array_intersect(['changeDateTransaksi'], Auth::user()->hak_akses))) with-date @endif">
                        
                    </ul>
                    <div id="keranjang_kosong">
                        <p>Keranjang Kosong</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between total-box">
                    <p class="m-0" style="vertical-align: middle;">Total</p>
                    <p class="m-0" style="vertical-align: middle;" id="total" data-total="0">Rp. 0</p>
                </div>
                <div class="form-group mt-4 d-flex justify-content-around">
                    <button type="submit" class="btn-action btn btn-warning px-5 me-4" onclick="checkTypePembayaran()">Save</button>
                    <button type="button" class="btn-action btn btn-danger px-5" onclick="cancelTransaksi()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

@section('modal')
<div class="modal fade" id="modal_qris" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Qris</h4>
            </div>
            <div class="modal-body py-10 px-lg-17">
                <div class="me-n7 pe-7">
                    <img src="{{ asset('assets\images\avatar\avatar-4.png') }}" class="w-100" alt="" srcset="">
                </div>
            </div>
            <div class="modal-footer flex-center">
                <button type="button" onclick="doTransaksi()" class="btn btn-success me-3">Sudah Bayar!</button>
                <button type="button" onclick="$('#modal_qris').modal('hide')" class="btn btn-danger me-3">Nanti Dulu</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function(){
        var today = new Date();
        var year = today.getFullYear();
        var month = (today.getMonth() + 1).toString().padStart(2, '0');
        var day = today.getDate().toString().padStart(2, '0');

        var formattedDate = year + '-' + month + '-' + day;
        $('#tanggal_transaksi').val(formattedDate);
    });

    let tb;
    var DatatablesServerSide = function () {
        var initDatatable = function () {
            tb = $('#tb').DataTable({
                processing: true,
                paging: false,
                scrollY: 'calc(100vh - 395px)',
                scrollCollapse: true,
                ajax: {
                    url: '/main/transaksi-snack/datatables',
                    type: 'GET'
                },
                columnDefs: [
                    { className: 'text-center', targets: [1,2,3] },
                    { className: 'col-bold', targets: [0,1,2] },
                ],
                columns: [
                    { data: 'snack_name' },
                    { data: 'harga_jual', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp. ' ) },
                    { data: 'stock' },
                    { data: null, searchable: false, orderable: false, },
                ],
                rowCallback : function(row, data){
                    let url_delete = "{{ route('master.snack') }}/delete/" + data.id;
                    $('td:eq(3)', row).html(`
                        <button class="btn btn-info btn-sm btn-keranjang-${data.id} btn-keranjang" onclick="add_keranjang('${data.id}', '${data.snack_name}','${data.harga_jual}', '${data.stock}')"><i class="fa fa-plus"> </i></button>
                    `);
                }
            });
        }

        var handleSearchDatatable = function () {
            const filterSearch = document.querySelector('[data-table-filter="search"]');
            filterSearch.addEventListener('keyup', debounce(function (e) {
                $('#loading_search').addClass('d-none');
                tb.search(e.target.value).draw();
            }, 500));
        }

        return {
            init: function () {
                initDatatable();
                handleSearchDatatable();
            }
        }
    }();

    $('[data-table-filter="search"]').click(function(e){
        setTimeout(() => {
            if(e.target.value === ''){
                tb.search(e.target.value).draw();
            }
        }, 200);
    })

    $(document).ready(function(){
        DatatablesServerSide.init();
    })

    function delete_keranjang(id){
        $(`.list-snack[data-id='${id}']`).remove();
        if($('.list-snack').length === 0){
            $("#keranjang_kosong").removeClass('d-none');
        }
        $(`.btn-keranjang-${id}`).attr('disabled', false);
        calculate_total();
    }

    function add_keranjang(id, snack_name, harga_jual, stock){
        if(!$("#keranjang_kosong").hasClass('d-none')){
            $("#keranjang_kosong").addClass('d-none');
        }
        $("#current_order_list").append(`
            <li class="list-snack" data-id="${id}" data-subtotal="${harga_jual}">
                <div class="snack-name">${snack_name}</div>
                <div class="qty-btn">
                    <div class="position-relative d-flex align-items-center">
                        <button type="button" class="btn btn-icon btn-sm btn-light btn-icon-gray-500" onclick="$(this).next().val((i, val) => Math.max(parseInt(val) - 1, 1 )).change();">
                            <i class="fas fa-minus fs-1x"></i>
                        </button>

                        <input type="text" class="form-control border-0 text-center px-0 fs-3 fw-bold text-gray-800 qty-input" disabled style="width: 30px" onchange="calculate_subtotal(${id}, $(this).val(), ${harga_jual})" placeholder="qty" value="1">

                        <button type="button" class="btn btn-icon btn-sm btn-light btn-icon-gray-500" onclick="$(this).prev().val((i, val) => Math.min(parseInt(val) + 1, ${stock})).change();">
                            <i class="fas fa-plus fs-1x"></i>    
                        </button>
                    </div>
                </div>
                <div class="subtotal">Rp. ${fungsiRupiah2(harga_jual)}</div>
                <div class="button"><button class="btn btn-danger btn-delete-keranjang" onclick="delete_keranjang(${id})"><i class="fas fa-trash"></i></button></div>
            </li>
        `);
        calculate_subtotal(id, 1, harga_jual);
        $(`.btn-keranjang-${id}`).attr('disabled', true);
    }

    function calculate_subtotal(id, qty, harga_jual){
        var subTotal = parseInt(harga_jual) * parseInt(qty);
        $(`.list-snack[data-id="${id}"]`).data('subtotal', subTotal);
        $(`.list-snack[data-id="${id}"] .subtotal`).text(`Rp. ${fungsiRupiah2(subTotal)}`);
        calculate_total();
    }

    function calculate_total(){
        var total = 0;

        $('.list-snack').each(function() {
            total += parseFloat($(this).data('subtotal'));
        });
        $("#total").data("total", total);
        $("#total").text(`Rp. ${fungsiRupiah2(total)}`);
    }

    function checkTypePembayaran(){
        if (!$('.list-snack').length > 0) {
            Swal.fire('Peringatan..!',"Keranjang masih Kosong...!",'warning');
            return;
        }
        if($('input[name=payment]:checked').val() === 'qris'){
            $("#modal_qris").modal("show");
        }else {
            doTransaksi();
        }
    };

    function doTransaksi(){
        Swal.fire({
            title: 'Apakah Anda yakin ingin melakukan Transaksi?',
            text: 'Pastikan Customer sudah melakukan Pembayaran',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak!',
        }).then((result) => {
            if (result.value) {
                let snack = [];
                let total_harga = 0;
                $(".list-snack").each(function(i, elem) {
                    snack.push({
                        "master_snack_id": $(elem).data('id'),
                        "quantity": $(elem).find('.qty-input').val(),
                        "total_harga": $(elem).data('subtotal')
                    });
                    total_harga += parseFloat($(elem).data('subtotal'));
                });

                $("#modal_loading").modal('show');
                $.ajax({
                   url : "{{ route('main.transaksi_snack') . '/store' }}",
                   type: "POST",
                   data: {snack: snack, payment: $('input[name=payment]:checked').val(), total_harga: total_harga, tanggal_transaksi: $("#tanggal_transaksi").val()},
                   dataType: "JSON",
                   success: function(response){
                      $('#modal_qris').modal('hide');
                      setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                      if(response.code === 200){
                        Swal.fire('Berhasil!',response.message,'success').then(function(){
                            location.reload();
                        });
                      }else{
                        Swal.fire('Oops!',response.message,'error');
                      }
                   },error: function (jqXHR, textStatus, errorThrown){
                        setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                        $('#modal_qris').modal('hide');
                        if(jqXHR.status == 400){
                            $('.invalid-feedback').remove();
                            $('input, textarea, select').removeClass('is-invalid');
                            Object.keys(jqXHR.responseJSON.errors).forEach(function (key) {
                                var responseError = jqXHR.responseJSON.errors[key];
                                var elem_name = $('[name=' + responseError['field'] + ']');
                                var errorMessage = `<span class="d-flex text-danger invalid-feedback">${responseError['message']}</span>`
                                elem_name.addClass('is-invalid');
                                elem_name.after(errorMessage);
                            });
                            Swal.fire('Oops!',jqXHR.responseJSON.message,'warning');
                        }else if(jqXHR.status == 500){
                            Swal.fire('Error!',jqXHR.responseJSON.message,'error');
                        }else{
                            Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
                        }
                    }
                });
            }
        });
    }

    function cancelTransaksi(){
        Swal.fire({
            title: 'Apakah Anda yakin ingin membatalkan Transaksi?',
            text: 'Setelah anda membatalkan Transaksi Semua Input akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak!',
        }).then((result) => {
            if (result.value) {
                $('.list-snack').remove();
                $('.btn-keranjang').attr('disabled', false);
                calculate_total();
            }
        })
    }

</script>
@endsection
