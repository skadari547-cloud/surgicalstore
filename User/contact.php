<?php
require_once __DIR__.'/../includes/db.php';
if($_SERVER['REQUEST_METHOD']==='POST') {
$name=trim($_POST['name']??'');
$email=trim($_POST['email']??'');
$subject=trim($_POST['subject']??'');
$message=trim($_POST['message']??'');
if($name&&filter_var($email,FILTER_VALIDATE_EMAIL)&&$subject&&strlen($message)>=10) {
$st=mysqli_prepare($con,'INSERT INTO contact_messages(name,email,subject,message) VALUES(?,?,?,?)');
mysqli_stmt_bind_param($st,'ssss',$name,$email,$subject,$message);
mysqli_stmt_execute($st);
header('Location: contact.php?sent=1');
exit;
}
}
require 'layout.php';
userStart('Contact Us','contact');
?>
<div class="container">
<div class="page-head">
<h1>
<?=
h(setting('contact_title'))
?>
</h1>
<p>
<?=
h(setting('contact_description'))
?>
</p>
</div>
<?php
if(isset($_GET['sent'])):
?>
<div class="alert success">Message sent.</div>
<?php
endif;
?>
<div class="contact-wrapper">
<div class="contact-info">
<p>
<strong>Phone:</strong> 
<?=
h(setting('phone'))
?>
</p>
<p>
<strong>Email:</strong> 
<?=
h(setting('email'))
?>
</p>
<p>
<strong>Address:</strong> 
<?=
h(setting('address'))
?>
</p>
</div>
<div class="contact-form-area">
<form method="post" data-validate novalidate>
<div class="form-group">
<label>Name</label>
<input name="name" value="
<?=
h($_SESSION['user_name']??'')
?>
" data-validation="required alpha min max" data-min="2" data-max="100" required>
</div>
<div class="form-group">
<label>Email</label>
<input type="email" name="email" data-validation="required email" required>
</div>
<div class="form-group">
<label>Subject</label>
<select name="subject" data-validation="required" required>
<option value="">Choose</option>
<option>Product Enquiry</option>
<option>Order Assistance</option>
<option>Delivery Information</option>
<option>Payment Enquiry</option>
<option>Other</option>
</select>
</div>
<div class="form-group">
<label>Message</label>
<textarea name="message" data-validation="required min max" data-min="10" data-max="500" required>
</textarea>
</div>
<button class="btn primary">Send Message</button>
</form>
</div>
</div>
</div>
<?php
userEnd();
?>
