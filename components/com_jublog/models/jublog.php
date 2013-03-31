<?php
/**
* @Copyright Copyright (C) 2012 - JoniJnm.es
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die();
jimport('joomla.application.component.model');

class JUblogModelJUblog extends JUBlogModel {
	function &getList($id) {
		require_once JPATH_SITE.'/components/com_content/helpers/route.php';
		$db = JFactory::getDBO();
		$db->setQuery("SELECT a.id,a.title,a.alias,a.catid FROM #__content AS a LEFT JOIN #__categories AS c ON c.id=a.catid WHERE c.parent_id=".$id);
		$items = $db->loadObjectList();
		foreach ($items as &$item) {
			$url = ContentHelperRoute::getArticleRoute($item->id.':'.$item->alias, $item->catid);
			if (strpos($url, '&Itemid=') === false) $url .= JUblogHelper::getContentItemid();
			$item->url = JRoute::_($url);
		}
		return $items;
	}
	function getBlogUrl($catid) {
		require_once JPATH_SITE.'/components/com_content/helpers/route.php';
		$url = ContentHelperRoute::getCategoryRoute($catid);
		if (strpos($url, '&Itemid=') === false) $url .= JUblogHelper::getContentItemid();
		return JRoute::_($url);
	}
}
