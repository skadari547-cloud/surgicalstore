<?php
require_once __DIR__.'/common.php';
function adminStart($pageTitle='Admin Dashboard',$activePage='') {
if(!isset($_SESSION['admin_logged_in'])||$_SESSION['admin_logged_in']!==true) {
header('Location: login.php');
exit;
}
$store=setting('store_name','Surgical Store');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>
<?=
h($pageTitle)
?>
 | 
<?=
h($store)
?>
 Admin</title>
<link rel="stylesheet" href="/SurgicalStore/admin/css/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="admin-layout">
<aside class="sidebar" id="sidebar">
<div class="brand">
<div class="brand-icon">SS</div>
<div>
<strong>
<?=
h($store)
?>
</strong>
<small>Admin Panel</small>
</div>
</div>
<nav class="sidebar-menu">
<?php
$links=[['dashboard','dashboard.php','bar-chart-line','Dashboard'],['products','products.php','box-seam','Products'],['categories','categories.php','folder2-open','Categories'],['inventory','inventory.php','tags','Inventory'],['orders','orders.php','cart3','Orders'],['customers','customers.php','people','Customers'],['suppliers','suppliers.php','truck','Suppliers'],['sales','sales-report.php','graph-up','Sales Report'],['stock','stock-report.php','clipboard-data','Stock Report'],['coupons','coupons.php','ticket-perforated','Coupons'],['delivery','delivery-services.php','lightning-charge','Delivery Services'],['messages','messages.php','envelope','Messages']];
foreach($links as $l):
?>
<a href="
<?=
$l[1]
?>
" class="
<?=
$activePage===$l[0]?'active':''
?>
">
<i class="bi bi-
<?=
$l[2]
?>
">
</i>
<span>
<?=
$l[3]
?>
</span>
</a>
<?php
endforeach;
?>
<div class="menu-title">ACCOUNT</div>
<a href="profile.php" class="
<?=
$activePage==='profile'?'active':''
?>
">
<i class="bi bi-person">
</i>
<span>Profile</span>
</a>
<a href="settings.php" class="
<?=
$activePage==='settings'?'active':''
?>
">
<i class="bi bi-gear">
</i>
<span>Settings</span>
</a>
<a href="logout.php">
<i class="bi bi-box-arrow-right">
</i>
<span>Logout</span>
</a>
</nav>
</aside>
<main class="main-content">
<header class="topbar">
<button class="menu-button" type="button">
<i class="bi bi-list">
</i>
</button>
<div>
<h1>
<?=
h($pageTitle)
?>
</h1>
<p>
<?=
h($store)
?>
 management</p>
</div>
<div class="topbar-user">
<span>
<i class="bi bi-person">
</i>
</span>
<strong>
<?=
h($_SESSION['admin_name']??'Admin')
?>
</strong>
</div>
</header>
<section class="page-content">
<?php
admin_show_flash();
}
function adminEnd() {
?>
</section>
<footer class="footer">
<p>© 
<?=
date('Y')
?>
 
<?=
h(setting('store_name','Surgical Store'))
?>
 Admin Panel</p>
</footer>
</main>
</div>
<script src="/SurgicalStore/js/script.js">
</script>
<script src="/SurgicalStore/admin/js/validation.js">
</script>
</body>
</html>
<?php
}
?>
