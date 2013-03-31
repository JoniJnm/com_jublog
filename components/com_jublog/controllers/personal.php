<?php

/**
* @Copyright Copyright (C) 2012 - JoniJnm.es
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die();

jimport('joomla.application.component.controller');

class JUblogControllerPersonal extends JUBlogController {
	function edit() {
		$user = JFactory::getUser();
		if (!$user->id) die("Session expired");
		$db = JFactory::getDBO();
		jimport('joomla.filter.output');
		$catid = JUblogHelper::getParams()->get('catid_pp');
		if (!$catid) {
			$this->setRedirect(JRoute::_(JUBLOG_PATH.'&view=personal'), JText::_('COM_JUBLOG_SELECT_CATID_PP'));
			return;
		}
		$introtext = JRequest::getVar('jublog_text', '', 'post', 'string', JREQUEST_ALLOWRAW);
		if (!trim($introtext)) {
			$this->setRedirect(JRoute::_(JUBLOG_PATH.'&view=personal'), JText::_('COM_JUBLOG_TEXT_NOT_EMPTY'));
			return;
		}
		$alias = preg_replace("/-+/", "-", JFilterOutput::stringURLSafe($user->name));
		$db->setQuery('SELECT id FROM #__content WHERE alias="'.$alias.'" AND catid='.$catid);
		$id = (int)$db->loadResult();
		$title = $user->name;
		$created = gmdate('Y-m-d H:i:00', time());
		if ($id) {
			$db->setQuery('UPDATE #__content SET 
					title="'.addslashes($title).'",alias="'.$alias.'",introtext="'.addslashes($introtext).'",
					`fulltext`="",catid='.$catid.',modified="'.$created.'" WHERE id='.$id);
		}
		else {
			$db->setQuery('INSERT INTO #__content (title,alias,introtext,state,catid,created,created_by,access,language) VALUES
					("'.addslashes($title).'","'.$alias.'","'.addslashes($introtext).'",
					1,'.$catid.',"'.$created.'",'.$user->id.',1,"*")');
		}
		$db->query();
		$this->setRedirect(JRoute::_(JUBLOG_PATH));
	}
}
