<?php
/**
* Worldcup
*
* @version $Id:
* @package Matware.Worldcup
* @copyright Copyright (C) 2004 - 2014 Matware. All rights reserved.
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
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct() {
		parent::__construct();

		require_once(JPATH_COMPONENT.DS.'tables'.DS.'tournaments.php');	
	}

  function display() {
  
    JRequest::setVar( 'view', 'tournaments' );
    //echo $task;

    parent::display();
  }

  function add() {
  
    JRequest::setVar( 'view', 'tournaments' );
    JRequest::setVar( 'layout', 'form'  );

    parent::display();
  }

  function edit() {
  
    JRequest::setVar( 'view', 'tournaments' );
    JRequest::setVar( 'layout', 'form'  );

    parent::display();
  }

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()	{

		$db =& JFactory::getDBO();
		$post = JRequest::get( 'post' );

		$tournaments = new TableWorldCuptournaments($db);
		$tournaments->bind($post);

		if ($tournaments->store()) {
			$msg = JText::_( 'Tournament added!' );
		} else {
			$msg = JText::_( 'Error adding Tournament' );
		}

		$link = 'index.php?option=com_worldcup&controller=tournaments';
		$this->setRedirect($link, $msg);
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel() {
		$msg = JText::_( 'Configuration Cancelled' );
		$this->setRedirect( 'index.php?option=com_worldcup', $msg );
	}

  function remove() {
    /* Check for request forgeries */
    JRequest::checkToken() or jexit( 'Invalid Token' );

    /* Initialize variables */
    $db     =& JFactory::getDBO();
    $hid    = JRequest::getVar( 'cid', array(), 'post', 'array' );
    $n      = count( $hid );

		/* Deleting */
  	$query = 'DELETE FROM #__worldcup_tournaments'
    . ' WHERE id = ' . implode( ' OR id = ', $hid );

    $db->setQuery( $query );
    if (!$db->query()) {
      JError::raiseWarning( 500, $db->getError() );
    }

		/* TODO - Remove assigned users */

		$this->setRedirect( 'index.php?option=com_worldcup&controller=tournaments' );
    $this->setMessage( JText::sprintf( 'tournaments removed', $n ) );
  }
}
