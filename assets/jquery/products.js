$( document ).ready(function() {
    var category;
    $.post(base_url+'get_product_html', function(res) {
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
        $.post(base_url+'get_product_html',filter, function(res){
            console.log(res);
            $('#product_cards').html(res);
        })
        return false;
    });

    $(document).on('click', '#add_product', function(){
        $('#add_product_modal').modal('show');
    })
});