<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Model 
{
// ========================================== //
// ================ GETTERS ================ //
// ======================================== //
    function get_all_categories(){ 
        return $this->db->query(
            "SELECT c.*, COUNT(p.category_id) as prod_count 
            FROM categories AS c
                LEFT JOIN products AS p
                ON p.category_id = c.id
            GROUP BY c.id"
        )->result_array();
    }

    function get_all_product(){ 
        $results = $this->db->query("SELECT * FROM products")->result_array();
        for($x=0; $x<count($results); $x++){
            $results[$x]['images'] = json_decode($results[$x]['images']);
        }
        return $results;
    }

    function get_filtered_product($filter){

    }
// ============= END OF GETTERS ============= //
}
?>