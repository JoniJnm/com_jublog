<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class JUblogViewConfig extends JUBlogView
{
	public function display($tpl = null) {
		JToolBarHelper::preferences('com_jublog');
		parent::display($tpl);
	}
}
