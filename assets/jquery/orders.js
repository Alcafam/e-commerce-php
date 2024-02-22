$( document ).ready(function() {
    var status;
    var last_row;
    $.post(base_url+'get_order_html', function(res) {
        $('#product_table').html(res);
    });

    $(document).on('keyup','#search_filter',function(){
        $('#filter_form').submit();        
    })

    $(document).on('click', '.category_button', function(){
        console.log('pressseddd');
        status = $(this).attr('data-id');
        $('#filter_form').submit();
    })

    $(document).on('click','#go_to_page', function(){
        last_row = $(this).attr('data-id');
        $('#filter_form').submit();
    })

    $(document).on('submit', '#filter_form', function(){
        let filter = $("#filter_form").serializeArray();
        filter.push({name: 'status', value: status});
        filter.push({name: 'last_row', value: last_row});
        $.post(base_url+'get_order_html',filter, function(res){
            $('#product_table').html(res);
        })
        return false;
    });

    $(document).on('change', '.edit_status', function(){
        $('#form_order_id').val($(this).attr('data-id'));
        $('#form_status_id').val($(this).val());
        $('#are_you_sure_modal').modal('show');
    })

    $(document).on('submit', '#update_status_form', function(){
        let data = $(this).serializeArray();
        $.post(base_url+'update_status',data, function(res){
            $('#are_you_sure_modal').modal('hide');
            $('#message_modal').modal('show');
        })
        return false;
    });

    $('#message_modal').on('hide.bs.modal', function(){
        $('#filter_form').submit();
    })
});