<?php

/**
* @Copyright Copyright (C) 2012 - JoniJnm.es
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_ROOT.'/components/com_jublog/legacy.php');
require_once(dirname(__FILE__).'/controller.php');

$controller	= new JUblogControllerAdmin();
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
