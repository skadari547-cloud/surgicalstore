<?php
require 'layout.php';
$edit=isset($_GET['edit'])?db_one('SELECT * FROM coupons WHERE coupon_id='.(int)$_GET['edit']):null;
if($_SERVER['REQUEST_METHOD']==='POST') {
admin_check_csrf();
$id=(int)($_POST['id']??0);
$code=strtoupper(trim($_POST['coupon_code']??''));
$type=$_POST['discount_type']==='fixed'?'fixed':'percentage';
$value=(float)$_POST['discount_value'];
$min=(float)$_POST['min_order_amount'];
$start=$_POST['start_date']??'';
$expiry=$_POST['expiry_date']??'';
$status=$_POST['status']??'active';
if($id) {
$st=mysqli_prepare($con,"UPDATE coupons SET coupon_code=?,discount_type=?,discount_value=?,min_order_amount=?,start_date=NULLIF(?,''),expiry_date=NULLIF(?,''),status=? WHERE coupon_id=?");
mysqli_stmt_bind_param($st,'ssddsssi',$code,$type,$value,$min,$start,$expiry,$status,$id);
}
else {
$st=mysqli_prepare($con,"INSERT INTO coupons(coupon_code,discount_type,discount_value,min_order_amount,start_date,expiry_date,status) VALUES(?,?,?, ?,NULLIF(?,''),NULLIF(?,''),?)");
mysqli_stmt_bind_param($st,'ssddsss',$code,$type,$value,$min,$start,$expiry,$status);
}
mysqli_stmt_execute($st);
admin_flash($id?'Coupon updated.':'Coupon added.');
admin_redirect('coupons.php');
}
if(isset($_GET['delete'])) {
mysqli_query($con,'DELETE FROM coupons WHERE coupon_id='.(int)$_GET['delete']);
admin_flash('Coupon deleted.');
admin_redirect('coupons.php');
}
$rows=db_all('SELECT * FROM coupons ORDER BY coupon_id DESC');
adminStart('Coupons','coupons');
?>
<div class="page-heading">
<div>
<h2>Coupons</h2>
<p>Coupons are used on the user checkout.</p>
</div>
</div>
<div class="card">
<h3>
<?=
$edit?'Edit Coupon':'Add Coupon'
?>
</h3>
<form method="post" data-validate novalidate class="form-grid">
<input type="hidden" name="csrf_token" value="
<?=
h(admin_csrf())
?>
">
<input type="hidden" name="id" value="
<?=
h($edit['coupon_id']??0)
?>
">
<div>
<label>Coupon Code *</label>
<input name="coupon_code" value="
<?=
h($edit['coupon_code']??'')
?>
" data-validation="required min max" data-min="2" data-max="30" required>
</div>
<div>
<label>Discount Type</label>
<select name="discount_type">
<option value="percentage" 
<?=
($edit['discount_type']??'percentage')==='percentage'?'selected':''
?>
>Percentage</option>
<option value="fixed" 
<?=
($edit['discount_type']??'')==='fixed'?'selected':''
?>
>Fixed</option>
</select>
</div>
<div>
<label>Discount Value *</label>
<input type="number" name="discount_value" min="0.01" step="0.01" value="
<?=
h($edit['discount_value']??'')
?>
" data-validation="required" required>
</div>
<div>
<label>Minimum Order</label>
<input type="number" name="min_order_amount" min="0" step="0.01" value="
<?=
h($edit['min_order_amount']??0)
?>
">
</div>
<div>
<label>Start Date</label>
<input type="datetime-local" name="start_date" value="
<?=
!empty($edit['start_date'])?date('Y-m-d\TH:i',strtotime($edit['start_date'])):''
?>
">
</div>
<div>
<label>Expiry Date</label>
<input type="datetime-local" name="expiry_date" value="
<?=
!empty($edit['expiry_date'])?date('Y-m-d\TH:i',strtotime($edit['expiry_date'])):''
?>
">
</div>
<div>
<label>Status</label>
<select name="status">
<option value="active" 
<?=
($edit['status']??'active')==='active'?'selected':''
?>
>Active</option>
<option value="inactive" 
<?=
($edit['status']??'')==='inactive'?'selected':''
?>
>Inactive</option>
</select>
</div>
<div>
<button class="btn primary">
<?=
$edit?'Update Coupon':'Add Coupon'
?>
</button>
</div>
</form>
</div>
<div class="card">
<div class="table-wrap">
<table>
<thead>
<tr>
<th>ID</th>
<th>Code</th>
<th>Discount</th>
<th>Minimum</th>
<th>Expiry</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
foreach($rows as $c):
?>
<tr>
<td>
<?=
$c['coupon_id']
?>
</td>
<td>
<?=
h($c['coupon_code'])
?>
</td>
<td>
<?=
h($c['discount_value']).($c['discount_type']==='percentage'?'%':' ₹')
?>
</td>
<td>₹
<?=
number_format($c['min_order_amount'],2)
?>
</td>
<td>
<?=
h($c['expiry_date']??'')
?>
</td>
<td>
<?=
h($c['status'])
?>
</td>
<td>
<a class="btn small" href="coupons.php?edit=
<?=
$c['coupon_id']
?>
">Edit</a>
<a class="btn small" href="coupons.php?delete=
<?=
$c['coupon_id']
?>
" onclick="return confirm('Delete coupon?')">Delete</a>
<a class="btn small" href="view-coupon.php?id=
<?=
$c['coupon_id']
?>
">View</a>
</td>
</tr>
<?php
endforeach;
?>
</tbody>
</table>
</div>
</div>
<?php
adminEnd();
?>
