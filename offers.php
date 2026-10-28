<?php
require 'layout.php';
$coupons=db_all("SELECT * FROM coupons WHERE status='active' AND (start_date IS NULL OR start_date<=NOW()) AND (expiry_date IS NULL OR expiry_date>=NOW()) ORDER BY coupon_id DESC");
guestStart('Offers','offers');
?>
<div class="container">
<div class="page-head">
<span class="eyebrow">SPECIAL OFFERS</span>
<h1>Available Coupons</h1>
<p>Current offers are loaded from the admin coupon section.</p>
</div>
<div class="offers-grid">
<?php
foreach($coupons as $c):
?>
<div class="offer-coupon-card">
<div class="offer-coupon-info">
<h3>
<?=
h($c['coupon_code'])
?>
</h3>
<p>
<?=
h($c['discount_value'])
?>
<?=
$c['discount_type']==='percentage'?'% OFF':' ₹ OFF'
?>
</p>
<p>Minimum order: ₹
<?=
number_format($c['min_order_amount'],2)
?>
</p>
<small>Valid until 
<?=
h($c['expiry_date']??'No expiry')
?>
</small>
</div>
</div>
<?php
endforeach;
if(!$coupons):
?>
<p>No active coupons.</p>
<?php
endif;
?>
</div>
</div>
<?php
guestEnd();
?>
