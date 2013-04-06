<div class="modal-header">
	<h3>Login</h3>
</div>
<div class="modal-body">
	<?php $this->statuses->show_statuses(FALSE, 'bootstrap', FALSE); ?>
	<?php echo validation_errors(); ?>
	<?php echo form_open(); ?>
	<table class="table">
		<tr>
			<td>Brugernavn</td>
			<td><?php echo form_input('username'); ?></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><?php echo form_password('password'); ?></td>
		</tr>
		<tr>
			<td></td>
			<td><?php echo form_submit('submit', 'Log ind', 'class="btn btn-primary"'); ?></td>
		</tr>
	</table>
	<?php echo form_close(); ?>
</div>