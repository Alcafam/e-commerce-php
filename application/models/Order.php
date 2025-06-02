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
            "SELECT * FROM orders o
            WHERE o.status_id != 1"
        )->result_array());
    }

    function get_order_count(){
        $total = $this->db->query(
            "SELECT COUNT(*) AS total FROM orders
            WHERE status_id != 1"
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
        return "SELECT p.id, p. price, p.images->>'$.main_pic' AS 'image', c.category, o.quantity, CONCAT(JSON_EXTRACT(o.shipping,'$.first_name'),' ',JSON_EXTRACT(o.shipping,'$.last_name')) AS 'name', DATE_FORMAT(o.updated_at,'%m/%d/%Y') AS 'order_date', o.status_id, o.id as 'order_id',
        CONCAT(
            IF(LENGTH(JSON_EXTRACT(o.shipping,'$.address_1')),CONCAT(JSON_EXTRACT(o.shipping,'$.address_1'), ', '),''),
            IF(LENGTH(JSON_EXTRACT(o.shipping,'$.address_2')),CONCAT(JSON_EXTRACT(o.shipping,'$.address_2'), ', '),''),
            IF(LENGTH(JSON_EXTRACT(o.shipping,'$.city')),CONCAT(JSON_EXTRACT(o.shipping,'$.city'), ', '),''),
            IF(LENGTH(JSON_EXTRACT(o.shipping,'$.state')),CONCAT(JSON_EXTRACT(o.shipping,'$.state'), ', '),''),
            IF(LENGTH(JSON_EXTRACT(o.shipping,'$.zipcode')),CONCAT(JSON_EXTRACT(o.shipping,'$.zipcode'), ', '),'')
        ) AS shipping ";
    }
    function get_orders($last_row){
        $query = $this->orders_select_query(). 
            "FROM orders o
                LEFT JOIN products p ON p.id = o.product_id
                LEFT JOIN categories c ON c.id = p.category_id
                LEFT JOIN users u ON u.id = o.user_id
            WHERE o.status_id != 1 LIMIT {$last_row}, 5";
        $results = $this->db->query($query)->result_array();
        return $results;
    }

    function get_filtered_orders($filters){
        $query = $this->orders_select_query(). 
            ", stat.status
            FROM orders o
                LEFT JOIN products p ON p.id = o.product_id
                LEFT JOIN categories c ON c.id = p.category_id
                LEFT JOIN users u ON u.id = o.user_id
                LEFT JOIN statuses stat ON stat.id = o.status_id
            WHERE o.status_id != 1
                AND (p.product_name LIKE '%{$this->security->xss_clean($filters['search_filter'])}%'
                OR p.id LIKE '%{$this->security->xss_clean($filters['search_filter'])}%'
                OR stat.status LIKE '%{$this->security->xss_clean($filters['search_filter'])}%'
                )
            ";
        if(!empty($filters['status'])){
            $query .= " AND stat.status = '{$this->security->xss_clean($filters['status'])}'";
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
            WHERE s.id !=1
            GROUP BY s.id"
        )->result_array();
        $results = array_filter($results);
        return $results;
    }
// =========== END OF ORDER-RELATED SQL =========== //

// =========== CRUD-RELATED SQL =========== //
    function update_status($data){
        return $this->db->query(
            "UPDATE orders SET status_id=?, updated_at=NOW() WHERE id=?", 
            array($this->security->xss_clean($data['status_id']),
                $this->security->xss_clean($data['order_id'])
            )
        );
    }
// =========== END OF CRUD-RELATED SQL =========== //
}
?>