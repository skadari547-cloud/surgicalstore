<?php
require 'layout.php';
if(isset($_GET['remove'])) {
cart_remove((int)$_GET['remove']);
redirect_to('cart.php');
}
if($_SERVER['REQUEST_METHOD']==='POST') {
foreach($_POST['qty']??[] as $id=>$q) {
$q=max(1,(int)$q);
$_SESSION['cart'][(int)$id]=$q;
}
redirect_to('cart.php');
}
$rows=cart_rows();
$subtotal=0;
foreach($rows as $r)$subtotal+=$r['price']*$r['quantity'];
userStart('Cart','products');
?>
<div class="container">
<div class="page-head">
<h1>My Cart</h1>
<p>Review your selected products.</p>
</div>
<?php
if(!$rows):
?>
<div class="card">
<p>Your cart is empty.</p>
<a class="btn primary" href="products.php">Shop Products</a>
</div>
<?php
else:
?>
<form method="post">
<div class="card table-wrap">
<table>
<thead>
<tr>
<th>Product</th>
<th>Price</th>
<th>Quantity</th>
<th>Total</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
foreach($rows as $r):
?>
<tr>
<td>
<?=
h($r['product_name'])
?>
</td>
<td>₹
<?=
number_format($r['price'],2)
?>
</td>
<td>
<input type="number" name="qty[
<?=
$r['product_id']
?>
]" value="
<?=
$r['quantity']
?>
" min="1" max="
<?=
$r['stock_quantity']
?>
" style="width:80px">
</td>
<td>₹
<?=
number_format($r['price']*$r['quantity'],2)
?>
</td>
<td>
<a class="btn small" href="cart.php?remove=
<?=
$r['product_id']
?>
">Remove</a>
</td>
</tr>
<?php
endforeach;
?>
</tbody>
</table>
</div>
<div class="card">
<h3>Subtotal: ₹
<?=
number_format($subtotal,2)
?>
</h3>
<button class="btn">Update Cart</button>
<a class="btn primary" href="checkout.php">Checkout</a>
</div>
</form>
<?php
endif;
?>
</div>
<?php
userEnd();
?>
