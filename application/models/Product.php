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

    function get_product_count(){
        $total = $this->db->query("SELECT COUNT(*) AS total FROM products")->result_array();
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

    function get_total_product(){
        return count($this->db->query("SELECT * FROM products")->result_array());
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

    function get_all_product($last_row){ 
        $query =
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
            GROUP BY p.id LIMIT {$last_row}, 5";
            
        $results = $this->db->query($query)->result_array();
        $results = $this->decode_images($results);
        return $results;
    }

    function get_filtered_product($filters){
        $query =
            "SELECT p.*, c.category, 
            sum(CASE 
                WHEN o.status_id != 5 
                THEN od.quantity 
                ELSE 0 
            END) as sold
            FROM products p
            LEFT JOIN categories c
                ON c.id = p.category_id
            LEFT JOIN order_details od
                ON od.product_id = p.id
            LEFT JOIN orders o
                ON o.id = od.order_id
            WHERE 
                (p.product_name LIKE '%{$this->security->xss_clean($filters['search_filter'])}%'
                OR p.description LIKE '%{$this->security->xss_clean($filters['search_filter'])}%'
                OR p.price LIKE '%{$this->security->xss_clean($filters['search_filter'])}%')";

        if(!empty($filters['category'])){
            $query .= " AND c.category = '{$this->security->xss_clean($filters['category'])}'";
        }
        $query .= "GROUP BY p.id LIMIT {$filters['last_row']}, 5";

        $results = $this->db->query($query)->result_array();
        $results = $this->decode_images($results);
        return $results;
    }
// ============= END OF GETTERS ============= //

// =========== VALIDATIONS =========== //
function validate_product($data){
    $errors ='';
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">','</div>');
    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('description', 'Description', 'required');
    $this->form_validation->set_rules('price', 'Price', 'required|is_numeric');
    $this->form_validation->set_rules('stock', 'Stock', 'required|is_numeric');
    $this->form_validation->set_rules('category', 'Category', 'required');
    $this->form_validation->set_rules('main', 'Main Image', 'required');
    
    if(isset($_FILES['images']) && ($data['main'] == 'undefined' || $data['main'] =='')){
        $errors .= '<div class="alert alert-danger" role="alert">Pick a Main Image!</div>';
    } 

    if(!isset($_FILES['images'])){
        $errors .= '<div class="alert alert-danger" role="alert">Select an Image!!</div>';
    }

    if(!$this->form_validation->run() || !empty($errors)) {
        $errors .= validation_errors();
        return $errors;
    }else{
        return 'success';
    }
}

// =========== END OF VALIDATIONS =========== //

// =========== CRUDS =========== //
function add_product($data){
    $query = "INSERT INTO products(category_id, product_name, description, price, images, stock, created_at, updated_at) VALUES (?,?,?,?,?,?,NOW(),NOW())";

    $data['image'] = $this->json_stringify($_FILES['images']['name'], $data['main']);

    $values = array(
        $this->security->xss_clean($data['category']),
        $this->security->xss_clean($data['name']),
        $this->security->xss_clean($data['description']),
        $this->security->xss_clean($data['price']),
        $this->security->xss_clean($data['image']),
        $this->security->xss_clean($data['stock']),
    );
    $this->db->query($query, $values);
    return $this->db->insert_id();
}
// =========== END OF CRUDS =========== //

// =========== JSON_DECODE =========== //
function decode_images($images){
    for($x=0; $x<count($images); $x++){
        $images[$x]['images'] = json_decode($images[$x]['images']);
    }
    return $images;
}

function json_stringify($jsons,$main){
    $string = '{"main_pic": "'.$jsons[$main].'", "extras": [';
    unset($jsons[$main]);
    $jsons = array_values($jsons);
    if(!empty($jsons)){
        foreach($jsons as $key=>$value){
            if($key == count($jsons)-1 ){
                $string .= '"'.$value.'"]}';
            }else{
                $string .= '"'.$value.'", ';
            }
        }
    }else{
        $string .= "]}";
    }
    return $string;
}
// =========== END OF JSON_DECODE =========== //
}
?>