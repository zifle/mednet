<h3 class="page-title">Symptomer</h3>
<?php echo form_open('admin/symptom/search/'); ?>
	<div class="input-append">
		<input type="text" name="search_query" value="<?php echo $search_query; ?>" id="appendedInputButton" class="span8">
		<button type="submit" class="btn span1">Søg</button>
	</div>
<?php echo form_close(); ?>
<?php if ($search_query): ?><div class="alert alert-info">Der blev fundet <?php echo $c = count($symptoms); ?> resultat<?php echo $c === 1 ?'':'er';?></div><?php ENDIF; ?>
<table class="table table-striped">
	<thead>
		<th>#</th>
		<th>Type</th>
		<th>Titel</th>
		<th>Beskrivelse</th>
		<th class="span1">Rediger</th>
		<th class="span1">Slet</th>
	</thead>
	<tbody>
		<?php foreach ($symptoms as $symptom): ?>
			<tr>
				<td><?php echo $symptom->symptoms_id; ?></td>
				<td><?php echo $symptom->type; ?></td>
				<td><?php echo $symptom->title; ?></td>
				<td><?php echo $symptom->description; ?></td>
				<td><?php echo btn_edit(site_url('admin/symptom/edit/'.$symptom->symptoms_id)); ?></td>
				<td><?php echo btn_delete(site_url('admin/symptom/delete/'.$symptom->symptoms_id)); ?></td>
			</tr>
		<?php ENDFOREACH; ?>
		<?php if (empty($symptoms)): ?>
			<tr>
				<td colspan="6"><i>Der blev ikke fundet nogle symptomer.</i></td>
			</tr>
		<?php ENDIF; ?>
	</tbody>
</table>