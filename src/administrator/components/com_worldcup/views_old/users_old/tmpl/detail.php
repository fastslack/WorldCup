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

$groups = $this->groups;
$teams = $this->teams;
$matches = $this->matches;

//print_r($teams);

?>
<link rel="stylesheet" type="text/css" href="components/com_worldcup/css/worldcup.css" />
<?php

	for ($i=0;$i<count($groups);$i++){
?>
<table summary="<?php echo JText::_( "Group" ); ?> A" class="fixture" width="100%" cellpadding="0" cellspacing="0">
<caption><?php echo JText::_( "Group" ); ?> <?php echo $groups[$i]->name; ?></caption>
<thead>
	<tr>
		<td width="30"><?php echo JText::_( "Match" ); ?></td>
		<td width="70"><?php echo JText::_( "Date" ); ?> - <?php echo JText::_( "Hour" ); ?></td>
		<td width="150"><?php echo JText::_( "Seat" ); ?></td>
		<td width="20"></td>
		<td width="100"></td>
		<td width="30"><?php echo JText::_( "Result" ); ?></td>
		<td width="100"></td>
		<td width="20"></td>
	</tr>
</thead>
<tbody>
<?php

		for ($y=0;$y<count($matches[$i]);$y++){

			$date =& JFactory::getDate($matches[$i][$y]->date);          
			$format = '%b/%d %H:%M';

			$bet = $this->bets[$matches[$i][$y]->id]->goals;

			$result = explode("-", $bet);

?>
<tr class="odd">
	<td><?php echo $matches[$i][$y]->id; ?></td>
	<td><span class="matchTimeConvertible"><?php echo $date->toFormat($format); ?></span></td>
	<td>
		<?php echo $matches[$i][$y]->pname; ?>
	</td>
	<td>
		<img src="<?php echo JURI::root(); ?>images/flags/<?php echo $matches[$i][$y]->team1; ?>.png">
	</td>
	<td>
		<?php echo $teams[$matches[$i][$y]->team1]->name; ?>
	</td>
	<td align="center">
		<?php echo $result[0]; ?>&nbsp;-&nbsp;<?php echo $result[1]; ?>
	</td>
	<td align="right">
		<?php echo $teams[$matches[$i][$y]->team2]->name; ?>
	</td>
	<td>
		<img src="<?php echo JURI::root(); ?>images/flags/<?php echo $matches[$i][$y]->team2; ?>.png">
	</td>
</tr>
<?php
		}
	}
?>
</tbody>
</table>
<form action="index.php?option=com_worldcup" method="post" name="adminForm">
<input type="hidden" name="option" value="com_worldcup" />
<input type="hidden" name="controller" value="users" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>

