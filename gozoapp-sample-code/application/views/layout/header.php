<div id="wrapper">
	<?php echo $this->template->img('gozo_logo.jpg', '', array('margin-top: 15px;')); ?>
	<ul id="nav">
		<?php if( $this->auth->logged_in() ) { ?>
		<li><a href="/admin/users/">Users</a></li>
		<li><a href="/admin/business/">Business</a></li>
		<li><a href="/admin/category/">Business Categories</a></li>
		<li><a href="/admin/docs/users/">API Docs</a></li>
		<li><a href="/admin/permissions/users/">Permissions</a></li>
		<li><a href="/admin/uauth/logout/">Log Out</a></li>
		<?php } else { ?>
		<li><a href="/login/">Log In</a></li>
		<?php } ?>
		<li style="float:right;"><a href="/">View Website</a></li>
	</ul>
	
	<?php if( $this->auth->logged_in() ) { ?>
	<ul id="secondary">

		<?php if( uri(2) == 'docs' ) { ?>
			<li><a href="/admin/docs/oa/">OAuth</a></li>
			<li><a href="/admin/docs/users/">Users</a></li>
			<li><a href="/admin/docs/locations/">Locations</a></li>
			<li><a href="/admin/docs/user-preferences/">User Preferences</a></li>
			<li><a href="/admin/docs/events/">Events</a></li>
			<li><a href="/admin/docs/reminders/">Reminders</a></li>
			<li><a href="#">Business</a></li>
			<li><a href="/admin/docs/category/">Categories</a></li>
			<li><a href="/admin/docs/library/">Library</a></li>
			<li><a href="/admin/docs/find-me/">Find Me</a></li>
			<li><a href="/admin/docs/notifications/">Notifications</a></li>
			<li><a href="/admin/docs/misc/">Misc Items</a></li>
		<?php } ?>
		
		<?php if( uri(2) == 'permissions' ) { ?>
			<li><a href="/admin/permissions/users/">Users</a></li>
			<li><a href="/admin/permissions/groups/">Groups</a></li>
			<li><a href="/admin/permissions/uris/">URIs</a></li>
			<?php if( uri(3) == 'users') { ?><li><a href="/admin/permissions/users/add/">Add User</a></li><?php } ?>
			<?php if( uri(3) == 'groups') { ?><li><a href="/admin/permissions/groups/add/">Add Group</a></li><?php } ?>
			<?php if( uri(3) == 'uris') { ?><li><a href="/admin/permissions/uris/add/">Add URI</a></li><?php } ?>		
		<?php } ?>
		
		<?php if( uri(2) == 'business' ) { ?>
			<li><a href="/admin/business/">List All</a></li>
			<li><a href="/admin/business/add/">Add Business</a></li>
			<?php if(uri(3) == 'locations') { ?>
			<li><a href="/admin/business/locations/add/?business_id=<?php echo $this->input->get('business_id'); ?>">Add Locations</a></li>
			<?php } ?>
		<?php } ?>
		
		<?php if( uri(2) == 'category') { ?>
			<li><a href="/admin/category/">List All</a></li>
			<li><a href="/admin/category/add">Add</a></li>
		<?php } ?>

		
	</ul>
	<?php } ?>
	
	<?php if( $this->auth->logged_in() ) { ?>
	<ul id="sub-nav">
			<?php if( uri(2) == 'docs' && uri(3) == 'oa' ) { ?>
			<li><a href="/admin/docs/oa/">Access Token</a></li>
			<li><a href="/admin/docs/oa/api/">API Overview</a></li>
			<li><a href="/admin/docs/oa/oauth/">OAuth/XAuth</a></li>
			<?php } ?>
			
		<?php if(uri(2) == 'docs' && uri(3) == 'users') { ?>
		<li><a href="#get">get</a></li>
		<li><a href="#register">register</a></li>
		<li><a href="#update">update</a></li>
		<li><a href="#forgot">forgot</a></li>
		<?php } ?>
				
		<?php if(uri(2) == 'docs' && uri(3) == 'locations') { ?>
		<li><a href="#user-save-location">user save locations</a></li>
		<li><a href="#save-location">save location</a></li>
		<li><a href="#delete-location">delete location</a></li>
		<?php } ?>
		
		<?php if(uri(2) == 'docs' && uri(3) == 'user-preferences') { ?>
		<li><a href="#merchants">merchants</a></li>
		<li><a href="#categories">categories</a></li>
		<li><a href="#update-categories">update merchants</a></li>
		<li><a href="#hide-denied">hide denied (side menu option)</a></li>
		<?php } ?>
		
		<?php if(uri(2) == 'docs' && uri(3) == 'events') { ?>
		<li><a href="#create">create</a></li>
		<li><a href="#update">update</a></li>
		<li><a href="#delete">delete</a></li>
		<li><a href="#get">get</a></li>
		<li><a href="#details">details</a></li>
		<li><a href="#user-titles">user titles</a></li>
		<li><a href="#post-comment">post comment</a></li>
		<li><a href="#update-user-status">update user status</a></li>
		<li><a href="#user-events">user events</a></li>
		<li><a href="#groups">groups</a>
		<li><a href="#save-title">save title</a></li>
		<li><a href="#save-for-later">save unfinished event</a></li>
		<?php } ?>	
		
		<?php if(uri(2) == 'docs' && uri(3) == 'reminders') { ?>
		<li><a href="#get">get</a></li>
		<li><a href="#update-user-reminders">update user reminders</a></li>
		<?php } ?>
		
		<?php if(uri(2) == 'docs' && uri(3) == 'category') { ?>
		<li><a href="#get">get</a></li>
		<?php } ?>
		
		<?php if(uri(2) == 'docs' && uri(3) == 'notifications') { ?>
		<li><a href="/admin/docs/notifications/#post">Post</a></li>
		<li><a href="/admin/docs/notifications-test/">Testing Form</a></li>
		<?php } ?>
		
		<?php if(uri(2) == 'docs' && uri(3) == 'library') { ?>
		<li><a href="/admin/docs/library/#get">Get</a></li>
		<?php } ?>
	</ul>
	<?php } ?>
		
	<div id="container">