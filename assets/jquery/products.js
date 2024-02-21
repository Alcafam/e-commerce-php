$( document ).ready(function() {
    var category;
    var last_row;
    var files = [];

// ON PAGE RELOAD
    $.post(base_url+'get_product_table', function(res) {
        $('#product_cards').html(res);
    });

// FILTER EVENTS
    $(document).on('keyup','#search_filter',function(){
        $('#filter_form').submit();        
    })

    $(document).on('click', '.category_button', function(){
        category = $(this).attr('data-id');
        last_row = null;
        $('#filter_form').submit();
    })
    
    $(document).on('click','#go_to_page', function(){
        last_row = $(this).attr('data-id');
        $('#filter_form').submit();
    })

    $(document).on('submit', '#filter_form', function(){
        let filter = $("#filter_form").serializeArray();
        console.log(filter);
        filter.push({name: 'category', value: category});
        filter.push({name: 'last_row', value: last_row});
        $.post(base_url+'get_product_table',filter, function(res){
            $('#product_cards').html(res);
        })
        return false;
    });

// CRUD EVENTS
    $(document).on('click', '#add_product', function(){
        $('#submit_modal_btn').attr('value', "ADD");
        $('#modal_title').text('ADD PRODUCT');
        $('#add_update_product_modal').modal('show');
    })

    $(document).on('click', '.edit_product', function(){
        $('#modal_title').text('UPDATE PRODUCT');
        $('#submit_modal_btn').attr('value', "UPDATE");
        $('#submit_modal_btn').attr('data-id', $(this).attr('data-id'));
        $('#add_update_product_modal').modal('show');
    })

    // IMAGE PREVIEW
    $(document).on('change', '#image', function(){
        $("#frames").html('');
        for (var i = 0; i < $(this)[0].files.length; i++) {
            files.push($(this)[0].files[i]);
            $("#frames").append(
                '<div class="d-inline-block position-relative me-3 border border-1 border-dark" style="width:150px; height:150px">' +
                    '<a href="javascript:void(0)" class="absolute-cat-num remove_image btn btn-danger" data-id="'+i+'">x</a>'+
                        '<img src="'+window.URL.createObjectURL($(this)[0].files[i])+'"  class="img-fluid"/>' +
                    '<div class="position-absolute sticky-bottom">'+
                        '<input type="checkbox" class="main_pic" name="main_pic" value="'+i+'">Mark as main</div>'+
                '</div>'
            );
        }
    })

    $(document).on('click', '.remove_image', function(){
        let index = $(this).attr('data-id');
        files.splice(index, 1);
        $(this).parent().remove();
    })

// AJAX
    $(document).on('submit', '#add_update_form', function(){
        let form_data = new FormData();
        let url;
        for (var index = 0; index < files.length; index++) {
            form_data.append("images[]", files[index]);
        }
        form_data.append('name', $('#product').val());
        form_data.append('description', $('#description').val());
        form_data.append('price', $('#price').val());
        form_data.append('stock', $('#stock').val());
        form_data.append('category', $('#category').val());
        form_data.append('main', $('.main_pic:checked').val());  

        if($('#submit_modal_btn').val() == "ADD"){
            url = "add_product"
        }else{
            url = "update_product/"+$(this).attr('data-id');
        }

        $.ajax({
            url: base_url+url, 
            type: 'POST',
            data: form_data,
            dataType: 'json',
            contentType: false,  
            cache: false,  
            processData:false,  
            success: function (response){
                if(response != "success"){
                    $('#modal_messages').html(response);
                }else{
                    $('#add_update_product_modal').modal('hide');
                    $('#message_modal_body').html('<h1>SUCCESSFULLY ADDED A PRODUCT</h1>');
                    $('#message_modal').modal('show');
                }
            }, error:function(error){
                $('#product_cards').html(error.responseText);
            }
        });
        return false;
    })

// ON MODAL CLOSE & STYLING EVENTS
    $('#message_modal').on('hide.bs.modal', function(){
        $('#filter_form').submit();
    })

    $('#add_update_product_modal').on('hide.bs.modal', function(){
        $('#add_update_form').trigger("reset");
        $('#frames').empty();
        $('#modal_messages').empty();
    })

    $(document).on('change', '.main_pic', function(){
        $('.main_pic').not(this).prop('checked', false);     
    })
});