<?php
require 'layout.php';
if(isset($_GET['delete'])) {
mysqli_query($con,'DELETE FROM contact_messages WHERE message_id='.(int)$_GET['delete']);
admin_flash('Message deleted.');
admin_redirect('messages.php');
}
if(isset($_GET['read'])) {
mysqli_query($con,"UPDATE contact_messages SET status='read' WHERE message_id=".(int)$_GET['read']);
admin_redirect('messages.php');
}
$rows=db_all('SELECT * FROM contact_messages ORDER BY message_id DESC');
adminStart('Messages','messages');
?>
<div class="page-heading">
<h2>Contact Messages</h2>
<p>Messages submitted from the guest/user contact form.</p>
</div>
<div class="card">
<div class="table-wrap">
<table>
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Subject</th>
<th>Message</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
foreach($rows as $m):
?>
<tr>
<td>
<?=
$m['message_id']
?>
</td>
<td>
<?=
h($m['name'])
?>
</td>
<td>
<?=
h($m['email'])
?>
</td>
<td>
<?=
h($m['subject'])
?>
</td>
<td>
<?=
h($m['message'])
?>
</td>
<td>
<?=
h($m['status'])
?>
</td>
<td>
<a class="btn small" href="messages.php?read=
<?=
$m['message_id']
?>
">Mark Read</a>
<a class="btn small" href="messages.php?delete=
<?=
$m['message_id']
?>
" onclick="return confirm('Delete message?')">Delete</a>
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
