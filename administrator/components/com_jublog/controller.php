<?php

/**
* @Copyright Copyright (C) 2012 - JoniJnm.es
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die;
class JUblogControllerAdmin extends JUBlogController
{
	var $default_view = 'config';
	
	public function display($cachable = false, $urlparams = false) {
		JToolBarHelper::title('Jublog');
		parent::display();
		return $this;
	}
}
