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

jimport('joomla.filesystem.file');

$my =& JFactory::getUser();

$score = $this->score;
$usersnames = $this->usersnames;
//$matches = $this->matches;
//print_r($usersnames);

?>
<link rel="stylesheet" type="text/css" href="components/com_worldcup/css/worldcup.css" />
<form action="index.php?option=com_worldcup&task=save" method="post" name="adminForm" onSubmit="submitbutton(); return false;">





