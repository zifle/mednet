<section>
	<h2>Pages</h2>
	<?php echo anchor('admin/page/edit', '<i class="icon-plus"></i> Add a page'); ?>
	<table class="table">
		<thead>
			<tr>
				<th>Title</th>
				<th>Parent</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
<?php if (count($pages)): foreach ($pages as $page): ?>
			<tr>
				<td><?php echo anchor('admin/page/edit/' . $page->id, $page->title); ?></td>
				<td><?php echo $page->parent_slug; ?></td>
				<td><?php echo btn_edit('admin/page/edit/' . $page->id); ?></td>
				<td><?php echo btn_delete('admin/page/delete/' . $page->id); ?></td>
			</tr>
<?php ENDFOREACH; ?>
<?php ELSE: ?>
			<tr>
				<td colspan="3">We could not find any pages.</td>
			</tr>
<?php ENDIF; ?>
		</tbody>
	</table>
</section>