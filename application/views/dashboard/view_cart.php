<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="cart_div" class="row">
    <div class="col-2">
        <form method="POST" id="filter_form">
<?php       foreach($statuses as $status){
?>          <a href="javascript:void(0)" class="category_button text-white text-decoration-none py-3 my-1 rounded-2 text-center w-50 <?= ($active == $status['status'])?'active':'' ?>" data-id="<?= $status['status'] ?>">
                <span><?= $status['status'] ?></span>
            </a>
<?php   }
?>            
        </form>

    </div>

    <div class="<?= ($active == "On-Cart")? 'col-6':'col' ?>">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" width="50%">Order</th>
                    <th scope="col" width="20%">Unit Price</th>
                    <th scope="col" width="20%">Total Price</th>
<?php               if($active == "On-Cart"){
?>                    <th scope="col" width="10%"></th>
<?php               }
                    if($active == "Shipped"){
?>                    <th scope="col" width="10%"></th>
<?php               }
?>
                </tr>
            </thead>
            <tbody>
<?php           foreach($carts as $cart){
?>              <tr>
                    <th class="align-middle">
                        <img height="100px" src="<?= base_url('assets/images/products/'.$cart['product_id'].'/'.$cart['main_pic']) ?>">
                        <?= $cart['product_name'] ?> (<?= $cart['quantity'] ?>)
                    </th>
                    <td class="align-middle">&#8369; <?= number_format($cart['price'],2) ?></td>
                    <td class="align-middle">&#8369; <?= number_format(($cart['price']*$cart['quantity']), 2) ?></td>
<?php               if($active == "On-Cart"){
?>                    <td class="align-middle"><a href="<?= base_url('delete_cart_item/'.$cart['cart_id']) ?>"><i class="fa-solid fa-xmark fa-2xl"></i></a></td>
<?php               }
?>              
<?php               if($active == "Shipped"){
?>                  <td class="align-middle"><a href="<?= base_url('receive_item/'.$cart['cart_id']) ?>" id="item_received" class="btn btn-success">Received</a></td>
<?php               }
?>
                </tr>
<?php   }
?>          </tbody>
        </table>
    </div>
<?php   if($active == "On-Cart"){
?> 
    <div class="col">
        <h1 class="fs-4">Checkout</h1>
        <form id="checkout_form">
            <div class="row" id="shipping">
                <p class="fw-bold fs-5 d-inline-block w-50">Shipping Information</p> 
                <div class="d-inline-block w-50"><input type="checkbox" class="me-2" id="same_as_billing" name="same_as_billing" checked>Same as billing</div>
                <div class="col mb-2">
                    <input type="text" class="form-control" placeholder="First name" aria-label="First name" id="first_name" name="shipping[first_name]">
                </div>
                <div class="col mb-2">
                    <input type="text" class="form-control" placeholder="Last name" aria-label="Last name" id="last_name" name="shipping[last_name]">
                </div>
                <div class="col-12 mb-2">
                    <input type="text" class="form-control" id="address_1" name="shipping[address_1]" placeholder="Address 1">
                </div>
                <div class="col-12 mb-2">
                    <input type="text" class="form-control" id="address_2" name="shipping[address_2]" placeholder="Address 2">
                </div>
                <div class="col mb-2">
                    <input type="text" class="form-control" placeholder="City" aria-label="City" id="city" name="shipping[city]">
                </div>
                <div class="col mb-2">
                    <input type="text" class="form-control" placeholder="State" aria-label="State" id="state" name="shipping[state]">
                </div>
                <div class="col mb-2">
                    <input type="text" class="form-control" placeholder="Zipcode" aria-label="Zipcode" id="zipcode" name="shipping[zipcode]">
                </div>
            </div>
            
            <div id="order_summary">
                <p class="fw-bold fs-5">Order Summary</p>
                <div class="row">
                    <div class="col fw-bold">Items</div>
                    <div class="col" id="items">&#8369; <?= number_format($total_fee,2) ?></div>
                </div>
                <div class="row">
                    <div class="col fw-bold">Shipping Fee</div>
                    <div class="col" id="shipping_fee">&#8369; 250.00</div>
                </div>
                <div class="row">
                    <div class="col fw-bold">Total Amount</div>
                    <div class="col" id="total_amount" data = "<?= $total_fee + 250 ?>">&#8369; <?= number_format($total_fee + 250,2) ?></div>
                </div>
            </div>
        </form>
        <button id="proceed_checkout" class="btn btn-success">Proceed to Checkout</button>
        <div id="message_area"></div>
    </div>
</div>

<div class="modal" tabindex="-1" id="payment_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body bg-white">
<?php           if($this->session->flashdata('success')){ ?>
                <div class="alert alert-success text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <p><?php echo $this->session->flashdata('success'); ?></p>
                </div>
<?php } ?>
                <form role="form" action="<?php echo base_url('handleStripePayment');?>" method="post" class="form-validation" data-cc-on-file="false" data-stripe-publishable-key="<?php echo $this->config->item('stripe_key') ?>" id="payment-form">
                    <div class='form-row row'>
                        <div class='col-xs-12 form-group required'>
                            <label class='control-label'>Name on Card</label>
                            <input class='form-control' size='4' type='text'>
                        </div>
                    </div>
                    <div class='form-row row'>
                        <div class='col-xs-12 form-group  bg-white'>
                            <label class='control-label'>Card Number</label>
                            <input autocomplete='off' class='form-control card-number' size='20' type='text'>
                        </div>
                    </div>
                    <div class='form-row row'>
                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                            <label class='control-label'>CVC</label>
                            <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311'
                                size='4' type='text'>
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label class='control-label'>Expiration Month</label>
                            <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label class='control-label'>Expiration Year</label>
                            <input class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                type='text'>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-xs-12 text-end">
                            <input class="btn btn-success btn-lg btn-block" type="submit" id="submit_payment" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
    var checkout_info;
    var $stripeForm = $(".form-validation");

    $(document).on('change', '#same_as_billing', function(){
        $('#message_area').empty();
        if(!$('#same_as_billing').is(':checked')){
            $( '<div class="row" id="billing">'+
                '<p class="fw-bold fs-5">Billing Information</p>'+
                '<div class="col mb-2">'+
                    '<input type="text" class="form-control" placeholder="First name" aria-label="First name" id="b_first_name" name="billing[first_name]">'+
                '</div>'+
                '<div class="col mb-2">'+
                    '<input type="text" class="form-control" placeholder="Last name" aria-label="Last name" id="b_last_name" name="billing[last_name]">'+
                '</div>'+
                '<div class="col-12 mb-2">'+
                    '<input type="text" class="form-control" id="b_address_1" name="billing[address_1]" placeholder="Address 1">'+
                '</div>'+
                '<div class="col-12 mb-2">'+
                    '<input type="text" class="form-control" id="b_address_2" name="billing[address_2]" placeholder="Address 2">'+
                '</div>'+
                '<div class="col mb-2">'+
                    '<input type="text" class="form-control" placeholder="City" aria-label="City" id="b_city" name="billing[city]">'+
                '</div>'+
                '<div class="col mb-2">'+
                    '<input type="text" class="form-control" placeholder="State" aria-label="State" id="b_state" name="billing[state]">'+
                '</div>'+
                '<div class="col mb-2">'+
                    '<input type="text" class="form-control" placeholder="Zipcode" aria-label="Zipcode" id="b_zipcode" name="billing[zipcode]">'+
                '</div>'+
            '</div>' ).insertAfter( "#shipping" );
        }else if($('#myCheckbox').prop('checked', true)){
            $('#billing').remove();
        }
    })
    $(document).on('click', '#proceed_checkout', function(){
        checkout_info = $('#checkout_form').serializeArray();
        $('#message_area').empty();
        $.post(base_url+'validate_information', checkout_info, function(res){
            if(res !== "success"){
                $('#message_area').html(res);
            }else{
                $('#submit_payment').val('Pay '+ $('#total_amount').attr('data'))
                $('#payment_modal').modal('show');
            }
        })
    })

    // STRIPE THINGY
		$('form.form-validation').bind('submit', function (e) {
			var $stripeForm = $(".form-validation"),
				inputSelector = ['input[type=email]', 'input[type=password]',
					'input[type=text]', 'input[type=file]',
					'textarea'
				].join(', '),
				$inputs = $stripeForm.find('.required').find(inputSelector),
				$errorMessage = $stripeForm.find('div.error'),
				valid = true;
			$errorMessage.addClass('hide');
			$('.has-error').removeClass('has-error');
			$inputs.each(function (i, el) {
				var $input = $(el);
				if ($input.val() === '') {
					$input.parent().addClass('has-error');
					$errorMessage.removeClass('hide');
					e.preventDefault();
				}
			});
			if (!$stripeForm.data('cc-on-file')) {
				e.preventDefault();
				Stripe.setPublishableKey($stripeForm.data('stripe-publishable-key'));
				Stripe.createToken({
					number: $('.card-number').val(),
					cvc: $('.card-cvc').val(),
					exp_month: $('.card-expiry-month').val(),
					exp_year: $('.card-expiry-year').val()
				}, stripeResponseHandler);
			}
		});

		function stripeResponseHandler(status, res) {
			if (res.error) {
				$('.error')
					.removeClass('hide')
					.find('.alert')
					.text(res.error.message);
			} else {
				var token = res['id'];
				$stripeForm.find('input[type=text]').empty();
				$stripeForm.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
				$stripeForm.get(0).submit();
			}
		}
</script>
<?php   }
?>