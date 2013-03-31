<?php

defined('_JEXEC') or die;
?>
<div id="jublog">
	<h1><?php echo JText::_('COM_JUBLOG_ARTICLE_LIST'); ?></h1>
	<br />

	<?php echo $this->loadTemplate('bar'); ?>
	<br />
	<div>
	<?php foreach ($this->items as &$item) : ?>
		<a href="<?php echo JRoute::_(JUBLOG_PATH.'&view=article&id='.$item->id); ?>"><img src="<?php echo JURI::base().'media/system/images/edit.png'; ?>" alt="<?php echo JText::_('COM_JUBLOG_EDIT'); ?>" /></a>
		<a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
	<?php endforeach; ?>
	</div>
	<?php echo $this->loadTemplate('footer'); ?>
</div>