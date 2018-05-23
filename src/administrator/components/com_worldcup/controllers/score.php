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

class worldcupControllerScore extends worldcupController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct() {
		parent::__construct();

		require_once(JPATH_COMPONENT.DS.'tables'.DS.'score.php');
		//require_once(JPATH_COMPONENT.DS.'tables'.DS.'usergroups.php');
	}

  function display() {

    JRequest::setVar( 'view', 'score' );
    //echo $task;

    parent::display();
  }

}
?>

