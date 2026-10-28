<?php
require 'layout.php';
userStart('Bulk Orders','services');
?>
<div class="container">
<div class="page-head">
<h1>Bulk / Clinic Orders</h1>
<p>Contact the store for recurring or bulk supply requirements.</p>
</div>
<div class="card">
<p>Phone: 
<?=
h(setting('phone'))
?>
</p>
<p>Email: 
<?=
h(setting('email'))
?>
</p>
<a class="btn primary" href="contact.php">Contact Support</a>
</div>
</div>
<?php
userEnd();
?>
