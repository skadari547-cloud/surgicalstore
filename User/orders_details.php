<?php
$id=(int)($_GET['id']??0);
header('Location: order-details.php?id='.$id);
exit;
?>
