<div class="w-50">
    <form id="filter_form" method="POST" class="text-center d-flex">
        <input class="form-control me-2" type="search" name="search_filter" id="search_filter" placeholder="search order" aria-label="Search">
    </form>
</div>
<div class="row mt-5">
    <div class="col-2">
        <a href="javascript:void(0)" class="category_button text-white text-decoration-none position-relative py-3 my-1 rounded-2 text-center w-50">
            <span class="absolute-cat-num"><?=$total ?></span>
            <span>All Products</span>
        </a>
<?php   foreach($statuses as $status){
?>      <a href="javascript:void(0)" class="category_button text-white text-decoration-none position-relative py-3 my-1 rounded-2 text-center w-50" data-id="<?= $status['status'] ?>">
            <span class="absolute-cat-num"><?=$status['status_count'] ?></span>
            <span><?= $status['status'] ?></span>
        </a>
<?php   }
?>
    </div>
    <div class="col-10" id="product_table">
    </div>
</div>
    