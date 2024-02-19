<h1 class="fs-3"><?= $filter ?></h1>
<?php   foreach($products as $prod){
?>      <a href="" class="card d-inline-block m-1 text-decoration-none" style="width: 18rem;">
            <img src="<?= base_url('assets/images/products/'.$prod['images']->main_pic)?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?= $prod['product_name'] ?></h5>
                <p class="card-text">&#8369; <?= $prod['price'] ?></p>
            </div>
        </a>
<?php   }
?>
