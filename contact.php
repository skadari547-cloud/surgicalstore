<?php
require 'layout.php';
$sent=isset($_GET['sent']);
if($_SERVER['REQUEST_METHOD']==='POST') {
$name=trim($_POST['name']??'');
$email=trim($_POST['email']??'');
$subject=trim($_POST['subject']??'');
$message=trim($_POST['message']??'');
if($name&&filter_var($email,FILTER_VALIDATE_EMAIL)&&$subject&&strlen($message)>=10) {
$st=mysqli_prepare($con,'INSERT INTO contact_messages(name,email,subject,message) VALUES(?,?,?,?)');
mysqli_stmt_bind_param($st,'ssss',$name,$email,$subject,$message);
mysqli_stmt_execute($st);
redirect_to('contact.php?sent=1');
}
}
guestStart('Contact Us','contact');
?>
<section class="page-banner">
<div class="container">
<span class="eyebrow">CUSTOMER SUPPORT</span>
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
</section>
<section class="section">
<div class="container contact-wrapper">
<div class="contact-info">
<h2>Let's Talk</h2>
<div class="contact-detail">
<i class="bi bi-telephone">
</i>
<div>
<h3>Phone</h3>
<p>
<?=
h(setting('phone'))
?>
</p>
</div>
</div>
<div class="contact-detail">
<i class="bi bi-envelope">
</i>
<div>
<h3>Email</h3>
<p>
<?=
h(setting('email'))
?>
</p>
</div>
</div>
<div class="contact-detail">
<i class="bi bi-geo-alt">
</i>
<div>
<h3>Location</h3>
<p>
<?=
h(setting('address'))
?>
</p>
</div>
</div>
</div>
<div class="contact-form-area">
<h2>Send Us a Message</h2>
<?php
if($sent):
?>
<div class="alert success">Message sent successfully.</div>
<?php
endif;
?>
<form method="post" data-validate novalidate>
<div class="form-group">
<label>Full Name</label>
<input name="name" data-validation="required alpha min max" data-min="2" data-max="50" required>
</div>
<div class="form-group">
<label>Email</label>
<input type="email" name="email" data-validation="required email" required>
</div>
<div class="form-group">
<label>Subject</label>
<select name="subject" data-validation="required" required>
<option value="">Choose a subject</option>
<option>Product Enquiry</option>
<option>Order Assistance</option>
<option>Delivery Information</option>
<option>Payment Enquiry</option>
<option>Other</option>
</select>
</div>
<div class="form-group">
<label>Message</label>
<textarea name="message" data-validation="required min max" data-min="10" data-max="500" rows="4" required>
</textarea>
</div>
<button class="btn primary">Send Message <i class="bi bi-send">
</i>
</button>
</form>
</div>
</div>
</section>
<?php
guestEnd();
?>
