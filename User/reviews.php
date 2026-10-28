<?php
require 'layout.php';
$products=db_all("SELECT product_id,product_name FROM products WHERE status='active' ORDER BY product_name");
if($_SERVER['REQUEST_METHOD']==='POST') {
$pid=(int)$_POST['product_id'];
$rating=(int)$_POST['rating'];
$text=trim($_POST['review_text']);
if($pid&&$rating>=1&&$rating<=5&&strlen($text)>=10) {
$st=mysqli_prepare($con,'INSERT INTO reviews(user_id,product_id,rating,review_text) VALUES(?,?,?,?)');
mysqli_stmt_bind_param($st,'iiis',$_SESSION['user_id'],$pid,$rating,$text);
mysqli_stmt_execute($st);
redirect_to('reviews.php?saved=1');
}
}
$reviews=db_all('SELECT r.*,p.product_name FROM reviews r JOIN products p ON p.product_id=r.product_id WHERE r.user_id='.user_id().' ORDER BY r.review_id DESC');
userStart('Reviews','');
?>
<div class="container">
<div class="page-head">
<h1>Rating & Reviews</h1>
</div>
<?php
if(isset($_GET['saved'])):
?>
<div class="alert success">Review submitted.</div>
<?php
endif;
?>
<div class="form-card">
<form method="post" data-validate novalidate>
<div class="form-group">
<label>Product *</label>
<select name="product_id" data-validation="required" required>
<option value="">Choose product</option>
<?php
foreach($products as $p):
?>
<option value="
<?=
$p['product_id']
?>
">
<?=
h($p['product_name'])
?>
</option>
<?php
endforeach;
?>
</select>
</div>
<div class="form-group">
<label>Rating *</label>
<select name="rating" data-validation="required" required>
<option value="">Choose rating</option>
<?php
for($i=5;
$i>=1;
$i--):
?>
<option value="
<?=
$i
?>
">
<?=
$i
?>
 / 5</option>
<?php
endfor;
?>
</select>
</div>
<div class="form-group">
<label>Review *</label>
<textarea name="review_text" data-validation="required min max" data-min="10" data-max="500" required>
</textarea>
</div>
<button class="btn primary">Submit Review</button>
</form>
</div>
<div class="card">
<div class="table-wrap">
<table>
<tr>
<th>Product</th>
<th>Rating</th>
<th>Review</th>
<th>Status</th>
</tr>
<?php
foreach($reviews as $r):
?>
<tr>
<td>
<?=
h($r['product_name'])
?>
</td>
<td>
<?=
$r['rating']
?>
/5</td>
<td>
<?=
h($r['review_text'])
?>
</td>
<td>
<?=
h($r['status'])
?>
</td>
</tr>
<?php
endforeach;
?>
</table>
</div>
</div>
</div>
<?php
userEnd();
?>
