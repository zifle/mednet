<h3 class="page-title">Apoteker</h3>
<?php echo form_open('admin/pharmacy/search/'); ?>
	<div class="input-append">
		<input type="text" name="search_query" value="<?php echo $search_query; ?>" id="appendedInputButton" class="span8">
		<button type="submit" class="btn span1">Søg</button>
	</div>
<?php echo form_close(); ?>
<?php if ($search_query): ?><div class="alert alert-info">Der blev fundet <?php echo $c = count($pharmacies); ?> resultat<?php echo $c === 1 ?'':'er';?></div><?php ENDIF; ?>
<table class="table table-striped">
	<thead>
		<th>Postnr.</th>
		<th>Navn</th>
		<th>Koordinater</th>
		<th class="span1">Rediger</th>
		<th class="span1">Slet</th>
	</thead>
	<tbody>
		<?php foreach ($pharmacies as $pharmacy): ?>
			<tr>
				<td><?php echo $pharmacy->zipcode; ?></td>
				<td><?php echo $pharmacy->title; ?></td>
				<td><?php echo $pharmacy->longitude && $pharmacy->latitude ? 'Ja' : 'Nej'; ?></td>
				<td><?php echo btn_edit(site_url('admin/pharmacy/edit/'.$pharmacy->pharmacies_id)); ?></td>
				<td><?php echo btn_delete(site_url('admin/pharmacy/delete/'.$pharmacy->pharmacies_id)); ?></td>
			</tr>
		<?php ENDFOREACH; ?>
		<?php if (empty($pharmacies)): ?>
			<tr>
				<td colspan="5"><i>Der blev ikke fundet nogle apoteker.</i></td>
			</tr>
		<?php ENDIF; ?>
	</tbody>
</table>