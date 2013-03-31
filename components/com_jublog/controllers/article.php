<?php

/**
* @Copyright Copyright (C) 2012 - JoniJnm.es
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined('_JEXEC') or die();

jimport('joomla.application.component.controller');

class JUblogControllerArticle extends JUBlogController {
	function edit() {
		$user = JFactory::getUser();
		if (!$user->id) die("Session expired");
		$db = JFactory::getDBO();
		$id = JRequest::getInt('id', 0);
		$title = JRequest::getVar('title');
		$metakey = JRequest::getVar('metakey');	
		$text = JRequest::getVar('jublog_text', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$text = explode('<hr id="system-readmore" />', $text);
		if (count($text) == 1) {
			$introtext = $text[0];
			$fulltext = '';
		}
		else {
			$introtext = $text[0];
			$fulltext = $text[1];
		}
		jimport('joomla.filter.output');
		$alias = preg_replace("/-+/", "-", JFilterOutput::stringURLSafe($title));
		$created = gmdate('Y-m-d H:i:00', time());
		$catid = JRequest::getInt('catid');
		if (!$catid) {
			$parent = JUblogHelper::checkCat();
			$new_cat = JRequest::getVar('new_cat');
			$catid = JUblogHelper::createCat($parent, $new_cat);
			if (!$catid) {
				$this->setRedirect(JRoute::_(JUBLOG_PATH.'&view=article'), JText::_(COM_JUBLOG_CATEGORY_CANT_BE_CREATE));
				return;
			}
		}
		if ($id) {
			$db->setQuery('UPDATE #__content SET 
					title="'.addslashes($title).'",alias="'.$alias.'",introtext="'.addslashes($introtext).'",
					`fulltext`="'.addslashes($fulltext).'",catid='.$catid.',modified="'.$created.'",metakey="'.$metakey.'" WHERE id='.$id);
		}
		else {
			$db->setQuery('SELECT id FROM #__content WHERE alias="'.$alias.'" AND catid='.$catid);
			if ($db->loadResult() > 0) {
				$this->setRedirect(JRoute::_(JUBLOG_PATH.'&view=pagina'), JText::_(COM_JUBLOG_ARTICLE_CANT_BE_CREATE));
				return;
			}
			$db->setQuery('INSERT INTO #__content (title,alias,introtext,`fulltext`,state,catid,created,metakey,created_by,access,language) VALUES
					("'.addslashes($title).'","'.$alias.'","'.addslashes($introtext).'","'.addslashes($fulltext).'",
					1,'.$catid.',"'.$created.'","'.$metakey.'",'.$user->id.',1,"*")');
		}
		$db->query();
		$this->setRedirect(JRoute::_(JUBLOG_PATH));
	}
}
