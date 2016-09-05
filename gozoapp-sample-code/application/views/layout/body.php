
	<div id="core">
		<?php if(uri(2) == 'docs' && uri(3) != 'oa') { ?>
			<h2 class="class_name">Class Name: <?php echo isset($class_name) ? $class_name : null; ?></h2>
		<?php } ?>
		<?php echo $this->message->display(); ?>
		
		<?php $this->template->view('pages/'.$page); ?>
	</div>

