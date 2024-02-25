<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('User');
        $this->load->model('Product');
        $this->load->model('Cart');
        define ('SITE_ROOT', realpath(dirname(__FILE__)));
 	}

// =========== INITIALIZER =========== //
    function init(){
		$sess_like_data['name'] = $this->session->userdata('name');
		$sess_like_data['user_id'] = $this->session->userdata('user_id');
        $sess_like_data['role'] = $this->session->userdata('role');
        $sess_like_data['cart_num'] = count($this->Cart->get_carts($this->session->userdata('user_id')));
		return $sess_like_data;
	}
// =========== END OF INITIALIZER =========== //

// =========== VIEW RELATED FUNCTIONS =========== //
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
            $view_data['pages'] = $this->Product->get_pages(count($view_data['products']),5);
            $view_data['filter'] = "Search Result (".count($view_data['products']).")";
        }else if(!$this->input->post('last_row') && empty($this->input->post('search_filter')) && ($this->input->post('category') || !$this->input->post('category'))){
            $view_data['pages'] = $this->Product->get_product_count(5);
            $view_data['products']=$this->Product->get_products(0);
            $view_data['filter'] = "All Products(".count($view_data['products']).")";
        }else{
            $view_data['pages'] = $this->Product->get_product_count(5);
            $view_data['products']=$this->Product->get_products($this->input->post('last_row'));
            $view_data['filter'] = "All Products(".count($view_data['products']).")";
        }
        $this->load->view('dashboard/product_table', $view_data);
    }

    function get_product_details($id){
        $product = $this->Product->get_product_by_id($id);
        echo json_encode($product);
    }

    function view_product($id){
        $view_data = $this->init();
        $view_data['product'] = $this->Product->get_product_by_id($id);
        $view_data['similar_products'] = $this->Product->get_similar_product($id);
        $this->load_view($view_data['product']['product_name'], $view_data);
        if($this->session->userdata('role')==0){
            $this->load->view('layout/user_side_nav', $view_data);
        }else{
            $this->load->view('layout/side_nav', $view_data);
        }
        $this->load->view('dashboard/product_detail', $view_data);
    }
// =========== END OF VIEW RELATED FUNCTIONS =========== //

// =========== CRUDS =========== //
    function add_product(){
        $data = $this->input->post();
        $validation = $this->Product->validate_product($data);
        if($validation!=="success"){
            echo json_encode($validation);
        }else{
            /* FILE UPLOAD */
            $inserted_id = $this->Product->add_product($data);
            $this->save_image($_FILES, $inserted_id);
            echo json_encode("success");
        }
    }

    function delete_image(){
        $data = $this->input->post();
        $check_image = $this->Product->validate_image($data['product_id'],$data['json_index']);
        if($check_image !== "success"){
            echo $check_image;
        }else{
            $success = $this->Product->delete_image($data);
            if($success == true){
                unlink(FCPATH.'assets\images\products/'.$data['product_id'].'/'.$data['name']);
            }
        }
        
    }

    function update_product(){
        $data = $this->input->post();
        $validation = $this->Product->validate_product($data);
        if($validation!=="success"){
            echo json_encode($validation);
        }else{
            /* FILE UPLOAD */
            $id = $data['product_id'];
            if($data['old_main'] && !$_FILES){
                $this->Product->update_main($data);
            }   
            if($_FILES){
                $update = $this->Product->update_image($data);
                $this->save_image($_FILES, $id);
            }
            $update_product = $this->Product->update_product($data);
            echo json_encode("success");
        }
    }

    function save_image($files, $id){
        for($i = 0; $i < count($files['images']['name']); $i++){ 
            $_FILES['images']['name'] = $files['images']['name'][$i]; 
            $_FILES['images']['type'] = $files['images']['type'][$i]; 
            $_FILES['images']['tmp_name'] = $files['images']['tmp_name'][$i]; 
            $_FILES['images']['error'] = $files['images']['error'][$i]; 
            $_FILES['images']['size'] = $files['images']['size'][$i];

            $path= 'assets/images/products/'.$id.'/';
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
            } 
        }
    }

    function add_category(){
        $inserted_id = $this->Product->add_new_category($this->input->post());
        echo json_encode($inserted_id);
    }

// =========== END OF CRUDS =========== //


}

