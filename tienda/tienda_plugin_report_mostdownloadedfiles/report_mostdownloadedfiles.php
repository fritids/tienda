<?php
/**
 * @version	1.5
 * @package	Tienda
 * @author 	Dioscouri Design
 * @link 	http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

Tienda::load( 'TiendaReportPlugin', 'library.plugins.report' );

class plgTiendaReport_MostDownloadedFiles extends TiendaReportPlugin
{
	/**
	 * @var $_element  string  Should always correspond with the plugin's filename,
	 *                         forcing it to be unique
	 */
    var $_element    = 'report_mostdownloadedfiles';

    /**
     * @var $default_model  string  Default model used by report
     */
    var $default_model    = 'productfiles';

	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param object $subject The object to observe
	 * @param 	array  $config  An array that holds the plugin configuration
	 * @since 1.5
	 */
	function plgTiendaReport_MostDownloadedFiles(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage( '', JPATH_ADMINISTRATOR );
	}

    /**
     * Override parent::_getData() to set the direction of the product quantity
     *
     * @return objectlist
     */
    function _getData()
    {
        $state = $this->_getState();
        $model = $this->_getModel();
       	$query = $model->getQuery();          	
       
		
        $field = array();    
        // select the total downloads  
       	$field[] = "
            (
            SELECT 
                COUNT(*)
            FROM
                #__tienda_productdownloads AS tbl_downloads
            WHERE 
                tbl_downloads.productfile_id = tbl.productfile_id               
            ) 
        AS file_downloads ";    
      	 // select the product name
       	$field[] = "
            (
            SELECT 
                tbl_products.product_name
            FROM
                #__tienda_products AS tbl_products
            WHERE 
                tbl_products.product_id = tbl.product_id               
            ) 
        AS product_name ";
       	                    
        $query->select( $field );       
      
		$query->order('file_downloads DESC');
        $model->setQuery( $query );		
        $data = $model->getList();

        return $data;
    }
    
    /**
     * Override parent::_getState() to do the filtering
     *
     * @return object
     */
    function _getState()
    {
    	$app = JFactory::getApplication();
        $model = $this->_getModel( $this->default_model );
        $ns = $this->_getNamespace();

        $state = array();        
       	//$state['filter_name'] = $app->getUserStateFromRequest($ns.'name', 'filter_name', '', '');
        //$state['filter_quantity_from'] = $app->getUserStateFromRequest($ns.'quantity_from', 'filter_quantity_from', '', '');
        //$state['filter_quantity_to'] = $app->getUserStateFromRequest($ns.'quantity_to', 'filter_quantity_to', '', '');      
    	//$state['filter_category'] = $app->getUserStateFromRequest($ns.'category', 'filter_category', '', '');
        //$state = $this->_handleRangePresets( $state );
        
        foreach (@$state as $key=>$value)
        {
            $model->setState( $key, $value );
        }

        return $state;
    
    }
}
