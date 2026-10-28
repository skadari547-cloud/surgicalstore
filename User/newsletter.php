<?php
require_once '../includes/db.php';
if($_SERVER['REQUEST_METHOD']==='POST') {
$email=trim($_POST['newsletter_email']??'');
if(filter_var($email,FILTER_VALIDATE_EMAIL)) {
$st=mysqli_prepare($con,'INSERT IGNORE INTO newsletter_subscribers(email) VALUES(?)');
mysqli_stmt_bind_param($st,'s',$email);
mysqli_stmt_execute($st);
}
}
$back=$_SERVER['HTTP_REFERER']??'../index.php';
header('Location: '.$back);
exit;
?>
