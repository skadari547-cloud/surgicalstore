<?php
require 'layout.php';
$id=(int)($_GET['id']??0);
if(isset($_GET['add'])) {
cart_add($id,max(1,(int)($_GET['qty']??1)));
redirect_to('product_details.php?id='.$id.'&added=1');
}
$p=db_one("SELECT p.*,c.category_name FROM products p LEFT JOIN categories c ON c.category_id=p.category_id WHERE p.product_id=$id AND p.status='active'");
userStart('Product Details','products');
?>
<div class="container product-detail-page">
<div class="page-head">
<span class="eyebrow">PRODUCT DETAILS</span>
<h1>
<?=
h($p['product_name']??'Product not found')
?>
</h1>
<p>Product information, availability and easy shopping in one place.</p>
</div>
    
<?php
if(isset($_GET['added'])):
?>
        <div class="alert success">
<i class="bi bi-check-circle">
</i> Product added to your cart successfully.</div>
    
<?php
endif;
?>
    
<?php
if($p):
?>
    <div class="product-detail-shell">
<div class="product-detail-media">
<img src="/SurgicalStore/images/
<?=
h($p['image']?:'digital-thermometer.jpg')
?>
" alt="
<?=
h($p['product_name'])
?>
">
</div>
<div class="product-detail-info">
<div class="product-detail-breadcrumb">
<a href="products.php">Products</a> / 
<?=
h($p['category_name']??'Healthcare')
?>
</div>
<span class="category">
<?=
h($p['category_name']??'Healthcare')
?>
</span>
<h2 class="product-detail-title">
<?=
h($p['product_name'])
?>
</h2>
<div class="product-detail-price">₹
<?=
number_format($p['price'],2)
?>
</div>
<p class="product-detail-description">
<?=
h($p['description']?:'Reliable healthcare product suitable for home, clinic and everyday medical needs.')
?>
</p>
<div class="product-detail-meta">
<div class="product-meta-item">
<span class="product-meta-label">Brand</span>
<span class="product-meta-value">
<?=
h($p['brand']?:'Not specified')
?>
</span>
</div>
<div class="product-meta-item">
<span class="product-meta-label">Category</span>
<span class="product-meta-value">
<?=
h($p['category_name']??'Healthcare')
?>
</span>
</div>
</div>
            
<?php
if($p['stock_quantity']>0):
?>
                <span class="product-stock">
<i class="bi bi-check2">
</i> In stock · 
<?=
$p['stock_quantity']
?>
 available</span>
<div class="product-detail-actions">
<input class="product-quantity" type="number" min="1" max="
<?=
h($p['stock_quantity'])
?>
" value="1" id="productQty">
<a class="btn primary" href="product_details.php?id=
<?=
$p['product_id']
?>
&add=1" onclick="this.href='product_details.php?id=
<?=
$p['product_id']
?>
&add=1&qty='+document.getElementById('productQty').value">
<i class="bi bi-cart-plus">
</i> Add to Cart</a>
</div>
            
<?php
else:
?>
                <span class="product-stock out">
<i class="bi bi-x-circle">
</i> Currently out of stock</span>
            
<?php
endif;
?>
            <div class="product-trust-row">
<div class="product-trust-item">
<i class="bi bi-shield-check">
</i>Quality checked</div>
<div class="product-trust-item">
<i class="bi bi-truck">
</i>Easy delivery</div>
<div class="product-trust-item">
<i class="bi bi-headset">
</i>Support available</div>
</div>
</div>
</div>
    
<?php
else:
?>
        <div class="product-not-found">
<i class="bi bi-box-seam" style="font-size:38px;color:#087f8c">
</i>
<h2 style="margin:12px 0 6px">Product unavailable</h2>
<p style="color:#6b7d86">This product may have been removed or is currently inactive.</p>
<br>
<a class="btn primary" href="products.php">Browse Products</a>
</div>
    
<?php
endif;
?>
</div>
<?php
userEnd();
?>
