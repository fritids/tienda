<?php
/**
* @version      $Id: view.html.php 11673 2009-03-08 20:41:00Z willebil $
* @package      Joomla
* @subpackage   Registration
* @copyright    Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license      GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Registration component
 *
 * @package     Joomla
 * @subpackage  Registration
 * @since 1.0
 */
class UserViewRegister extends JView
{
    function display($tpl = null)
    {
        global $mainframe;

        // Check if registration is allowed
        $usersConfig = JComponentHelper::getParams( 'com_users' );
        if (!$usersConfig->get( 'allowUserRegistration' )) {
            JError::raiseError( 403, JText::_('COM_TIENDA_ACCESS_FORBIDDEN'));
            return;
        }

        $pathway  = $mainframe->getPathway();
        $document = JFactory::getDocument();
        $params = &$mainframe->getParams();

        // Page Title
        $menus  = JSite::getMenu();
        $menu   = $menus->getActive();

        // because the application sets a default page title, we need to get it
        // right from the menu item itself
        if (is_object( $menu )) {
            $menu_params = new DSCParameter( $menu->params );
            if (!$menu_params->get( 'page_title')) {
                $params->set('page_title',  JText::_('COM_TIENDA_REGISTRATION'));
            }
        } else {
            $params->set('page_title',  JText::_('COM_TIENDA_REGISTRATION'));
        }
        $document->setTitle( $params->get( 'page_title' ) );

        $pathway->addItem( JText::_('COM_TIENDA_NEW'));

        // Load the form validation behavior
        JHTML::_('behavior.formvalidation');

        $user = JFactory::getUser();
        $this->assignRef('user', $user);
        $this->assignRef('params',      $params);
        parent::display($tpl);
    }
}
