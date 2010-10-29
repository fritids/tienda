<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('script', 'tienda.js', 'media/com_tienda/js/'); ?>
<?php $state = @$vars->state; ?>

<p><?php echo JText::_( "This report displays the quantity of each product that was ordered during a selected time period." ); ?></p>

<div class="note">
    <?php // Many stores will have 1,000+ items, which is too many for a selectlist
    // TODO Convert this to just a text input box so the admin can filter by product_name 
    ?>
	<?php echo JText::_("Select Product"); ?>:
	<input type="text" name="product_name" id="product_name" value="<?php echo @$state->product_name; ?>" style="width: 250px;"/>
	<br/><br/>
	<?php echo JText::_("Select Date Range"); ?>:	
	<?php $attribs = array('class' => 'inputbox', 'size' => '1'); ?>	
	<?php echo TiendaSelect::reportrange( @$state->filter_range ? $state->filter_range : 'custom', 'filter_range', $attribs, 'range', true ); ?>	
	<span class="label"><?php echo JText::_("From"); ?>:</span>
	<?php echo JHTML::calendar( @$state->filter_date_from, "filter_date_from", "filter_date_from", '%Y-%m-%d %H:%M:%S' ); ?>
	<span class="label"><?php echo JText::_("To"); ?>:</span>
	<?php echo JHTML::calendar( @$state->filter_date_to, "filter_date_to", "filter_date_to", '%Y-%m-%d %H:%M:%S' ); ?>
</div>