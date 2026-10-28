<?php
require 'layout.php';
$cats=db_all("SELECT category_id,category_name FROM categories WHERE status='active' ORDER BY category_name");
$error='';
if($_SERVER['REQUEST_METHOD']==='POST') {
admin_check_csrf();
$name=trim($_POST['product_name']??'');
$cat=(int)($_POST['category_id']??0);
$price=(float)($_POST['price']??0);
$stock=(int)($_POST['stock_quantity']??0);
$brand=trim($_POST['brand']??'');
$desc=trim($_POST['description']??'');
$image=trim($_POST['image']??'');
$status=$_POST['status']??'active';
if($name===''||$price<0||$stock<0)$error='Please enter valid product details.';
else {
$st=mysqli_prepare($con,"INSERT INTO products(category_id,product_name,description,brand,price,stock_quantity,image,status) VALUES(NULLIF(?,0),?,?,?,?,?,?,?)");
mysqli_stmt_bind_param($st,'isssdiss',$cat,$name,$desc,$brand,$price,$stock,$image,$status);
if(mysqli_stmt_execute($st)) {
admin_flash('Product added.');
admin_redirect('products.php');
}
$error='Could not add product.';
}
}
adminStart('Add Product','products');
?>
<div class="page-heading">
<div>
<h2>Add Product</h2>
</div>
<a class="btn" href="products.php">Back</a>
</div>
<div class="card">
<?php
if($error):
?>
<p class="alert error">
<?=
h($error)
?>
</p>
<?php
endif;
?>
<form method="post" data-validate novalidate>
<input type="hidden" name="csrf_token" value="
<?=
h(admin_csrf())
?>
">
<div class="form-grid">
<div>
<label>Product Name *</label>
<input name="product_name" data-validation="required min max" data-min="2" data-max="150" required>
</div>
<div>
<label>Category *</label>
<select name="category_id" data-validation="required" required>
<option value="">Select Category</option>
<?php
foreach($cats as $c):
?>
<option value="
<?=
$c['category_id']
?>
">
<?=
h($c['category_name'])
?>
</option>
<?php
endforeach;
?>
</select>
</div>
<div>
<label>Brand</label>
<input name="brand" data-validation="max" data-max="100">
</div>
<div>
<label>Price *</label>
<input type="number" name="price" min="0" step="0.01" data-validation="required" required>
</div>
<div>
<label>Stock Quantity *</label>
<input type="number" name="stock_quantity" min="0" data-validation="required numeric" required>
</div>
<div>
<label>Image filename</label>
<input name="image" placeholder="digital-thermometer.jpg" data-validation="max" data-max="255">
</div>
<div>
<label>Status</label>
<select name="status">
<option value="active">Active</option>
<option value="inactive">Inactive</option>
</select>
</div>
<div class="full-width">
<label>Description</label>
<textarea name="description" rows="4" data-validation="max" data-max="1000">
</textarea>
</div>
</div>
<button class="btn primary">Save Product</button>
</form>
</div>
<?php
adminEnd();
?>
