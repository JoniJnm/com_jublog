<?php

/**
* @Copyright Copyright (C) 2012 - JoniJnm.es
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

jimport('joomla.filter.output');

function JUblogBuildRoute(&$query) {
	$lang = JFactory::getLanguage();
	$lang->load("com_jublog");
	$segments = array();
	if(isset($query['view'])) {
		switch ($query['view']) {
			case 'article':
				$segments[] = JFilterOutput::stringURLSafe(JText::_('COM_JUBLOG_SEO_ARTICLE'));
				break;
			case 'personal':
				$segments[] = JFilterOutput::stringURLSafe(JText::_('COM_JUBLOG_SEO_PERSONAL'));
				break;
		}
		unset( $query['view'] );
	}
	return $segments;
}

function JUblogParseRoute($segments) {
	$lang = JFactory::getLanguage();
	$lang->load("com_jublog");
	$vars = array();
	switch($segments[0]) {
		case JFilterOutput::stringURLSafe(JText::_('COM_JUBLOG_SEO_ARTICLE')):
			$vars['view'] = 'article';
			break;
		case JFilterOutput::stringURLSafe(JText::_('COM_JUBLOG_SEO_PERSONAL')):
			$vars['view'] = 'personal';
			break;
	}
	return $vars;
}
