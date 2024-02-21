
<div class="col-2">
    <a href="javascript:void(0)" class="category_button text-white text-decoration-none position-relative py-3 my-1 rounded-2 text-center w-50 <?= ($active == '')?'active':'' ?>">
        <span class="absolute-cat-num"><?=$total ?></span>
        <span>All Products</span>
    </a>
<?php   foreach($statuses as $status){
?>      <a href="javascript:void(0)" class="category_button text-white text-decoration-none position-relative py-3 my-1 rounded-2 text-center w-50 <?= ($active == $status['status'])?'active':'' ?>" data-id="<?= $status['status'] ?>">
            <span class="absolute-cat-num"><?=$status['status_count'] ?></span>
            <span><?= $status['status'] ?></span>
        </a>
<?php   }
?>
</div>

<div class="col-10">
    <table class="table table-bordered table-hover">
        <thead>
            <tr class="bg-info">
                <th scope="col" width="25%"><?= $filter ?></th>
                <th scope="col" width="10%">Order ID#</th>
                <th scope="col" width="10%">Order Date</th>
                <th scope="col" width="25%">Receiver</th>
                <th scope="col" width="10%">Total Amount</th>
                <th scope="col" width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
<?php   foreach($products as $prod){
?>          <tr>
                <th>
                    <img height="100px" src="<?= base_url('assets/images/products/'.$prod['id'].'/'.$prod['image']) ?>">
                    <span><?= $prod['quantity'] ?> items</span>
                </th>
                <td><?= $prod['id'] ?></td>
                <td><?= $prod['order_date'] ?></td>
                <td>
                    <span class="d-block fw-bold"><?= $prod['name'] ?></span>
                    <span class="d-block"><?= $prod['address'] ?></span>
                </td>
                <td>&#8369; <?= number_format($prod['price'] * $prod['quantity'], 2) ?></td>
                <td>
                    <select>
<?php               foreach($statuses as $stat){
?>                      <option value="<?= $stat['id'] ?>" <?= ($prod['status_id'] == $stat['id'])? 'selected' : '' ?>><?= $stat['status'] ?></option>
<?php               }
?>                  </select>
                </td>
            </tr>
<?php   }
?>
        </tbody>
    </table>
<div id='pagination' class="text-center">
<?php   foreach($pages as $key=>$page){
?>          <a href="javascript:void(0)" class="mx-1 text-info text-decoration-none p-2 text-white bg-dark" id="go_to_page" data-id="<?=$page?>"><?=$key+1?></a>
<?php   }
?>
</div>
