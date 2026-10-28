<?php
require 'layout.php';
$id=(int)($_GET['id']??0);
$p=db_one("SELECT p.*,c.category_name FROM products p LEFT JOIN categories c ON c.category_id=p.category_id WHERE p.product_id=$id");
adminStart('View Product','products');
?>
<div class="page-heading">
<div>
<h2>Product Details</h2>
</div>
<a class="btn" href="products.php">Back</a>
</div>
<div class="card">
<?php
if($p):
?>
<img src="/SurgicalStore/images/
<?=
h($p['image']?:'digital-thermometer.jpg')
?>
" style="width:180px;height:180px;object-fit:cover">
<p>
<strong>ID:</strong> 
<?=
$p['product_id']
?>
</p>
<p>
<strong>Name:</strong> 
<?=
h($p['product_name'])
?>
</p>
<p>
<strong>Category:</strong> 
<?=
h($p['category_name']??'')
?>
</p>
<p>
<strong>Brand:</strong> 
<?=
h($p['brand'])
?>
</p>
<p>
<strong>Price:</strong> ₹
<?=
number_format((float)$p['price'],2)
?>
</p>
<p>
<strong>Stock:</strong> 
<?=
$p['stock_quantity']
?>
</p>
<p>
<strong>Description:</strong> 
<?=
h($p['description'])
?>
</p>
<p>
<strong>Status:</strong> 
<?=
h($p['status'])
?>
</p>
<?php
else:
?>
<p>Product not found.</p>
<?php
endif;
?>
</div>
<?php
adminEnd();
?>
