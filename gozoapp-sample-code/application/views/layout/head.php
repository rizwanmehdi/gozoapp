<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php echo $this->config->item('application_name'); if(isset($title)) { echo ' | ' . $title; } ?></title>
<?php
/* CSS */
echo $this->template->css('reset', 'screen') . "\n";
echo $this->template->css('default.screen', 'screen') . "\n";
echo $this->template->css('forms', 'screen') . "\n";
echo $this->template->css('pagination', 'screen') . "\n";
echo $this->template->css('messages', 'screen') . "\n";
echo $this->template->css('ui-theme/jquery-ui-1.8.11.custom') . "\n";
echo $this->template->css($this->template->path('js/tablesorter/style.css'), 'screen', null, true) . "\n";
echo $this->template->css($this->template->path('js/uploadify/uploadify.css'), 'screen', null, true) . "\n";
$this->template->load_styles();

/* SCRIPTS */
echo $this->template->script('https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', true) . "\n";
echo $this->template->script('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js', true) . "\n";
echo $this->template->script('jquery.maskedinput') . "\n";
echo $this->template->script('tablesorter/jquery.tablesorter.min') . "\n";
echo $this->template->script('uploadify/jquery.uploadify.min') . "\n";
echo $this->template->script('jquery.blockUI.js') . "\n";

echo $this->template->script('base');
$this->template->load_scripts();
?>
</head>
<body>