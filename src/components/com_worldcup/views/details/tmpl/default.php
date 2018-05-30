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

<table width="100%">
<tr>
  <td align="center">
    <h2><b><a href="index.php?option=com_worldcup&view=bets"><?php echo JText::_( "My Bet" ); ?></a> - <a href="index.php?option=com_worldcup&view=score"><?php echo JText::_( "Table" ); ?></a> - <a href="index.php?option=com_worldcup&view=results"><?php echo JText::_( "Results" ); ?></a></b></h2>
  </td>
</tr>
</table>

<table width="100%">
<thead>
	<tr>
		<td width="100"><?php echo JText::_( "User" ); ?></td>
		<td width="100"><?php echo JText::_( "Points" ); ?></td>
	</tr>
</thead>
<?php
	for ($i=0;$i<count($score);$i++){
    if($score[$i]->count == 64) {
?>
<tbody>
<tr class="odd">
	<td><a href="index.php?index.php?option=com_worldcup&view=detail&"><?php echo $usersnames[$score[$i]->uid]->name; ?></a></td>
	<td><?php echo $score[$i]->points; ?></td>
<?php
    }
	}
?>

</tbody>
</table>
