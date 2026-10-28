<?php
require 'layout.php';
$id=(int)($_GET['id']??0);
$p=db_one("SELECT * FROM products WHERE product_id=$id");
if(!$p)admin_redirect('products.php');
$cats=db_all('SELECT category_id,category_name FROM categories ORDER BY category_name');
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
$status=$_POST['status']==='inactive'?'inactive':'active';
if($name===''||$price<0||$stock<0)$error='Please enter valid product details.';
else {
$st=mysqli_prepare($con,'UPDATE products SET category_id=NULLIF(?,0),product_name=?,description=?,brand=?,price=?,stock_quantity=?,image=?,status=? WHERE product_id=?');
mysqli_stmt_bind_param($st,'isssdissi',$cat,$name,$desc,$brand,$price,$stock,$image,$status,$id);
if(mysqli_stmt_execute($st)) {
admin_flash('Product updated.');
admin_redirect('products.php');
}
$error='Could not update product.';
}
$p=db_one("SELECT * FROM products WHERE product_id=$id");
}
adminStart('Edit Product','products');
?>
<div class="page-heading">
<div>
<h2>Edit Product</h2>
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
<input name="product_name" value="
<?=
h($p['product_name'])
?>
" data-validation="required min max" data-min="2" data-max="150" required>
</div>
<div>
<label>Category</label>
<select name="category_id">
<option value="0">No category</option>
<?php
foreach($cats as $c):
?>
<option value="
<?=
$c['category_id']
?>
" 
<?=
$p['category_id']==$c['category_id']?'selected':''
?>
>
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
<input name="brand" value="
<?=
h($p['brand'])
?>
" data-validation="max" data-max="100">
</div>
<div>
<label>Price *</label>
<input type="number" name="price" value="
<?=
h($p['price'])
?>
" min="0" step="0.01" data-validation="required" required>
</div>
<div>
<label>Stock *</label>
<input type="number" name="stock_quantity" value="
<?=
h($p['stock_quantity'])
?>
" min="0" data-validation="required numeric" required>
</div>
<div>
<label>Image filename</label>
<input name="image" value="
<?=
h($p['image'])
?>
">
</div>
<div>
<label>Status</label>
<select name="status">
<option value="active" 
<?=
$p['status']==='active'?'selected':''
?>
>Active</option>
<option value="inactive" 
<?=
$p['status']==='inactive'?'selected':''
?>
>Inactive</option>
</select>
</div>
<div class="full-width">
<label>Description</label>
<textarea name="description" rows="4" data-validation="max" data-max="1000">
<?=
h($p['description'])
?>
</textarea>
</div>
</div>
<button class="btn primary">Update Product</button>
</form>
</div>
<?php
adminEnd();
?>
