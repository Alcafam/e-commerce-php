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

    function get_all_status(){
        return $this->db->query(
            "SELECT *
            FROM statuses"
        )->result_array();
    }

    function get_all_product(){ 
        $results = $this->db->query("SELECT * FROM products")->result_array();
        $results = $this->decode_images($results);
        return $results;
    }

    function get_filtered_product($filters){
        $query=
            "SELECT p.* FROM products p
            LEFT JOIN categories c
                ON c.id = p.category_id
            WHERE 
                (p.product_name LIKE '%?%'
                OR p.description LIKE '%?%'
                OR p.price LIKE '%?%')
                AND c.category = ?";
        $values = array(
            $this->security->xss_clean($filters['search_filter']), 
            $this->security->xss_clean($filters['search_filter']),
            $this->security->xss_clean($filters['search_filter']),
            $this->security->xss_clean($filters['category'])
        );
        
        $results = $this->db->query($query, $values)->result_array();
        var_dump($filters);
        die();
        // $results = $this->decode_images($results);
        // return $results;
    }
// ============= END OF GETTERS ============= //

// ========================================== //
// =========== IMAGE JSON_DECODE =========== //
// ======================================== //
    function decode_images($results){
        for($x=0; $x<count($results); $x++){
            $results[$x]['images'] = json_decode($results[$x]['images']);
        }
        return $results;
    }
}
?>