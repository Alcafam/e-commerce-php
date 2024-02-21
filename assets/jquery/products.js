$( document ).ready(function() {
    var category;
    $.post(base_url+'get_product_table', function(res) {
        $('#product_cards').html(res);
    });

    $(document).on('keyup','#search_filter',function(){
        $('#filter_form').submit();        
    })
    $(document).on('click', '.category_button', function(){
        category = $(this).attr('data-id');
        $('#filter_form').submit();
    })

    $(document).on('submit', '#filter_form', function(){
        let filter = $("#filter_form").serializeArray();
        console.log(filter);
        filter.push({name: 'category', value: category});
        $.post(base_url+'get_product_table',filter, function(res){
            console.log(res);
            $('#product_cards').html(res);
        })
        return false;
    });

    $(document).on('click', '#add_product', function(){
        $('#modal_title').text('ADD PRODUCT');
        $('#add_update_product_modal').modal('show');
    })

    $(document).on('click', '.edit_product', function(){
        $('#modal_title').text('UPDATE PRODUCT');
        $('#add_update_product_modal').modal('show');
    })

    $('#add_update_product_modal').on('hide.bs.modal', function(){
        $('#add_update_form').trigger("reset");
    })
});