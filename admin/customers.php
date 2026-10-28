<?php
require 'layout.php';
if(isset($_GET['delete'])) {
mysqli_query($con,'DELETE FROM register WHERE id='.(int)$_GET['delete'].' AND role="user"');
admin_flash('Customer deleted.');
admin_redirect('customers.php');
}
if($_SERVER['REQUEST_METHOD']==='POST') {
admin_check_csrf();
$id=(int)$_POST['id'];
$name=trim($_POST['fullname']);
$email=trim($_POST['email']);
$mobile=trim($_POST['mobile']);
$address=trim($_POST['address']);
$city=trim($_POST['city']);
$pin=trim($_POST['pincode']);
$status=$_POST['status'];
$st=mysqli_prepare($con,'UPDATE register SET fullname=?,email=?,mobile=?,address=?,city=?,pincode=?,status=? WHERE id=? AND role="user"');
mysqli_stmt_bind_param($st,'sssssssi',$name,$email,$mobile,$address,$city,$pin,$status,$id);
mysqli_stmt_execute($st);
admin_flash('Customer updated.');
admin_redirect('customers.php');
}
$edit=isset($_GET['edit'])?db_one('SELECT * FROM register WHERE id='.(int)$_GET['edit'].' AND role="user"'):null;
$rows=db_all("SELECT u.*,COUNT(o.order_id) order_count FROM register u LEFT JOIN orders o ON o.user_id=u.id WHERE u.role='user' GROUP BY u.id ORDER BY u.id DESC");
adminStart('Customers','customers');
?>
<div class="page-heading">
<h2>Customers</h2>
<p>View, edit, block and delete registered users.</p>
</div>
<?php
if($edit):
?>
<div class="card">
<h3>Edit Customer</h3>
<form method="post" data-validate novalidate class="form-grid">
<input type="hidden" name="csrf_token" value="
<?=
h(admin_csrf())
?>
">
<input type="hidden" name="id" value="
<?=
$edit['id']
?>
">
<div>
<label>Full Name *</label>
<input name="fullname" value="
<?=
h($edit['fullname'])
?>
" data-validation="required alpha min max" data-min="2" data-max="100" required>
</div>
<div>
<label>Email *</label>
<input type="email" name="email" value="
<?=
h($edit['email'])
?>
" data-validation="required email" required>
</div>
<div>
<label>Mobile *</label>
<input name="mobile" value="
<?=
h($edit['mobile'])
?>
" data-validation="required numeric" required>
</div>
<div>
<label>City</label>
<input name="city" value="
<?=
h($edit['city'])
?>
" data-validation="alpha">
</div>
<div>
<label>Pincode</label>
<input name="pincode" value="
<?=
h($edit['pincode'])
?>
" data-validation="numeric">
</div>
<div>
<label>Status</label>
<select name="status">
<option value="active" 
<?=
$edit['status']==='active'?'selected':''
?>
>Active</option>
<option value="blocked" 
<?=
$edit['status']==='blocked'?'selected':''
?>
>Blocked</option>
<option value="inactive" 
<?=
$edit['status']==='inactive'?'selected':''
?>
>Inactive</option>
</select>
</div>
<div class="full-width">
<label>Address</label>
<textarea name="address">
<?=
h($edit['address'])
?>
</textarea>
</div>
<div>
<button class="btn primary">Update Customer</button>
<a class="btn" href="customers.php">Cancel</a>
</div>
</form>
</div>
<?php
endif;
?>
<div class="card">
<div class="table-wrap">
<table>
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Orders</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
foreach($rows as $u):
?>
<tr>
<td>
<?=
$u['id']
?>
</td>
<td>
<?=
h($u['fullname'])
?>
</td>
<td>
<?=
h($u['email'])
?>
</td>
<td>
<?=
h($u['mobile'])
?>
</td>
<td>
<?=
$u['order_count']
?>
</td>
<td>
<?=
h($u['status'])
?>
</td>
<td>
<a class="btn small" href="view-customer.php?id=
<?=
$u['id']
?>
">View</a>
<a class="btn small" href="customers.php?edit=
<?=
$u['id']
?>
">Edit</a>
<a class="btn small" href="customers.php?delete=
<?=
$u['id']
?>
" onclick="return confirm('Delete customer and their orders?')">Delete</a>
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
