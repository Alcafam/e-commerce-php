<h1 class="fs-3"><?= $filter ?></h1>
<div class="row">
<?php   foreach($products as $prod){
?>      <div class="col-lg-3 d-flex align-items-stretch">
                <a href="" class="card m-1 text-decoration-none">
                    <img src="<?= base_url('assets/images/products/'.$prod['images']->main_pic)?>" class="img-fluid"  alt="..." >
                    <div class="card-body">
                        <h5 class="card-title"><?= $prod['product_name'] ?></h5>
                        <p class="card-text">&#8369; <?= $prod['price'] ?></p>
                    </div>
                </a>
            </div>
        
<?php   }
?></div>
