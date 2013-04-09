<h3 class="page-title">Medicin</h3>
<?php echo form_open('admin/medicine/search/'); ?>
	<div class="input-append">
		<input type="text" name="search_query" value="<?php echo $search_query; ?>" id="appendedInputButton" class="span8">
		<button type="submit" class="btn span1">Søg</button>
	</div>
<?php echo form_close(); ?>
<?php if ($search_query): ?><div class="alert alert-info">Der blev fundet <?php echo $c = count($medicines); ?> resultat<?php echo $c === 1 ?'':'er';?></div><?php ENDIF; ?>
<table class="table table-striped">
	<thead>
		<th>Navn</th>
		<th>Anvendelse</th>
		<th class="span1">Rediger</th>
		<th class="span1">Slet</th>
	</thead>
	<tbody>
		<?php foreach ($medicines as $medicine): ?>
			<tr>
				<td><?php echo $medicine->title; ?></td>
				<td><?php echo $medicine->usage; ?></td>
				<td><?php echo btn_edit(site_url('admin/medicine/edit/'.$medicine->medicine_id)); ?></td>
				<td><?php echo btn_delete(site_url('admin/medicine/delete/'.$medicine->medicine_id)); ?></td>
			</tr>
		<?php ENDFOREACH; ?>
		<?php if (empty($medicines)): ?>
			<tr>
				<td colspan="4"><i>Der blev ikke fundet noget medicin.</i></td>
			</tr>
		<?php ENDIF; ?>
	</tbody>
</table>