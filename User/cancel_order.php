<?php
require '../includes/db.php';
require_user();
$id=(int)($_GET['id']??0);
mysqli_query($con,"UPDATE orders SET order_status='cancelled' WHERE order_id=$id AND user_id=".user_id()." AND order_status IN ('pending','confirmed')");
header('Location: orders.php');
exit;
?>
