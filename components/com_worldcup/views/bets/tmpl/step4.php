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
// no direct access
defined('_JEXEC') or die('Restricted access');

//jimport('joomla.filesystem.file');

include(JPATH_ADMINISTRATOR.'/components/com_worldcup/worldcup_config.php');

$my =& JFactory::getUser();

$teams = $this->teams;
$bets = $this->bets;
$oldbets = $this->oldbets;
$matches = $this->matches;
//print_r($groups);
//echo "<br><br>";
//print_r($data);
//$key = recursiveArraySearch($groups, 'C');
//echo ">".$key."<";
?>
<link rel="stylesheet" type="text/css" href="components/com_worldcup/css/worldcup.css" />
<div><h3><?php echo JText::_( $worldcupConfig['title'] ); ?></h3></div>
<table width="100%">
<tr>
  <td align="center">
    <h2><b><a href="index.php?option=com_worldcup&view=bets"><?php echo JText::_( "My Bet" ); ?></a> - <a href="index.php?option=com_worldcup&view=score"><?php echo JText::_( "Table" ); ?></a> - <a href="index.php?option=com_worldcup&view=results"><?php echo JText::_( "Results" ); ?></a></b></h2>
  </td>
</tr>
</table>

<form action="index.php?option=com_worldcup&task=bets&step=5" method="post" name="adminForm" onSubmit="submitbutton(); return false;">

<table>
<tr>
	<td align="left" width="100%">
		<h3><?php //echo $this->phases[1]; ?></h3>
	</td>
</tr>
</table>
<table class="adminlist" width="100%" cellpadding="2" cellspacing="2" border="0">
<thead>
	<tr>
		<th width="20">
			<?php echo JText::_( 'ID' ); ?>
		</th>
		<th width="20%" nowrap="nowrap">
			<?php echo JText::_( 'Date' ); ?>
		</th>
		<th width="20%" nowrap="nowrap">
			<?php echo JText::_( 'Place' ); ?>
		</th>
		<th width="25%" nowrap="nowrap">
			<?php echo JText::_( 'Team' ); ?>
		</th>
		<th width="10%" nowrap="nowrap">
			&nbsp;
		</th>
		<th width="25%" nowrap="nowrap">
			<?php echo JText::_( 'Team' ); ?>
		</th>
	</tr>
</thead>
<tbody>
<?php		          
	//print_r($oldbets);
	//print_r($data[$group1][$pos1]['name']

	for ($i=0, $n=count( $matches ); $i < $n; $i++) {
		$match = &$matches[$i];

		$date =& JFactory::getDate($match->date);          
			$format = 'd/m H:M';

		$winner1 = substr($match->team1, 1, 3);
		$winner2 = substr($match->team2, 1, 3);

		if ($oldbets[$winner1]->local > $oldbets[$winner1]->visit) {
			$local = $oldbets[$winner1]->team1;
		}else if ($oldbets[$winner1]->local < $oldbets[$winner1]->visit) {
			$local = $oldbets[$winner1]->team2;
		}

		if ($oldbets[$winner2]->local > $oldbets[$winner2]->visit) {
			$visit = $oldbets[$winner2]->team1;
		}else if ($oldbets[$winner2]->local < $oldbets[$winner2]->visit) {
			$visit = $oldbets[$winner2]->team2;
		}
		
?>
	<tr class="<?php echo "row$k"; ?>">
		<td align="center">
			<?php echo $match->id; ?>
		</td>
		<td align="center">
			<?php echo $date->toFormat($format); ?>
		</td>
		<td>
			<?php echo $match->pname;?>
		</td>
		<td align="right">
			<img src="components/com_worldcup/images/flags/<?php echo $teams[$local]->id; ?>.png">
			<?php echo $teams[$local]->name; ?>
		</td>
		<td>
			<input type="text" name="l<?php echo $match->id; ?>" value="<?php echo $bets[$match->id]->local; ?>" size="1" class="input_result">&nbsp;-&nbsp;
			<input type="text" name="v<?php echo $match->id; ?>" value="<?php echo $bets[$match->id]->visit; ?>" size="1" class="input_result2">
		</td>
		<td>
			<img src="components/com_worldcup/images/flags/<?php echo $teams[$visit]->id; ?>.png">
			<?php echo $teams[$visit]->name;?>
		</td>
		<input type="hidden" name="team1-<?php echo $match->id; ?>" value="<?php echo $teams[$local]->id; ?>" />
		<input type="hidden" name="team2-<?php echo $match->id; ?>" value="<?php echo $teams[$visit]->id; ?>" />
	</tr>
<?php
		unset($pos1);unset($pos2);
		unset($group1);unset($group2);
	}
?>
<tr>
	<td align="center" colspan="8">
		<input type="submit" value="<?php echo JText::_( 'Send' ); ?>" />
	</td>
</tr>

</tbody>
</table>
</form>

