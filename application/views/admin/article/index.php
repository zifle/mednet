<h3 class="page-title">Nyheder</h3>
<?php echo form_open('admin/article/search/'); ?>
	<div class="input-append">
		<input type="text" name="search_query" value="<?php echo $search_query; ?>" id="appendedInputButton" class="span8">
		<button type="submit" class="btn span1">Søg</button>
	</div>
<?php echo form_close(); ?>
<?php if ($search_query): ?><div class="alert alert-info">Der blev fundet <?php echo $c = count($articles); ?> resultat<?php echo $c === 1 ?'':'er';?></div><?php ENDIF; ?>
<table class="table table-striped">
	<thead>
		<th>Udgivelses dato</th>
		<th>Titel</th>
		<th>Teaser</th>
		<th>Billede</th>
		<th class="span1">Redgier</th>
		<th class="span1">Slet</th>
	</thead>
	<tbody>
		<?php foreach ($articles as $article): ?>
			<tr>
				<td><?php echo date('Y-m-d', strtotime($article->publish)); ?></td>
				<td><?php echo $article->title; ?></td>
				<td><?php echo !empty($article->teaser) ? $article->teaser : firstline_or_numwords(strip_tags($article->content), 10); ?></td>
				<td><?php echo $article->image ? '<img src="'.site_url('admin/article/image/'.$article->articles_id.'/130/50').'" alt="" />' : 'Intet billede'; ?></td>
				<td><?php echo btn_edit('admin/article/edit/'.$article->articles_id); ?></td>
				<td><?php echo btn_delete('admin/article/delete/'.$article->articles_id); ?></td>
			</tr>
		<?php ENDFOREACH; ?>
		<?php if (empty($articles)): ?>
			<tr>
				<td colspan="6"><i>Der blev ikke fundet nogle nyheder.</i></td>
			</tr>
		<?php ENDIF; ?>
	</tbody>
</table>