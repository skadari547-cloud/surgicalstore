<?php
require 'layout.php';
$category=(int)($_GET['category']??0);
$cats=db_all("SELECT * FROM categories WHERE status='active' ORDER BY category_name");
$where=$category?" AND p.category_id=$category":'';
$items=db_all("SELECT p.*,c.category_name FROM products p LEFT JOIN categories c ON c.category_id=p.category_id WHERE p.status='active' $where ORDER BY p.product_id DESC");
guestStart('Products','products');
?>
<div class="container">
<div class="page-head">
<span class="eyebrow">PRODUCT CATALOG</span>
<h1>Browse healthcare products</h1>
<p>Products and prices are loaded from the database.</p>
</div>
<div class="filter">
<input id="productSearch" placeholder="Search products...">
<select id="categoryFilter">
<option value="">All Categories</option>
<?php
foreach($cats as $c):
?>
<option value="
<?=
$c['category_id']
?>
" 
<?=
$category===$c['category_id']?'selected':''
?>
>
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
foreach($items as $p):
?>
<div class="product-item">
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
<p>
<?=
h($p['description'])
?>
</p>
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
</div>
<?php
endforeach;
if(!$items):
?>
<p>No active products found.</p>
<?php
endif;
?>
</div>
</div>
<script>document.getElementById('productSearch')?.addEventListener('input',function(){let q=this.value.toLowerCase();document.querySelectorAll('.product-item').forEach(x=>x.style.display=x.innerText.toLowerCase().includes(q)?'':'none')});document.getElementById('categoryFilter')?.addEventListener('change',function(){location.href='products.php'+(this.value?'?category='+this.value:'')});</script>
<?php
guestEnd();
?>
