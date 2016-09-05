<form action="/<?php echo uri_string(); ?>/?<?php echo $_SERVER['QUERY_STRING']; ?>" method="post" accept-charset="utf-8">
	<?php echo form_fieldset($business->company . ' Location(s)'); ?>
	<ul>
		<li>
			<?php echo form_label('Location', 'location');
			echo form_input(array('name'=>'title', 'id'=>'location', 'maxlength'=>'100', 'value'=>set_value('title', $item->title))); ?>
		</li>
		<li>
			<?php echo form_label('Address', 'address');
			echo form_input(array('name'=>'address', 'id'=>'address', 'maxlength'=>'200', 'value'=>set_value('address', $item->address))); ?>
		</li>
		<li>
			<?php echo form_label('City', 'city');
			echo form_input(array('name'=>'city', 'id'=>'city', 'maxlength'=>'200', 'value'=>set_value('city', $item->city))); ?>
		</li>
		<li>
			<?php echo form_label('States', 'state'); ?>
			<select name="state" id="state">
				<option value="">Choose State</option>
				<?php foreach($states->result() AS $state) { ?>
				<option value="<?php echo $state->value; ?>"<?php echo set_select('state', $state->value, $item->state == $state->value ? TRUE : FALSE) ?>><?php echo $state->alt_value; ?></option>
				<?php } ?>
			</select>
		</li>
	</ul>
	<?php echo form_fieldset_close(); ?>
	<ul class="buttons">
		<li>
			<?php echo form_hidden(array('process'=>'1', 'country'=>'United States', 'business_id' => $business->id));
			echo form_submit(array('value'=>'Save'));
			if( uri(4) == 'edit' && is_numeric(uri(5))) { ?>
			<a href="/admin/business/locations/delete/<?php echo uri(5); ?>/" onclick="return confirm('Are you sure you want to delete this business and all locations?');" class="delete-item">Delete</a>
			<?php } ?>
			<a href="/admin/business/" class="cancel-link">Cancel</a>
		</li>
	</ul>
</form>
<?php print_f($item); ?>