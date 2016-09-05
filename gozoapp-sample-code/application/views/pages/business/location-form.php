<form action="/<?php echo uri_string(); ?>/<?php echo $_SERVER['QUERY_STRING'] != '' ? '?' . $_SERVER['QUERY_STRING'] : null; ?>" method="post" accept-charset="utf-8">
	<?php echo form_fieldset('Manage Location'); ?>
	<ul>
		<li>
			<?php echo form_label('Title');
			echo form_input(array('name'=>'title', 'maxlength'=>'128', 'value'=>set_value('title', $item['title']))); ?>
		</li>
		<li>
			<?php echo form_label('Address Line 1');
			echo form_input(array('name'=>'address_1', 'maxlength'=>'255', 'value'=>set_value('address_1', $item['address']))); ?>
		</li>
		<li>
			<?php echo form_label('City');
			echo form_input(array('name'=>'city', 'maxlength'=>'75', 'value'=>set_value('city', $item['city']))); ?>
		</li>
		<li>
			<?php echo form_label('State'); ?>
			<select name="state_id">
				<option value="">choose one...</option>
				<?php foreach($states->result() AS $state) { ?>
				<option value="<?php echo $state->value; ?>"<?php echo set_select('state_id', $state->value, $state->value == $item['state'] ? TRUE : FALSE); ?>><?php echo $state->alt_value . ' (' . $state->value . ')'; ?></option>
				<?php } ?>
			</select>
		</li>
	</ul>
	<?php echo form_fieldset_close(); ?>
	<ul class="buttons">
		<li>
			<?php echo form_hidden(array('process'=>'1', 'country'=>'United States', 'business_id' => $business_id));
			echo form_submit(array('value'=>'Save'));
			if( uri(4) == 'edit' && is_numeric(uri(5))) { ?>
			<a href="/admin/business/locations/delete/<?php echo uri(5); ?>/" onclick="return confirm('Are you sure you want to delete this business and all locations?');" class="delete-item">Delete</a>
			<?php } ?>
			<a href="/admin/business/" class="cancel-link">Cancel</a>
		</li>
	</ul>

</form>