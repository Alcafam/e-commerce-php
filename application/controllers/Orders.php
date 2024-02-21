<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('User');
        $this->load->model('Order');
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
                $view_data['statuses'] = $this->Order->get_total_orders_per_status();
                $view_data['total'] = $this->Order->get_all_order_count();

                $this->load_view("Order Dashboard - Emmeness",$view_data);
                $this->load->view('layout/side_nav');
                $this->load->view('layout/status_layout',$view_data);
            }
        }
	}

    function get_order_html(){
        $view_data['statuses'] = $this->Order->get_total_orders_per_status();
        $view_data['total'] = $this->Order->get_all_order_count();
        if($this->input->post('status')){
            $view_data['active'] = $this->input->post('status');
        }else{
            $view_data['active'] = '';
        }

        if($this->input->post('search_filter') || $this->input->post('status')){
            $filters = $this->input->post();
            if(empty($filters['last_row'])){
                $filters['last_row']=0;
            }

            $view_data['products']=$this->Order->get_filtered_orders($filters);
            $view_data['pages'] = $this->Order->get_pages(count($view_data['products']));
            $view_data['filter'] = "Search Result (".count($view_data['products']).")";
        }else if(!$this->input->post('last_row') && empty($this->input->post('search_filter')) && ($this->input->post('category') || !$this->input->post('status'))){
            $view_data['pages'] = $this->Order->get_order_count();
            $view_data['products']=$this->Order->get_orders(0);
            $view_data['filter'] = "All Orders(".count($view_data['products']).")";
        }else{
            $view_data['pages'] = $this->Order->get_order_count();
            $view_data['products']=$this->Order->get_orders($this->input->post('last_row'));
            $view_data['filter'] = "All Orders(".count($view_data['products']).")";
        }
        
        $this->load->view('dashboard/orders_table', $view_data);
    }

}
