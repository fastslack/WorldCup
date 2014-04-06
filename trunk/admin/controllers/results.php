<?php
/**
 * WorldCup
 *
 * @author      Matias Aguirre
 * @email       maguirre@matware.com.ar
 * @url         http://www.matware.com.ar
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class worldcupControllerResults extends worldcupController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct() {
		parent::__construct();

		require_once(JPATH_COMPONENT.DS.'tables'.DS.'results.php');	
		//require_once(JPATH_COMPONENT.DS.'tables'.DS.'usergroups.php');
	}

  function display() {
  
    JRequest::setVar( 'view', 'results' );
    //echo $task;

    parent::display();
  }

  function add() {
  
    JRequest::setVar( 'view', 'results' );
    JRequest::setVar( 'layout', 'form'  );

    parent::display();
  }

  function edit() {
  
    JRequest::setVar( 'view', 'results' );
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
		//print_r($post);

		$post['date'] = $post['tdate'] ." ". $post['hour'].":".$post['minutes'];
		//echo "<br><br>".$post['date'];

		$results = new TableWorldCupResults($db);
		$results->bind($post);

		if ($results->store()) {
			$msg = JText::_( 'Match added!' );
		} else {
			$msg = JText::_( '1: Error adding match' );
		}

		$link = 'index.php?option=com_worldcup&controller=results';
		$this->setRedirect($link, $msg);
	}

  function remove() {
    /* Check for request forgeries */
    JRequest::checkToken() or jexit( 'Invalid Token' );

    /* Initialize variables */
    $db     =& JFactory::getDBO();
    $hid    = JRequest::getVar( 'cid', array(), 'post', 'array' );
    $n      = count( $hid );

		/* Deleting */
  	$query = 'DELETE FROM #__worldcup_results'
    . ' WHERE id = ' . implode( ' OR id = ', $hid );

    $db->setQuery( $query );
    if (!$db->query()) {
      JError::raiseWarning( 500, $db->getError() );
    }

		/* TODO - Remove all history */

		$this->setRedirect( 'index.php?option=com_worldcup&controller=results' );
    $this->setMessage( JText::sprintf( 'Results removed', $n ) );
  }

}
?>
