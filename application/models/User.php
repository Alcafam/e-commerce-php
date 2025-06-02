<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model 
{
// ================ GETTERS ================ //
    function get_user_by_email($email){ 
        $query = "SELECT * FROM users
        WHERE email=?";
        return $this->db->query($query, $this->security->xss_clean($email))->result_array();
    }

    function get_user_by_id($id){ 
        $query = "SELECT * FROM users
            WHERE id=?";
        $result['profile'] = $this->db->query($query, $this->security->xss_clean($id))->result_array()[0];
        return $result;
    }

    function get_address_by_id($id){
        return $this->db->query(
            "SELECT 
                JSON_VALUE(address, '$.house') as house,
                JSON_VALUE(address, '$.street') as street,
                JSON_VALUE(address, '$.city') as city,
                JSON_VALUE(address, '$.barangay') as barangay,
                JSON_VALUE(address, '$.province') as province,
                JSON_VALUE(address, '$.zipcode') as zipcode
            FROM addresses 
            WHERE id = ?", 
            $this->security->xss_clean($id)
        )->result_array()[0];
    }
// ============= END OF GETTERS ============= //

// ================ TRANSACTIONS ================ //
    function create_user($user){
        $query = 
            "INSERT INTO Users (is_admin, first_name, last_name, email, password, salt, created_at, updated_at) 
            VALUES (?,?,?,?,?,?,NOW(),NOW())";
        $salt = bin2hex(openssl_random_pseudo_bytes(22));
        $values = array(
            $this->security->xss_clean(0),
            $this->security->xss_clean($user['first_name']), 
            $this->security->xss_clean($user['last_name']), 
            $this->security->xss_clean($user['email']), 
            md5($this->security->xss_clean($user["password"])).$salt, 
            $salt);
            
        return $this->db->query($query, $values);
    }

    function add_address($id, $data){
        $query = 
            "INSERT INTO addresses (user_id, address, created_at, updated_at) 
            VALUES(?, ?, NOW(), NOW())";
        $values = array(
            $this->security->xss_clean($id),
            $this->security->xss_clean(json_encode($data))
        );
        $this->db->query($query, $values);
    }

    function edit_address($data){
        $query=
            "UPDATE addresses SET 
                address = JSON_REPLACE(address, '$.house','{$this->security->xss_clean($data['house'])}'), 
                address = JSON_REPLACE(address, '$.street','{$this->security->xss_clean($data['street'])}'), 
                address = JSON_REPLACE(address, '$.barangay','{$this->security->xss_clean($data['barangay'])}'), 
                address = JSON_REPLACE(address, '$.city','{$this->security->xss_clean($data['city'])}'), 
                address = JSON_REPLACE(address, '$.province','{$this->security->xss_clean($data['province'])}'), 
                address = JSON_REPLACE(address, '$.zipcode','{$this->security->xss_clean($data['zipcode'])}') 
            WHERE id = {$this->security->xss_clean($data['address_id'])}";
        $values=array(
            $this->security->xss_clean($data['house']),
            $this->security->xss_clean($data['street']),
            $this->security->xss_clean($data['barangay']),
            $this->security->xss_clean($data['city']),
            $this->security->xss_clean($data['province']),
            $this->security->xss_clean($data['zipcode']),
            $this->security->xss_clean($data['address_id'])
        );
        $this->db->query($query, $values);
    }
// =========== END OF TRANSACTIONS =========== //

// ============== VALIDATIONS ============== //
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

    function validate_address(){
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">','</div>');
        $this->form_validation->set_rules('barangay', 'Barangay', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('province', 'Province', 'required');
        $this->form_validation->set_rules('zipcode', 'Zipcode', 'required|is_numeric');

        if(!$this->form_validation->run()) {
            return validation_errors();
        }else{
            return 'success';
        }
    }
// ============= END OF VALIDATIONS ============= //
}
?>