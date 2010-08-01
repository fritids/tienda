<?php
/**
 * @package	Tienda
 * @author 	Dioscouri Design
 * @link 	http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted access' );

class TiendaControllerOrderPayments extends TiendaController 
{
	/**
	 * constructor
	 */
	function __construct() 
	{
		parent::__construct();
		$this->set('suffix', 'orderpayments');
	}
	
	/**
	 * Sets the model's state
	 * 
	 * @return array()
	 */
    function _setModelState()
    {
    	$state = parent::_setModelState();   	
		$app = JFactory::getApplication();
		$model = $this->getModel( $this->get('suffix') );
    	$ns = $this->getNamespace();

        $state['order']     = $app->getUserStateFromRequest($ns.'.filter_order', 'filter_order', 'tbl.created_date', 'cmd');
        $state['direction'] = $app->getUserStateFromRequest($ns.'.filter_direction', 'filter_direction', 'DESC', 'word');
        $state['filter_orderid']       = $app->getUserStateFromRequest($ns.'filter_orderid', 'filter_orderid', '', '');
        $state['filter_type']       = $app->getUserStateFromRequest($ns.'filter_type', 'filter_type', '', '');
        $state['filter_transaction']    = $app->getUserStateFromRequest($ns.'filter_transaction', 'filter_transaction', '', '');
        $state['filter_user']         = $app->getUserStateFromRequest($ns.'filter_user', 'filter_user', '', '');
        $state['filter_id_from']    = $app->getUserStateFromRequest($ns.'id_from', 'filter_id_from', '', '');
        $state['filter_id_to']      = $app->getUserStateFromRequest($ns.'id_to', 'filter_id_to', '', '');
        $state['filter_date_from'] = $app->getUserStateFromRequest($ns.'date_from', 'filter_date_from', '', '');
        $state['filter_date_to'] = $app->getUserStateFromRequest($ns.'date_to', 'filter_date_to', '', '');
        $state['filter_datetype']   = 'created';
        $state['filter_total_from']    = $app->getUserStateFromRequest($ns.'filter_total_from', 'filter_total_from', '', '');
        $state['filter_total_to']      = $app->getUserStateFromRequest($ns.'filter_total_to', 'filter_total_to', '', '');
		
    	foreach (@$state as $key=>$value)
		{
			$model->setState( $key, $value );	
		}
  		return $state;
    }
	
	/**
	 * Saves an item and redirects based on task
	 * @return void
	 */
	function save() 
	{
		$model 	= $this->getModel( $this->get('suffix') );
		
	    $row = $model->getTable();
	    $row->load( $model->getId() );
        $row->bind( JRequest::get('POST') );
        		
		$fieldname = 'orderpayment_image_new';
		$userfile = JRequest::getVar( $fieldname, '', 'files', 'array' );
		if (!empty($userfile['size']))
		{
			if ($upload = $this->addfile( $fieldname ))
			{
				$row->orderpayment_image = $upload->getPhysicalName();	
			}
				else
			{
				$error = true;	
			}
		}
		
		if ( $row->save() ) 
		{
			$model->setId( $row->id );
			$this->messagetype 	= 'message';
			$this->message  	= JText::_( 'Saved' );
			if ($error)
			{
				$this->messagetype 	= 'notice';
				$this->message .= " :: ".$this->getError();	
			}
			
			$dispatcher = JDispatcher::getInstance();
			$dispatcher->trigger( 'onAfterSave'.$this->get('suffix'), array( $row ) );
		} 
			else 
		{
			$this->messagetype 	= 'notice';			
			$this->message 		= JText::_( 'Save Failed' )." - ".$row->getError();
		}
		
    	$redirect = "index.php?option=com_tienda";
    	$task = JRequest::getVar('task');
    	switch ($task)
    	{
    		case "savenew":
    			$redirect .= '&view='.$this->get('suffix').'&task=add';
    		  break;
    		case "apply":
    			$redirect .= '&view='.$this->get('suffix').'&task=edit&id='.$model->getId();
    		  break;
    		case "save":
    		default:
    			$redirect .= "&view=".$this->get('suffix');
    		  break;
    	}

    	$redirect = JRoute::_( $redirect, false );
		$this->setRedirect( $redirect, $this->message, $this->messagetype );
	}
}

?>