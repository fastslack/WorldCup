<?php
/**
* Worldcup
*
* @version $Id:
* @package Matware.Worldcup
* @copyright Copyright (C) 2004 - 2018 Matware. All rights reserved.
* @author Matias Aguirre
* @email maguirre@matware.com.ar
* @link http://www.matware.com.ar/
* @license GNU General Public License version 2 or later; see LICENSE
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class WorldcupControllerTournaments extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since   1.0
	 */
	public function getModel($name = 'Team', $prefix = 'WorldcupModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

	/**
	 * Method to provide child classes the opportunity to process after the delete task.
	 *
	 * @param   JModelLegacy   $model   The model for the component
	 * @param   mixed          $ids     array of ids deleted.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function postDeleteHook(JModelLegacy $model, $ids = null)
	{
	}

	/**
	 * Method to cancel an edit.
	 *
	 * @param   string  $key  The name of the primary key of the URL variable.
	 *
	 * @return  boolean  True if access level checks pass, false otherwise.
	 *
	 * @since   1.6
	 */
	public function cancel($key = null)
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		$this->setRedirect( 'index.php?option=com_worldcup', null );
	}

/*
	@@ Unused method

  function remove() {
    // Check for request forgeries 
    JRequest::checkToken() or jexit( 'Invalid Token' );

    // Initialize variables 
    $db     =& JFactory::getDBO();
    $hid    = JRequest::getVar( 'cid', array(), 'post', 'array' );
    $n      = count( $hid );

		// Deleting 
  	$query = 'DELETE FROM #__worldcup_tournaments'
    . ' WHERE id = ' . implode( ' OR id = ', $hid );

    $db->setQuery( $query );
    if (!$db->query()) {
      JError::raiseWarning( 500, $db->getError() );
    }

		// TODO - Remove assigned users 

		$this->setRedirect( 'index.php?option=com_worldcup&controller=tournaments' );
    $this->setMessage( JText::sprintf( 'tournaments removed', $n ) );
  }
*/
}
