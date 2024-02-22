<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('User');
        $this->load->model('Product');
        define ('SITE_ROOT', realpath(dirname(__FILE__)));
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
        $view_data = $this->init();
        $view_data['categories'] = $this->Product->get_all_categories();

        $this->load_view("Product Dashboard - Emmeness", $view_data);
        $this->load->view('layout/side_nav');
        $this->load->view('layout/category_layout',$view_data);
        $this->load->view('modals/add_product_modal');
    }

    function get_product_table(){
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
            $view_data['products']=$this->Product->get_filtered_product($filters);
            $view_data['pages'] = $this->Product->get_pages(count($view_data['products']));
            $view_data['filter'] = "Search Result (".count($view_data['products']).")";
        }else if(!$this->input->post('last_row') && empty($this->input->post('search_filter')) && ($this->input->post('category') || !$this->input->post('category'))){
            $view_data['pages'] = $this->Product->get_product_count();
            $view_data['products']=$this->Product->get_all_product(0);
            $view_data['filter'] = "All Products(".count($view_data['products']).")";
        }else{
            $view_data['pages'] = $this->Product->get_product_count();
            $view_data['products']=$this->Product->get_all_product($this->input->post('last_row'));
            $view_data['filter'] = "All Products(".count($view_data['products']).")";
        }
        $this->load->view('dashboard/product_table', $view_data);
    }

    function add_product(){
        $data = $this->input->post();
        $validation = $this->Product->validate_product($data);
        if($validation!=="success"){
            echo json_encode($validation);
        }else{
            /* FILE UPLOAD */
            $inserted_id = $this->Product->add_product($data);
            $files = $_FILES;
            for($i = 0; $i < count($files['images']['name']); $i++){ 
                
                $_FILES['images']['name'] = $files['images']['name'][$i]; 
                $_FILES['images']['type'] = $files['images']['type'][$i]; 
                $_FILES['images']['tmp_name'] = $files['images']['tmp_name'][$i]; 
                $_FILES['images']['error'] = $files['images']['error'][$i]; 
                $_FILES['images']['size'] = $files['images']['size'][$i];

                $path= 'assets/images/products/'.$inserted_id.'/';
                $config['upload_path'] = $path;  
                $config['allowed_types'] = 'gif|jpg|png';
                $config['overwrite'] = TRUE;
                $config['remove_spaces'] = FALSE;

                if(!is_dir($path)){
                    mkdir($path,0655,true);
                }

                $this->load->library('upload', $config); 
                $this->upload->initialize($config); 

                if(!$this->upload->do_upload('images')){ 
                    $error = array('error' => $this->upload->display_errors());
                    var_dump($error);  
                } 
            }
            echo json_encode("success");
        }
    }

    function get_product_details($id){
        $product = $this->Product->get_product_by_id($id);
        echo json_encode($product);
    }

    function delete_image(){
        $data = $this->input->post();
        $success = $this->Product->delete_image($data);
        if($success == true){
            unlink(FCPATH.'assets\images\products/'.$data['product_id'].'/'.$data['name']);
        }
    }

    function update_product(){
        $data = $this->input->post();
        $validation = $this->Product->validate_product($data);
        if($validation!=="success"){
            echo json_encode($validation);
        }else{
            echo json_encode("emmmeee");
            /* FILE UPLOAD */
            // $inserted_id = $this->Product->add_product($data);
            // $files = $_FILES;
            // for($i = 0; $i < count($files['images']['name']); $i++){ 
                
            //     $_FILES['images']['name'] = $files['images']['name'][$i]; 
            //     $_FILES['images']['type'] = $files['images']['type'][$i]; 
            //     $_FILES['images']['tmp_name'] = $files['images']['tmp_name'][$i]; 
            //     $_FILES['images']['error'] = $files['images']['error'][$i]; 
            //     $_FILES['images']['size'] = $files['images']['size'][$i];

            //     $path= 'assets/images/products/'.$inserted_id.'/';
            //     $config['upload_path'] = $path;  
            //     $config['allowed_types'] = 'gif|jpg|png';
            //     $config['overwrite'] = TRUE;
            //     $config['remove_spaces'] = FALSE;

            //     if(!is_dir($path)){
            //         mkdir($path,0655,true);
            //     }

            //     $this->load->library('upload', $config); 
            //     $this->upload->initialize($config); 

            //     if(!$this->upload->do_upload('images')){ 
            //         $error = array('error' => $this->upload->display_errors());
            //         var_dump($error);  
            //     } 
            // }
            // echo json_encode("success");
        }
        // var_dump($validation);
    }
}

