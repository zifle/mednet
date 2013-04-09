<h3 class="page-title">Log ind</h3>
<?php echo form_open(); ?>
<label class="row">
	<div class="span2">Brugernavn</div>
	<?php echo form_input('username'); ?>
</label>
<label class="row">
	<div class="span2">Password</div>
	<?php echo form_password('password'); ?>
</label>
<div class="row">
	<div class="span2"></div>
	<?php echo form_submit('submit', 'Log ind', 'class="btn"'); ?>
</div>
<?php echo form_close(); ?>