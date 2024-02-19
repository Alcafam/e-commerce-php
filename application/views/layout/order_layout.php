<div class="w-50">
    <form id="filter_form" method="POST" class="text-center d-flex">
        <input class="form-control me-2" type="search" name="search_filter" id="search_filter" placeholder="search product" aria-label="Search">
    </form>
</div>
<div class="row mt-5">
    <div class="col-2">
        <a href="" class="category_button text-white text-decoration-none position-relative py-3 my-1 rounded-2 text-center w-50">
            <span class="absolute-cat-num"><?=$total ?></span>
            <span>All Products</span>
        </a>
<?php   foreach($categories as $cat){
?>      <a href="" class="category_button text-white text-decoration-none position-relative py-3 my-1 rounded-2 text-center w-50">
            <span class="absolute-cat-num"><?=$cat['prod_count'] ?></span>
            <span><?= $cat['category'] ?></span>
        </a>
<?php   }
?>
    </div>
    <div class="col-10" id="order_cards">
    </div>
</div>
    