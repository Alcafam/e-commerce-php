$( document ).ready(function() {
    var filter = {'search_filter':'','category':''};
    $.get(base_url+'get_product_html', function(res) {
        $('#product_cards').html(res);
    });

    $(document).on('keyup','#search_filter',function(){
        filter.search_filter = ($(this).val());
        filter_order(filter);
    })
    $(document).on('click', '.category_button', function(){
        filter.category = ($(this).attr('data-id'));
        filter_order(filter);
    })

    function filter_order(filters){
        $.post(base_url+'get_product_html',filters, function(res){
            $('#product_cards').html(res);
        })
    }
});