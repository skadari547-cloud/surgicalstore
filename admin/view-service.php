<?php
require 'layout.php';
$s=db_one('SELECT * FROM delivery_services WHERE service_id='.(int)($_GET['id']??0));
adminStart('View Delivery Service','delivery');
?>
<div class="page-heading">
<h2>Service Details</h2>
<a class="btn" href="delivery-services.php">Back</a>
</div>
<div class="card">
<?php
if($s):foreach($s as $k=>$v):
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
<p>Service not found.</p>
<?php
endif;
?>
</div>
<?php
adminEnd();
?>
