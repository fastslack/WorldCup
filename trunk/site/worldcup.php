<?php
/**
 * WorldCup
 *
 * @author      Matias Aguirre
 * @email       maguirre@matware.com.ar
 * @url         http://www.matware.com.ar
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

// Require the com_content helper library
require_once (JPATH_COMPONENT.'/controller.php');

// Create the controller
$controller = new WorldCupController( array('default_task' => 'subscribe') );

$task = JRequest::getVar('task', null, 'default', 'cmd');
$view = JRequest::getVar('view', null, 'default', 'cmd');

//echo JRequest::getVar('task', null, 'default', 'cmd');
//echo "<br>";
//echo JRequest::getVar('view', null, 'default', 'cmd');

if($task == "" && isset($view)){
    $task = $view;
}

//echo $task;

// Perform the Request task
$controller->execute($task);

// Redirect if set by the controller
$controller->redirect();

?>
