<h3 class="page-title">Sider</h3>
<?php echo form_open('admin/page/search/'); ?>
	<div class="input-append">
		<input type="text" name="search_query" value="<?php echo $search_query; ?>" id="appendedInputButton" class="span8">
		<button type="submit" class="btn span1">Søg</button>
	</div>
<?php echo form_close(); ?>
<?php if ($search_query): ?><div class="alert alert-info">Der blev fundet <?php echo $c = count($pages); ?> resultat<?php echo $c === 1 ?'':'er';?></div><?php ENDIF; ?>
<table class="table table-striped">
	<thead>
		<th>Skabelon</th>
		<th>Titel</th>
		<th>Indhold</th>
		<th>Vises i footer</th>
		<th class="span1">Redgier</th>
		<th class="span1">Slet</th>
	</thead>
	<tbody>
		<?php foreach ($pages as $page): ?>
			<tr>
				<td><?php echo $page->template; ?></td>
				<td><?php echo $page->title; ?></td>
				<td><?php echo firstline_or_numwords(strip_tags($page->content), 30); ?></td>
				<td><?php echo $page->footer ? "Ja" : "Nej"; ?></td>
				<td><?php echo btn_edit('admin/page/edit/'.$page->pages_id); ?></td>
				<td><?php echo btn_delete('admin/page/delete/'.$page->pages_id); ?></td>
			</tr>
		<?php ENDFOREACH; ?>
		<?php if (empty($pages)): ?>
			<tr>
				<td colspan="6"><i>Der blev ikke fundet nogle sider.</i></td>
			</tr>
		<?php ENDIF; ?>
	</tbody>
</table>