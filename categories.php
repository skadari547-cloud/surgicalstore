<?php
require 'layout.php';
$rows=db_all("SELECT c.*,COUNT(p.product_id) product_count FROM categories c LEFT JOIN products p ON p.category_id=c.category_id AND p.status='active' WHERE c.status='active' GROUP BY c.category_id ORDER BY c.category_name");
guestStart('Categories','categories');
?>
<div class="container">
<div class="page-head">
<h1>Shop by category</h1>
<p>Categories are managed from the admin panel.</p>
</div>
<div class="grid-4">
<?php
foreach($rows as $c):
?>
<div class="category-card">
<div class="category-icon">
<i class="bi bi-folder2-open">
</i>
</div>
<h3>
<?=
h($c['category_name'])
?>
</h3>
<p>
<?=
h($c['description'])
?>
</p>
<p>
<?=
$c['product_count']
?>
 products</p>
<a class="btn primary small" href="products.php?category=
<?=
$c['category_id']
?>
">Browse Products</a>
</div>
<?php
endforeach;
?>
</div>
</div>
<?php
guestEnd();
?>
