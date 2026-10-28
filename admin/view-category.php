<?php
require 'layout.php';
$id=(int)($_GET['id']??0);
$c=db_one("SELECT c.*,COUNT(p.product_id) product_count FROM categories c LEFT JOIN products p ON p.category_id=c.category_id WHERE c.category_id=$id GROUP BY c.category_id");
adminStart('View Category','categories');
?>
<div class="page-heading">
<div>
<h2>Category Details</h2>
</div>
<a class="btn" href="categories.php">Back</a>
</div>
<div class="card">
<?php
if($c):
?>
<p>
<strong>ID:</strong> 
<?=
h($c['category_id'])
?>
</p>
<p>
<strong>Name:</strong> 
<?=
h($c['category_name'])
?>
</p>
<p>
<strong>Description:</strong> 
<?=
h($c['description'])
?>
</p>
<p>
<strong>Products:</strong> 
<?=
h($c['product_count'])
?>
</p>
<p>
<strong>Status:</strong> 
<?=
h($c['status'])
?>
</p>
<?php
else:
?>
<p>Category not found.</p>
<?php
endif;
?>
</div>
<?php
adminEnd();
?>
