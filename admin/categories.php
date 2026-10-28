<?php
require 'layout.php';
if($_SERVER['REQUEST_METHOD']==='POST') {
admin_check_csrf();
$id=(int)($_POST['id']??0);
$name=trim($_POST['category_name']??'');
$desc=trim($_POST['description']??'');
$status=$_POST['status']??'active';
if($name==='') {
admin_flash('Category name is required.','error');
}
elseif($id) {
$st=mysqli_prepare($con,'UPDATE categories SET category_name=?,description=?,status=? WHERE category_id=?');
mysqli_stmt_bind_param($st,'sssi',$name,$desc,$status,$id);
mysqli_stmt_execute($st);
admin_flash('Category updated.');
}
else {
$st=mysqli_prepare($con,'INSERT INTO categories(category_name,description,status) VALUES(?,?,?)');
mysqli_stmt_bind_param($st,'sss',$name,$desc,$status);
mysqli_stmt_execute($st);
admin_flash('Category added.');
}
admin_redirect('categories.php');
}
if(isset($_GET['delete'])) {
$id=(int)$_GET['delete'];
mysqli_query($con,"DELETE FROM categories WHERE category_id=$id");
admin_flash('Category deleted.');
admin_redirect('categories.php');
}
$edit=isset($_GET['edit'])?db_one('SELECT * FROM categories WHERE category_id='.(int)$_GET['edit']):null;
$rows=db_all('SELECT c.*,COUNT(p.product_id) product_count FROM categories c LEFT JOIN products p ON p.category_id=c.category_id GROUP BY c.category_id ORDER BY c.category_id DESC');
adminStart('Categories','categories');
?>
<div class="page-heading">
<div>
<h2>Categories</h2>
<p>Add, edit, view and delete categories.</p>
</div>
</div>
<div class="card">
<h3>
<?=
$edit?'Edit Category':'Add Category'
?>
</h3>
<form method="post" data-validate novalidate class="form-grid">
<input type="hidden" name="csrf_token" value="
<?=
h(admin_csrf())
?>
">
<input type="hidden" name="id" value="
<?=
h($edit['category_id']??0)
?>
">
<div>
<label>Category Name *</label>
<input name="category_name" value="
<?=
h($edit['category_name']??'')
?>
" data-validation="required alpha min max" data-min="2" data-max="100" required>
</div>
<div>
<label>Description</label>
<input name="description" value="
<?=
h($edit['description']??'')
?>
" data-validation="max" data-max="255">
</div>
<div>
<label>Status</label>
<select name="status">
<option value="active" 
<?=
($edit['status']??'active')==='active'?'selected':''
?>
>Active</option>
<option value="inactive" 
<?=
($edit['status']??'')==='inactive'?'selected':''
?>
>Inactive</option>
</select>
</div>
<div>
<button class="btn primary">
<?=
$edit?'Update Category':'Add Category'
?>
</button>
<?php
if($edit):
?>
 <a class="btn" href="categories.php">Cancel</a>
<?php
endif;
?>
</div>
</form>
</div>
<div class="card">
<div class="table-wrap">
<table>
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Description</th>
<th>Products</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
foreach($rows as $c):
?>
<tr>
<td>
<?=
$c['category_id']
?>
</td>
<td>
<?=
h($c['category_name'])
?>
</td>
<td>
<?=
h($c['description'])
?>
</td>
<td>
<?=
$c['product_count']
?>
</td>
<td>
<?=
h($c['status'])
?>
</td>
<td>
<a class="btn small" href="categories.php?edit=
<?=
$c['category_id']
?>
">Edit</a>
<a class="btn small" href="categories.php?delete=
<?=
$c['category_id']
?>
" onclick="return confirm('Delete this category?')">Delete</a>
<a class="btn small" href="view-category.php?id=
<?=
$c['category_id']
?>
">View</a>
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
