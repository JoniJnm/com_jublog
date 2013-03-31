<?php
/**
* @Copyright Copyright (C) 2012 - JoniJnm.es
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die();
jimport('joomla.application.component.view');

class JUblogViewJUblog extends JUBlogView {
	function display($tpl = null) {	
		$model = $this->getModel();
		$catid = JUblogHelper::checkCat();	
		if ($catid) {
			$items = $model->getList($catid);
			if ($this->getLayout() == 'myblog') {
				if (count($items))
					JFactory::getApplication()->redirect($model->getBlogUrl($catid));
				else
					JFactory::getApplication()->redirect(JRoute::_(JUBLOG_PATH), JText::_('COM_JUBLOG_NO_ARTICLES'));
			}
			if (count($items)) {
				$user = JFactory::getUser();
				$this->assign('userid', $user->id);
				$this->assign('blog', $model->getBlogUrl($catid));
				$this->assignRef("items", $items);
			}
			else
				$tpl = 'noitems';
		}
		else {
			$this->setLayout('error');
			$tpl = 'catid';
		}
		parent::display($tpl);
	}
}
