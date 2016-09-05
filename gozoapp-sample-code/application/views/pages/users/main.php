<?php if( $items->num_rows() <= 0 ) { ?>
	no results to display
<?php } else { ?>

<table class="tablesorter">
	<thead>
		<tr>
			<th style="width:275px;">Device ID</th>
			<th style="width:100px;">Device Type</th>
			<th>Email</th>
			<th>User</th>
			<th style="width:75px;">Zip Code</th>
			<th>Facebook ID</th>
			<th style="width:150px;">Created</th>
			<th style="width:50px;">Delete</th>
	</thead>
	<tbody>
		<?php foreach($items->result() AS $item) { ?>
		<tr>
			<td><?php echo $item->device_id; ?></td>
			<td><?php echo $item->device_type; ?></td>
			<td><?php echo $item->email; ?></td>
			<td><?php echo $item->first_name . ' ' . $item->last_name; ?></td>
			<td><?php echo $item->zip_code; ?></td>
			<td><?php echo $item->facebook_id; ?></td>
			<td><?php echo date('M j, Y g:ia', strtotime($item->created_on)); ?></td>
			<td style="text-align:center;"><a href="/admin/users/delete/<?php echo $item->id; ?>/" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete"><?php echo $this->template->img('icons/trash.png'); ?></a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<?php } ?>