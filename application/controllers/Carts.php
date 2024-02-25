<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carts extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('User');
        $this->load->model('Cart');
 	}

	function index(){	
        if(!$this->session->userdata('user_id')){ 
            redirect(base_url('login'));
        }else{
            $view_data = $this->init();
            $view_data['title'] = "Cart";
            $view_data['user_id'] = $this->session->userdata('user_id');
            $this->load->view('layout/header', $view_data);
            $this->load->view('layout/navbar', $view_data);
            $this->load->view('layout/user_side_nav', $view_data);
        }
	}

    function get_cart(){
        $view_data['statuses'] = $this->Cart->get_statuses();
        if($this->input->post('status')){
            $view_data['active'] = $this->input->post('status');
            $view_data['carts'] = $this->Cart->get_filtered_carts($this->session->userdata('user_id'), $this->input->post('status'));
        }else{
            $view_data['active'] = "On-Cart";
            $view_data['carts'] = $this->Cart->get_carts($this->session->userdata('user_id'));
        }

        $view_data['total_fee']=0;
        foreach($view_data['carts'] as $cart){
            $view_data['total_fee'] += $cart['total'];
        }

        $this->load->view('dashboard/view_cart',$view_data);
    }

    function add_to_cart(){
        $data = $this->input->post();
        
        $validation = $this->Cart->validate_cart($data);
        if($validation!="success"){
            $this->session->set_flashdata('input_errors', $validation);
        }else{
            $this->Cart->add_to_cart($this->session->userdata('user_id'), $data);
            $this->session->set_flashdata('input_errors', '<div class="alert alert-success" role="alert">Added to Cart!</div>');
        }
        redirect(base_url('view_product/'.$data['product_id']));
    }

    function delete_cart_item($id){
        $this->Cart->delete_cart_item($id);
        redirect(base_url('cart'));
    }

    function validate_information(){
        $data = $this->input->post();
        unset($data['same_as_billing']);
        $validataion = $this->Cart->validate_information($data);
        if($validataion!="success"){
            echo $validataion;
        }else{
            $this->Cart->checkout($data);
            echo "success";
        }
    }

    function receive_item($id){
        $this->Cart->receive_item($id);
        redirect('cart');
    }


    // INITIALIZERS
    function init(){
		$sess_like_data['name'] = $this->session->userdata('name');
		$sess_like_data['user_id'] = $this->session->userdata('user_id');
        $sess_like_data['role'] = $this->session->userdata('role');
        $sess_like_data['cart_num'] = count($this->Cart->get_carts($this->session->userdata('user_id')));
		return $sess_like_data;
	}
}
