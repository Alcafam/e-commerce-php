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
        filter.push({name: 'category', value: category});
        filter.push({name: 'last_row', value: last_row});

        $.post(base_url+'get_product_table',filter, function(res){
            console.log('emme')
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
        let id = $(this).attr('data-id');
        $('#modal_title').text('UPDATE PRODUCT');
        $('#submit_modal_btn').attr('value', "UPDATE");
        $('#add_update_form').prepend('<input id="form_product_id" name="product_id" value="'+$(this).attr('data-id')+'" hidden>')
        $.get(base_url+'get_product_details/'+id, function(res){
            $('#product_cards').html(res);
            $('#modal_product').val(res.product_name);
            $('#modal_description').val(res.description);
            $("#modal_category option[value="+res.category_id+"]").attr('selected','selected');
            $('#modal_price').val(res.price);
            $('#modal_stock').val(res.stock);
            set_update_frames(res.images)
        },'json')
        $('#add_update_product_modal').modal('show');
    })

    // ADD IMAGE PREVIEW
    $(document).on('change', '#modal_image', function(){
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
    $(document).on('click', '.remove_saved_image', function(){
        let index = $(this).attr('data-id');
        let data = {
            "name": $(this).attr('data'),
            "product_id": $(this).attr('id'),
            "index" : index,
            "json_index": parseInt(index)-1
        }
        let button = $(this);
        $.post(base_url+'delete_image', data, function(res){
            button.parent().remove();
            $('.saved_images').each(function(key, value) {
                $(this).children('.remove_saved_image').attr('data-id', key);
            })
        })
    })

    // UPDATE IMAGE PREVIEW
    function set_update_frames(paths){
        $.each(paths, function(key, value) {
            $("#update_frames").append(
                '<div class="d-inline-block position-relative me-3 border border-1 border-dark saved_images" style="width:150px; height:150px">' +
                    '<a href="javascript:void(0)" class="absolute-cat-num remove_saved_image btn btn-danger" id="'+value.id+'" data="'+value.name+'" data-id="'+key+'">x</a>'+
                        '<img src="'+value.path+'"  class="img-fluid"/>' +
                    '<div class="position-absolute sticky-bottom main_div_'+key+'">'+
                    '</div>'+
                '</div>'
            );
            if(key == 0){
                $(".main_div_"+key).append(
                    '<input type="checkbox" class="main_pic" name="main_pic" value="'+key+'" checked >Mark as main'
                );
            }else{
                $(".main_div_"+key).append(
                    '<input type="checkbox" class="main_pic" name="main_pic" value="'+key+'" >Mark as main'
                );
            }
        });
    }
    

// AJAX
    $(document).on('submit', '#add_update_form', function(){
        let form_data = new FormData();
        let url;
        for (var index = 0; index < files.length; index++) {
            form_data.append("images[]", files[index]);
        }
        form_data.append('name', $('#modal_product').val());
        form_data.append('description', $('#modal_description').val());
        form_data.append('price', $('#modal_price').val());
        form_data.append('stock', $('#modal_stock').val());
        form_data.append('category', $('#modal_category').val());
        form_data.append('main', $('.main_pic:checked').val());  

        if($('#submit_modal_btn').val() == "ADD"){
            url = "add_product"
        }else{
            url = "update_product";
            form_data.append('product_id', $('#form_product_id').val());
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
        $('#update_frames').empty();
        $('#frames').empty();
        $('#modal_messages').empty();
        // $('#filter_form').submit();
    })

    $(document).on('change', '.main_pic', function(){
        $('.main_pic').not(this).prop('checked', false);     
    })
});