<?php
require 'layout.php';
$rows=db_all('SELECT * FROM orders WHERE user_id='.user_id().' ORDER BY order_date DESC');
userStart('My Orders','orders');
?>
<div class="container">
<div class="page-head">
<h1>My Orders</h1>
<p>Track your purchases.</p>
</div>
<div class="card table-wrap">
<table>
<thead>
<tr>
<th>Order</th>
<th>Date</th>
<th>Total</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
foreach($rows as $o):
?>
<tr>
<td>
<?=
h($o['order_number'])
?>
</td>
<td>
<?=
h($o['order_date'])
?>
</td>
<td>₹
<?=
number_format($o['total_amount'],2)
?>
</td>
<td>
<?=
h($o['order_status'])
?>
</td>
<td>
<a class="btn small" href="order-details.php?id=
<?=
$o['order_id']
?>
">View</a>
</td>
</tr>
<?php
endforeach;
if(!$rows):
?>
<tr>
<td colspan="5">No orders yet.</td>
</tr>
<?php
endif;
?>
</tbody>
</table>
</div>
</div>
<?php
userEnd();
?>
