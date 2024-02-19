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

    function load_view($title){
        $view_data['title'] = $title;
        $this->load->view('layout/header', $view_data);
        $this->load->view('layout/navbar', $view_data);
    }

	function index(){	
        if(!$this->session->userdata('user_id')){ 
            redirect(base_url('login'));
        }else{
            if($this->session->userdata('user_id') == 0){
                redirect(base_url('catalog'));
            }else{
                $view_data=$this->init();
                $view_data['statuses'] = $this->Product->get_all_status();
                $view_data['total'] = count($this->Product->get_all_product());

                $this->load_view("Order Dashboard - Emmeness");
                $this->load->view('layout/side_nav');
                $this->load->view('layout/status_layout',$view_data);
            }
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
        $this->load->view('dashboard/product_dashboard', $view_data);
    }

    function get_filtered_orders($filter){
        var_dump($filter);
        die();
    }

}
