<?php

/**
* @Copyright Copyright (C) 2012 - JoniJnm.es
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined('_JEXEC') or die;

$db = JFactory::getDBO();
$db->setQuery('SELECT id FROM #__menu WHERE link LIKE "index.php?option=com_jublog%" AND published=1 LIMIT 1');
$Itemid = (int)$db->loadResult();
DEFINE('JUBLOG_ITEMID', $Itemid ? '&Itemid='.$Itemid : '');

DEFINE('JUBLOG_PHP', dirname(__FILE__).'/');
DEFINE('JUBLOG_HTML', JURI::root().'components/com_jublog/');
DEFINE('JUBLOG_PATH', 'index.php?option=com_jublog'.JUBLOG_ITEMID);
DEFINE('JUBLOG_AJAX', JURI::root().JUBLOG_PATH.'&no_html=1&tmpl=component');

require_once(JUBLOG_PHP.'helpers/jublog.php');

if (JRequest::getCmd('no_html')) {
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-type: text/html; charset=utf-8');
}
else {
	JUblogHelper::addHead();
}

require_once(dirname(__FILE__).'/legacy.php');

$controller = JRequest::getCmd('controller', 'jublog');
if (!file_exists(JUBLOG_PHP.'controllers/'.$controller.'.php')) $controller = 'jublog';
require_once(JUBLOG_PHP.'controllers/'.$controller.'.php');

$controller = 'JUblogController'.$controller;
$controller = new $controller();
$controller->execute(JRequest::getCmd('task'));
if (JRequest::getCmd('no_html')) exit;
$controller->redirect();
