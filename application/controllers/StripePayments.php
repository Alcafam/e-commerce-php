<?php
defined('BASEPATH') OR exit('No direct script access allowed');
   
class StripePayments extends CI_Controller {
    
    public function __construct() {
       parent::__construct();
       $this->load->library("session");
       $this->load->helper('url');
       $this->load->model('Cart');
    }
    
    public function handlePayment()
    {
        require_once('application/libraries/stripe-php/init.php');
    
        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
     
        \Stripe\Charge::create ([
                "amount" => 100 * 120,
                "currency" => "inr",
                "source" => $this->input->post('stripeToken'),
                "description" => "Dummy stripe payment." 
        ]);
        
        $this->session->set_flashdata('input_errors', '<div class="alert alert-success" role="alert">Payment Successful!</div>');
             
        redirect('cart');
    }
}