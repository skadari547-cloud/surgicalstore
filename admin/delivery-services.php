<?php
require 'layout.php';
$edit=isset($_GET['edit'])?db_one('SELECT * FROM delivery_services WHERE service_id='.(int)$_GET['edit']):null;
if($_SERVER['REQUEST_METHOD']==='POST') {
admin_check_csrf();
$id=(int)$_POST['id'];
$name=trim($_POST['service_name']);
$type=trim($_POST['service_type']);
$desc=trim($_POST['description']);
$fee=(float)$_POST['fee'];
$free=$_POST['free_above']===''?null:(float)$_POST['free_above'];
$status=$_POST['status']??'active';
if($id) {
$st=mysqli_prepare($con,'UPDATE delivery_services SET service_name=?,service_type=?,description=?,fee=?,free_above=?,status=? WHERE service_id=?');
mysqli_stmt_bind_param($st,'sssddsi',$name,$type,$desc,$fee,$free,$status,$id);
}
else {
$st=mysqli_prepare($con,'INSERT INTO delivery_services(service_name,service_type,description,fee,free_above,status) VALUES(?,?,?,?,?,?)');
mysqli_stmt_bind_param($st,'sssdds',$name,$type,$desc,$fee,$free,$status);
}
mysqli_stmt_execute($st);
admin_flash($id?'Service updated.':'Service added.');
admin_redirect('delivery-services.php');
}
if(isset($_GET['delete'])) {
mysqli_query($con,'DELETE FROM delivery_services WHERE service_id='.(int)$_GET['delete']);
admin_flash('Service deleted.');
admin_redirect('delivery-services.php');
}
$rows=db_all('SELECT * FROM delivery_services ORDER BY service_id DESC');
adminStart('Delivery Services','delivery');
?>
<div class="page-heading">
<h2>Delivery Services</h2>
</div>
<div class="card">
<h3>
<?=
$edit?'Edit Service':'Add Service'
?>
</h3>
<form method="post" data-validate novalidate class="form-grid">
<input type="hidden" name="csrf_token" value="
<?=
h(admin_csrf())
?>
">
<input type="hidden" name="id" value="
<?=
h($edit['service_id']??0)
?>
">
<div>
<label>Service Name *</label>
<input name="service_name" value="
<?=
h($edit['service_name']??'')
?>
" data-validation="required min max" data-min="2" data-max="100" required>
</div>
<div>
<label>Type</label>
<input name="service_type" value="
<?=
h($edit['service_type']??'')
?>
">
</div>
<div>
<label>Fee</label>
<input type="number" name="fee" min="0" step="0.01" value="
<?=
h($edit['fee']??0)
?>
">
</div>
<div>
<label>Free Above</label>
<input type="number" name="free_above" min="0" step="0.01" value="
<?=
h($edit['free_above']??'')
?>
">
</div>
<div>
<label>Status</label>
<select name="status">
<option value="active" 
<?=
($edit['status']??'active')==='active'?'selected':''
?>
>Active</option>
<option value="inactive" 
<?=
($edit['status']??'')==='inactive'?'selected':''
?>
>Inactive</option>
</select>
</div>
<div class="full-width">
<label>Description</label>
<textarea name="description" data-validation="max" data-max="255">
<?=
h($edit['description']??'')
?>
</textarea>
</div>
<div>
<button class="btn primary">
<?=
$edit?'Update Service':'Add Service'
?>
</button>
</div>
</form>
</div>
<div class="card">
<div class="table-wrap">
<table>
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Type</th>
<th>Fee</th>
<th>Free Above</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
foreach($rows as $s):
?>
<tr>
<td>
<?=
$s['service_id']
?>
</td>
<td>
<?=
h($s['service_name'])
?>
</td>
<td>
<?=
h($s['service_type'])
?>
</td>
<td>₹
<?=
number_format($s['fee'],2)
?>
</td>
<td>
<?=
is_null($s['free_above'])?'—':'₹'.number_format($s['free_above'],2)
?>
</td>
<td>
<?=
h($s['status'])
?>
</td>
<td>
<a class="btn small" href="delivery-services.php?edit=
<?=
$s['service_id']
?>
">Edit</a>
<a class="btn small" href="delivery-services.php?delete=
<?=
$s['service_id']
?>
" onclick="return confirm('Delete service?')">Delete</a>
<a class="btn small" href="view-service.php?id=
<?=
$s['service_id']
?>
">View</a>
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
