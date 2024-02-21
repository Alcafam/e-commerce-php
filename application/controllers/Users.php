<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('User');
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
            if($view_data['role']==1){
                redirect(base_url('orders'));
            }else{
                redirect(base_url('catalog'));
            }
        }
	}

    // INITIALIZERS
    function init_sessions($user){
        $this->session->set_userdata(array(
            'user_id'=>$user[0]['id'], 
            'name' => $user[0]['first_name'].' '.$user[0]['lastname'],
            'role' => $user[0]['is_admin']
        )); 
    }
}
