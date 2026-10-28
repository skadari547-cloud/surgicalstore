<?php
require 'layout.php';
$rows=db_all('SELECT p.*,c.category_name FROM products p LEFT JOIN categories c ON c.category_id=p.category_id ORDER BY p.stock_quantity ASC');
adminStart('Inventory','inventory');
?>
<div class="page-heading">
<h2>Inventory</h2>
<p>Live stock from products table.</p>
</div>
<div class="card">
<div class="table-wrap">
<table>
<thead>
<tr>
<th>Product</th>
<th>Category</th>
<th>Stock</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
foreach($rows as $p):
?>
<tr>
<td>
<?=
h($p['product_name'])
?>
</td>
<td>
<?=
h($p['category_name']??'')
?>
</td>
<td>
<?=
$p['stock_quantity']
?>
</td>
<td>
<?=
h($p['status'])
?>
</td>
<td>
<a class="btn small" href="edit-products.php?id=
<?=
$p['product_id']
?>
">Edit Stock</a>
</td>
</tr>
<?php
endforeach;
?>
</tbody>
</table>
</div>
</div>
<?php
adminEnd();
?>
