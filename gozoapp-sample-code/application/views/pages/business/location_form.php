<form action="/<?php echo uri_string();?>/" method="post" accept-charset="utf-8">
	<?php echo form_fieldset('Location Details'); ?>
	<ul>
		<li>
			<?php echo form_label('Business', 'owner_id');?>
			<select name="owner_id" id="owner_id">
				<option value="">choose one...</option>
				<?php foreach($businesses->result() AS $business) { ?>
				<option value="<?php echo $business->id; ?>"<?php echo set_select('owner_id', $business->id, $business->id == $item->owner_id || $this->input->get('id') == $business->id ? TRUE : FALSE); ?>><?php echo $business->company; ?></option>
				<?php } ?>
			</select>
		</li>
		<li>
			<?php echo form_label('Title', 'title');
			echo form_input(array('name'=>'title', 'id'=>'title', 'maxlength'=>'64', 'value'=>set_value('title', $item->title))); ?>
		</li>
		<li>
			<?php echo form_label('Address', 'address_1');
			echo form_input(array('name'=>'address_line_1', 'id'=>'address_1', 'maxlength'=>'64', 'value'=>set_value('address_line_1', $item->address_line_1))); ?>
		</li>
		<li>
			<?php echo form_label('Address (cont.)', 'address_2');
			echo form_input(array('name'=>'address_line_2', 'id'=>'address_2', 'maxlength'=>'64', 'value'=>set_value('address_line_2', $item->address_line_2))); ?>
		</li>
		<li>
			<?php echo form_label('City', 'city');
			echo form_input(array('name'=>'city', 'id'=>'city', 'maxlength'=>'64', 'value'=>set_value('city', $item->city))); ?>
		</li>
		<li>
			<?php echo form_label('State', 'eav_state_id'); ?>
			<select name="eav_state_id" id="eav_state_id">
				<option value="">choose one...</option>
				<?php foreach($states->result() AS $state) { ?>
				<option value="<?php echo $state->id;?>"<?php echo set_select('eav_state_id', $state->id, $state->id == $item->eav_state_id ? TRUE : FALSE); ?>><?php echo $state->alt_value; ?></option>
				<?php } ?>
			</select>
		</li>
		<li>
			<?php echo form_label('Zip Code', 'zip');
			echo form_input(array('name'=>'zip', 'id'=>'zip', 'maxlength'=>'5', 'style'=>'width:100px;', 'value'=>set_value('zip', $item->zip_code))); ?>
		</li>
		<li>
			<?php echo form_label('Latitude', 'latitude');
			echo form_input(array('name'=>'latitude', 'id'=>'latitude', 'readonly'=>'readonly', 'style'=>'width:100px;', 'value'=>set_value('latitude', $item->latitude))); ?>
		</li>
		<li>
			<?php echo form_label('Longitude', 'longitude');
			echo form_input(array('name'=>'longitude', 'id'=>'longitude', 'readonly', 'style'=>'width:100px;', 'value'=>set_value('longitude', $item->longitude))); ?>
		</li>
		<li>
			<?php echo form_label('Phone', 'phone');
			echo form_input(array('name'=>'phone', 'id'=>'phone', 'class'=>'phone', 'style'=>'width:100px;', 'value'=>set_value('phone', format_phone_number($item->phone)))); ?>
		</li>
	</ul>
	<?php echo form_fieldset_close(); ?>
	<ul class="buttons">
		<li>
			<?php echo form_hidden(array('process'=>'1'));
			echo form_submit(array('value'=>'Save'));
			if( uri(4) == 'edit' && is_numeric(uri(5))) { ?>
			<a href="/admin/business/locations/delete/<?php echo uri(5); ?>/" onclick="return confirm('Are you sure you want to delete this business and all locations?');" class="delete-item">Delete</a>
			<?php } ?>
			<a href="/admin/business/" class="cancel-link">Cancel</a>
		</li>
	</ul>
</form>
<script type="text/javascript">
$(document).ready(function(){
	
	$('#zip').blur(function(){
		zip_code = $('#zip').val();
		if( zip_code != '')
		{
			$.ajax({
				type: 'post',
				url: '/admin/ajax/get-coordinates/',
				data: {zip_code:zip_code},
				async: false,
				success:function(response) {
					response = $.parseJSON(response);
					
					switch(eval(response).status)
					{
						case 'success':
							$('#longitude').val(eval(response).longitude);
							$('#latitude').val(eval(response).latitude);
							break;
					}
				}
			});
		}
	})
});
</script>
