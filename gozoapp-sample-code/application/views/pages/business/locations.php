<h2><?php echo $business->company; ?> Locations</h2>

<?php if( $items->num_rows() > 0 ) { ?>
	
	<table class="tablesorter">
		<thead>
			<tr>
				<th style="width:50px;text-align:center;">ID</th>
				<th>Reference Name</th>
				<th>Address</th>
				<th>Latitude</th>
				<th>Longitude</th>
				<th colspan="2" style="text-align:center;background-image:none;">Manage</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($items->result() AS $item) { ?>
			<tr>
				<td style="text-align:center;"><?php echo $item->id; ?></td>
				<td><?php echo $item->title; ?></td>
				<td><?php echo $item->formatted_address; ?></td>
				<td><?php echo $item->latitude; ?></td>
				<td><?php echo $item->longitude; ?></td>
				<td style="width:60px;text-align:center;"><a href="/admin/business/locations/edit/<?php echo $item->id; ?>/" title="Edit Location"><?php echo $this->template->img('icons/edit.png'); ?></a></td>
				<td style="width:60px;text-align:center;"><a href="/admin/business/locations/delete/<?php echo $item->id; ?>/?<?php echo $_SERVER['QUERY_STRING']; ?>" title="Delete Location" onclick="return confirm('Are you sure you want to delete this location?');"><?php echo $this->template->img('icons/trash.png'); ?></a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>

<?php } else { ?>
	no results to display.
<?php } ?>