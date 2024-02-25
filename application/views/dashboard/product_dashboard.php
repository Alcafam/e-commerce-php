<div class="col-2">
    <a href="javascript:void(0)" class="category_button text-white text-decoration-none position-relative py-3 my-1 rounded-2 text-center w-50 <?= ($active == '')?'active':'' ?>">
        <span class="absolute-cat-num"><?=$total ?></span>
        <span>All Products</span>
    </a>
<?php   foreach($categories as $cat){
?>      <a href="javascript:void(0)" class="category_button text-white text-decoration-none position-relative py-3 my-1 rounded-2 text-center w-50 <?= ($active == $cat['category'])?'active':'' ?>" data-id="<?= $cat['category'] ?>">
        <span class="absolute-cat-num"><?=$cat['prod_count'] ?></span>
        <span><?= $cat['category'] ?></span>
    </a>
<?php   }
?>
</div>
<div class="col-10">
    <h1 class="fs-3"><?= $filter ?></h1>
    <div class="row">
<?php   foreach($products as $prod){
?>      <div class="col-lg-3 d-flex align-items-stretch">
            <a href="<?= base_url('view_product/'.$prod['id']) ?>" class="card m-1 text-decoration-none">
                <img src="<?= base_url('assets/images/products/'.$prod['id'].'/'.$prod['main_pic'])?>" class="img-fluid"  alt="..." >
                <div class="card-body">
                    <h5 class="card-title"><?= $prod['product_name'] ?></h5>
                    <p class="card-text">&#8369; <?= $prod['price'] ?></p>
                </div>
            </a>
        </div>
<?php   }
?></div>
<div id='pagination' class="mt-5 text-center">
<?php   foreach($pages as $key=>$page){
?>          <a href="javascript:void(0)" class="mx-1 text-info text-decoration-none p-2 text-white bg-dark" id="go_to_page" data-id="<?=$page?>"><?=$key+1?></a>
<?php   }
?>
</div>