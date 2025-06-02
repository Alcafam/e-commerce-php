<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('User');
        $this->load->model('Cart');
 	}

	function index(){	
        if(!$this->session->userdata('user_id')){ 
            redirect(base_url('login'));
        }else{
            redirect(base_url('dashboard'));
        }
	}

    // LOGIN
	function login(){
        if(!$this->session->userdata('user_id')){ 
            $title['title'] = "Login - Emmeness";
			$this->load->view('layout/header', $title);
			$this->load->view('authentication/login');
        }else{
            redirect(base_url('dashboard'));
        }
	}

	function login_process(){
		$result = $this->User->validate_signin_form();
        if($result != 'success'){
            $this->session->set_flashdata('input_errors', $result);
            redirect(base_url('login'));
        }else{
            $email = $this->input->post('email');
            $user = $this->User->get_user_by_email($email);

            $result = $this->User->validate_signin_match($user, $this->input->post('password'));
            if($result == "success"){
                $this->init_sessions($user);
                redirect(base_url('dashboard'));
            }else{
                $this->session->set_flashdata('input_errors', $result);
                redirect(base_url("login"));
            }
        }
	}

    // REGISTRATION OR NEW USER
    function register(){
        if(!$this->session->userdata('user_id')){ 
            $title['title'] = "Sign up - Emmeness";
			$this->load->view('layout/header', $title);
			$this->load->view('authentication/registration');
        }else{
            redirect(base_url('dashboard'));
        }
    }

    function registration_process(){
        $result = $this->User->validate_registration($this->input->post('email'));
        
        if($result!='success'){
            $this->session->set_flashdata('input_errors', $result);
            redirect(base_url("registration"));
        }else{
            $form_data = $this->input->post();
            $this->User->create_user($form_data);

            $new_user = $this->User->get_user_by_email($form_data['email']);
            $this->init_sessions($new_user);
			redirect(base_url('dashboard'));
        }
	}

    // LOGOUT
    public function logout() 
    {
        $this->session->sess_destroy();
        redirect(base_url());   
    }

    // DASHBOARD
    function dashboard(){
        if(!$this->session->userdata('user_id')){
            redirect(base_url('login'));
        }else{
            if($this->session->userdata('role')==1){
                redirect(base_url('orders'));
            }else{
                redirect(base_url('catalog'));
            }
        }
	}

    // VIEW PROFILE
    function profile_layout(){
        $view_data['title'] = "Profile";
        $view_data['cart_num'] = count($this->Cart->get_carts($this->session->userdata('user_id')));
        $view_data['user_id'] = $this->session->userdata('user_id');
        $this->load->view('layout/header', $view_data);
        $this->load->view('layout/navbar', $view_data);
        $this->load->view('layout/user_side_nav', $view_data);
    }

    function get_profile(){
        $view_data['profile'] = $this->User->get_user_by_id($this->session->userdata('user_id'));
        $this->load->view('dashboard/view_user_profile',$view_data);
        $this->load->view('modals/add_update_address');
    }

    function get_address(){
        $id = $this->input->post();
        $address=$this->User->get_address_by_id($id['id']);
        echo json_encode($address);
    }

    function add_update_address_process(){
        $data=$this->input->post();
        $validation = $this->User->validate_address();
        if($validation!="success"){
            echo $validation;
        }else{
            if(isset($data['address_id'])){
                $this->User->edit_address($data);
            }else{
                $this->User->add_address($this->session->userdata('user_id'), $data);
            }
            echo "success";
        }
    }

    // INITIALIZERS
    function init_sessions($user){
        $this->session->set_userdata(array(
            'user_id'=>$user[0]['id'], 
            'name' => $user[0]['first_name'].' '.$user[0]['last_name'],
            'role' => $user[0]['is_admin']
        )); 
    }
}
