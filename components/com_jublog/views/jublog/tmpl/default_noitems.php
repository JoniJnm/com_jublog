<?php
defined('_JEXEC') or die;
?>
<h1><?php echo JText::_('COM_JUBLOG_ARTICLE_LIST'); ?></h1>
<br />

<?php 

echo $this->loadTemplate('bar');
echo '<br />';
echo JText::_('COM_JUBLOG_NO_ARTICLES');
echo $this->loadTemplate('footer');
