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

/**
 * 
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class worldcupControllerConfig extends worldcupController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
	}

  function display() {

		$my =& JFactory::getUser();

		if ($my->usertype != "Super Administrator" && $my->usertype != "Administrator" ) {
			$msg = JText::_( 'You do not have access' );
			$link = 'index.php?option=com_worldcup&controller=cpanel';
			$this->setRedirect($link, $msg);
		}
      
    JRequest::setVar( 'view', 'config' );
    
    parent::display();
  }

	function apply() {

		$model = $this->getModel('config');

		$data = JRequest::get( 'post' );

		if ($model->saveConfig($data)) {
			$msg = JText::_( 'Configuration Applied!' );
		} else {
			$msg = JText::_( 'Error Applying Configuration' );
		}

		JRequest::setVar( 'view', 'config' );

		$link = 'index.php?option=com_worldcup&controller=config';
		$this->setRedirect($link, $msg);
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$model = $this->getModel('config');

		$data = JRequest::get( 'post' );

		if ($model->saveConfig($data)) {
			$msg = JText::_( 'Configuration Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Configuration' );
		}

		$link = 'index.php?option=com_worldcup';
		$this->setRedirect($link, $msg);
	}

}
?>
