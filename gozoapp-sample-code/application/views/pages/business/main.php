<?php if( $items->num_rows() <= 0 ) { ?>
 no results to display.
<?php } else { ?>

	<table class="tablesorter">
		<thead>
			<tr>
				<th style="width:50px;">ID</th>
				<th>Company Name</th>
				<th>Email</th>
				<th>No. of Locations</th>
				<th colspan="3" style="text-align:center;background-image:none;">Manage</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($items->result() AS $item) { ?>
			<tr>
				<td><?php echo $item->id; ?></td>
				<td><?php echo $item->company; ?></td>
				<td><?php echo $item->email; ?></td>
				<td style="width:115px;text-align:center;"><?php echo $this->db->where(array('owner_id' => $item->id, 'owner_type' => 'business'))->count_all_results('locations'); ?></td>
				<td style="width:60px;text-align:center;"><a href="/admin/business/locations/?business_id=<?php echo $item->id; ?>" title="View Locations"><?php echo $this->template->img('icons/location-pin.png', '', array('width'=>'20px')); ?></td>
				<td style="width:60px;text-align:center;"><a href="/admin/business/edit/<?php echo $item->id; ?>/" title="Edit Business"><?php echo $this->template->img('icons/edit.png'); ?></a></td>
				<td style="width:60px;text-align:center;"><a href="/admin/business/delete/<?php echo $item->id; ?>/" title="Delete Business" onclick="return confirm('Are you sure you want to do delete this business and all of its locations?');"><?php echo $this->template->img('icons/trash.png'); ?></a></td>
			</tr>				
			<?php } ?>
		</tbody>
	</table>
	<?php echo $pagination; ?>

<?php } ?>