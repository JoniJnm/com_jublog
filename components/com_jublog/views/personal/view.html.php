<?php
/**
* @Copyright Copyright (C) 2012 - JoniJnm.es
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die();
jimport('joomla.application.component.view');

class JUblogViewPersonal extends JUBlogView {
	function display($tpl = null) {
		if ($this->getLayout() == 'mypp') {
			$url = JUblogHelper::getPersonalPageUrl();
			if ($url)
				JFactory::getApplication()->redirect($url);
			else
				JFactory::getApplication()->redirect(JRoute::_(JUBLOG_PATH.'&view=personal'), JText::_('COM_JUBLOG_NO_PP_CREATED'));
		}
		$user = JFactory::getUser();
		$db = JFactory::getDBO();
		$catid = JUblogHelper::getParams()->get('catid_pp');
		if (!$catid)
			JFactory::getApplication()->redirect(JRoute::_(JUBLOG_PATH), JText::_('COM_JUBLOG_SELECT_CATID_PP'));
		jimport('joomla.filter.output');
		$alias = preg_replace("/-+/", "-", JFilterOutput::stringURLSafe($user->name));
		$db->setQuery('SELECT id FROM #__content WHERE alias="'.$alias.'" AND catid='.$catid);
		$id = (int)$db->loadResult();
		$art = JUblogHelper::getArt($id);
		$editor = JUblogHelper::getEditor($art->introtext, $art->fulltext, false);
		$this->assignRef('editor', $editor);
		parent::display($tpl);
	}
}
