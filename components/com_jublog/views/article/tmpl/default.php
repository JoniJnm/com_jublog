<?php

defined('_JEXEC') or die;
?>

<div id="jublog">
	<h1><?php echo JText::_('COM_JUBLOG_NEW_ARTICLE'); ?></h1>
	<br />

	<div><button onclick="jublog.article.enviar()"><?php echo JText::_('COM_JUBLOG_SAVE'); ?></button></div>
	<form action="<?php echo JUBLOG_PATH.'&controller=article&task=edit'; ?>" id="jublogForm" name="jublogForm" method="post">
		<table class="jublog">
			<tr>
				<td><?php echo JText::_('COM_JUBLOG_TITULO'); ?></td>
				<td><input type="text" id="title" name="title" value="<?php echo $this->art->title; ?>" />
			</tr>
			<tr>
				<td style="vertical-align:top"><?php echo JText::_('COM_JUBLOG_CATEGORY'); ?></td>
				<td>
					<select id="catid" name="catid" onchange="jublog.article.change_category(this.value)">
						<?php foreach ($this->cats as &$cat) : ?>
						<option value="<?php echo $cat->id; ?>" <?php if ($cat->id == $this->catid) echo 'selected="selected"'; ?>><?php echo $cat->title; ?></option>
						<?php endforeach; ?>
						<option value="0"><?php echo JText::_('COM_JUBLOG_NEW_CAT'); ?></option>
					</select>
					<div id="new_cat_div" style="display:none"><?php echo JText::_('COM_JUBLOG_NEW_CATID_NAME'); ?> <input type="text" id="new_cat" name="new_cat" value="" /></div>
				</td>
			</tr>
			<tr>
				<td><?php echo JText::_('COM_JUBLOG_TAGS'); ?></td>
				<td><input type="text" id="metakey" name="metakey" value="<?php echo $this->art->metakey; ?>" />
			</tr>
			<tr>
				<td></td>
				<td><?php echo $this->editor; ?></td>
			</tr>
		</table>
		<input type="hidden" name="id" value="<?php echo JRequest::getInt('id', 0); ?>" />
	</form>
</div>
<script type="text/javascript">
jublog.article.check_category();
</script>
