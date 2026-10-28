<?php
require 'layout.php';
$cats=db_all("SELECT c.*,COUNT(p.product_id) product_count FROM categories c LEFT JOIN products p ON p.category_id=c.category_id AND p.status='active' WHERE c.status='active' GROUP BY c.category_id ORDER BY c.category_id LIMIT 8");
$featured=db_all("SELECT p.*,c.category_name FROM products p LEFT JOIN categories c ON c.category_id=p.category_id WHERE p.status='active' ORDER BY p.product_id DESC LIMIT 4");
guestStart('Home','home');
?>
<section class="hero">
<div class="container hero-grid">
<div>
<span class="eyebrow">
<?=
h(setting('hero_eyebrow'))
?>
</span>
<h1>
<?=
h(setting('hero_title'))
?>
</h1>
<p>
<?=
h(setting('hero_description'))
?>
</p>
<a class="btn primary" href="products.php">Explore Products <i class="bi bi-arrow-right">
</i>
</a>
<a class="btn" href="offers.php">View Offers</a>
</div>
<div class="hero-image">
<img src="/SurgicalStore/images/stethoscope.jpg" alt="Healthcare products">
<div class="floating-note">
<i class="bi bi-shield-check">
</i>
<?=
h(setting('announcement_one'))
?>
</div>
</div>
</div>
</section>
<section class="section">
<div class="container">
<div class="section-title">
<div>
<span class="eyebrow">SHOP BY NEED</span>
<h2>Find what you need faster</h2>
</div>
</div>
<div class="grid-4">
<?php
foreach($cats as $c):
?>
<a class="category-card" href="products.php?category=
<?=
$c['category_id']
?>
">
<div class="category-icon">
<i class="bi bi-heart-pulse">
</i>
</div>
<h3>
<?=
h($c['category_name'])
?>
</h3>
<p>
<?=
h($c['description'])
?>
</p>
<small>
<?=
$c['product_count']
?>
 products</small>
</a>
<?php
endforeach;
?>
</div>
</div>
</section>
<section class="section section-soft">
<div class="container">
<div class="section-title">
<div>
<span class="eyebrow">LATEST PRODUCTS</span>
<h2>Recently added</h2>
</div>
</div>
<div class="grid-4">
<?php
foreach($featured as $p):
?>
<div class="product-card">
<img src="/SurgicalStore/images/
<?=
h($p['image']?:'digital-thermometer.jpg')
?>
" alt="
<?=
h($p['product_name'])
?>
">
<div class="product-info">
<span class="category">
<?=
h($p['category_name']??'Healthcare')
?>
</span>
<h3>
<?=
h($p['product_name'])
?>
</h3>
<span class="price">₹
<?=
number_format($p['price'],2)
?>
</span>
<br>
<a class="btn primary small" href="product_details.php?id=
<?=
$p['product_id']
?>
">View Product</a>
</div>
</div>
<?php
endforeach;
?>
</div>
</div>
</section>
<?php
guestEnd();
?>
