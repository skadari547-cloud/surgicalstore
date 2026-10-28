<?php
require_once '../includes/db.php';
header('Content-Type: application/json');
echo json_encode(db_all('SELECT id,fullname,email,mobile,city,status FROM register WHERE role="user" ORDER BY id DESC'));
?>
