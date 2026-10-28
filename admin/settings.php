<?php
require 'layout.php';
$keys=['store_name'=>'Store Name','announcement_one'=>'Announcement 1','announcement_two'=>'Announcement 2','announcement_three'=>'Announcement 3','phone'=>'Phone','email'=>'Email','address'=>'Store Address','hero_eyebrow'=>'Home Eyebrow','hero_title'=>'Home Hero Title','hero_description'=>'Home Hero Description','about_title'=>'About Title','about_description'=>'About Description','contact_title'=>'Contact Title','contact_description'=>'Contact Description','free_delivery_above'=>'Free Delivery Above','urgent_text'=>'Urgent Delivery Text','hero_image'=>'Home Hero Image'];
if($_SERVER['REQUEST_METHOD']==='POST') {
admin_check_csrf();
foreach($keys as $k=>$label)set_setting($k,trim($_POST[$k]??''));
admin_flash('Settings saved.');
admin_redirect('settings.php');
}
$vals=[];
foreach($keys as $k=>$label)$vals[$k]=setting($k);
adminStart('Settings','settings');
?>
<div class="page-heading">
<h2>Store Settings</h2>
<p>These values are used on the guest and user pages.</p>
</div>
<div class="card">
<form method="post" data-validate novalidate>
<input type="hidden" name="csrf_token" value="
<?=
h(admin_csrf())
?>
">
<div class="form-grid">
<?php
foreach($keys as $k=>$label):
?>
<div class="
<?=
$k==='hero_description'||$k==='about_description'||$k==='contact_description'||$k==='address'?'full-width':''
?>
">
<label>
<?=
h($label)
?>
</label>
<?php
if(str_contains($k,'description')||$k==='address'):
?>
<textarea name="
<?=
$k
?>
" rows="3" data-validation="max" data-max="500">
<?=
h($vals[$k])
?>
</textarea>
<?php
else:
?>
<input name="
<?=
$k
?>
" value="
<?=
h($vals[$k])
?>
" data-validation="required max" data-max="500" required>
<?php
endif;
?>
</div>
<?php
endforeach;
?>
</div>
<button class="btn primary">Save Settings</button>
</form>
</div>
<?php
adminEnd();
?>
