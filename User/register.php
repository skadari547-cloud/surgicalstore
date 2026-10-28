<?php
session_start();
require_once '../includes/db.php';
if(user_id())redirect_to('index.php');
$error='';
if($_SERVER['REQUEST_METHOD']==='POST') {
$first=trim($_POST['first_name']??'');
$last=trim($_POST['last_name']??'');
$email=trim($_POST['email']??'');
$mobile=trim($_POST['mobile']??'');
$password=$_POST['password']??'';
$confirm=$_POST['confirm_password']??'';
$name=trim($first.' '.$last);
if($password!==$confirm)$error='Password and confirm password do not match.';
elseif(!filter_var($email,FILTER_VALIDATE_EMAIL))$error='Enter a valid email.';
elseif(!preg_match('/^[6-9][0-9]{9}$/',$mobile))$error='Enter a valid mobile number.';
else {
$st=mysqli_prepare($con,'INSERT INTO register(fullname,email,mobile,password,role,status) VALUES(?,?,?,? ,"user","active")');
mysqli_stmt_bind_param($st,'ssss',$name,$email,$mobile,$password);
if(mysqli_stmt_execute($st)) {
$_SESSION['user_id']=mysqli_insert_id($con);
$_SESSION['user_logged_in']=true;
$_SESSION['user_name']=$name;
redirect_to('index.php');
}
$error='Email may already be registered.';
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Create Account | Surgical Store</title>
<link rel="stylesheet" href="/SurgicalStore/css/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="login-page-shell">
<div class="login-panel">
<a class="logo" href="../index.php">
<span class="logo-icon">
<i class="bi bi-heart-pulse-fill">
</i>
</span>
<span>Surgical Store</span>
</a>
<div class="form-card" style="margin:28px 0 0">
<span class="eyebrow">NEW CUSTOMER</span>
<h1 style="text-align:left">Create your account</h1>
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
<form method="post" data-validate novalidate style="margin-top:22px">
<div class="form-grid">
<div class="form-group">
<label>First Name *</label>
<input name="first_name" data-validation="required alpha min max" data-min="2" data-max="30" required>
</div>
<div class="form-group">
<label>Last Name *</label>
<input name="last_name" data-validation="required alpha min max" data-min="2" data-max="30" required>
</div>
<div class="form-group full">
<label>Email *</label>
<input type="email" name="email" data-validation="required email" required>
</div>
<div class="form-group full">
<label>Mobile *</label>
<input name="mobile" data-validation="required numeric" required>
</div>
<div class="form-group">
<label>Password *</label>
<input type="password" id="password" name="password" data-validation="required strongPassword" required>
</div>
<div class="form-group">
<label>Confirm Password *</label>
<input type="password" name="confirm_password" data-validation="required confirmPassword" data-password-id="password" required>
</div>
</div>
<button class="btn primary" style="width:100%">Create Account</button>
</form>
<p style="text-align:center;margin-top:18px">Already registered? <a href="login.php">Login</a>
</p>
</div>
</div>
<div class="login-aside">
<span class="eyebrow">SURGICAL STORE</span>
<h2>Everything you need after browsing.</h2>
</div>
</div>
<script src="/SurgicalStore/js/validation.js">
</script>
</body>
</html>
