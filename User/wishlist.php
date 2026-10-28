<?php
require 'layout.php';
if(isset($_GET['add'])) {
$id=(int)$_GET['add'];
$st=mysqli_prepare($con,'INSERT IGNORE INTO wishlist(user_id,product_id) VALUES(?,?)');
mysqli_stmt_bind_param($st,'ii',$_SESSION['user_id'],$id);
mysqli_stmt_execute($st);
redirect_to('wishlist.php');
}
if(isset($_GET['remove'])) {
mysqli_query($con,'DELETE FROM wishlist WHERE wishlist_id='.(int)$_GET['remove'].' AND user_id='.user_id());
redirect_to('wishlist.php');
}
$rows=db_all('SELECT w.wishlist_id,p.* FROM wishlist w JOIN products p ON p.product_id=w.product_id WHERE w.user_id='.user_id().' ORDER BY w.wishlist_id DESC');
userStart('Wishlist','');
?>
<div class="container">
<div class="page-head">
<h1>Wishlist</h1>
</div>
<div class="grid-4">
<?php
foreach($rows as $p):
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
<a class="btn small" href="wishlist.php?remove=
<?=
$p['wishlist_id']
?>
">Remove</a>
<a class="btn primary small" href="product_details.php?id=
<?=
$p['product_id']
?>
">View</a>
</div>
</div>
<?php
endforeach;
if(!$rows):
?>
<p>No wishlist items.</p>
<?php
endif;
?>
</div>
</div>
<?php
userEnd();
?>
