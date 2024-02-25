<div class="row">
    <div class="col-4">
        <div style="width:100%"class="d-block border border-2 border-dark bg-light">
            <img src="<?= base_url('assets/images/products/'.$product['id'].'/'.$product['main_pic']) ?>" class="img-fluid" id="big_pic">
        </div>
<?php   if(!empty($product['extras'])){ 
?>      <div style="height:110px" class="d-block text-center border border-2 border-dark" id="extra_pics">
<?php       foreach($product['extras'] as $extra){
?>          <a href="javascript:void(0)" class="toggle_image text-decoration-none">
                <img src="<?= base_url('assets/images/products/'.$product['id'].'/'.$extra) ?>" class="d-inline-block" style="height:100px">
            </a>
<?php       }
?>
        </div>
<?php   }
?>
    </div>
    <div class="col mx-3">
        <h1><?= $product['product_name'] ?></h1>
        <p class="mt-2"><span class="fw-bold">Price: </span>&#8369;<?= $product['price'] ?></p>
        <p class="mt-2"><span class="fw-bold">Stock: </span><?= $product['stock'] ?></p>
        <p class="mt-2"><?= $product['description'] ?></p>
    
        <?= ($this->session->flashdata('input_errors'))? $this->session->flashdata('input_errors'):'' ?>
        <form method="POST" action="<?= base_url('add_to_cart') ?>">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
            <input name="product_id" value="<?= $product['id'] ?>" hidden>
            <input name="stocks" value="<?= $product['stock'] ?>" hidden>
            <div class="mb-3 w-50 row mx-1">
                <div class="col">
                    <label for="product" class="form-label">Quantity</label>
                    <input type="number" class="form-control mx-1" name="quantity" id="quantity" >
                </div>
                <div class="col">
                    <label for="product" class="form-label">Total Amount</label>
                    <input type="text" class="form-control mx-1" name="total_amount"  id="total_amount" disabled>
                </div>     
                <div class="col position-relative">
                    <input type="submit" class="btn btn-success position-absolute bottom-0" value="Add to Cart">
                </div>                       
            </div>
        </form>
    </div>
</div>
<div class="row mt-5" >
    <h1 class="fs-3">Similar Products</h1>
<?php   foreach($similar_products as $prod){ 
?>          <div class="col-lg-2 d-flex align-items-stretch">
                <a href="<?= base_url('view_product/'.$prod['id']) ?>" class="card m-1 text-decoration-none">
                    <img src="<?= base_url('assets/images/products/'.$prod['id'].'/'.$prod['main_pic'])?>" class="img-fluid"  alt="..." >
                    <div class="card-body">
                        <h5 class="card-title"><?= $prod['product_name'] ?></h5>
                        <p class="card-text">&#8369; <?= $prod['price'] ?></p>
                    </div>
                </a>
            </div>
<?php   }
?>
</div>

<script>var price=<?= $product['price'] ?></script>
<script src="<?= base_url('assets/jquery/view_productss.js') ?>"></script>