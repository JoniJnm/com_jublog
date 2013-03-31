<?php

defined('_JEXEC') or die;

class JUblogHelper {
	static private $TEXTAREA_NAME = "jublog_text";
	
	function addHead() {
		$doc = JFactory::getDocument();
		$doc->addScript(JUBLOG_HTML.'assets/jublog.js');		
		$doc->addStyleSheet(JUBLOG_HTML.'assets/jublog.css');
		$doc->addScriptDeclaration("
		jublog.path='".JUBLOG_PATH."';
		jublog.html='".JUBLOG_HTML."'
		jublog.msgs = {
			FILL_REQUIRED_FIELDS: '".JText::_("COM_JUBLOG_FILL_REQUIRED_FIELDS")."'
		};
		jublog.editorSave = function() {
			".self::getEditorSaveFunction()."
		};
		");
	}
	function getContentItemid() {
		static $id = -1;
		if ($id == -1) {
			$db = JFactory::getDBO();
			$db->setQuery('SELECT id FROM #__menu WHERE link="index.php?option=com_content&view=featured" AND home=1');
			$id = $db->loadResult();
			if (!$id) {
				$db->setQuery('SELECT id FROM #__menu WHERE link="index.php?option=com_content&view=featured" AND access<=1 AND published=1 ORDER BY id DESC LIMIT 1');
				$id = $db->loadResult();
				if (!$id) {
					$db->setQuery('SELECT id FROM #__menu WHERE link LIKE "index.php?option=com_content%" AND access<=1 AND published=1 ORDER BY id DESC LIMIT 1');
					$id = (int)$db->loadResult();
				}
			}
			$id = $id ? '&Itemid='.$id : '';
		}
		return $id;
	}
	function getPersonalPageUrl($id=null) {
		require_once JPATH_SITE.'/components/com_content/helpers/route.php';
		$catid = JUblogHelper::getParams()->get('catid_pp');
		if (!$catid) return '';
		$db = JFactory::getDBO();
		$user = JFactory::getUser($id);
		if (!$user) return '';
		$db->setQuery('SELECT id,alias,catid FROM #__content WHERE catid='.$catid.' AND alias="'.JFilterOutput::stringURLSafe($user->name).'"');
		$obj = $db->loadObject();
		if (!$obj) return '';
		$url = ContentHelperRoute::getArticleRoute($obj->id.':'.$obj->alias, $obj->catid);
		if (strpos($url, '&Itemid=') === false) $url .= self::getContentItemid();
		return JRoute::_($url);
	}
	function &getParams() {
		static $params;
		if (!is_object($params))
			$params = JComponentHelper::getParams('com_jublog');
		return $params;
	}
	function checkCat() {
		$db = JFactory::getDBO();
		$params = JUblogHelper::getParams();
		$catid = $params->get('catid_blogs');
		if (!$catid) return 0;
		jimport('joomla.filter.output');		
		$user = JFactory::getUser();
		$alias = JFilterOutput::stringURLSafe($user->name);
		$db->setQuery('SELECT id FROM #__categories WHERE alias="'.$alias.'"');
		$id = $db->loadResult();
		return $id ? $id : self::createCat($catid, $user->name);
	}
	function createCat($parent, $title) {
		jimport('joomla.filter.output');
		if (!$parent) {
			trigger_error('Error: $parent is null', E_USER_ERROR);
			exit;
		}
		if (!$title) {
			trigger_error('Error: $title is null', E_USER_ERROR);
			exit;
		}
		$user = JFactory::getUser();
		$db = JFactory::getDBO();
		$db->setQuery('SELECT path,level,lft,rgt FROM #__categories WHERE id='.$parent);
		$padre = $db->loadObject();
		if (!$padre) {
			trigger_error("Error: the catid with id ".$catid." does not exists", E_USER_ERROR);
			exit;
		}
		$alias = JFilterOutput::stringURLSafe($title);
		$db->setQuery('SELECT id FROM #__categories WHERE alias="'.$alias.'" AND parent_id='.$parent);
		if ($db->loadResult() > 0) {
			return 0;
		}
		$db->setQuery('UPDATE #__categories SET lft=lft+2 WHERE lft > '.$padre->rgt);
		$db->query();
		$db->setQuery('UPDATE #__categories SET rgt=rgt+2 WHERE rgt >= '.$padre->rgt);
		$db->query();
		$db->setQUery('INSERT INTO #__categories (lft,rgt,parent_id,level,path,extension,title,alias,published,access,created_user_id,language) 
			VALUES ('.$padre->rgt.','.($padre->rgt+1).','.$parent.','.($padre->level+1).',"'.$padre->path.'/'.$alias.'","com_content","'.$title.'","'.$alias.'",1,1,'.$user->id.',"*")');
		$db->query();
		$db->setQuery('SELECT LAST_INSERT_ID()');
		$id = $db->loadResult();
		return $id;
	}
	function createArt() {
		$obj = new stdclass;
		$obj->introtext = '';
		$obj->fulltext = '';
		$obj->metakey = '';
		$obj->title = '';
		return $obj;
	}
	function &getArt($id) {
		$db = JFactory::getDBO();
		$db->setQuery('SELECT * FROM #__content WHERE id='.$id);
		$item = $db->loadObject();
		if (!$item) $item = self::createArt();
		return $item;
	}
	function &getEditor($intro, $full, $more=true) {
		$editor = JFactory::getEditor();
		$html = $editor->display(self::$TEXTAREA_NAME, $intro.($intro&&$full?'<hr id="system-readmore" />':'').$full, '550', '400', '100', '50', false);
		$html .= self::getImageButton();
		if ($more) $html .= self::getReadmoreButton();
		return $html;
	}
	function getEditorSaveFunction() {
		$editor = JFactory::getEditor();
		return $editor->save(self::$TEXTAREA_NAME);
	}
	function getImageButton() {
		jimport('joomla.filter.output');
		$lang = JFactory::getLanguage();
		$lang->load('plg_editors-xtd_image', JPATH_ROOT.'/administrator');	
		$user = JFactory::getUser();
		$alias = JFilterOutput::stringURLSafe($user->username);
		$folder = JPATH_SITE.'/images/jublog/'.$alias.'/';
		if (!file_exists($folder)) {
			if (!file_exists(JPATH_SITE.'/images/jublog')) mkdir(JPATH_SITE.'/images/jublog');
			mkdir($folder);
		}
		$link = 'index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;e_name='.self::$TEXTAREA_NAME.'&amp;asset=com_content&amp;author=&amp;folder=jublog/'.$alias;
		JHtml::_('behavior.modal');
		$button = new JObject;
		$button->set('modal', true);
		$button->set('link', $link);
		$button->set('text', JText::_('PLG_IMAGE_BUTTON_IMAGE'));
		$button->set('name', 'image');
		$button->set('options', "{handler: 'iframe', size: {x: 800, y: 500}}");
		return self::displayButton($button);
	}
	function getReadmoreButton() {
		$lang = JFactory::getLanguage();
		$lang->load('plg_editors-xtd_readmore', JPATH_ROOT.'/administrator');
		$button = new JObject;
		$button->set('modal', false);
		$button->set('onclick', 'insertReadmore(\''.self::$TEXTAREA_NAME.'\');return false;');
		$button->set('text', JText::_('PLG_READMORE_BUTTON_READMORE'));
		$button->set('name', 'readmore');
		$button->set('link', '#');
		return self::displayButton($button);
	}
	function displayButton($button) {
		$modal		= ($button->get('modal')) ? 'class="modal-button"' : null;
		$base 		= substr($button->get('link'), 0, strlen('javascript:')) == 'javascript:' ? '' : JURI::base();
		$href		= ($button->get('link')) ? 'href="'.$base.$button->get('link').'"' : null;
		$onclick	= ($button->get('onclick')) ? 'onclick="'.$button->get('onclick').'"' : '';
		$title      = ($button->get('title')) ? $button->get('title') : $button->get('text');
		return "<div class=\"button2-left\"><div class=\"".$button->get('name')."\"><a ".$modal." title=\"".$title."\" ".$href." ".$onclick." rel=\"".$button->get('options')."\">".$button->get('text')."</a></div></div>\n";
	}
}
