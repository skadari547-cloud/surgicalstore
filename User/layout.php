<?php
require_once __DIR__.'/../includes/db.php';
function userStart($pageTitle='Surgical Store',$activePage='')  {
require_user();
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
</title>
<link rel="stylesheet" href="/SurgicalStore/css/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="announcement">
<div class="container announcement-inner">
<span>
<i class="bi bi-truck">
</i>
<?=
h(setting('announcement_two'))
?>
</span>
<span>
<i class="bi bi-lightning-charge">
</i>
<?=
h(setting('urgent_text','Urgent delivery service available'))
?>
</span>
<span>
<i class="bi bi-headset">
</i>
<?=
h(setting('phone'))
?>
</span>
</div>
</div>
<header class="site-header">
<div class="container nav-wrap">
<a class="logo" href="index.php">
<span class="logo-icon">
<i class="bi bi-heart-pulse-fill">
</i>
</span>
<span>
<?=
h($store)
?>
</span>
</a>
<button class="menu-btn">
<i class="bi bi-list">
</i>
</button>
<nav id="mainNav">
<a class="
<?=
$activePage==='home'?'active':''
?>
" href="index.php">Home</a>
<a class="
<?=
$activePage==='products'?'active':''
?>
" href="products.php">Products</a>
<a class="
<?=
$activePage==='categories'?'active':''
?>
" href="categories.php">Categories</a>
<a class="
<?=
$activePage==='offers'?'active':''
?>
" href="offers.php">Offers</a>
<a class="
<?=
$activePage==='services'?'active':''
?>
" href="services.php">Services</a>
<a class="
<?=
$activePage==='orders'?'active':''
?>
" href="orders.php">My Orders</a>
<a href="../index.php">Store</a>
</nav>
<div class="nav-actions">
<a class="nav-icon" href="wishlist.php">
<i class="bi bi-heart">
</i>
</a>
<a class="nav-icon" href="cart.php">
<i class="bi bi-cart3">
</i>
<span class="nav-count">
<?=
cart_count()
?>
</span>
</a>
<a class="nav-icon" href="profile.php">
<i class="bi bi-person-circle">
</i>
</a>
<a class="login-link" href="logout.php">Logout</a>
</div>
</div>
</header>
<main>
<?php
}
function userEnd()  {
?>
<footer class="footer">
<div class="container footer-grid">
<div>
<a class="footer-brand" href="index.php">
<?=
h(setting('store_name','Surgical Store'))
?>
</a>
<p>
<?=
h(setting('hero_description'))
?>
</p>
</div>
<div>
<h4>Shop</h4>
<a href="products.php">Products</a>
<a href="categories.php">Categories</a>
<a href="offers.php">Offers</a>
<a href="services.php">Services</a>
</div>
<div>
<h4>Account</h4>
<a href="profile.php">Profile</a>
<a href="orders.php">My Orders</a>
<a href="wishlist.php">Wishlist</a>
<a href="change-password.php">Security</a>
</div>
<div>
<h4>Support</h4>
<p>
<?=
h(setting('phone'))
?>
</p>
<p>
<?=
h(setting('email'))
?>
</p>
<p>
<?=
h(setting('address'))
?>
</p>
</div>
</div>
<div class="copyright">© 
<?=
date('Y')
?>
 
<?=
h(setting('store_name','Surgical Store'))
?>
</div>
</footer>
<script src="/SurgicalStore/js/script.js">
</script>
<script src="/SurgicalStore/js/validation.js">
</script>
</body>
</html>
<?php
}
?>
