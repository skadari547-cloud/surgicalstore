<?php
require 'layout.php';
$services=db_all("SELECT * FROM delivery_services WHERE status='active' ORDER BY service_id");
userStart('Delivery Services','services');
?>
<div class="container">
<div class="page-head">
<span class="eyebrow">DELIVERY OPTIONS</span>
<h1>Delivery services</h1>
<p>Services configured by the admin.</p>
</div>
<div class="grid-3">
<?php
foreach($services as $s):
?>
<div class="service-card">
<div class="service-icon">
<i class="bi bi-truck">
</i>
</div>
<span class="service-tag">
<?=
h(strtoupper($s['service_type']))
?>
</span>
<h3>
<?=
h($s['service_name'])
?>
</h3>
<p>
<?=
h($s['description'])
?>
</p>
<strong>₹
<?=
number_format($s['fee'],2)
?>
</strong>
</div>
<?php
endforeach;
?>
</div>
</div>
<?php
userEnd();
?>
