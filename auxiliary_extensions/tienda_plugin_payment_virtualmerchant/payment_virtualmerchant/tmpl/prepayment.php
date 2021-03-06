<?php defined('_JEXEC') or die('Restricted access'); ?>

<div class="note">
<?php echo JText::_('TIENDA VIRTUALMERCHANT PAYMENT PREPARATION MESSAGE');?>
</div>

<form action="<?php echo @$vars->payment_url; ?>" method="post" name="adminForm">

    <input type='hidden' name='ssl_merchant_id' value='<?php echo @$vars->ssl_merchant_id; ?>' />
    <input type='hidden' name='ssl_pin' value='<?php echo @$vars->ssl_pin; ?>' />
    
    <input type='hidden' name='ssl_user_id' value='<?php echo @$vars->ssl_user_id; ?>' />
    <input type='hidden' name='ssl_show_form' value='true' />
    <input type='hidden' name='ssl_transaction_type' value='CCSALE' />
    
    <input type='hidden' name='ssl_company' value='<?php echo @$vars->company; ?>' />
    <input type='hidden' name='ssl_first_name' value='<?php echo @$vars->first_name; ?>' />
    <input type='hidden' name='ssl_last_name' value='<?php echo @$vars->last_name; ?>' />
    <input type='hidden' name='ssl_avs_address' value='<?php echo @$vars->address_1; ?>' />
    <input type='hidden' name='ssl_address2' value='<?php echo @$vars->address_2; ?>' />
    <input type='hidden' name='ssl_city' value='<?php echo @$vars->city; ?>' />
    <input type='hidden' name='ssl_state' value='<?php echo @$vars->state; ?>' />
    <input type='hidden' name='ssl_avs_zip' value='<?php echo @$vars->zip; ?>' />
    <input type='hidden' name='ssl_country' value='<?php echo @$vars->country; ?>' />
    <input type='hidden' name='ssl_email' value='<?php echo @$vars->email; ?>' />
    <input type='hidden' name='ssl_phone' value='<?php echo @$vars->phone; ?>' />
    
    <input type='hidden' name='ssl_customer_code' value='<?php echo @$vars->ssl_customer_code; ?>' />
    <input type='hidden' name='ssl_invoice_number' value='<?php echo @$vars->ssl_invoice_number; ?>' />
    <input type='hidden' name='ssl_description' value='<?php echo @$vars->ssl_description; ?>' />
    
    <input type='hidden' name='ssl_amount' value='<?php echo @$vars->amount; ?>' />
    <input type='hidden' name='ssl_salestax' value='<?php echo @$vars->taxes; ?>' />
    
    <?php if(@$vars->test_mode):?>
    <input type='hidden' name='ssl_test_mode' value='true' />
    <?php else: ?>
    <input type='hidden' name='ssl_test_mode' value='false' />
    <?php endif;?>

    <input type="submit" class="button" value="<?php echo JText::_('COM_TIENDA_CLICK_HERE_TO_COMPLETE_ORDER'); ?>" />
    
    <input type='hidden' name='ssl_receipt_apprvl_method' value='POST' />
    <input type='hidden' name='ssl_receipt_apprvl_post_url' value='<?php echo JRoute::_(@$vars->receipt_url); ?>' />
    <input type='hidden' name='ssl_receipt_decl_method' value='POST' />
    <input type='hidden' name='ssl_receipt_decl_post_url' value='<?php echo JRoute::_(@$vars->failed_url); ?>' />
    <input type='hidden' name='ssl_result_format' value="HTML" />
    
    <?php echo JHTML::_( 'form.token' ); ?>
</form>