<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Model 
{
// ================ GETTERS ================ //
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
            FROM statuses
            WHERE id != 5"
        )->result_array();
    }

    function get_all_product(){ 
        $results = $this->db->query(
            "SELECT p.*, c.category, 
                sum(CASE 
                    WHEN o.status_id != 5 
                    THEN od.quantity 
                    ELSE 0 
                END) as sold
            FROM products AS p 
                LEFT JOIN categories c
                    ON c.id = p.category_id
                LEFT JOIN order_details od
                    ON od.product_id = p.id
                LEFT JOIN orders o
                    ON o.id = od.order_id
            GROUP BY p.id"
        )->result_array();
        $results = $this->decode_images($results);
        return $results;
    }

    function get_filtered_product($filters){
        $query=
            "SELECT p.*, c.category FROM products p
            LEFT JOIN categories c
                ON c.id = p.category_id
            WHERE 
                (p.product_name LIKE '%{$this->security->xss_clean($filters['search_filter'])}%'
                OR p.description LIKE '%{$this->security->xss_clean($filters['search_filter'])}%'
                OR p.price LIKE '%{$this->security->xss_clean($filters['search_filter'])}%')";

        if(!empty($filters['category'])){
            $query .= " AND c.category = '{$this->security->xss_clean($filters['category'])}'";
        }
        $results = $this->db->query($query)->result_array();
        $results = $this->decode_images($results);
        return $results;
    }
// ============= END OF GETTERS ============= //

// ============= ORDER-RELATED SQL ============= // 
    function orders_select_query(){
        return "SELECT p.id, p. price, p.images->>'$.main_pic' AS 'image', c.category, od.quantity, CONCAT(u.first_name,' ',u.last_name) AS 'name', DATE_FORMAT(o.updated_at,'%m/%d/%Y') AS 'order_date', o.status_id,
        CONCAT_WS(
            IF(LENGTH(JSON_VALUE(o.shipping_address,'$.house')),CONCAT(JSON_VALUE(o.shipping_address,'$.house'), ', '),''),
            IF(LENGTH(JSON_VALUE(o.shipping_address,'$.street')),CONCAT(JSON_VALUE(o.shipping_address,'$.street'), ', '),''),
            IF(LENGTH(JSON_VALUE(o.shipping_address,'$.city')),CONCAT(JSON_VALUE(o.shipping_address,'$.city'), ', '),''),
            IF(LENGTH(JSON_VALUE(o.shipping_address,'$.barangay')),CONCAT(JSON_VALUE(o.shipping_address,'$.barangay'), ', '),''),
            IF(LENGTH(JSON_VALUE(o.shipping_address,'$.province')),CONCAT(JSON_VALUE(o.shipping_address,'$.province'), ', '),''),
            IF(LENGTH(JSON_VALUE(o.shipping_address,'$.zipcode')),JSON_VALUE(o.shipping_address,'$.zipcode'),'')
        ) AS 'address'";
    }
    function get_orders(){
        $results = $this->db->query($this->orders_select_query(). 
            " FROM products AS p 
                LEFT JOIN categories c
                    ON c.id = p.category_id
                LEFT JOIN order_details od
                    ON od.product_id = p.id
                LEFT JOIN orders o
                    ON o.id = od.order_id
                LEFT JOIN users u
                    ON u.id = o.user_id
            WHERE o.status_id != 5"
        )->result_array();
        return $results;
    }

    function get_filtered_orders($filters){
        $query = $this->orders_select_query(). 
            ", s.status
                FROM products AS p 
                LEFT JOIN categories c
                    ON c.id = p.category_id
                LEFT JOIN order_details od
                    ON od.product_id = p.id
                LEFT JOIN orders o
                    ON o.id = od.order_id
                LEFT JOIN users u
                    ON u.id = o.user_id
            LEFT JOIN statuses s
            ON s.id = o.status_id
            WHERE o.status_id != 5
                AND (p.product_name LIKE '%{$this->security->xss_clean($filters['search_filter'])}%'
                    OR p.id LIKE '%{$this->security->xss_clean($filters['search_filter'])}%'
                    OR s.status LIKE '%{$this->security->xss_clean($filters['search_filter'])}%'
                )
            ";
        if(!empty($filters['status'])){
            $query .= " AND s.status = '{$this->security->xss_clean($filters['status'])}'";
        }

        $results = $this->db->query($query)->result_array();
        return $results;
    }

    function get_order_count(){
        $results = $this->db->query(
            "SELECT s.*, count(o.status_id) as 'status_count'
            FROM statuses s
                LEFT JOIN orders o 
                    ON o.status_id = s.id
            WHERE s.id !=5
            GROUP BY s.id"
        )->result_array();
        $results = array_filter($results);
        return $results;
    }
// =========== END OF ORDER-RELATED SQL =========== //

// =========== JSON_DECODE =========== //
function decode_images($images){
    for($x=0; $x<count($images); $x++){
        $images[$x]['images'] = json_decode($images[$x]['images']);
    }
    return $images;
}
// =========== END OF JSON_DECODE =========== //
}
?>