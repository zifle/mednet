<h3 class="page-title">Sygdomme</h3>
<?php echo form_open('admin/illness/search/'); ?>
	<div class="input-append">
		<input type="text" name="search_query" value="<?php echo $search_query; ?>" id="appendedInputButton" class="span8">
		<button type="submit" class="btn span1">Søg</button>
	</div>
<?php echo form_close(); ?>
<?php if ($search_query): ?><div class="alert alert-info">Der blev fundet <?php echo $c = count($illnesses); ?> resultat<?php echo $c === 1 ?'':'er';?></div><?php ENDIF; ?>
<table class="table table-striped">
	<thead>
		<th>Latinske navn</th>
		<th>Navn</th>
		<th>Beskrivelse</th>
		<th class="span1">Rediger</th>
		<th class="span1">Slet</th>
	</thead>
	<tbody>
		<?php foreach ($illnesses as $illness): ?>
			<tr>
				<td><?php echo $illness->latin_name; ?></td>
				<td><?php echo $illness->title; ?></td>
				<td><?php echo $illness->description; ?></td>
				<td><?php echo btn_edit(site_url('admin/illness/edit/'.$illness->illnesses_id)); ?></td>
				<td><?php echo btn_delete(site_url('admin/illness/delete/'.$illness->illnesses_id)); ?></td>
			</tr>
		<?php ENDFOREACH; ?>
		<?php if (empty($illnesses)): ?>
			<tr>
				<td colspan="5"><i>Der blev ikke fundet nogle sygdomme.</i></td>
			</tr>
		<?php ENDIF; ?>
	</tbody>
</table>