<?php
require 'layout.php';
$c=db_one('SELECT * FROM coupons WHERE coupon_id='.(int)($_GET['id']??0));
adminStart('View Coupon','coupons');
?>
<div class="page-heading">
<h2>Coupon Details</h2>
<a class="btn" href="coupons.php">Back</a>
</div>
<div class="card">
<?php
if($c):foreach($c as $k=>$v):
?>
<p>
<strong>
<?=
h(ucwords(str_replace('_',' ',$k)))
?>
:</strong> 
<?=
h($v)
?>
</p>
<?php
endforeach;
else:
?>
<p>Coupon not found.</p>
<?php
endif;
?>
</div>
<?php
adminEnd();
?>
