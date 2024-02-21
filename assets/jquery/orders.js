$( document ).ready(function() {
    var status;
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

    $(document).on('submit', '#filter_form', function(){
        let filter = $("#filter_form").serializeArray();
        filter.push({name: 'status', value: status});
        $.post(base_url+'get_order_html',filter, function(res){
            console.log(res);
            $('#product_table').html(res);
        })
        return false;
    });
});