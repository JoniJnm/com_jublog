<?php

defined('_JEXEC') or die;
?>

<div id="jublog">
	<h1><?php echo JText::_('COM_JUBLOG_PERSONAL_PAGE'); ?></h1>
	<br />

	<div><button onclick="jublog.personal.enviar()"><?php echo JText::_('COM_JUBLOG_SAVE'); ?></button></div>
	<form action="<?php echo JUBLOG_PATH.'&controller=personal&task=edit'; ?>" id="jublogForm" name="jublogForm" method="post">
		<?php echo $this->editor; ?>
	</form>
</div>