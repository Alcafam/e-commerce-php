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

    function load_view($title, $view_data){
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
                $view_data['statuses'] = $this->Product->get_order_count();
                $view_data['total'] = count($this->Product->get_orders());

                $this->load_view("Order Dashboard - Emmeness",$view_data);
                $this->load->view('layout/side_nav');
                $this->load->view('layout/status_layout',$view_data);
            }
        }
	}

    function get_order_html(){
        if($this->input->post()){
            $filters = $this->input->post();
            $view_data['products']=$this->Product->get_filtered_orders($filters);
            $view_data['filter'] = "Search Result (".count($view_data['products']).")";
        }else if(!$this->input->post() && empty($this->input->post('search_filter'))){
            $view_data['products']=$this->Product->get_orders();
            $view_data['filter'] = "All Products(".count($view_data['products']).")";
        }
        $view_data['statuses'] = $this->Product->get_all_status();
        $this->load->view('dashboard/orders_table', $view_data);
    }

}
