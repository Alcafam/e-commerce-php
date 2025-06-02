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

    function get_product_count($per_page){
        $total = $this->db->query("SELECT COUNT(*) AS total FROM products")->result_array();
            $last_rows=array();
            for($i=0; $i<=$total[0]['total']; $i+=$per_page){
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

    function get_pages($count,$per_page){
        $pages=array();
            for($i=0; $i<=$count; $i+=$per_page){
                if($i >= ($count)){
                    break;
                }else{
                    array_push($pages, $i);
                }
            }
        return $pages;
    }

    function get_products($last_row){ 
        $query =
            "SELECT p.*, c.category, 
                sum(CASE 
                    WHEN o.status_id != 1
                    THEN o.quantity 
                    ELSE 0 
                END) as sold
            FROM orders o
                RIGHT JOIN products p ON p.id = o.product_id 
                JOIN categories c ON c.id = p.category_id
            GROUP BY p.id LIMIT {$last_row}, 5";
            
        $results = $this->db->query($query)->result_array();
        $results = $this->decode_images($results);
        return $results;
    }

    function get_filtered_product($filters){
        $query =
            "SELECT p.*, c.category, 
            sum(CASE 
                WHEN o.status_id != 1 
                THEN o.quantity 
                ELSE 0 
            END) as sold
            FROM orders o
                RIGHT JOIN products p ON p.id = o.product_id 
                LEFT JOIN categories c ON c.id = p.category_id
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

    function get_product_by_id($id){
        $results = $this->db->query(
            "SELECT p.*, JSON_VALUE(p.images,'$.main_pic') AS main_pic, JSON_VALUE(p.images,'$.extras') AS extras, c.category
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            WHERE p.id =  {$this->security->xss_clean($id)}")->result_array()[0];
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

    function get_similar_product($id){
        $main = $this->db->query(
            "SELECT p.category_id FROM products p WHERE p.id = {$this->security->xss_clean($id)}")->result_array()[0];
        return $this->db->query(
            "SELECT p.*, JSON_VALUE(p.images,'$.main_pic') AS main_pic, JSON_VALUE(p.images,'$.extras') AS extras, c.category
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            WHERE p.category_id =  {$this->security->xss_clean($main['category_id'])} 
            AND p.id!={$this->security->xss_clean($id)}
            LIMIT 3")->result_array();
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
    
    if(($data['main'] == 'undefined' || $data['main'] =='')){
        $errors .= '<div class="alert alert-danger" role="alert">Pick a Main Image!</div>';
    }

    if(!isset($_FILES['images']) && !isset($data['product_id'])){
        $errors .= '<div class="alert alert-danger" role="alert">Select an Image!!</div>';
    }

    if(!$this->form_validation->run() || !empty($errors)) {
        $errors .= validation_errors();
        return $errors;
    }else{
        return 'success';
    }
}
function validate_image($id, $json_id){
    if($json_id=='-1'){
        return '<div class="alert alert-danger" role="alert">Have a Main Image before deleting this Main image!</div>';
    }else{
        return "success";
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

function update_image($data){
    $main = $this->check_main($_FILES['images']['name'], $data);
}

function update_main($data){
    $this->db->query(
        "UPDATE products
        SET images = JSON_ARRAY_APPEND(images, '$.extras', JSON_VALUE(images,'$.main_pic')), 
        images = JSON_REPLACE(images, '$.main_pic', JSON_VALUE(images,'$.extras[0]')), 
        images = JSON_REMOVE(images,'$.extras[0]'), updated_at=NOW()
        WHERE id = {$data['product_id']}"
    );
}

function update_product($data){
    $query="UPDATE products SET category_id=?,product_name=?,description=?,price=?,stock=?,updated_at=NOW() WHERE id = ?";
    $values=array(
        $this->security->xss_clean($data['category']),
        $this->security->xss_clean($data['name']),
        $this->security->xss_clean($data['description']),
        $this->security->xss_clean($data['price']),
        $this->security->xss_clean($data['stock']),
        $this->security->xss_clean($data['product_id'])
    );
    $this->db->query($query, $values);
}

function delete_image($data){
    if($data['index'] == 0){
        return $this->db->query("UPDATE products set images = JSON_REPLACE(images,'$.main_pic','') WHERE id={$this->security->xss_clean($data['product_id'])}");
    }else{
        return $this->db->query("UPDATE products set images = JSON_REMOVE(images,'$.extras[{$this->security->xss_clean($data['json_index'])}]') WHERE id={$this->security->xss_clean($data['product_id'])}");
    }
}

function add_new_category($data){
    $this->db->query("INSERT INTO categories (category, created_at, updated_at) VALUES('{$this->security->xss_clean($data['category'])}', NOW(), NOW())");
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
            if($key==count($jsons)-1){
                $string .= '"'.$value.'"';
            }else{
                $string .= '"'.$value.'",';
            }
        }
    }
    $string .= "]}";
    return $string;
}

function check_main($new_images, $old_images){
    if($old_images['old_main'] == "changed"){
        $old_main = $this->db->query(
            "UPDATE products
            SET images = JSON_ARRAY_APPEND(images, '$.extras', JSON_VALUE(images, '$.main_pic')), updated_at=NOW()
            WHERE id = {$old_images['product_id']}"
        );
        $new_main = $this->db->query(
            'UPDATE products
            SET images = JSON_REPLACE(images, "$.main_pic", "'.$new_images[$old_images['main']].'"), updated_at=NOW()
            WHERE id = '.$old_images['product_id']
        );
        unset($new_images[$old_images['main']]);
        $new_images = array_values($new_images);
    }
    if(!empty($new_images)){
        foreach($new_images as $new){
            $this->db->query(
                'UPDATE products
                SET images = JSON_ARRAY_APPEND(images, "$.extras", "'.$new.'"), updated_at=NOW()
                WHERE id = '.$old_images["product_id"]
            );
        }
    }
}
// =========== END OF JSON_DECODE =========== //
}
?>