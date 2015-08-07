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

jimport('joomla.filesystem.file');

$my =& JFactory::getUser();

$data = $this->data;
$groups = $this->groups;
$matches = $this->matches;
$oldbets = $this->oldbets;
//print_r($groups);
//echo "<br><br>";
//print_r($data);
//$key = recursiveArraySearch($groups, 'C');
//echo ">".$key."<";
?>
<script language="javascript">
	function submitbutton(pressbutton)
	{
		var form = document.adminForm;

		for(i=0;i<form.elements.length;i++) {
			//alert(form.elements[i].name);
			if (form.elements[i].value.length < 1 ) {
				//alert(form.elements[i].value + ' - ' + form.elements[i].name);
				alert('<?php echo JText::_( "Please complete all fields", true ); ?>');
				form.elements[i].focus();
				return false;
			}
		}

		form.submit();

	}
//-->
</script>
<link rel="stylesheet" type="text/css" href="components/com_worldcup/css/worldcup.css" />
<div><h3><?php echo JText::_( $worldcupConfig['title'] ); ?></h3></div>
<table width="100%">
<tr>
  <td align="center">
    <h2><b><a href="index.php?option=com_worldcup&view=bets"><?php echo JText::_( "My Bet" ); ?></a> - <a href="index.php?option=com_worldcup&view=score"><?php echo JText::_( "Table" ); ?></a> - <a href="index.php?option=com_worldcup&view=results"><?php echo JText::_( "Results" ); ?></a></b></h2>
  </td>
</tr>
</table>

<form action="index.php?option=com_worldcup&task=bets&step=3" method="post" name="adminForm" onSubmit="submitbutton(); return false;">
<table width="100%" border="0">
<tr>
<?php
	$e = 1;

	for ($i=1;$i<=count($data);$i++){
		if($e==4 || $e == 7 ){
			echo "</tr><tr>";
		}
?>
<td>
<table width="100%" cellspacing="0" cellpadding="2" id="group_table">
<caption><?php echo JText::_( "Group" ); ?> <?php echo $groups[$i]['name']; ?></caption>
<thead>
	<tr>
		<td><?php echo JText::_( "Team" ); ?></td>
		<td width="10"><?php echo JText::_( "Points" ); ?></td>
		<td width="10"><?php echo JText::_( "GF" ); ?></td>
		<td width="10"><?php echo JText::_( "GE" ); ?></td>
	</tr>
</thead>
<tbody>
<?php

//print_r($data[$i]);

		for ($y=0;$y<count($data[$i]);$y++){

//print_r($data[$i][$y]);

?>

		<tr>
			<td>
				<img src="components/com_worldcup/images/flags/<?php echo $data[$i][$y]['id']; ?>.png">&nbsp;<?php echo $data[$i][$y]['name']; ?></td>
			<td align="center"><?php echo $data[$i][$y]['points'] ? $data[$i][$y]['points'] : 0; ?></td>
			<td><?php echo $data[$i][$y]['gf'] ? $data[$i][$y]['gf'] : 0; ?></td>
			<td><?php echo $data[$i][$y]['ge'] ? $data[$i][$y]['ge'] : 0; ?></td>
		</tr>

<?php
		}
		echo "</tbody></table></td>";

		$e++;
	}
?>

</tr>
</table>

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
		<th width="12%" nowrap="nowrap">
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

			$pos1 = substr($match->team1, 0, 1);
			$group1 = $this->recursiveArraySearch($groups, substr($match->team1, 1, 2) );

			$pos2 = substr($match->team2, 0, 1);
			$group2 = $this->recursiveArraySearch($groups, substr($match->team2, 1, 2) );

			//echo $group1 . "<br>";
			//print_r($team1);

			//$key = recursiveArraySearch($groups, 'C');

			//print_r($group1);
			//echo "<br><br>";


?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $match->id; ?>
				</td>
				<td align="center">
					<?php echo $date->format($format); ?>
				</td>
				<td>
					<?php echo $match->pname;?>
				</td>
				<td align="right">
					<img src="components/com_worldcup/images/flags/<?php echo $data[$group1][$pos1-1]['id']; ?>.png">
					<?php echo $data[$group1][$pos1-1]['name'];?>
				</td>
				<td align="center">
					<input type="text" name="l<?php echo $match->id; ?>" value="<?php echo $oldbets[$match->id]->local; ?>" size="1" class="input_result">&nbsp;-&nbsp;
					<input type="text" name="v<?php echo $match->id; ?>" value="<?php echo $oldbets[$match->id]->visit; ?>" size="1" class="input_result2">
				</td>
				<td>
					<img src="components/com_worldcup/images/flags/<?php echo $data[$group2][$pos2-1]['id']; ?>.png">
					<?php echo $data[$group2][$pos2-1]['name'];?>
				</td>
				<input type="hidden" name="team1-<?php echo $match->id; ?>" value="<?php echo $data[$group1][$pos1-1]['id']; ?>" />
				<input type="hidden" name="team2-<?php echo $match->id; ?>" value="<?php echo $data[$group2][$pos2-1]['id']; ?>" />
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

