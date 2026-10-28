<?php
require 'layout.php';
$rows=db_all("SELECT DATE(order_date) order_day,COUNT(*) orders,SUM(total_amount) sales FROM orders WHERE order_status<>'cancelled' GROUP BY DATE(order_date) ORDER BY order_day DESC");
$total=(float)(db_one("SELECT COALESCE(SUM(total_amount),0) n FROM orders WHERE order_status<>'cancelled'")['n']??0);
adminStart('Sales Report','sales');
?>
<div class="page-heading">
<h2>Sales Report</h2>
<p>Total sales: ₹
<?=
number_format($total,2)
?>
</p>
</div>
<div class="card">
<div class="table-wrap">
<table>
<thead>
<tr>
<th>Date</th>
<th>Orders</th>
<th>Sales</th>
</tr>
</thead>
<tbody>
<?php
foreach($rows as $r):
?>
<tr>
<td>
<?=
h($r['order_day'])
?>
</td>
<td>
<?=
$r['orders']
?>
</td>
<td>₹
<?=
number_format($r['sales'],2)
?>
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
