<?php
require 'common.php';
if($_SERVER['REQUEST_METHOD']==='POST') {
admin_check_csrf();
$id=(int)($_POST['product_id']??0);
$action=$_POST['action']??'';
if($id&&$action==='delete') {
mysqli_query($con,"DELETE FROM products WHERE product_id=$id");
admin_flash('Product deleted.');
}
}
admin_redirect('products.php');
?>
