<?php
require 'layout.php';
$id=(int)($_GET['id']??0);
$o=db_one("SELECT o.*,u.fullname FROM orders o JOIN register u ON u.id=o.user_id WHERE o.order_id=$id");
$items=db_all("SELECT * FROM order_items WHERE order_id=$id ORDER BY item_id");
adminStart('Order Details','orders');
?>
<div class="page-heading">
<h2>Order 
<?=
h($o['order_number']??'')
?>
</h2>
<a class="btn" href="orders.php">Back</a>
</div>
<?php
if($o):
?>
<div class="card">
<p>
<strong>Customer:</strong> 
<?=
h($o['fullname'])
?>
</p>
<p>
<strong>Mobile:</strong> 
<?=
h($o['mobile'])
?>
</p>
<p>
<strong>Email:</strong> 
<?=
h($o['email'])
?>
</p>
<p>
<strong>Address:</strong> 
<?=
h($o['address'])
?>
, 
<?=
h($o['city'])
?>
 - 
<?=
h($o['pincode'])
?>
</p>
<p>
<strong>Payment:</strong> 
<?=
h($o['payment_method'])
?>
</p>
<p>
<strong>Status:</strong> 
<?=
h($o['order_status'])
?>
</p>
</div>
<div class="card">
<div class="table-wrap">
<table>
<thead>
<tr>
<th>Product</th>
<th>Qty</th>
<th>Price</th>
<th>Total</th>
</tr>
</thead>
<tbody>
<?php
foreach($items as $i):
?>
<tr>
<td>
<?=
h($i['product_name'])
?>
</td>
<td>
<?=
$i['quantity']
?>
</td>
<td>₹
<?=
number_format($i['price'],2)
?>
</td>
<td>₹
<?=
number_format($i['total'],2)
?>
</td>
</tr>
<?php
endforeach;
?>
</tbody>
</table>
</div>
<p>Subtotal: ₹
<?=
number_format($o['subtotal'],2)
?>
</p>
<p>Delivery: ₹
<?=
number_format($o['delivery_amount'],2)
?>
</p>
<p>Discount: ₹
<?=
number_format($o['discount_amount'],2)
?>
</p>
<h3>Total: ₹
<?=
number_format($o['total_amount'],2)
?>
</h3>
</div>
<?php
else:
?>
<div class="card">Order not found.</div>
<?php
endif;
?>
<?php
adminEnd();
?>
