<h3 class="page-title">Registrer</h3>
<?php echo form_open(); ?>
<label class="row">
	<div class="span2">Navn</div>
	<?php echo form_input('name', set_value('name')); ?>
</label>
<label class="row">
	<div class="span2">Email</div>
	<?php echo form_input('email', set_value('email'), 'required placeholder="test@eksempel.dk"'); ?>
</label>
<label class="row">
	<div class="span2">Gentag email</div>
	<?php echo form_input('email2', set_value('email2'), 'required placeholder="test@eksempel.dk"'); ?>
</label>
<label class="row">
	<div class="span2">Password</div>
	<?php echo form_password('password', '', 'required'); ?>
</label>
<label class="row">
	<div class="span2">Gentag password</div>
	<?php echo form_password('password2', '', 'required'); ?>
</label>
<div class="row">
	<div class="span2"></div>
	<?php echo form_submit('submit', 'Registrer', 'class="btn"'); ?>
</div>
<?php echo form_close(); ?>