<div class="w-75">
    <form id="filter_form" method="POST" class="text-center d-inline-block w-75">
        <input class="form-control me-2" type="search" name="search_filter" id="search_filter" placeholder="search product" aria-label="Search">
    </form>
<?php   if(isset($role)){
?>          <button class="btn btn-success d-inline-block mx-3 mb-1" id="add_product">Add a Product</button>
<?php   }
?>
</div>
<div class="row mt-5">
    <div class="col-2">
        <a href="javascript:void(0)" class="category_button text-white text-decoration-none position-relative py-3 my-1 rounded-2 text-center w-50">
            <span class="absolute-cat-num"><?=$total ?></span>
            <span>All Products</span>
        </a>
<?php   foreach($categories as $cat){
?>      <a href="javascript:void(0)" class="category_button text-white text-decoration-none position-relative py-3 my-1 rounded-2 text-center w-50" data-id="<?= $cat['category'] ?>">
            <span class="absolute-cat-num"><?=$cat['prod_count'] ?></span>
            <span><?= $cat['category'] ?></span>
        </a>
<?php   }
?>
    </div>
    <div class="col-10" id="product_cards">
    </div>
</div>

<div class="modal" tabindex="-1" id="add_product_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ADD PRODUCT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body">
            <p>Modal body text goes here.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
</div>