<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Model 
{
// ================ GETTERS ================ //
    function get_all_status(){
        return $this->db->query(
            "SELECT *
            FROM statuses
            WHERE id != 5"
        )->result_array();
    }

    function get_all_order_count(){
        return count($this->db->query(
            "SELECT od.* FROM orders o
                LEFT JOIN order_details od ON od.order_id = o.id
            WHERE o.status_id != 5"
        )->result_array());
    }

    function get_order_count(){
        $total = $this->db->query(
            "SELECT COUNT(*) AS total FROM orders o
                LEFT JOIN order_details od ON od.order_id = o.id
            WHERE o.status_id != 5"
        )->result_array();
            $last_rows=array();
            for($i=0; $i<=$total[0]['total']; $i+=5){
                if($i == ($total[0]['total'])){
                    break;
                }else{
                    array_push($last_rows, $i);
                }
            }
            $data = $last_rows;
            return $data;
    }

    function get_pages($count){
        $pages=array();
            for($i=0; $i<=$count; $i+=5){
                if($i >= ($count)){
                    break;
                }else{
                    array_push($pages, $i);
                }
            }
        return $pages;
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
    function get_orders($last_row){
        $query = $this->orders_select_query(). 
            " FROM products AS p 
                LEFT JOIN categories c
                    ON c.id = p.category_id
                LEFT JOIN order_details od
                    ON od.product_id = p.id
                LEFT JOIN orders o
                    ON o.id = od.order_id
                LEFT JOIN users u
                    ON u.id = o.user_id
            WHERE o.status_id != 5 LIMIT {$last_row}, 5";
        $results = $this->db->query($query)->result_array();
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

    function get_total_orders_per_status(){
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
}
?>