$( document ).ready(function() {
    reload_partial();
    function reload_partial(){
        $.post(base_url+'get_profile', function(res) {
            $('#main').html(res);
        });
    }    

    $(document).on('click', '#add_address', function(){
        $('#modal_title').text('ADD ADDRESS');
        $('#add_update_address_modal').modal('show');
    })

    $(document).on('click', '.edit_address', function(){
        let data = {"id":$(this).attr('data_id')};
        $('#modal_title').text('EDIT ADDRESS');
        $('#add_update_form').prepend('<input name="address_id" value="'+data.id+'" hidden>')
        $.post(base_url+'get_address',data, function(res) {
            console.log(res);
            $('#modal_house').val(res.house);
            $('#modal_street').val(res.street);
            $('#modal_barangay').val(res.barangay);
            $('#modal_city').val(res.city);
            $('#modal_province').val(res.province);
            $('#modal_zipcode').val(res.zipcode);

            $('#add_update_address_modal').modal('show');
        },'json');
    })

    $(document).on('hide.bs.modal', '#add_update_address_modal', function(){
        $('#add_update_form').trigger("reset");
        $('#modal_messages').empty();
    })

    $(document).on('hide.bs.modal', '#message_modal', function(){
        reload_partial();
    })

    $(document).on('submit', '#add_update_form', function(){
        let data = $('#add_update_form').serializeArray();
        $.post(base_url+'add_update_address_process', data, function(res) {
            if(res != "success"){
                $('#modal_messages').html(res);
            }else{
                $('#add_update_address_modal').modal('hide');
                $('#message_modal_body').prepend('<h1>Successfully Added an Address!</h1>')
                $('#message_modal').modal('show');
            }
        });
        return false;
    })
});