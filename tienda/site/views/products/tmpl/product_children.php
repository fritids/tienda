<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('script', 'tienda.js', 'media/com_tienda/js/');
$items = @$this->product_relations_data->items;
$form = @$this->form;

Tienda::load('TiendaHelperImage', 'helpers.image');
$image_addtocart = TiendaHelperImage::getLocalizedName("addcart.png", Tienda::getPath('images'));

?>

<form action="<?php echo JRoute::_( @$form['action'] ); ?>" method="post" class="adminform" name="adminFormChildren" enctype="multipart/form-data" >
    
    <div class="reset"></div>

    <div id="product_children">
        <div id="product_children_header" class="tienda_header">
            <span><?php echo JText::_('COM_TIENDA_SELECT_THE_ITEMS_TO_ADD_TO_YOUR_CART'); ?></span>
        </div>
        
        <table class="adminlist">
        <thead>
        <tr>
        	<th>
               
            </th>
            <th style="text-align: left;">
                <?php echo JText::_('COM_TIENDA_PRODUCT_NAME'); ?>
            </th>
            <th style="text-align: left;">
                <?php echo JText::_('COM_TIENDA_SKU'); ?>
            </th>
            <th style="text-align: center;">
                <?php echo JText::_('COM_TIENDA_PRICE'); ?>
            </th>
            <th style="text-align: center;">
                <?php echo JText::_('COM_TIENDA_QUANTITY'); ?>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        $k = 0;         
        foreach ($items as $item): ?>
            <?php 
            $model = JModel::getInstance('Products', 'TiendaModel'); 
            $model->setId($item->product_id_to); 
            $item->full_object = $model->getItem(); 
            ?>
        <tr>
        	<td style="text-align: center; width: 50px;">
        		<?php echo TiendaHelperProduct::getImage($item->product_id, 'id', $item->product_name, 'thumb', false, false, array( 'width'=>64 )); ?>
             </td>
            <td style="text-align: left;">
                <?php echo $item->product_name; ?>
            </td>
            <td style="text-align: left;">
                <?php echo $item->product_sku; ?>
            </td>
            <td style="text-align: center;">
               <?php  echo TiendaHelperProduct::dispayPriceWithTax($item->product_price, $item->tax, $this->product_relations_data->show_tax); ?>
            </td>
            <td style="text-align: center;">
                <div id='product_quantity_input_<?php echo $item->product_id; ?>' class="product_quantity_input">
                    <?php if ($item->full_object->product_parameters->get('hide_quantity_input') == '1') { ?>
                        <input type="hidden" name="quantities[<?php echo $item->product_id; ?>]" value="<?php echo $item->full_object->product_parameters->get('default_quantity', '1'); ?>" />
                    <?php } elseif ($item->full_object->quantity_restriction && $item->full_object->quantity_min == $item->full_object->quantity_max) { ?>
                        <input type="hidden" name="quantities[<?php echo $item->product_id; ?>]" value="<?php echo $item->full_object->quantity_min; ?>" />
                    <?php } else { ?>
                        <input type="text" name="quantities[<?php echo $item->product_id; ?>]" value="<?php echo ($item->full_object->quantity_min > 0) ? $item->full_object->quantity_min : '1'; ?>" size="5" />
                    <?php } ?>
                </div>
            </td>        
        </tr>
        <?php $k = 1 - $k; ?>           
        <?php endforeach; ?>
        </tbody>
        </table>
        
        <div class="reset"></div> 
        
        <div id="validationmessage_children"></div>
        
        <!-- Add to cart button ---> 
        <div id='add_to_cart_children' style="display: block; float: right;">
            <input type="hidden" name="product_id" value="<?php echo $this->product_relations_data->product_id; ?>" />
            <input type="hidden" name="filter_category" value="<?php echo $this->product_relations_data->filter_category; ?>" />
            <input type="hidden" id="task" name="task" value="" />
            <?php echo JHTML::_( 'form.token' ); ?>
      
            <?php $onclick = "tiendaFormValidation( '".JRoute::_( @$this->product_relations_data->validation )."', 'validationmessage_children', 'addchildrentocart', document.adminFormChildren );"; ?>
            
            <?php 
            if (empty($item->product_check_inventory) || (!empty($item->product_check_inventory) && empty($this->product_relations_data->invalidQuantity)) ) :
            		switch (Tienda::getInstance()->get('cartbutton', 'image')) 
                {
                    case "button":
                        ?>
                        <input onclick="<?php echo $onclick; ?>" value="<?php echo JText::_('COM_TIENDA_ADD_TO_CART'); ?>" type="button" class="btn btn-primary btn-addtocart" />
                        <?php
                        break;
                    case "image":
                    default:
                        ?> 
                        <img class='addcart' src='<?php echo Tienda::getUrl('images').$image_addtocart; ?>' alt='<?php echo JText::_('COM_TIENDA_ADD_TO_CART'); ?>' onclick="<?php echo $onclick; ?>" />
                        <?php
                        break;
                }
            endif; 
            ?>
        </div>
        
        <div class="reset"></div>
    </div>

<div class="reset"></div>

</form>