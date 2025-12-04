<?php
?>
<script>
    $(document).ready(function (){
        get_documan(1,20,0,0);
    });
    function get_documan(page,shownumber,file_category_id,search)
    {
        $.ajax({

            'url':'/dokuman/get',
            'type':'POST',
            'data':'page='+page+'&shownumber='+shownumber+'&file_category_id='+file_category_id+'&search='+search+'&_token={{csrf_token()}}',
            'success':function(e)
            {
                $('#dokuman_tablo').html(e);
            }
        });
    }


    function file_upload(page,shownumber,file_category_id,search,title,file_id,file_name_id,file_obj,explain)
    {

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: "Dosya Güncelleme",
            text: title+" isimli Dosyanızı güncellemek istiyor musunuz?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Evet Güncelle!",
            cancelButtonText: "Hayır Kapat",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                var formData = new FormData();
                formData.append('_token','{{csrf_token()}}')
                formData.append('file',file_obj[0]);
                formData.append('file_id',file_id);
                formData.append('file_name_id',file_name_id);
                formData.append('revision_explain',explain);

                $.ajax({
                    url: "/dokuman/upload",
                    type: "POST",
                    data : formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {

                    },
                    success: function(data){

                        swalWithBootstrapButtons.fire({
                            title: "BAŞARILI",
                            text: "Başarılı bir şekilde doküman güncellendi",
                            icon: "success"
                        });
                        get_documan(page,shownumber,file_category_id,search);

                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }


                });

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire({
                    title: "İPTAL EDİLDİ",
                    text: "İşlem iptal edildi",
                    icon: "error"
                });
            }
        });



    }

    function show_versions(file_name_id,file_name)
    {
        $('#revisionModal #doc_title').html(file_name+' Dokümanı');
        get_revisions(1,0,file_name_id);
        $('#revisionModal').modal('show');

    }
    function get_revisions(page,shownumber,file_name_id)
    {
        $.ajax({

            'url':'/dokuman/getversions',
            'type':'POST',
            'data':'page='+page+'&shownumber='+shownumber+'&file_name_id='+file_name_id+'&_token={{csrf_token()}}',
            'success':function(e)
            {
                $('#revisionModal #doc_versions').html(e);
            }
        });
    }

    function open_update_filename_modal(page,shownumber,file_category_id,search,file_name_id)
    {
        $.ajax({

            'url':'/dokuman/getfilename',
            'type':'POST',
            'data':'file_name_id='+file_name_id+'&_token={{csrf_token()}}',
            'success':function(e)
            {

                $('#updatefilenamemodal #page').val(page);
                $('#updatefilenamemodal #shownumber').val(shownumber);
                $('#updatefilenamemodal #file_category_id').val(file_category_id);
                $('#updatefilenamemodal #search').val(search);
                $('#updatefilenamemodal #form_name_id').val(file_name_id);
                $('#updatefilenamemodal #form_name').val(e);
                $('#updatefilenamemodal').modal('show');
            }
        });
    }
    function update_filename(page,shownumber,file_category_id,search,file_name_id,new_file_name)
    {
        $.ajax({

            'url':'/dokuman/updatefilename',
            'type':'POST',
            'data':'file_name_id='+file_name_id+'&new_file_name='+new_file_name+'&_token={{csrf_token()}}',
            'success':function(e)
            {
                Swal.fire({
                    'icon':'success',
                    'title':'Başarılı',
                    'text':e
                });
                get_documan(page,shownumber,file_category_id,search);
                $('#updatefilenamemodal').modal('hide');
            },
            'error':function(response){
                var str='';
                var errors=response.responseJSON.errors;
                for(err in errors)
                {
                    str+='<p>'+errors[err][0]+'</p>';
                }
                $('#updatefilenamemodal #err').html(str);
            }
        });
    }
</script>

