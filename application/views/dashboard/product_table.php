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
    <table class="table table-bordered table-hover">
        <thead>
            <tr class="bg-info">
                <th scope="col" width="30%"><?= $filter ?></th>
                <th scope="col" width="15%">Product ID#</th>
                <th scope="col" width="10%">Price</th>
                <th scope="col" width="15%">Category</th>
                <th scope="col" width="10%">Stocks</th>
                <th scope="col" width="10%">Sold</th>
                <th scope="col" width="10%"></th>
            </tr>
        </thead>
        <tbody>
<?php   foreach($products as $prod){
?>          <tr>
                <th>
                    <img height="100px" src="<?= base_url('assets/images/products/'.$prod['id'].'/'.$prod['images']->main_pic) ?>">
                    <?= $prod['product_name'] ?>
                </th>
                <td><?= $prod['id'] ?></td>
                <td>&#8369; <?= $prod['price'] ?></td>
                <td><?= $prod['category'] ?></td>
                <td><?= $prod['stock'] ?></td>
                <td><?= $prod['sold'] ?></td>
                <td><a href="javascript:void(0)" class="btn btn-info edit_product" data-id=<?= $prod['id'] ?>><i class="fa-solid fa-pen-to-square"></i></a></td>
            </tr>
<?php   }
?>      </tbody>
    </table>
<div id='pagination' class="text-center">
<?php   foreach($pages as $key=>$page){
?>          <a href="javascript:void(0)" class="mx-1 text-info text-decoration-none p-2 text-white bg-dark" id="go_to_page" data-id="<?=$page?>"><?=$key+1?></a>
<?php   }
?>
</div>