<?php
/**
* @Copyright Copyright (C) 2012 - JoniJnm.es
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class JUblogModelPagina extends JUBlogModel {
	function &getCats($id) {
		$db = JFactory::getDBO();
		$db->setQuery('SELECT id,title FROM #__categories WHERE parent_id='.$id);
		$items = $db->loadObjectList();
		return $items;
	}
}
