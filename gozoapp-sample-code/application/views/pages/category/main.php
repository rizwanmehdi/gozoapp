<?php if( $items->num_rows() <= 0 ) { ?>
	no results to display.
<?php } else { ?>

	<table class="tablesorter">
		<thead>
			<tr>
				<th style="width:60px;background-image:none;">ID</th>
				<th>Category</th>
				<th>Parent Category</th>
				<th colspan="2" style="text-align:center;background-image:none;">Manage</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($items->result() AS $item) { ?>
		<tr>
			<td><?php echo $item->id; ?></td>
			<td style="<?php echo $item->parent_id == 0 ? 'color:#a02;font-weight:bold;' : ''; ?>"><?php echo $item->title; ?></td>
			<td><?php echo $item->parent; ?></td>
			<td style="width:60px;text-align:center;"><a href="/admin/category/edit/<?php echo $item->id; ?>/" title="Edit This Category"><?php echo $this->template->img('icons/edit.png'); ?></a></td>
			<td style="width:60px;text-align:center;"><a href="/admin/category/delete/<?php echo $item->id;?>/" title="Delete This Catagory" onclick="return confirm('Are you sure you want to delete this category?');"><?php echo $this->template->img('icons/trash.png'); ?></a></td>
		</tr>
		<?php } ?>
		</tbody>
	</table>

<?php } ?>