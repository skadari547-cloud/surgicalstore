<?php
require 'layout.php';
$rows=db_all('SELECT p.product_name,p.stock_quantity,p.price,c.category_name FROM products p LEFT JOIN categories c ON c.category_id=p.category_id ORDER BY p.stock_quantity ASC');
adminStart('Stock Report','stock');
?>
<div class="page-heading">
<h2>Stock Report</h2>
</div>
<div class="card">
<div class="table-wrap">
<table>
<thead>
<tr>
<th>Product</th>
<th>Category</th>
<th>Stock</th>
<th>Price</th>
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
<td>
<?=
h($r['category_name']??'')
?>
</td>
<td>
<?=
$r['stock_quantity']
?>
</td>
<td>₹
<?=
number_format($r['price'],2)
?>
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
