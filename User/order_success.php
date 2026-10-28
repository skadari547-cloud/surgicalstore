<?php
require 'layout.php';
$id=(int)($_GET['id']??0);
$o=db_one("SELECT * FROM orders WHERE order_id=$id AND user_id=".user_id());
userStart('Order Success','orders');
?>
<div class="container">
<div class="card">
<h1>Order Placed Successfully</h1>
<?php
if($o):
?>
<p>Your order number is <strong>
<?=
h($o['order_number'])
?>
</strong>.</p>
<p>Total: ₹
<?=
number_format($o['total_amount'],2)
?>
</p>
<a class="btn primary" href="order-details.php?id=
<?=
$o['order_id']
?>
">View Order</a>
<?php
endif;
?>
</div>
</div>
<?php
userEnd();
?>
