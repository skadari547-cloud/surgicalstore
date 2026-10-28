<?php
require 'layout.php';
userStart('About Us','about');
?>
<section class="page-banner">
<div class="container">
<span class="eyebrow">ABOUT US</span>
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
<h2>
<?=
h(setting('about_title'))
?>
</h2>
<p>
<?=
h(setting('about_description'))
?>
</p>
</div>
</div>
</section>
<?php
userEnd();
?>
