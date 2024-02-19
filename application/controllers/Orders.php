<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('User');
        $this->load->model('Product');
 	}

     function init(){
		$sess_like_data['name'] = $this->session->userdata('name');
		$sess_like_data['user_id'] = $this->session->userdata('user_id');
        $sess_like_data['role'] = $this->session->userdata('role');
		return $sess_like_data;
	}

	function index(){	
        if(!$this->session->userdata('user_id')){ 
            redirect(base_url('login'));
        }else{
            $view_data=$this->init();
            $view_data['categories'] = $this->Product->get_all_categories();
            $view_data['total'] = count($this->Product->get_all_product());

            $view_data['title'] = "Order Dashboard - Emmeness";
            $this->load->view('layout/header', $view_data);
            $this->load->view('layout/navbar', $view_data);
            $this->load->view('layout/side_nav');
            $this->load->view('layout/order_layout');
        }
	}

    function get_order_html(){
        if($this->input->get()){
            $view_data['products']=$this->Product->get_all_product();
            $view_data['filter'] = "All Products(".count($view_data['products']).")";
        }else{
            $view_data['products']=$this->Product->get_all_product();
            $view_data['filter'] = "All Products(".count($view_data['products']).")";
        }
        $this->load->view('dashboard/order_dashboard', $view_data);
    }

    function get_filtered_orders($filter){
        var_dump($filter);
        die();
    }

}
