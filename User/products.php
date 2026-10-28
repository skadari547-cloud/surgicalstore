<?php
require_once __DIR__ . '/../includes/db.php';
require 'layout.php';
userStart('Products','products');
?>
<div class="container">
<div class="page-head">
<span class="eyebrow">PRODUCT CATALOG</span>
<h1>Browse healthcare products</h1>
<p>Products and prices are updated from the store database.</p>
</div>
<div class="filter">
<input id="productSearch" placeholder="Search products...">
<select id="categoryFilter">
<option value="">All Categories</option>
<?php
foreach(db_all("SELECT category_name FROM categories WHERE status='active' ORDER BY category_name") as $c):
?>
<option value="
<?=
h(strtolower($c['category_name']))
?>
">
<?=
h($c['category_name'])
?>
</option>
<?php
endforeach;
?>
</select>
</div>
<div class="grid-4">
<?php
$items=db_all("SELECT p.*,c.category_name FROM products p LEFT JOIN categories c ON c.category_id=p.category_id WHERE p.status='active' ORDER BY p.product_id DESC");
foreach($items as $p): $img=trim($p['image']??'');
$imgPath='../images/';
?>
<div class="product-item" data-category="
<?=
h(strtolower($p['category_name']??''))
?>
">
<div class="product-card">
<img src="/SurgicalStore/images/
<?=
h($img ?: 'digital-thermometer.jpg')
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
<p>
<?=
h($p['description']??'')
?>
</p>
<span class="price">₹
<?=
number_format((float)$p['price'],2)
?>
</span>
<br>
<a class="btn primary small" href="product_details.php?id=
<?=
(int)$p['product_id']
?>
">View Product</a>
</div>
</div>
</div>
<?php
endforeach;
if(!$items) echo '<p>No active products are available yet.</p>';
?>
</div>
</div>
<script>document.getElementById('productSearch')?.addEventListener('input',function(){let q=this.value.toLowerCase();document.querySelectorAll('.product-item').forEach(x=>x.style.display=x.innerText.toLowerCase().includes(q)?'':'none')});document.getElementById('categoryFilter')?.addEventListener('change',function(){let c=this.value;document.querySelectorAll('.product-item').forEach(x=>x.style.display=(!c||x.dataset.category===c)?'':'none')});</script>
<?php
userEnd();
?>
