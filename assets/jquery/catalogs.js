$( document ).ready(function() {
    var category;
    var last_row;
    
    $.post(base_url+'get_catalog_html', function(res) {
        $('#product_cards').html(res);
    });

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

        $.post(base_url+'get_catalog_html',filter, function(res){
            $('#product_cards').html(res);
        })
        return false;
    });
});