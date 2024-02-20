<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('User');
        $this->load->model('Product');
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
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
        $view_data = $this->init();
        $view_data['categories'] = $this->Product->get_all_categories();
        $view_data['total'] = count($this->Product->get_all_product());

        $this->load_view("Product Dashboard - Emmeness");
        $this->load->view('layout/side_nav');
        $this->load->view('layout/category_layout',$view_data);
    }

    function get_product_html(){
        if($this->input->post()){
            $filters = $this->input->post();
            $view_data['products']=$this->Product->get_filtered_product($filters);
            if(!empty($filters['search_filter'])){
                $view_data['filter'] = $filters['category']." (".count($view_data['products']).")";
            }else{
                $view_data['filter'] = "Search Result (".count($view_data['products']).")";
            }
        }else{
            $view_data['products']=$this->Product->get_all_product();
            $view_data['filter'] = "All Products(".count($view_data['products']).")";
        }
        $this->load->view('dashboard/product_dashboard', $view_data);
    }

    function get_product_table(){
        if($this->input->post()){
            $filters = $this->input->post();
            $view_data['products']=$this->Product->get_filtered_product($filters);
            if(!empty($filters['search_filter'])){
                $view_data['filter'] = $filters['category']." (".count($view_data['products']).")";
            }else{
                $view_data['filter'] = "Search Result (".count($view_data['products']).")";
            }
        }else{
            $view_data['products']=$this->Product->get_all_product();
            $view_data['filter'] = "All Products(".count($view_data['products']).")";
        }
        $this->load->view('dashboard/product_table', $view_data);
    }
}
