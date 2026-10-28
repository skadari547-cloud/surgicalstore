<?php
require 'layout.php';
guestStart('About Us','about');
?>
<section class="page-banner">
<div class="container">
<span class="eyebrow">ABOUT SURGICAL STORE</span>
<h1>
<?=
h(setting('about_title'))
?>
</h1>
<p>
<?=
h(setting('about_description'))
?>
</p>
</div>
</section>
<section class="section">
<div class="container">
<div class="card">
<div class="category-icon">
<i class="bi bi-heart-pulse">
</i>
</div>
<h2>
<?=
h(setting('about_title'))
?>
</h2>
<p style="margin-top:12px;color:var(--muted)">
<?=
h(setting('about_description'))
?>
</p>
</div>
</div>
</section>
<?php
guestEnd();
?>
