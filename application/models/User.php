<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model 
{
// ========================================== //
// ================ GETTERS ================ //
// ======================================== //
    function get_user_by_email($email){ 
        $query = "SELECT * FROM users
        WHERE email=?";
        return $this->db->query($query, $this->security->xss_clean($email))->result_array();
    }

    function get_user_by_id($id){ 
        $query = "SELECT * FROM users WHERE user_id=?";
        return $this->db->query($query, $this->security->xss_clean($id))->result_array();
    }
// ============= END OF GETTERS ============= //

// =============================================== //
// ================ TRANSACTIONS ================ //
// ============================================= //
    function create_user($user){
        $query = 
            "INSERT INTO Users (is_admin, first_name, last_name, email, password, salt, created_at, updated_at) 
            VALUES (?,?,?,?,?,?,?,?)";
        $salt = bin2hex(openssl_random_pseudo_bytes(22));
        $values = array(
            $this->security->xss_clean(0),
            $this->security->xss_clean($user['first_name']), 
            $this->security->xss_clean($user['last_name']), 
            $this->security->xss_clean($user['email']), 
            md5($this->security->xss_clean($user["password"])).$salt, 
            $salt,
            $this->security->xss_clean(date("Y-m-d, H:i:s")),
            $this->security->xss_clean(date("Y-m-d, H:i:s")));
            
        return $this->db->query($query, $values);
    }
// =========== END OF TRANSACTIONS =========== //

// ========================================== //
// ============== VALIDATIONS ============== //
// ======================================== //
    function validate_signin_form(){
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>','</div>');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
    
        if(!$this->form_validation->run()){
            return validation_errors();
        }else {
            return "success";
        }
    }

    function validate_signin_match($user, $password){
        $hash_password = $this->security->xss_clean(md5($password).$user[0]['salt']);
        if($user[0]['password'] == $hash_password){
            return "success";
        }else {
            return "Invalid Password/Email";
        }
    }

    function validate_update_details(){
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>','</div>');
        $this->form_validation->set_rules('edit_username', 'User Name', 'required');
        $this->form_validation->set_rules('edit_first_name', 'First Name', 'required');
        $this->form_validation->set_rules('edit_last_name', 'Last Name', 'required');   
        
        if(!$this->form_validation->run()) {
            return validation_errors();
        }else{
            return 'success';
        }
    }

    function validate_update_password(){
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>','</div>');
        $this->form_validation->set_rules('old_password', 'Old Password', 'required');
        $this->form_validation->set_rules('edit_password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('edit_confirm_password', 'Confirm Password', 'required|matches[edit_password]');   
        
        if(!$this->form_validation->run()) {
            return validation_errors();
        }else{
            return 'success';
        }
    }

    function validate_old_password($user,$password){
        $hash_password = $this->security->xss_clean(md5($password).$user[0]['salt']);
        if($user[0]['password'] == $hash_password){
            return "success";
        }else {
            return "Old password does not match";
        }
    }

    function validate_registration($username){
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>','</div>');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]',
            array(
                'is_unique' => 'Email already taken!'
            ));   
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        
        if(!$this->form_validation->run()) {
            return validation_errors();
        }else{
            return 'success';
        }
    }
// ============= END OF VALIDATIONS ============= //
}
?>