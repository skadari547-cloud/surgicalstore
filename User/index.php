<?php
require 'layout.php';
$featured=db_all("SELECT p.*,c.category_name FROM products p LEFT JOIN categories c ON c.category_id=p.category_id WHERE p.status='active' ORDER BY p.product_id DESC LIMIT 4");
userStart('Home','home');
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
<a class="btn primary" href="products.php">Shop Products</a>
<a class="btn" href="offers.php">View Coupons</a>
</div>
<div class="hero-image">
<img src="/SurgicalStore/images/stethoscope.jpg" alt="Healthcare products">
<div class="floating-note">
<i class="bi bi-lightning-charge">
</i>Urgent delivery available</div>
</div>
</div>
</section>
<section class="section">
<div class="container">
<div class="section-title">
<h2>Latest Products</h2>
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
h($p['category_name']??'')
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
userEnd();
?>
