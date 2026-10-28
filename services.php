<?php
require 'layout.php';
$services=db_all("SELECT * FROM delivery_services WHERE status='active' ORDER BY service_id");
guestStart('Delivery Services','services');
?>
<section class="page-banner">
<div class="container">
<span class="eyebrow">DELIVERY OPTIONS</span>
<h1>Choose the service that fits your need</h1>
<p>Delivery services are controlled from the admin panel.</p>
</div>
</section>
<section class="section">
<div class="container">
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
<?php
if(!is_null($s['free_above'])):
?>
 · Free above ₹
<?=
number_format($s['free_above'],2)
?>
<?php
endif;
?>
</strong>
</div>
<?php
endforeach;
?>
</div>
</div>
</section>
<?php
guestEnd();
?>
