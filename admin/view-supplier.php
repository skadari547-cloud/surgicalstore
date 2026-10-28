<?php
require 'layout.php';
$s=db_one('SELECT * FROM suppliers WHERE supplier_id='.(int)($_GET['id']??0));
adminStart('View Supplier','suppliers');
?>
<div class="page-heading">
<h2>Supplier Details</h2>
<a class="btn" href="suppliers.php">Back</a>
</div>
<div class="card">
<?php
if($s):foreach($s as $k=>$v):
?>
<p>
<strong>
<?=
h(ucwords(str_replace('_',' ',$k)))
?>
:</strong> 
<?=
h($v)
?>
</p>
<?php
endforeach;
else:
?>
<p>Supplier not found.</p>
<?php
endif;
?>
</div>
<?php
adminEnd();
?>
