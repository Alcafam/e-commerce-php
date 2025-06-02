<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalog extends CI_Model 
{
    function get_all_products($last_row, $per_row){
        $results = $this->db->query("SELECT *, JSON_VALUE(images,'$.main_pic') AS main_pic FROM products LIMIT {$last_row}, {$per_row}")->result_array();
        return $results;
    }

    function get_filtered_catalog($filters){
        $query =
            "SELECT p.*, c.category, JSON_VALUE(p.images,'$.main_pic') AS main_pic
            FROM products p
            LEFT JOIN categories c
                ON c.id = p.category_id
            WHERE 
                (p.product_name LIKE '%{$this->security->xss_clean($filters['search_filter'])}%'
                OR p.description LIKE '%{$this->security->xss_clean($filters['search_filter'])}%'
                OR p.price LIKE '%{$this->security->xss_clean($filters['search_filter'])}%')";

        if(!empty($filters['category'])){
            $query .= " AND c.category = '{$this->security->xss_clean($filters['category'])}'";
        }
        $query .= "GROUP BY p.id LIMIT {$filters['last_row']}, 8";

        $results = $this->db->query($query)->result_array();
        return $results;
    }

    function get_catalog_by_id($id){
        $results = $this->db->query("SELECT *, JSON_VALUE(images,'$.main_pic') AS main_pic, JSON_VALUE(images,'$.extras') AS extras FROM products WHERE id =  {$this->security->xss_clean($id)}")->result_array()[0];
        $results['extras'] = json_decode($results['extras']);
        $results['images'] = array();
        $results['images'][0]['path'] = base_url().'assets/images/products/'.$id.'/'.$results['main_pic'];
        $results['images'][0]['id'] = $id;
        $results['images'][0]['name'] = $results['main_pic'];
        foreach($results['extras'] as $key=>$extra){
            $results['images'][$key+1]['path'] = base_url().'assets/images/products/'.$id.'/'.$extra;
            $results['images'][$key+1]['id'] = $id;
            $results['images'][$key+1]['name'] = $extra;
        }
        return $results;
    }
// ============= END OF GETTERS ============= //
}
?>