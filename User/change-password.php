<?php
require 'layout.php';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST') {
$u=db_one('SELECT * FROM register WHERE id='.user_id());
$old=$_POST['old_password'];
$new=$_POST['password'];
$confirm=$_POST['confirm_password'];
if(!($old===$u['password']||password_verify($old,$u['password'])))$error='Old password is incorrect.';
elseif($new!==$confirm)$error='Passwords do not match.';
else {
$st=mysqli_prepare($con,'UPDATE register SET password=? WHERE id=?');
mysqli_stmt_bind_param($st,'si',$new,$u['id']);
mysqli_stmt_execute($st);
redirect_to('change-password.php?saved=1');
}
}
userStart('Change Password','');
?>
<div class="container">
<div class="page-head">
<h1>Change Password</h1>
</div>
<?php
if(isset($_GET['saved'])):
?>
<div class="alert success">Password changed.</div>
<?php
endif;
?>
<?php
if($error):
?>
<div class="alert error">
<?=
h($error)
?>
</div>
<?php
endif;
?>
<div class="form-card">
<form method="post" data-validate novalidate>
<div class="form-group">
<label>Old Password *</label>
<input type="password" name="old_password" data-validation="required" required>
</div>
<div class="form-group">
<label>New Password *</label>
<input id="password" type="password" name="password" data-validation="required strongPassword" required>
</div>
<div class="form-group">
<label>Confirm Password *</label>
<input type="password" name="confirm_password" data-validation="required confirmPassword" data-password-id="password" required>
</div>
<button class="btn primary">Change Password</button>
</form>
</div>
</div>
<?php
userEnd();
?>
