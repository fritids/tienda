<?php	defined('_JEXEC') or die('Restricted access');?>
<p>
	<?php	echo JText::_($this->_importer->get('tool_description'));?>
</p>
<div class="note">
	<span style="float: right; font-size: large; font-weight: bold;">
		<?php	echo JText::_('COM_TIENDA_FINAL');?>
	</span>
	<p>
		<?php	echo JText::_('COM_TIENDA_MIGRATION_RESULTS');?>
	</p>
</div>
<?php echo $this->getHtmlStep(3, 2);?>
<?php echo $this->vars->additional_html;?>
