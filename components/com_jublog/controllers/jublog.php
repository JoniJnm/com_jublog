<?php

/**
* @Copyright Copyright (C) 2012 - JoniJnm.es
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die();

jimport('joomla.application.component.controller');

class JUBlogControllerJUblog extends JUBlogController {
	function display() {
		$user = JFactory::getUser();
		if (!$user->id) die("Session expired");
		parent::display();
	}
}
