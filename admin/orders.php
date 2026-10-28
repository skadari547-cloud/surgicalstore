<?php
require 'layout.php';
$allowed=['pending','confirmed','processing','shipped','delivered','cancelled'];
if($_SERVER['REQUEST_METHOD']==='POST') {
admin_check_csrf();
$id=(int)$_POST['order_id'];
$status=$_POST['order_status'];
if(in_array($status,$allowed,true)) {
$st=mysqli_prepare($con,'UPDATE orders SET order_status=? WHERE order_id=?');
mysqli_stmt_bind_param($st,'si',$status,$id);
mysqli_stmt_execute($st);
admin_flash('Order status updated.');
}
admin_redirect('orders.php');
}
$rows=db_all('SELECT o.*,u.fullname FROM orders o JOIN register u ON u.id=o.user_id ORDER BY o.order_date DESC');
adminStart('Orders','orders');
?>
<div class="page-heading">
<h2>Orders</h2>
<p>Orders created from the user checkout are shown here.</p>
</div>
<div class="card">
<div class="table-wrap">
<table>
<thead>
<tr>
<th>Order</th>
<th>Customer</th>
<th>Date</th>
<th>Total</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
foreach($rows as $o):
?>
<tr>
<td>
<?=
h($o['order_number'])
?>
</td>
<td>
<?=
h($o['fullname'])
?>
</td>
<td>
<?=
h($o['order_date'])
?>
</td>
<td>₹
<?=
number_format($o['total_amount'],2)
?>
</td>
<td>
<?=
h($o['order_status'])
?>
</td>
<td>
<a class="btn small" href="order-details.php?id=
<?=
$o['order_id']
?>
">View</a>
<form method="post" style="display:inline">
<input type="hidden" name="csrf_token" value="
<?=
h(admin_csrf())
?>
">
<input type="hidden" name="order_id" value="
<?=
$o['order_id']
?>
">
<select name="order_status">
<?php
foreach($allowed as $a):
?>
<option value="
<?=
$a
?>
" 
<?=
$a===$o['order_status']?'selected':''
?>
>
<?=
ucfirst($a)
?>
</option>
<?php
endforeach;
?>
</select>
<button class="btn small">Save</button>
</form>
</td>
</tr>
<?php
endforeach;
if(!$rows):
?>
<tr>
<td colspan="6">No orders.</td>
</tr>
<?php
endif;
?>
</tbody>
</table>
</div>
</div>
<?php
adminEnd();
?>
