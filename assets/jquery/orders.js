$( document ).ready(function() {
    var filter = {'search_filter':'','category':''};
    $.get(base_url+'get_order_html', function(res) {
        $('#order_cards').html(res);
    });

    $(document).on('keyup','#search_filter',function(){
        filter.search_filter = ($(this).val());
        filter_order(filter);
    })

    function filter_order(filters){
        $.get(base_url+'get_order_html',filters, function(res){
            $('#order_cards').html(res);
        })
    }
});