<?php
require 'layout.php';
$u=db_one('SELECT * FROM register WHERE id='.user_id());
$error='';
if($_SERVER['REQUEST_METHOD']==='POST') {
$name=trim($_POST['fullname']);
$email=trim($_POST['email']);
$mobile=trim($_POST['mobile']);
$address=trim($_POST['address']);
$city=trim($_POST['city']);
$pin=trim($_POST['pincode']);
if(!filter_var($email,FILTER_VALIDATE_EMAIL))$error='Invalid email.';
else {
$st=mysqli_prepare($con,'UPDATE register SET fullname=?,email=?,mobile=?,address=?,city=?,pincode=? WHERE id=?');
mysqli_stmt_bind_param($st,'ssssssi',$name,$email,$mobile,$address,$city,$pin,$u['id']);
mysqli_stmt_execute($st);
$_SESSION['user_name']=$name;
redirect_to('profile.php?saved=1');
}
}
userStart('Profile','');
?>
<div class="container">
<div class="page-head">
<h1>My Profile</h1>
<p>Manage your account information.</p>
</div>
<?php
if(isset($_GET['saved'])):
?>
<div class="alert success">Profile updated.</div>
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
<div class="form-grid">
<div>
<label>Full Name *</label>
<input name="fullname" value="
<?=
h($u['fullname'])
?>
" data-validation="required alpha min max" data-min="2" data-max="100" required>
</div>
<div>
<label>Email *</label>
<input type="email" name="email" value="
<?=
h($u['email'])
?>
" data-validation="required email" required>
</div>
<div>
<label>Mobile *</label>
<input name="mobile" value="
<?=
h($u['mobile'])
?>
" data-validation="required numeric" required>
</div>
<div>
<label>City</label>
<input name="city" value="
<?=
h($u['city'])
?>
" data-validation="alpha">
</div>
<div>
<label>Pincode</label>
<input name="pincode" value="
<?=
h($u['pincode'])
?>
" data-validation="numeric">
</div>
<div class="full">
<label>Address</label>
<textarea name="address" data-validation="min max" data-min="10" data-max="255">
<?=
h($u['address'])
?>
</textarea>
</div>
</div>
<button class="btn primary">Update Profile</button>
</form>
</div>
</div>
<?php
userEnd();
?>
