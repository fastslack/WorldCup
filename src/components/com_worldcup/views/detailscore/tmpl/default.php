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

// No direct access to this file
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');

$my =& JFactory::getUser();

$score = $this->score;
$usersnames = $this->usersnames;
//$matches = $this->matches;
//print_r($usersnames);

?>
<link rel="stylesheet" type="text/css" href="components/com_worldcup/css/worldcup.css" />
<form action="index.php?option=com_worldcup&task=save" method="post" name="adminForm" onSubmit="submitbutton(); return false;">
