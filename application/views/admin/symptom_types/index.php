<h3 class="page-title">Symptom typer</h3>
<?php echo form_open('admin/symptom_type/search/'); ?>
	<div class="input-append">
		<input type="text" name="search_query" value="<?php echo $search_query; ?>" id="appendedInputButton" class="span8">
		<button type="submit" class="btn span1">Søg</button>
	</div>
<?php echo form_close(); ?>
<?php if ($search_query): ?><div class="alert alert-info">Der blev fundet <?php echo $c = count($symptom_types); ?> resultat<?php echo $c === 1 ?'':'er';?></div><?php ENDIF; ?>
<table class="table table-striped">
	<thead>
		<th>#</th>
		<th>Type</th>
		<th class="span1">Rediger</th>
		<th class="span1">Slet</th>
	</thead>
	<tbody>
		<?php foreach ($symptom_types as $symptom_type): ?>
			<tr>
				<td><?php echo $symptom_type->symptom_types_id; ?></td>
				<td><?php echo $symptom_type->title; ?></td>
				<td><?php echo btn_edit(site_url('admin/symptom_type/edit/'.$symptom_type->symptom_types_id)); ?></td>
				<td><?php echo btn_delete(site_url('admin/symptom_type/delete/'.$symptom_type->symptom_types_id)); ?></td>
			</tr>
		<?php ENDFOREACH; ?>
		<?php if (empty($symptom_types)): ?>
			<tr>
				<td colspan="4"><i>Der blev ikke fundet nogle symptom typer.</i></td>
			</tr>
		<?php ENDIF; ?>
	</tbody>
</table>