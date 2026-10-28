<?php
require 'layout.php';
$edit=isset($_GET['edit'])?db_one('SELECT * FROM suppliers WHERE supplier_id='.(int)$_GET['edit']):null;
if($_SERVER['REQUEST_METHOD']==='POST') {
admin_check_csrf();
$id=(int)$_POST['id'];
$name=trim($_POST['supplier_name']);
$person=trim($_POST['contact_person']);
$phone=trim($_POST['phone']);
$email=trim($_POST['email']);
$address=trim($_POST['address']);
$status=$_POST['status']??'active';
if($id) {
$st=mysqli_prepare($con,'UPDATE suppliers SET supplier_name=?,contact_person=?,phone=?,email=?,address=?,status=? WHERE supplier_id=?');
mysqli_stmt_bind_param($st,'ssssssi',$name,$person,$phone,$email,$address,$status,$id);
}
else {
$st=mysqli_prepare($con,'INSERT INTO suppliers(supplier_name,contact_person,phone,email,address,status) VALUES(?,?,?,?,?,?)');
mysqli_stmt_bind_param($st,'ssssss',$name,$person,$phone,$email,$address,$status);
}
mysqli_stmt_execute($st);
admin_flash($id?'Supplier updated.':'Supplier added.');
admin_redirect('suppliers.php');
}
if(isset($_GET['delete'])) {
mysqli_query($con,'DELETE FROM suppliers WHERE supplier_id='.(int)$_GET['delete']);
admin_flash('Supplier deleted.');
admin_redirect('suppliers.php');
}
$rows=db_all('SELECT * FROM suppliers ORDER BY supplier_id DESC');
adminStart('Suppliers','suppliers');
?>
<div class="page-heading">
<h2>Suppliers</h2>
</div>
<div class="card">
<h3>
<?=
$edit?'Edit Supplier':'Add Supplier'
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
h($edit['supplier_id']??0)
?>
">
<div>
<label>Supplier Name *</label>
<input name="supplier_name" value="
<?=
h($edit['supplier_name']??'')
?>
" data-validation="required min max" data-min="2" data-max="150" required>
</div>
<div>
<label>Contact Person</label>
<input name="contact_person" value="
<?=
h($edit['contact_person']??'')
?>
" data-validation="alpha max" data-max="100">
</div>
<div>
<label>Phone</label>
<input name="phone" value="
<?=
h($edit['phone']??'')
?>
" data-validation="numeric">
</div>
<div>
<label>Email</label>
<input type="email" name="email" value="
<?=
h($edit['email']??'')
?>
" data-validation="email">
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
<div class="full-width">
<label>Address</label>
<input name="address" value="
<?=
h($edit['address']??'')
?>
">
</div>
<div>
<button class="btn primary">
<?=
$edit?'Update Supplier':'Add Supplier'
?>
</button>
</div>
</form>
</div>
<div class="card">
<div class="table-wrap">
<table>
<thead>
<tr>
<th>ID</th>
<th>Supplier</th>
<th>Contact</th>
<th>Phone</th>
<th>Email</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
foreach($rows as $s):
?>
<tr>
<td>
<?=
$s['supplier_id']
?>
</td>
<td>
<?=
h($s['supplier_name'])
?>
</td>
<td>
<?=
h($s['contact_person'])
?>
</td>
<td>
<?=
h($s['phone'])
?>
</td>
<td>
<?=
h($s['email'])
?>
</td>
<td>
<?=
h($s['status'])
?>
</td>
<td>
<a class="btn small" href="suppliers.php?edit=
<?=
$s['supplier_id']
?>
">Edit</a>
<a class="btn small" href="suppliers.php?delete=
<?=
$s['supplier_id']
?>
" onclick="return confirm('Delete supplier?')">Delete</a>
<a class="btn small" href="view-supplier.php?id=
<?=
$s['supplier_id']
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
