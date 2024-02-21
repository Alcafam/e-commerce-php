<div class="w-75">
    <form id="filter_form" method="POST" class="text-center d-inline-block w-75">
        <input class="form-control me-2" type="search" name="search_filter" id="search_filter" placeholder="search product" aria-label="Search">
    </form>
<?php   if(isset($role) && $role == 1){
?>          <button class="btn btn-success d-inline-block mx-3 mb-1" id="add_product">Add a Product</button>
<?php   }
?>
</div>
<div class="row mt-5" id="product_cards">
    
</div>

