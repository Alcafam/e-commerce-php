$( document ).ready(function() {
    $(document).on('click', '.toggle_image', function(){
        console.log('emme')
        let old_view = $('#big_pic').attr('src');
        let new_view = $(this).children('img').attr('src');
        
        $('#big_pic').attr('src', new_view);
        $(this).children('img').attr('src', old_view);
    })
    
    $(document).on('keyup','#quantity',function(){
        let total = (price * $(this).val())
        $('#total_amount').val(total);
    })
});