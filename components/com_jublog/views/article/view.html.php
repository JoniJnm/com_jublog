<?php
/**
* @Copyright Copyright (C) 2012 - JoniJnm.es
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die();
jimport('joomla.application.component.view');

class JUblogViewArticle extends JUBlogView {
	function display($tpl = null) {
		$model = $this->getModel();
		$catid = JUblogHelper::checkCat();
		if (!$catid) {
			JFactory::getApplication()->redirect(JRoute::_(JUBLOG_PATH.'&view=article'), JText::_('COM_JUBLOG_SELECT_CATID_BLOGS'));
			return;
		}
		$id = JRequest::getInt('id', 0);
		$cats = $model->getCats($catid);
		$art = JUblogHelper::getArt($id);
		$editor = JUblogHelper::getEditor($art->introtext, $art->fulltext);

		$this->assignRef('catid', $catid);
		$this->assignRef('cats', $cats);
		$this->assignRef('art', $art);
		$this->assignRef('editor', $editor);
		parent::display($tpl);
	}
}
