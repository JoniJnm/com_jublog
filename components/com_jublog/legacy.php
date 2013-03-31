<?php

/*
 * @component Kide Shoutbox
 * @copyright Copyright (C) 2013 - JoniJnm.es
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
 
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');
jimport('joomla.application.component.model');
jimport('joomla.application.component.view');

if (version_compare(JVERSION, 3.0, '<')) {
	class JUBlogController extends JController {}
	class JUBlogModel extends JModel {}
	class JUBlogView extends JView {}
}
else {
	class JUBlogController extends JControllerLegacy {}
	class JUBlogModel extends JModelLegacy {}
	class JUBlogView extends JViewLegacy {}
}