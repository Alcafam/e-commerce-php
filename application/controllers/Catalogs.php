<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogs extends CI_Controller {

	function __construct(){
		parent::__construct();
        $this->load->model('Catalog');
        $this->load->model('Product');
        $this->load->model('Cart');
 	}

    function init(){
		$sess_like_data['name'] = $this->session->userdata('name');
		$sess_like_data['user_id'] = $this->session->userdata('user_id');
        $sess_like_data['role'] = $this->session->userdata('role');
        $sess_like_data['cart_num'] = count($this->Cart->get_carts($this->session->userdata('user_id')));
		return $sess_like_data;
	}

	function index(){	
        if(!$this->session->userdata('user_id')){ 
            redirect(base_url('login'));
        }else{
            if($this->session->userdata('user_id') == 1){
                redirect(base_url('orders'));
            }else{
                $view_data=$this->init();
                
                $view_data['title'] = "Order Dashboard - Emmeness";
                $this->load->view('layout/header', $view_data);
                $this->load->view('layout/navbar', $view_data);
                $this->load->view('layout/user_side_nav', $view_data);
                $this->load->view('layout/category_layout');
            }
        }
	}

    function get_catalog_html(){
        $view_data['categories'] = $this->Product->get_all_categories();
        $view_data['total'] = $this->Product->get_total_product();

        if($this->input->post('category')){
            $view_data['active'] = $this->input->post('category');
        }else{
            $view_data['active'] = '';
        }

        if($this->input->post('search_filter') || $this->input->post('category')){
            $filters = $this->input->post();
            if(empty($filters['last_row'])){
                $filters['last_row']=0;
            }

            $view_data['products'] = $this->Catalog->get_filtered_catalog($filters);
            $view_data['pages'] = $this->Product->get_pages(count($view_data['products']),8);
            $view_data['filter'] = "Search Result(".count($view_data['products']).")";
            
        }else if(!$this->input->post('last_row') && empty($this->input->post('search_filter')) && ($this->input->post('category') || !$this->input->post('category'))){
            $view_data['pages'] = $this->Product->get_product_count(8);
            $view_data['products']=$this->Catalog->get_all_products(0,8);
            $view_data['filter'] = "All Products(".count($view_data['products']).")";
        }else{
            $view_data['pages'] = $this->Product->get_product_count(8);
            $view_data['products'] = $this->Catalog->get_all_products($this->input->post('last_row'),8);
            $view_data['filter'] = "All Products(".count($view_data['products']).")";
        }
        $this->load->view('dashboard/product_dashboard', $view_data);
    }

    

}
