<?php
require 'layout.php';
$productCount=(int)(db_one('SELECT COUNT(*) n FROM products')['n']??0);
$customerCount=(int)(db_one("SELECT COUNT(*) n FROM register WHERE role='user'")['n']??0);
$orderCount=(int)(db_one('SELECT COUNT(*) n FROM orders')['n']??0);
$sales=(float)(db_one("SELECT COALESCE(SUM(total_amount),0) n FROM orders WHERE order_status<>'cancelled'")['n']??0);
$recent=db_all('SELECT o.*,u.fullname FROM orders o JOIN register u ON u.id=o.user_id ORDER BY o.order_date DESC LIMIT 8');
adminStart('Dashboard','dashboard');
?>
<div class="stats-grid">
<div class="stat-card">
<div class="stat-icon">
<i class="bi bi-box-seam">
</i>
</div>
<div>
<span>Products</span>
<strong>
<?=
$productCount
?>
</strong>
</div>
</div>
<div class="stat-card">
<div class="stat-icon">
<i class="bi bi-people">
</i>
</div>
<div>
<span>Customers</span>
<strong>
<?=
$customerCount
?>
</strong>
</div>
</div>
<div class="stat-card">
<div class="stat-icon">
<i class="bi bi-cart3">
</i>
</div>
<div>
<span>Orders</span>
<strong>
<?=
$orderCount
?>
</strong>
</div>
</div>
<div class="stat-card">
<div class="stat-icon">
<i class="bi bi-currency-rupee">
</i>
</div>
<div>
<span>Sales</span>
<strong>₹
<?=
number_format($sales,2)
?>
</strong>
</div>
</div>
</div>
<div class="card">
<h3>Recent Orders</h3>
<div class="table-wrap">
<table>
<thead>
<tr>
<th>Order</th>
<th>Customer</th>
<th>Total</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
foreach($recent as $o):
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
