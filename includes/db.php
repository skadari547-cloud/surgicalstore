<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../db_config.php';
mysqli_set_charset($con, 'utf8mb4');
function h($v) {
return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');
}
function db_all($sql) {
global $con;
$r=mysqli_query($con,$sql);
return $r ? mysqli_fetch_all($r,MYSQLI_ASSOC) : [];
}
function db_one($sql) {
global $con;
$r=mysqli_query($con,$sql);
return $r ? mysqli_fetch_assoc($r) : null;
}
function redirect_to($url) {
header('Location: '.$url);
exit;
}
function setting($key,$default='') {
global $con;
$key=mysqli_real_escape_string($con,$key);
$r=mysqli_query($con,"SELECT setting_value FROM site_settings WHERE setting_key='$key' LIMIT 1");
$row=$r?mysqli_fetch_assoc($r):null;
return $row ? $row['setting_value'] : $default;
}
function set_setting($key,$value) {
global $con;
$st=mysqli_prepare($con,"INSERT INTO site_settings(setting_key,setting_value) VALUES(?,?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)");
mysqli_stmt_bind_param($st,'ss',$key,$value);
return mysqli_stmt_execute($st);
}
function user_id() {
return (int)($_SESSION['user_id'] ?? 0);
}
function require_user() {
if(user_id()<=0) {
redirect_to('login.php');
}
}
function cart_items() {
return $_SESSION['cart'] ?? [];
}
function cart_count() {
$n=0;
foreach(cart_items() as $q)$n+=(int)$q;
return $n;
}
function cart_add($id,$qty=1) {
$_SESSION['cart']=$_SESSION['cart']??[];
$_SESSION['cart'][$id]=($_SESSION['cart'][$id]??0)+max(1,(int)$qty);
}
function cart_remove($id) {
unset($_SESSION['cart'][$id]);
}
function cart_clear() {
$_SESSION['cart']=[];
}
function cart_rows() {
global $con;
$cart=cart_items();
if(!$cart)return [];
$ids=array_map('intval',array_keys($cart));
$idList=implode(',',$ids);
$rows=db_all("SELECT p.*,c.category_name FROM products p LEFT JOIN categories c ON c.category_id=p.category_id WHERE p.product_id IN ($idList) AND p.status='active'");
foreach($rows as &$r)$r['quantity']=(int)($cart[$r['product_id']]??1);
return $rows;
}
?>
