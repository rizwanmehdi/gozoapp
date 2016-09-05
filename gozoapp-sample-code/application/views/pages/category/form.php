<form action="/<?php echo uri_string(); ?>/" method="post" accept-charset="utf-8">
	<?php echo form_fieldset('Category'); ?>
	<ul>
		<li>
			<?php echo form_label('Parent Category', 'parent_id'); ?>
			<select name="parent_id" id="parent_id">
			<option value="">choose one</option>
			<?php foreach($parents->result() AS $parent) { ?>
			<option value="<?php echo $parent->id; ?>"<?php echo set_select('parent_id', $parent->id, $parent->id == $item->parent_id ? TRUE : FALSE); ?>><?php echo $parent->title;?></option>
			<?php } ?>
			</select>
		</li>
		<li>
			<?php echo form_label('Category', 'title');
			echo form_input(array('name'=>'title', 'label'=>'category', 'maxlength'=>'50', 'value'=>set_value('title', $item->title))); ?>
		</li>
	</ul>
	<?php echo form_fieldset_close(); ?>
	<ul class="buttons">
		<li>
			<?php echo form_hidden(array('process'=>'1'));
			echo form_submit(array('value'=>'Save'));
			if( uri(4) == 'edit' && is_numeric(uri(5))) { ?>
			<a href="/admin/category/delete/<?php echo uri(4); ?>/" onclick="return confirm('Are you sure you want to delete this business and all locations?');" class="delete-item">Delete</a>
			<?php } ?>
			<a href="/admin/category/" class="cancel-link">Cancel</a>
		</li>
	</ul>
</form>