<?php
require 'layout.php';
$id=(int)($_GET['id']??0);
$u=db_one("SELECT * FROM register WHERE id=$id AND role='user'");
$orders=db_all("SELECT * FROM orders WHERE user_id=$id ORDER BY order_date DESC");
adminStart('View Customer','customers');
?>
<div class="page-heading">
<h2>Customer Details</h2>
<a class="btn" href="customers.php">Back</a>
</div>
<div class="card">
<?php
if($u):
?>
<p>
<strong>ID:</strong> 
<?=
$u['id']
?>
</p>
<p>
<strong>Name:</strong> 
<?=
h($u['fullname'])
?>
</p>
<p>
<strong>Email:</strong> 
<?=
h($u['email'])
?>
</p>
<p>
<strong>Mobile:</strong> 
<?=
h($u['mobile'])
?>
</p>
<p>
<strong>Address:</strong> 
<?=
h($u['address'])
?>
</p>
<p>
<strong>City:</strong> 
<?=
h($u['city'])
?>
</p>
<p>
<strong>Pincode:</strong> 
<?=
h($u['pincode'])
?>
</p>
<p>
<strong>Status:</strong> 
<?=
h($u['status'])
?>
</p>
<h3>Orders</h3>
<?php
foreach($orders as $o):
?>
<p>#
<?=
h($o['order_number'])
?>
 — ₹
<?=
number_format($o['total_amount'],2)
?>
 — 
<?=
h($o['order_status'])
?>
</p>
<?php
endforeach;
?>
<?php
else:
?>
<p>Customer not found.</p>
<?php
endif;
?>
</div>
<?php
adminEnd();
?>
