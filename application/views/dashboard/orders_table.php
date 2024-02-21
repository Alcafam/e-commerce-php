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
?>
        <tr>
            <th>
                <img height="100px" src="<?= base_url('assets/images/products/'.$prod['image']) ?>">
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
?>              </select>
            </td>
        </tr>
<?php   }
?>
    </tbody>
</table>