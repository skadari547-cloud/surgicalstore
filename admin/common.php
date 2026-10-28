<?php
if(session_status()===PHP_SESSION_NONE)session_start();
require_once dirname(__DIR__).'/includes/db.php';
function admin_csrf() {
if(empty($_SESSION['admin_csrf']))$_SESSION['admin_csrf']=bin2hex(random_bytes(32));
return $_SESSION['admin_csrf'];
}
function admin_check_csrf() {
if(!hash_equals($_SESSION['admin_csrf']??'',$_POST['csrf_token']??'')) {
http_response_code(403);
exit('Security check failed.');
}
}
function admin_flash($m,$type='success') {
$_SESSION['admin_flash']=['message'=>$m,'type'=>$type];
}
function admin_show_flash() {
if(!empty($_SESSION['admin_flash'])) {
$f=$_SESSION['admin_flash'];
unset($_SESSION['admin_flash']);
echo '<div class="alert '.h($f['type']).'">'.h($f['message']).'</div>';
}
}
function admin_redirect($u) {
header('Location: '.$u);
exit;
}
?>
