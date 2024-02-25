<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Model 
{
// ============= GETTERS ============= //
    function cart_query(){
        return "SELECT o.id as cart_id, stat.status, o.quantity, p.product_name, JSON_VALUE(p.images,'$.main_pic') as main_pic, p.id as product_id, p.price, (p.price * o.quantity) As total,
        CONCAT(
            IF(LENGTH(JSON_VALUE(o.shipping,'$.address_1')),CONCAT(JSON_VALUE(o.shipping,'$.address_1'), ', '),''),
            IF(LENGTH(JSON_VALUE(o.shipping,'$.address_2')),CONCAT(JSON_VALUE(o.shipping,'$.address_2'), ', '),''),
            IF(LENGTH(JSON_VALUE(o.shipping,'$.city')),CONCAT(JSON_VALUE(o.shipping,'$.city'), ', '),''),
            IF(LENGTH(JSON_VALUE(o.shipping,'$.state')),CONCAT(JSON_VALUE(o.shipping,'$.state'), ', '),''),
            IF(LENGTH(JSON_VALUE(o.shipping,'$.zipcode')),CONCAT(JSON_VALUE(o.shipping,'$.zipcode'), ', '),'')
        ) AS shipping, 
        CONCAT(
            IF(LENGTH(JSON_VALUE(o.billing,'$.address_1')),CONCAT(JSON_VALUE(o.billing,'$.address_1'), ', '),''),
            IF(LENGTH(JSON_VALUE(o.billing,'$.address_2')),CONCAT(JSON_VALUE(o.billing,'$.address_2'), ', '),''),
            IF(LENGTH(JSON_VALUE(o.billing,'$.city')),CONCAT(JSON_VALUE(o.billing,'$.city'), ', '),''),
            IF(LENGTH(JSON_VALUE(o.billing,'$.state')),CONCAT(JSON_VALUE(o.billing,'$.state'), ', '),''),
            IF(LENGTH(JSON_VALUE(o.billing,'$.zipcode')),CONCAT(JSON_VALUE(o.billing,'$.zipcode'), ', '),'')
        ) AS billing 
    FROM orders o
        LEFT JOIN statuses stat ON stat.id = o.status_id
        LEFT JOIN products p ON p.id = o.Product_id";
    }
    function get_carts($id){
        $query = $this->cart_query().
            "
        WHERE o.user_id = ? AND o.status_id = 1
        ORDER BY stat.status";

        $results = $this->db->query($query, $this->security->xss_clean($id))->result_array();

        return $results;
    }

    function get_filtered_carts($id,$status){
        $query = $this->cart_query().
        "
        WHERE o.user_id = ? AND stat.status = ?
        ORDER BY stat.status";

        $results = $this->db->query(
            $query, 
            array(
                $this->security->xss_clean($id), 
                $this->security->xss_clean($status)
            )
        )->result_array();
        return $results;
    }

    function get_statuses(){
        return $this->db->query(
            "SELECT *
            FROM statuses"
        )->result_array();
    }
// ============= END OF GETTERS ============= //

// ============= CRUD ============= //
    function add_to_cart($id, $data){
        $query="INSERT INTO orders (user_id, status_id, product_id, quantity, created_at, updated_at)
        VALUES(?,1,?,?,NOW(),NOW())";
        $values=array(
            $this->security->xss_clean($id),
            $this->security->xss_clean($data['product_id']),
            $this->security->xss_clean($data['quantity']),
        );
        $this->db->query($query, $values);
    }

    function delete_cart_item($id){
        return $this->db->query("DELETE FROM orders WHERE id = {$this->security->xss_clean($id)}");
    }

    function checkout($data){
        $cart_ids = $this->db->query("SELECT id FROM capstone.orders WHERE status_id=1")->result_array();
        $ids = [];
        foreach($cart_ids as $id){
            array_push($ids, $id['id']);
        }
        $ids = implode(", ", $ids);
        $bill;
        $ship = json_encode($data['shipping']);
        if(!isset($data['billing'])){
            $bill = json_encode($data['shipping']);
        }else{
            $bill = json_encode($data['billing']);
        }
        $query=
            "UPDATE orders SET status_id=2, billing='{$bill}', shipping='{$ship}', updated_at=NOW() WHERE id IN ({$ids})";
        $this->db->query($query);

        $this->update_stocks($ids);
    }

    function update_stocks($ids){
        $product_ids = $this->db->query("SELECT id, product_id, quantity FROM orders WHERE id IN ({$ids})")->result_array();
        foreach($product_ids as $id){
            $this->db->query("UPDATE products SET stock = (stock - {$id['quantity']}) WHERE id = {$id['product_id']}");
        }
    }

    function receive_item($id){
        $this->db->query("UPDATE orders SET status_id=5, updated_at=NOW() WHERE id = {$this->security->xss_clean($id)}");
    }
// ============= END OF CRUD ============= //

// =========== VALIDATIONS =========== //
function validate_cart($data){
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">','</div>');
    $this->form_validation->set_rules('quantity', 'Quantity', 'required|is_numeric|less_than_equal_to['.$data['stocks'].']|greater_than[0]');

    if(!$this->form_validation->run()) {
        return validation_errors();
    }else{
        return 'success';
    }
}

function validate_information($data){
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<p class="text-danger m-0 p-0">','</p>');
    $this->form_validation->set_rules('shipping[first_name]', 'Shipping First Name', 'required');
    $this->form_validation->set_rules('shipping[last_name]', 'Shipping Last Name', 'required');
    $this->form_validation->set_rules('shipping[address_1]', 'Shipping Address 1', 'required');
    $this->form_validation->set_rules('shipping[address_2]', 'Shipping Address 2', 'required');
    $this->form_validation->set_rules('shipping[city]', 'Shipping City', 'required');
    $this->form_validation->set_rules('shipping[state]', 'Shipping State', 'required');
    $this->form_validation->set_rules('shipping[zipcode]', 'Shipping Zipcode', 'required');
    if(isset($data['billing'])){
        $this->form_validation->set_rules('billing[first_name]', 'Billing First Name', 'required');
        $this->form_validation->set_rules('billing[last_name]', 'Billing Last Name', 'required');
        $this->form_validation->set_rules('billing[address_1]', 'Billing Address 1', 'required');
        $this->form_validation->set_rules('billing[address_2]', 'Billing Address 2', 'required');
        $this->form_validation->set_rules('billing[city]', 'Billing City', 'required');
        $this->form_validation->set_rules('billing[state]', 'Billing State', 'required');
        $this->form_validation->set_rules('billing[zipcode]', 'Billing Zipcode', 'required');
    }

    if(!$this->form_validation->run()) {
        return validation_errors();
    }else{
        return 'success';
    }

}
// =========== END OF VALIDATIONS =========== //
}
?>