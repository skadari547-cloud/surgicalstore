<?php
require 'layout.php';
$id=(int)($_SESSION['admin_id']??0);
$admin=$id?db_one("SELECT * FROM register WHERE id=$id AND role='admin'"):db_one("SELECT * FROM register WHERE role='admin' ORDER BY id LIMIT 1");
if($_SERVER['REQUEST_METHOD']==='POST') {
admin_check_csrf();
$name=trim($_POST['fullname']);
$email=trim($_POST['email']);
$mobile=trim($_POST['mobile']);
$st=mysqli_prepare($con,'UPDATE register SET fullname=?,email=?,mobile=? WHERE id=? AND role="admin"');
mysqli_stmt_bind_param($st,'sssi',$name,$email,$mobile,$admin['id']);
mysqli_stmt_execute($st);
$_SESSION['admin_name']=$name;
$_SESSION['admin_id']=$admin['id'];
admin_flash('Profile updated.');
admin_redirect('profile.php');
}
adminStart('Profile','profile');
?>
<div class="page-heading">
<h2>Admin Profile</h2>
</div>
<div class="card">
<form method="post" data-validate novalidate class="form-grid">
<input type="hidden" name="csrf_token" value="
<?=
h(admin_csrf())
?>
">
<div>
<label>Name *</label>
<input name="fullname" value="
<?=
h($admin['fullname']??'')
?>
" data-validation="required alpha min max" data-min="2" data-max="100" required>
</div>
<div>
<label>Email *</label>
<input type="email" name="email" value="
<?=
h($admin['email']??'')
?>
" data-validation="required email" required>
</div>
<div>
<label>Mobile</label>
<input name="mobile" value="
<?=
h($admin['mobile']??'')
?>
" data-validation="numeric">
</div>
<div>
<label>Role</label>
<input value="Admin" readonly>
</div>
<div>
<button class="btn primary">Update Profile</button>
</div>
</form>
</div>
<?php
adminEnd();
?>
