<?php
require_once __DIR__ . '/includes/db.php';
function guestStart($pageTitle='Surgical Store',$activePage='')  {
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
<i class="bi bi-shield-check">
</i>
<?=
h(setting('announcement_one'))
?>
</span>
<span>
<i class="bi bi-truck">
</i>
<?=
h(setting('announcement_two'))
?>
</span>
<span>
<i class="bi bi-headset">
</i>
<?=
h(setting('announcement_three'))
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
<button class="menu-btn" type="button">
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
$activePage==='about'?'active':''
?>
" href="about.php">About</a>
<a class="
<?=
$activePage==='contact'?'active':''
?>
" href="contact.php">Contact</a>
</nav>
<div class="nav-actions">
<a class="nav-icon" href="User/cart.php">
<i class="bi bi-cart3">
</i>
</a>
<a class="login-link" href="User/login.php">Login</a>
<a class="btn primary small" href="User/register.php">Create Account</a>
</div>
</div>
</header>
<main>
<?php
}
function guestEnd()  {
?>
<section class="newsletter">
<div class="container newsletter-inner">
<div>
<span class="eyebrow">STAY INFORMED</span>
<h2>Get useful product updates & offers</h2>
<p>Receive occasional updates about new healthcare essentials and store offers.</p>
</div>
<form method="post" action="User/newsletter.php" class="newsletter-form" data-validate novalidate>
<input type="email" name="newsletter_email" data-validation="required email" placeholder="Your email address" required>
<button class="btn primary">Subscribe <i class="bi bi-arrow-right">
</i>
</button>
</form>
</div>
</section>
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
<h4>Company</h4>
<a href="about.php">About Us</a>
<a href="contact.php">Contact Us</a>
<a href="User/login.php">Customer Login</a>
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
. All rights reserved.</div>
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
