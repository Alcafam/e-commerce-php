<table class="table table-bordered">
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
?>
        <tr>
            <th><?= $prod['product_name'] ?></th>
            <td><?= $prod['id'] ?></td>
            <td>&#8369; <?= $prod['price'] ?></td>
            <td><?= $prod['category'] ?></td>
            <td><?= $prod['stock'] ?></td>
            <td><?= $prod['sold'] ?></td>
            <td><a href="javascript:void(0)" class="btn btn-info edit_product" data-id=<?= $prod['id'] ?>><i class="fa-solid fa-pen-to-square"></i></a></td>
        </tr>
<?php   }
?>
    </tbody>
</table>