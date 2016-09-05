<form action="/<?php echo uri_string(); ?>/" method="post" accept-charset="utf-8">
	<?php echo form_fieldset('Business Information'); ?>
	<ul>
		<li>
			<?php echo form_label('Category', 'category'); ?>
			<select name="category_id" id="category">
				<option value="">Choose Top Level Category</option>
				<?php foreach($categories->result() AS $category) { ?>
				<option value="<?php echo $category->id; ?>"<?php echo set_select('category_id', $category->id, $item->category_id == $category->id ? TRUE : FALSE); ?>><?php echo $category->title; ?></option>
				<?php } ?>
			</select>
		</li>
		<li>
			<?php echo form_label('Sub-Category', 'sub-category'); ?>
			<select name="subcategory_id" id="sub-category">
				<option value="">Choose Top Level Category First</option>
			</select>
		</li>
		<li>
			<?php echo form_label('Business Name', 'company');
			echo form_input(array('name'=>'company', 'id'=>'company', 'maxlength'=>'50', 'value'=>set_value('company', $item->company))); ?>
		</li>
		<li>
			<?php echo form_label('Phone', 'phone');
			echo form_input(array('name'=>'phone', 'id'=>'phone', 'maxlength'=>'20', 'class'=>'phone', 'value'=>set_value('phone', $item->phone ? format_phone_number($item->phone) : null))); ?>
		</li>
		<li>
			<?php echo form_label('Email', 'email');
			echo form_input(array('name'=>'email', 'id'=>'email', 'maxlength'=>'64', 'value'=>set_value('email', $item->email))); ?>
		</li>
		<li>
			<?php echo form_label('Password', 'password');
			echo form_input(array('name'=>'password', 'id'=>'password', 'maxlength'=>'12', 'value'=>set_value('password'))); ?> <a href="#" class="generate-password">Generate Password</a>
		</li>
	</ul>
	<?php echo form_fieldset_close(); ?>
	<ul class="buttons">
		<li>
			<?php echo form_hidden(array('process'=>'1'));
			echo form_submit(array('value'=>'Save'));
			if( uri(4) == 'edit' && is_numeric(uri(5)) ) { ?>
			<a href="/admin/business/delete/<?php echo uri(5); ?>/" onclick="return confirm('Are you sure you want to delete this business and all locations?');" class="delete-item">Delete</a>
			<?php } ?>
			<a href="/admin/business/" class="cancel-link">Cancel</a>
		</li>
	</ul>
</form>

<script type="text/javascript">
$(document).ready(function(){
	$('#category').change(function(){
		if( $('#category').val() != '' )
		{
			category_id = $('#category').val();
			child_id = '<?php echo $item->subcategory_id; ?>';
			
			$.ajax({
				type: 'post',
				url: '/admin/ajax/generate_subcategory_dropdown/' + category_id + '/',
				data: {child_id: child_id},
				success: function(response)
				{
					$('#sub-category').html(response);
				}
			});
		}
	});
	
	$('.generate-password').click(function(){
		input = $('#password');
		$.ajax({
			type: 'post',
			url: '/admin/ajax/generate-password/',
			data: {},
			success:function(response) {
				input.val(response);
			}
		});
		return false;
	});
	
	<?php if( uri(3) == 'edit' ) { ?>
	$('#category').trigger('change');
	<?php } ?>

});
</script>