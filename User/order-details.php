<?php
require 'layout.php';
$id=(int)($_GET['id']??0);
$o=db_one('SELECT * FROM orders WHERE order_id='.$id.' AND user_id='.user_id());
$items=db_all('SELECT * FROM order_items WHERE order_id='.$id);
userStart('Order Details','orders');
?>
<div class="container">
<div class="page-head">
<h1>Order 
<?=
h($o['order_number']??'')
?>
</h1>
<a class="btn" href="orders.php">Back</a>
</div>
<?php
if($o):
?>
<div class="card">
<p>Status: <strong>
<?=
h($o['order_status'])
?>
</strong>
</p>
<p>Delivery: 
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
</div>
<div class="card table-wrap">
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
<div class="card">
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
</div>
<?php
userEnd();
?>
