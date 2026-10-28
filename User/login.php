<?php
session_start();
require_once '../includes/db.php';
if(user_id())redirect_to('index.php');
$error='';
if($_SERVER['REQUEST_METHOD']==='POST') {
$email=trim($_POST['email']??'');
$password=$_POST['password']??'';
$st=mysqli_prepare($con,"SELECT * FROM register WHERE email=? AND role='user' LIMIT 1");
mysqli_stmt_bind_param($st,'s',$email);
mysqli_stmt_execute($st);
$r=mysqli_stmt_get_result($st);
$u=mysqli_fetch_assoc($r);
if($u&&$u['status']==='active'&&($password===$u['password']||password_verify($password,$u['password']))) {
$_SESSION['user_id']=$u['id'];
$_SESSION['user_logged_in']=true;
$_SESSION['user_name']=$u['fullname'];
redirect_to('index.php');
}
$error='Invalid email or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Login | Surgical Store</title>
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
<span class="eyebrow">CUSTOMER ACCOUNT</span>
<h1 style="text-align:left">Welcome back</h1>
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
<div class="form-group">
<label>Email *</label>
<input type="email" name="email" data-validation="required email" required>
</div>
<div class="form-group">
<label>Password *</label>
<input type="password" name="password" data-validation="required" required>
</div>
<button class="btn primary" style="width:100%">Login</button>
</form>
<p style="text-align:center;margin-top:18px">New customer? <a href="register.php">Create an account</a>
</p>
<p style="text-align:center">
<a href="../index.php">← Back to store</a>
</p>
</div>
</div>
<div class="login-aside">
<span class="eyebrow">SURGICAL STORE</span>
<h2>Shop products, use coupons and track orders.</h2>
</div>
</div>
<script src="/SurgicalStore/js/validation.js">
</script>
</body>
</html>
