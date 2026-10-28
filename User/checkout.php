<?php
require 'layout.php';
$rows=cart_rows();
if(!$rows)redirect_to('cart.php');
$services=db_all("SELECT * FROM delivery_services WHERE status='active' ORDER BY service_id");
$coupons=db_all("SELECT * FROM coupons WHERE status='active' AND (start_date IS NULL OR start_date<=NOW()) AND (expiry_date IS NULL OR expiry_date>=NOW()) ORDER BY coupon_id DESC");
$u=db_one('SELECT * FROM register WHERE id='.user_id());
$error='';
$subtotal=0;
foreach($rows as $r)$subtotal+=$r['price']*$r['quantity'];
if($_SERVER['REQUEST_METHOD']==='POST') {
$name=trim($_POST['full_name']);
$email=trim($_POST['email']);
$mobile=trim($_POST['mobile']);
$address=trim($_POST['address']);
$city=trim($_POST['city']);
$pin=trim($_POST['pincode']);
$couponCode=strtoupper(trim($_POST['coupon']??''));
$serviceId=(int)($_POST['delivery']??0);
$payment=trim($_POST['payment_method']);
$service=db_one("SELECT * FROM delivery_services WHERE service_id=$serviceId AND status='active'");
$discount=0;
$coupon=null;
if($couponCode)$coupon=db_one("SELECT * FROM coupons WHERE coupon_code='".mysqli_real_escape_string($con,$couponCode)."' AND status='active' AND (start_date IS NULL OR start_date<=NOW()) AND (expiry_date IS NULL OR expiry_date>=NOW()) LIMIT 1");
if($coupon&&$subtotal>=$coupon['min_order_amount'])$discount=$coupon['discount_type']==='percentage'?min($subtotal,$subtotal*$coupon['discount_value']/100):min($subtotal,$coupon['discount_value']);
$delivery=$service?(float)$service['fee']:0;
if($service&&$service['free_above']!==null&&$subtotal>=$service['free_above'])$delivery=0;
$total=max(0,$subtotal+$delivery-$discount);
if(!$name||!filter_var($email,FILTER_VALIDATE_EMAIL)||!$mobile||!$address||!$city||!$pin||!$service||!$payment)$error='Please fill all required checkout fields.';
else {
$orderNo='SS'.date('YmdHis').rand(10,99);
$st=mysqli_prepare($con,'INSERT INTO orders(order_number,user_id,customer_name,email,mobile,address,city,pincode,coupon_code,delivery_service_id,payment_method,subtotal,delivery_amount,discount_amount,total_amount) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
mysqli_stmt_bind_param($st,'sisssssssisdddd',$orderNo,$u['id'],$name,$email,$mobile,$address,$city,$pin,$couponCode,$serviceId,$payment,$subtotal,$delivery,$discount,$total);
if(mysqli_stmt_execute($st)) {
$orderId=mysqli_insert_id($con);
foreach($rows as $r) {
$line=$r['price']*$r['quantity'];
$it=mysqli_prepare($con,'INSERT INTO order_items(order_id,product_id,product_name,quantity,price,total) VALUES(?,?,?,?,?,?)');
mysqli_stmt_bind_param($it,'iisidd',$orderId,$r['product_id'],$r['product_name'],$r['quantity'],$r['price'],$line);
mysqli_stmt_execute($it);
mysqli_query($con,'UPDATE products SET stock_quantity=GREATEST(0,stock_quantity-'.(int)$r['quantity'].') WHERE product_id='.(int)$r['product_id']);
}
cart_clear();
redirect_to('order_success.php?id='.$orderId);
}
else$error='Could not place order.';
}
}
userStart('Checkout','products');
?>
<div class="container">
<div class="page-head">
<h1>Checkout</h1>
<p>Complete your order.</p>
</div>
<?php
if($error):
?>
<div class="alert error">
<?=
h($error)
?>
</div>
<?php
endif;
?>
<div class="hero-grid">
<div class="form-card">
<form method="post" data-validate novalidate>
<div class="form-grid">
<div>
<label>Full Name *</label>
<input name="full_name" value="
<?=
h($u['fullname'])
?>
" data-validation="required alpha min max" data-min="2" data-max="100" required>
</div>
<div>
<label>Email *</label>
<input type="email" name="email" value="
<?=
h($u['email'])
?>
" data-validation="required email" required>
</div>
<div>
<label>Mobile *</label>
<input name="mobile" value="
<?=
h($u['mobile'])
?>
" data-validation="required numeric" required>
</div>
<div class="full-width">
<label>Address *</label>
<textarea name="address" data-validation="required min max" data-min="10" data-max="255" required>
<?=
h($u['address'])
?>
</textarea>
</div>
<div>
<label>City *</label>
<input name="city" value="
<?=
h($u['city'])
?>
" data-validation="required alpha min max" data-min="2" data-max="80" required>
</div>
<div>
<label>Pincode *</label>
<input name="pincode" value="
<?=
h($u['pincode'])
?>
" data-validation="required numeric" required>
</div>
<div>
<label>Coupon Code</label>
<select name="coupon">
<option value="">No coupon</option>
<?php
foreach($coupons as $c):
?>
<option value="
<?=
h($c['coupon_code'])
?>
">
<?=
h($c['coupon_code'])
?>
 - 
<?=
h($c['discount_value'])
?>
<?=
$c['discount_type']==='percentage'?'%':'₹'
?>
</option>
<?php
endforeach;
?>
</select>
</div>
<div>
<label>Delivery *</label>
<select name="delivery" data-validation="required" required>
<option value="">Choose delivery</option>
<?php
foreach($services as $s):
?>
<option value="
<?=
$s['service_id']
?>
">
<?=
h($s['service_name'])
?>
 - ₹
<?=
number_format($s['fee'],2)
?>
</option>
<?php
endforeach;
?>
</select>
</div>
<div>
<label>Payment *</label>
<select name="payment_method" data-validation="required" required>
<option value="">Select payment</option>
<option>Cash on Delivery</option>
<option>Online Payment (Demo)</option>
</select>
</div>
</div>
<button class="btn primary">Place Order</button>
</form>
</div>
<div class="card">
<h3>Order Summary</h3>
<?php
foreach($rows as $r):
?>
<p>
<?=
h($r['product_name'])
?>
 × 
<?=
$r['quantity']
?>
 — ₹
<?=
number_format($r['price']*$r['quantity'],2)
?>
</p>
<?php
endforeach;
?>
<hr>
<strong>Subtotal: ₹
<?=
number_format($subtotal,2)
?>
</strong>
</div>
</div>
</div>
<?php
userEnd();
?>
