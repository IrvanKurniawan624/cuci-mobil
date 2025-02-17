@extends('layouts.app')

@section('breadcrumb')
<div class="d-flex align-items-center">
    <h1 class="text-dark fw-bolder my-1 fs-5">Transaksi</h1>
</div>
<ul class="breadcrumb fw-bold mb-1">
    <li class="breadcrumb-item text-muted">
        <a href="#" class="text-muted">Utama</a>
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
                        <div class="mb-3 mb-sm-0 w-100" style="border-bottom: 6px solid #F3F4F5;padding-bottom: 9px;">
                            <h5 class="card-title fw-semibold">Input Transaksi</h5>
                        </div>
                    </div>
                    <form id="form_transaksi">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label class="required fs-3 fw-bold mb-2">Jenis Jasa</label>
                                    <select name="layanan_jasa" class="form-select select2-reset" id="presentase_select2" data-placeholder="Pilih Type">
                                        <option></option>
                                        @foreach ($presentase as $item)
                                            <option value="{{ $item->id }}" data-presentase-kas="{{ $item->presentase_kas }}" data-presentase-pekerja="{{ $item->presentase_pekerja }}" data-presentase-operasional="{{ $item->presentase_operasional }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="required fs-3 fw-bold mb-2">Plat Nomor</label>
                                    <div class="input-suggestion position-relative">
                                        <input type="text" class="form-control" required name="plat_nomor" id="plat_nomor" autocomplete="off">
                                        <div class="spinner-border loading-plat-nomor d-none" id="loading_plat_nomor" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <div class="w-100 result-box">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-custom mb-4">
                                    <h5 class="fw-bold detail-heading-text" style="border-bottom: 6px solid #F3F4F5">Detail Info</h5>
                                    <div class="detail-body">
                                        <div class="form-group mb-3">
                                            <label class="required fs-3 fw-bold mb-2">Pilih Jenis Mobil</label>
                                            <select class="form-select select2-reset" id="jenis_mobil_select2" name="master_jenis_mobil_id" required data-placeholder="Pilih Jenis Mobil">
                                                <option></option>
                                                @foreach ($jenis_mobil as $item)
                                                <option value="{{ $item->id }}" data-name="{{ $item->name }}" data-desc="{{ $item->description }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="required fs-3 fw-bold mb-2">Tipe Mobil</label>
                                            <input type="text" class="form-control" required name="mobil" id="mobil">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class=" fs-3 fw-bold mb-2">Nama Customer</label>
                                            <input type="text" class="form-control"  name="name" id="nama_customer">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class=" fs-3 fw-bold mb-2">No. Telepon</label>
                                            <input type="text" class="form-control"  name="no_telepon" id="nomor_telepon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 position-relative">
                                <div class="form-group mb-3">
                                    <label class="required fs-3 fw-bold mb-2">Pilih Pegawai</label>
                                    <select name="master_karyawan_id[]" id="master_karyawan_id" class="form-select select2-reset select2-multiple" data-placeholder="Pilih Pegawai" multiple>
                                        <option></option>
                                        @foreach ($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}">{{ $pegawai->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="required fs-3 fw-bold mb-2">Pembayaran</label>
                                    <div class="form-group custom-radio d-flex justify-content-center">
                                        <input type="radio" id="tunai" name="payment" value="tunai" checked=""><label for="tunai" style="border-right: none; text-align: center">Tunai</label>
                                        <input type="radio" id="qris" name="payment" value="qris"><label for="qris" style="text-align: center">Qris</label>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="required fs-3 fw-bold mb-2">Biaya</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="rp">Rp. </span>
                                        <input type="hidden" name="total_harga">
                                        <input type="text" class="form-control" onkeypress="onKeypressAngka()" onkeyup="return onkeyupRupiah(this.id)" id="total_harga" aria-describedby="rp">
                                    </div>
                                </div>
                                @if(!empty(array_intersect(['changeDateTransaksi'], Auth::user()->hak_akses)))
                                <div class="form-group mb-3">
                                    <label class="required fs-3 fw-bold mb-2">Tanggal Transaksi</label>
                                    <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" class="form-control">
                                </div>
                                @endif
                                <div class="form-group position-absolute" style="bottom: 10px; right: 15px">
                                    <button type="submit" class="btn btn-warning px-5 me-4">Save</button>
                                    <button type="button" class="btn btn-danger px-5" onclick="cancelTransaksi()">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
                    <img src="{{ asset('assets/images/products/s4.jpg') }}" class="w-100" alt="" srcset="">
                </div>
            </div>
            <div class="modal-footer flex-center">
                <button type="button" onclick="doTransaksi()" class="btn btn-success me-3">Sudah Bayar!</button>
                <button type="button" onclick="hideQrisModal()" class="btn btn-danger me-3">Nanti Dulu</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/js/loadash.min.js') }}"></script>
<script>

    $(document).ready(function(){
        var today = new Date();
        var year = today.getFullYear();
        var month = (today.getMonth() + 1).toString().padStart(2, '0');
        var day = today.getDate().toString().padStart(2, '0');

        var formattedDate = year + '-' + month + '-' + day;
        $('#tanggal_transaksi').val(formattedDate);
    });

    let clickedElement;
    $( '.select2-single' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    } );

    $( '.select2-multiple' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        closeOnSelect: false,
    } );

    $('#presentase_select2').select2({
        theme: "bootstrap-5",
        placeholder: $( this ).data( 'placeholder' ),
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        templateResult: function(data) {
            if (!data.id) {
                return data.text;
            }

            var optionText = data.text;
            var optionData = data.element.dataset;

            return $(`
                <div>
                    <span class="fw-semibold">${optionText}</span>
                    <span> - [ Kas : ${optionData.presentaseKas}% | Pekerja : ${optionData.presentasePekerja}% | Op : ${optionData.presentaseOperasional}% ]</span>
                </div>
            `);
        },
        templateSelection: function(data) {
            return data.text;
        }
    });

    function checkDataPlatNomor(){
        if($("#plat_nomor").val().length >= 2){
            $.ajax({
                url: "{{ route('main.transaksi') . '/suggestion-plat/' }}" + $("#plat_nomor").val(),
                type: "GET",
                dataType: "JSON",
                success: function (response) {
                    if(response.length === 1 && response[0].plat_nomor == $('#plat_nomor').val()){
                        clickSuggstion(response[0].plat_nomor, response[0].mobil, response[0].name, response[0].jenis_mobil, response[0].no_telepon);
                    }
                }
            });
        }
    }

    function clickSuggstion(plat_nomor, mobil, name, jenis_mobil, no_telepon){
        $('#plat_nomor').val(plat_nomor);
        $('#mobil').val(mobil == 'null' ? '' : mobil);
        $('#nama_customer').val(name == 'null' ? '' : name);
        $('#nomor_telepon').val(no_telepon == 'null' ? '' : no_telepon);
        let optionToSelect = $('#jenis_mobil_select2').find('option[data-name="' + jenis_mobil + '"]');
        if (optionToSelect.length > 0) {
            optionToSelect.prop('selected', true);
            $('#jenis_mobil_select2').trigger('change');
        }
        optionToSelect.prop('selected', true);
        $('.input-suggestion').removeClass('active');
        $('.result-box').empty();   
    }

    var ajaxCounter = 0;

    $('#plat_nomor').on('input', function () {
        $("#loading_plat_nomor").removeClass('d-none'); 
        debouncedAjaxRequest($(this).val());
        var inputValue = $(this).val().toUpperCase();
        $(this).val(inputValue);
    });
    
    var debouncedAjaxRequest = _.debounce(function (inputValue) {
        if (inputValue.length >= 2) {
            var currentCounter = ++ajaxCounter; 
            $.ajax({
                url: "{{ route('main.transaksi') . '/suggestion-plat/' }}" + inputValue,
                type: "GET",
                dataType: "JSON",
                success: function (response) {
                    $('.result-box').empty();
                    if(response.length > 0 && currentCounter === ajaxCounter){
                        $("#loading_plat_nomor").addClass('d-none');
                        $('.input-suggestion').addClass('active');
                        response.forEach(element => {
                            $('.result-box').append(`<li class="li-result" onclick="clickSuggstion('${element.plat_nomor}', '${element.mobil}', '${element.name}', '${element.jenis_mobil}', '${element.no_telepon}')">${element.plat_nomor}</li>`)
                        });
                    } else {
                        $("#loading_plat_nomor").addClass('d-none');
                        $('.input-suggestion').removeClass('active');
                    }
                },
                error: function (error) {
                }
            });
        } else {
            $('.result-box').empty();
            $("#loading_plat_nomor").addClass('d-none');
            $('.input-suggestion').removeClass('active');
        }
    }, 500);

    


    $(document).on('mousedown', function (event) {
        clickedElement = event.target;
    });

    $('#plat_nomor').on('blur', function (event) {
        if (!$(clickedElement).closest('.result-box').length) {
            checkDataPlatNomor();
            $('.input-suggestion').removeClass('active');
        }
    });

    $('#plat_nomor').on('focus', function () {
        if($('.result-box li').length > 0){
            $('.input-suggestion').addClass('active');
        }
    });

    $('#plat_nomor').on('keypress', function(e) {
        // Check if the pressed key is Enter (keyCode 13)
        if (e.which === 13) {
        // Call your custom function here
            checkDataPlatNomor();
        }
    });
    

    $('#jenis_mobil_select2').select2({
        theme: "bootstrap-5",
        placeholder: $( this ).data( 'placeholder' ),
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        templateResult: function(data) {
            if (!data.id) {
                return data.text;
            }

            var optionText = data.text;
            var optionData = data.element.dataset;

            return $(`
                <div>
                    <span class="fw-semibold">${optionText}</span>
                    <span> - ${optionData.desc}</span>
                </div>
            `);
        },
        templateSelection: function(data) {
            return data.text;
        }
    });

    $('#form_transaksi').submit(function(e){
        e.preventDefault();
        if (!$('#master_karyawan_id').val().length > 0) {
            Swal.fire('Peringatan..!',"Harap Pilih Pegawai Terlebih Dahulu...",'warning');
            return;
        }
        if($('input[name=payment]:checked').val() === 'qris'){
            showQrisModal();
        }else {
            doTransaksi();
        }


    });

    function showQrisModal(){
        $('#modal_qris').modal('show');
    }

    function hideQrisModal(){
        $('#modal_qris').modal('hide');
    }

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
                $("#modal_loading").modal('show');
                $.ajax({
                   url : "{{ route('main.transaksi') . '/store' }}",
                   type: "POST",
                   data: $('#form_transaksi').serialize(),
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
                                if (elem_name.parent().hasClass('input-group')) {
                                    elem_name.parent().children("input:last-child").addClass('is-invalid');
                                    elem_name.parent().append(errorMessage);
                                } else {
                                    elem_name.addClass('is-invalid');
                                    elem_name.after(errorMessage);
                                }
                            });
                            Swal.fire('Oops!',jqXHR.responseJSON.message,'warning');
                        }else if(jqXHR.status == 500){
                            Swal.fire('Error!',jqXHR.responseJSON.message,'error');
                        }else{
                            Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
                        }
                    }
                });
            } else {
                return;
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
                resetSelect2();
                $('#form_transaksi')[0].reset();
            }
        });
    };
</script>
@endsection
