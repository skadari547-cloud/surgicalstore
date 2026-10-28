<?php
require 'layout.php';
if(isset($_GET['delete'])) {
$id=(int)$_GET['delete'];
mysqli_query($con,"DELETE FROM products WHERE product_id=$id");
admin_flash('Product deleted.');
admin_redirect('products.php');
}
$rows=db_all('SELECT p.*,c.category_name FROM products p LEFT JOIN categories c ON c.category_id=p.category_id ORDER BY p.product_id DESC');
adminStart('Products','products');
?>
<div class="page-heading">
<div>
<h2>Products</h2>
<p>All product data is stored in MySQL and shown on guest/user pages.</p>
</div>
<a class="btn primary" href="add-products.php">+ Add Product</a>
</div>
<div class="card">
<div class="table-wrap">
<table>
<thead>
<tr>
<th>ID</th>
<th>Image</th>
<th>Product</th>
<th>Category</th>
<th>Price</th>
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
$p['product_id']
?>
</td>
<td>
<img src="/SurgicalStore/images/
<?=
h($p['image']?:'digital-thermometer.jpg')
?>
" style="width:55px;height:55px;object-fit:cover">
</td>
<td>
<?=
h($p['product_name'])
?>
</td>
<td>
<?=
h($p['category_name']??'Uncategorised')
?>
</td>
<td>₹
<?=
number_format((float)$p['price'],2)
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
<a class="btn small" href="view-product.php?id=
<?=
$p['product_id']
?>
">View</a>
<a class="btn small" href="edit-products.php?id=
<?=
$p['product_id']
?>
">Edit</a>
<a class="btn small" href="products.php?delete=
<?=
$p['product_id']
?>
" onclick="return confirm('Delete this product?')">Delete</a>
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
