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
            console.log(res);
            $('#product_table').html(res);
        })
        return false;
    });
});