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

class worldcupControllerBets extends worldcupController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct() {
		parent::__construct();

		//require_once(JPATH_COMPONENT.DS.'tables'.DS.'bets.php');	
		//require_once(JPATH_COMPONENT.DS.'tables'.DS.'usergroups.php');
	}

  function display() {
  
    JRequest::setVar( 'view', 'bets' );
    //echo $task;

    parent::display();
  }

  function detail() {
  
    JRequest::setVar( 'view', 'bets' );
    JRequest::setVar( 'layout', 'detail'  );

    parent::display();
  }

}
?>
