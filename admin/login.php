<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true)  {
header('Location: dashboard.php');
exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST')  {
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
require_once __DIR__ . '/../db_config.php';
$email = $username;
$stmt = mysqli_prepare($con, "SELECT id,fullname,email,password,role,status FROM register WHERE (email=? OR fullname=?) AND role='admin' LIMIT 1");
mysqli_stmt_bind_param($stmt, 'ss', $email, $username);
mysqli_stmt_execute($stmt);
$result=mysqli_stmt_get_result($stmt);
$admin=mysqli_fetch_assoc($result);
if ($admin && $admin['status']==='active' && ($password === $admin['password'] || password_verify($password, $admin['password'])))  {
$_SESSION['admin_logged_in']=true;
$_SESSION['admin_id']=$admin['id'];
$_SESSION['admin_name']=$admin['fullname'];
header('Location: dashboard.php');
exit;
}
if ($username === 'admin' && $password === 'admin123')  {
$_SESSION['admin_logged_in']=true;
$_SESSION['admin_id']=$admin['id'] ?? 0;
$_SESSION['admin_name']='Administrator';
header('Location: dashboard.php');
exit;
}
$error = 'Invalid username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
            Admin Login | Surgical Store
        </title>
<link rel="stylesheet" href="/SurgicalStore/admin/css/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="login-page">
<div class="login-card">
<div class="login-logo">
                SS
            </div>
<h1>
                Surgical Store
            </h1>
<p class="muted">
                Admin Login
            </p>
<?php
if ($error):
?>
<div class="alert error">
<?=
htmlspecialchars($error)
?>
</div>
<?php
endif;
?>
<form method="post" data-validate data-validate="" novalidate>
<label>
        Username
    </label>
<input type="text" name="username" data-validation="required min max" data-min="3" data-max="30" required placeholder="Enter username">
<label>
        Password
    </label>
<input type="password" name="password" data-validation="required" required placeholder="Enter password">
<button class="btn primary full" type="submit">
        Login
    </button>
</form>
<div class="demo-login">
<strong>
        Demo Login
    </strong>
<br>
    Username: admin
    <br>
    Password: admin123
</div>
</div>
<script src="/SurgicalStore/js/script.js">
</script>
<script src="/SurgicalStore/admin/js/validation.js">
</script>
</body>
</html>
