<script type="text/javascript">

    $('.form_submit').on('submit', function(e){
       e.preventDefault();
       let this_form = this;
 
       Swal.fire({
             title: 'Yakin?',
             text: "Apakah anda yakin akan menyimpan data ini?",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Save Changes'
         }).then((result) => {
             if (result.value) {
               $("#button_submit").attr('status', "loading");
               $("#button_submit").attr('disabled', "true");
               $("#modal_loading").modal('show');
                 $.ajax({
                     url:  $(this).attr('action'),
                     type: $(this).attr('method'),
                     data: $(this).serialize(),
                     success: function(response){
                        setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                        $("#button_submit").removeAttr('status');
                        $("#button_submit").removeAttr('disabled');
                         if(response.code == 200){
                            iziToast.success({
                                title: 'Success!',
                                message: response.message,
                                position: 'topRight'
                            });
                            $(".modal").modal('hide');
                            resetAllSelect();
                            this_form.reset();
                            tb.ajax.reload(null, false);
                         }
                         else if(response.code == 201){
                            iziToast.success({
                                title: 'Success!',
                                message: response.message,
                                position: 'topRight'
                            });
                             $(".modal").modal('hide');
                             window.location.href = response.data;
                         }
                         else if(response.code == 203){
                            iziToast.success({
                                title: 'Success!',
                                message: response.message,
                                position: 'topRight'
                            });
                             $(".modal").modal('hide');
                             tb.ajax.reload(null, false);
                         }

                     },error: function (jqXHR, textStatus, errorThrown) {
                        setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                        $("#button_submit").removeAttr('status');
                        $("#button_submit").removeAttr('disabled');
                        if(jqXHR.status == 400){
                           $('.invalid-feedback').remove();
                           $('input, textarea, select').removeClass('is-invalid');
                           Object.keys(jqXHR.responseJSON.errors).forEach(function (key) {
                              var responseError = jqXHR.responseJSON.errors[key];
                              var elem_name = $(this_form).find('[name=' + responseError['field'] + ']');
                              let errorMessage = `<span class="d-flex text-danger invalid-feedback">${responseError['message']}</span>`;
                              if (elem_name.parent().hasClass('input-group')) {
                                 elem_name.parent().children("input:last-child").addClass('is-invalid');
                                 elem_name.parent().append(errorMessage);
                              } else {
                                 elem_name.addClass('is-invalid');
                                 elem_name.after(errorMessage);
                              }
                           });
                           Swal.fire('Oops!',jqXHR.responseJSON.message,'warning');
                        }
                        else if(jqXHR.status == 500){
                           Swal.fire('Error!',jqXHR.responseJSON.message,'error');
                        }else{
                           Swal.fire('Oops!','Something wrong try again later (' + errorThrown + ')','error');
                        }
                     },
                 });
             }
         })
    });
 
    function editAction(url, modal_text){
       save_method = 'edit';
       $("#modal").modal('show');
       $(".modal-title").text(modal_text);
       $("#form_submit")[0].reset();
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
                var elem_name = $('[name=' + key + ']');
                elem_name.removeClass('is-invalid');
                if (elem_name.hasClass('selectric')) {
                   elem_name.val(response.data[key]).change().selectric('refresh');
                }else if(elem_name.hasClass('select2')){
                   elem_name.select2("trigger", "select", { data: { id: response.data[key] } });
                }else if(elem_name.hasClass('selectgroup-input')){
                   $("input[name="+key+"][value=" + response.data[key] + "]").prop('checked', true);
                }else if(elem_name.hasClass('my-ckeditor')){
                   CKEDITOR.instances[key].setData(response.data[key]);
                }else if(elem_name.hasClass('custom-control-input')){
                   $("input[name="+key+"][value=" + response.data[key] + "]").prop('checked', true);
                }else if(elem_name.hasClass('time-format')){
                   elem_name.val(response.data[key].substr(0, 5));
                }else if(elem_name.hasClass('format-rp')){
                   var nominal = response.data[key].toString();
                   elem_name.val(nominal.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
                }else if(elem_name.parent().hasClass('input-group')){
                   elem_name.val(response.data[key]);
                   $(`#${key}`).val(response.data[key]);
                }else{
                   elem_name.val(response.data[key]);
                }
             });
          },error: function (jqXHR, textStatus, errorThrown){

            setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
            
            if(jqXHR.status == 400){
                $('.invalid-feedback').remove();
                $('input, textarea, select').removeClass('is-invalid');
               Object.keys(jqXHR.responseJSON.errors).forEach(function (key) {
                  var responseError = jqXHR.responseJSON.errors[key];
                  var elem_name = $('[name=' + responseError['field'] + ']');
                  elem_name.after(`<span class="d-flex text-danger invalid-feedback">${responseError['message']}</span>`)
                  elem_name.addClass('is-invalid');
               });
               Swal.fire('Oops!',jqXHR.responseJSON.message,'warning');
            }
            else if(jqXHR.status == 404){
               Swal.fire('Error!',jqXHR.responseJSON.message,'error');
            }else if(jqXHR.status == 500){
               Swal.fire('Error!',jqXHR.responseJSON.message,'error');
            }else{
               Swal.fire('Oops!','Something wrong try again later (' + errorThrown + ')','error');
            }

             setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
              Swal.fire('Oops!','Terjadi kesalahan segera hubungi tim IT (' + errorThrown + ')','error');
          }
       });
    }
 
    function deleteAction(url, nama){
     Swal.fire({
             title: 'Anda yakin ingin menghapus ' + nama + '?',
             text: 'Setelah Anda menghapus data ini, Anda tidak akan dapat mengembalikannya',
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Ya, Hapus Data!'
         }).then((result) => {
             if (result.value) {
                $("#modal_loading").modal('show');
                $.ajax({
                   url : url,
                   type: "DELETE",
                   dataType: "JSON",
                   success: function(response){
                      setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
 
                      if(response.code === 200){
                         Swal.fire('Berhasil!',response.message,'success');
                         $("#modal").modal('hide');
                         tb.ajax.reload(null, false);
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
 
    function reload(){
       tb.ajax.reload(null,false);
    }
 
    function resetAllSelect(){
       $('.invalid-feedback').remove();
       $('input, textarea, select').removeClass('is-invalid');
       $('.select2').each(function(){
          var name = $(this).attr("name");
          $('[name="'+name+'"]').select2().trigger('change');
       });
 
       $('.selectric').each(function(){
          var name = $(this).attr("name");
          $('[name="'+name+'"]').selectric();
       });
    }

    function resetSelect2(){
      $('.select2-reset').val(null).trigger('change');
    }

   function debounce(callback, delay) {
      let timerId;
      return function (...args) {
         clearTimeout(timerId);
         timerId = setTimeout(() => {
               callback.apply(this, args);
         }, delay);
      };
   }
 
    //return onKeypressAngka(event,false);
    function onKeypressAngka(e, decimal) {
       var key;
       var keychar;
       if (window.event) {
          key = window.event.keyCode;
       } else if (e) {
          key = e.which;
       } else {
          return true;
       }
       keychar = String.fromCharCode(key);
       if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
          return true;
       } else if ((("0123456789").indexOf(keychar) > -1)) {
          return true;
       } else if (decimal && (keychar == ".")) {
          return true;
       } else {
          return false;
       }
    }
 
     function fungsiRupiah(angka){
         var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
         split   		= number_string.split(','),
         sisa     		= split[0].length % 3,
         rupiah     		= split[0].substr(0, sisa),
         ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
         // tambahkan titik jika yang di input sudah menjadi angka ribuan
         if(ribuan){
                 separator = sisa ? '.' : '';
                 rupiah += separator + ribuan.join('.');
         }
         rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
         return rupiah;
     }

     function fungsiRupiah2(angka){
         var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
         split   		= number_string.split(','),
         sisa     		= split[0].length % 3,
         rupiah     		= split[0].substr(0, sisa),
         ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
         if(ribuan){
                 separator = sisa ? ',' : '';
                 rupiah += separator + ribuan.join(',');
         }
         rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
         return rupiah;
     }

   function onkeyupRupiah(id){
      var rupiah = document.getElementById(id);
      rupiah.addEventListener('keyup', function(e){
         rupiah.value = fungsiRupiah(this.value);
      });
      var inputvalue = $('#' + id).val();

      $(`[name="${id}"]`).val(parseInt(inputvalue.toString().includes('.') ? inputvalue.toString().replace(/\./g, '') : inputvalue));   
    }
 
    function convertToAngka(rupiah)
    {
       return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10).toString();
    }
    
 
 </script>
 