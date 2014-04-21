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
// No direct access
defined('_JEXEC') or die('Restricted access');

// get document to add scripts
$document	= JFactory::getDocument();

$id = JFactory::getApplication()->input->get('id');

$format = 'd/m H:i';

$matches = $this->matches;
$teams = $this->teams;
$bets = $this->bets;
$data = $this->data;

?>
<form action="<?php echo JRoute::_('index.php?option=com_worldcup&view=bet&layout=edit&id=' . (int) $id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-horizontal">
	
<div class="row-fluid">

	<link rel="stylesheet" type="text/css" href="components/com_worldcup/css/worldcup.css" />
	<?php

		for ($i=1;$i<=count($this->groups);$i++){
	?>
	<table class="fixture" width="100%" cellpadding="0" cellspacing="0">
	<caption><?php echo JText::_( 'Group' ); ?> <?php echo $this->groups[$i]->name; ?></caption>
	<thead>
		<tr>
			<td width="30"><?php echo JText::_( 'Match' ); ?></td>
			<td width="70"><?php echo JText::_( 'Date' ); ?> - <?php echo JText::_( 'Hour' ); ?></td>
			<td width="150"><?php echo JText::_( 'Place' ); ?></td>
			<td width="20"></td>
			<td width="100"></td>
			<td width="30"><?php echo JText::_( 'Result' ); ?></td>
			<td width="100"></td>
			<td width="20"></td>
		</tr>
	</thead>
	<tbody>
	<?php

			for ($y=0;$y<count($matches[$i]);$y++){

				$date =& JFactory::getDate($matches[$i][$y]->date);

				$local = $this->bets[$matches[$i][$y]->id]->local;
		    $visit = $this->bets[$matches[$i][$y]->id]->visit;
	?>
	<tr class="odd">
		<td><?php echo $matches[$i][$y]->id; ?></td>
		<td><span class="matchTimeConvertible"><?php echo $date->format($format); ?></span></td>
		<td>
			<?php echo $matches[$i][$y]->pname; ?>
		</td>
		<td>
			<img src="components/com_worldcup/images/flags/<?php echo $matches[$i][$y]->team1; ?>.png">
		</td>
		<td>
			<?php echo $teams[$matches[$i][$y]->team1]->name; ?>
		</td>
		<td align="center">
			<?php echo $local; ?>&nbsp;-&nbsp;<?php echo $visit; ?>
		</td>
		<td align="right">
			<?php echo $teams[$matches[$i][$y]->team2]->name; ?>
		</td>
		<td>
			<img src="components/com_worldcup/images/flags/<?php echo $matches[$i][$y]->team2; ?>.png">
		</td>
	</tr>
	<?php
			}
		}
	?>
	</tbody>
	</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td align="left" width="100%">
		<h3><?php echo $this->phases[1]; ?></h3>
	</td>
</tr>
</table>
<table class="fixture" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead>
	<tr>
		<td width="30"><?php echo JText::_( 'Match' ); ?></td>
		<td width="70"><?php echo JText::_( 'Date' ); ?> - <?php echo JText::_( 'Hour' ); ?></td>
		<td width="150"><?php echo JText::_( 'Place' ); ?></td>
		<td width="20"></td>
		<td width="100"></td>
		<td width="30" align="center"><?php echo JText::_( 'Result' ); ?></td>
		<td width="100"></td>
		<td width="20"></td>
	</tr>
</thead>
<tbody>
<?php		          
		$matches = $this->matches[9];

		for ($i=0, $n=count( $matches ); $i < $n; $i++) {
			$match = &$matches[$i];

			$date =& JFactory::getDate($match->date);          

			$pos1 = substr($match->team1, 0, 1);
			$group1 = $this->recursiveArraySearch($this->groups, substr($match->team1, 1, 2) );

			$pos2 = substr($match->team2, 0, 1);
			$group2 = $this->recursiveArraySearch($this->groups, substr($match->team2, 1, 2) );
?>
			<tr class="odd">
				<td>
					<?php echo $match->id; ?>
				</td>
				<td>
					<?php echo $date->format($format); ?>
				</td>
				<td>
					<?php echo $match->pname;?>
				</td>
				<td>
					<img src="components/com_worldcup/images/flags/<?php echo $data[$group1][$pos1-1]['id']; ?>.png">
				</td>
				<td>
					<?php echo $data[$group1][$pos1-1]['name'];?>
				</td>
				<td align="center">
					<?php echo $bets[$match->id]->local; ?>&nbsp;-&nbsp;<?php echo $bets[$match->id]->visit; ?>
				</td>
				<td align="right">
					<?php echo $data[$group2][$pos2-1]['name'];?>
				</td>
				<td>
					<img src="components/com_worldcup/images/flags/<?php echo $data[$group2][$pos2-1]['id']; ?>.png">
				</td>
				<input type="hidden" name="team1-<?php echo $match->id; ?>" value="<?php echo $data[$group1][$pos1-1]['id']; ?>" />
				<input type="hidden" name="team2-<?php echo $match->id; ?>" value="<?php echo $data[$group2][$pos2-1]['id']; ?>" />
			</tr>
<?php
			unset($pos1);unset($pos2);
			unset($group1);unset($group2);
		}
?>
</tbody>
</table>

<table>
<tr>
	<td align="left" width="100%">
		<h3><?php echo $this->phases[2]; ?></h3>
	</td>
</tr>
</table>
<table class="fixture" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead>
	<tr>
		<td width="30"><?php echo JText::_( 'Match' ); ?></td>
		<td width="70"><?php echo JText::_( 'Date' ); ?> - <?php echo JText::_( 'Hour' ); ?></td>
		<td width="150"><?php echo JText::_( 'Place' ); ?></td>
		<td width="20"></td>
		<td width="100"></td>
		<td width="30" align="center"><?php echo JText::_( 'Result' ); ?></td>
		<td width="100"></td>
		<td width="20"></td>
	</tr>
</thead>
<tbody>
<?php		          
		$matches = $this->matches[10];
		//print_r($bets);

		for ($i=0, $n=count( $matches ); $i < $n; $i++) {
			$match = &$matches[$i];

			$date =& JFactory::getDate($match->date);          

			$winner1 = substr($match->team1, 1, 3);
			$winner2 = substr($match->team2, 1, 3);

			if ($bets[$winner1]->local > $bets[$winner1]->visit) {
				$local = $bets[$winner1]->team1;
			}else if ($bets[$winner1]->local < $bets[$winner1]->visit) {
				$local = $bets[$winner1]->team2;
			}

			if ($bets[$winner2]->local > $bets[$winner2]->visit) {
				$visit = $bets[$winner2]->team1;
			}else if ($bets[$winner2]->local < $bets[$winner2]->visit) {
				$visit = $bets[$winner2]->team2;
			}
		
?>
	<tr class="odd">
		<td align="left">
			<?php echo $match->id; ?>
		</td>
		<td align="left">
			<?php echo $date->format($format); ?>
		</td>
		<td>
			<?php echo $match->pname;?>
		</td>
		<td align="center">
			<img src="components/com_worldcup/images/flags/<?php echo $teams[$local]->id; ?>.png">
		</td>
		<td align="left">
			<?php echo $teams[$local]->name; ?>
		</td>
		<td align="center">
			<?php echo $bets[$match->id]->local; ?>&nbsp;-&nbsp;<?php echo $bets[$match->id]->visit; ?>
		</td>
		<td align="right">
			<?php echo $teams[$visit]->name;?>
		</td>
		<td>
			<img src="components/com_worldcup/images/flags/<?php echo $teams[$visit]->id; ?>.png">
		</td>
		<input type="hidden" name="team1-<?php echo $match->id; ?>" value="<?php echo $teams[$local]->id; ?>" />
		<input type="hidden" name="team2-<?php echo $match->id; ?>" value="<?php echo $teams[$visit]->id; ?>" />
	</tr>
<?php
		unset($pos1);unset($pos2);
		unset($group1);unset($group2);
	}
?>
</tbody>
</table>


<table>
<tr>
	<td align="left" width="100%">
		<h3><?php echo $this->phases[3]; ?></h3>
	</td>
</tr>
</table>
<table class="fixture" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead>
	<tr>
		<td width="30"><?php echo JText::_( 'Match' ); ?></td>
		<td width="70"><?php echo JText::_( 'Date' ); ?> - <?php echo JText::_( 'Hour' ); ?></td>
		<td width="150"><?php echo JText::_( 'Place' ); ?></td>
		<td width="20"></td>
		<td width="100"></td>
		<td width="30" align="center"><?php echo JText::_( 'Result' ); ?></td>
		<td width="100"></td>
		<td width="20"></td>
	</tr>
</thead>
<tbody>
<?php		          
		$matches = $this->matches[11];

		for ($i=0, $n=count( $matches ); $i < $n; $i++) {
			$match = &$matches[$i];

			$date =& JFactory::getDate($match->date);          

			$winner1 = substr($match->team1, 1, 3);
			$winner2 = substr($match->team2, 1, 3);

			if ($bets[$winner1]->local > $bets[$winner1]->visit) {
				$local = $bets[$winner1]->team1;
			}else if ($bets[$winner1]->local < $bets[$winner1]->visit) {
				$local = $bets[$winner1]->team2;
			}

			if ($bets[$winner2]->local > $bets[$winner2]->visit) {
				$visit = $bets[$winner2]->team1;
			}else if ($bets[$winner2]->local < $bets[$winner2]->visit) {
				$visit = $bets[$winner2]->team2;
			}
		
?>
	<tr class="odd">
		<td align="left">
			<?php echo $match->id; ?>
		</td>
		<td align="left">
			<?php echo $date->format($format); ?>
		</td>
		<td>
			<?php echo $match->pname;?>
		</td>
		<td align="center">
			<img src="components/com_worldcup/images/flags/<?php echo $teams[$local]->id; ?>.png">
		</td>
		<td align="left">
			<?php echo $teams[$local]->name; ?>
		</td>
		<td align="center">
			<?php echo $bets[$match->id]->local; ?>&nbsp;-&nbsp;<?php echo $bets[$match->id]->visit; ?>
		</td>
		<td align="right">
			<?php echo $teams[$visit]->name;?>
		</td>
		<td>
			<img src="components/com_worldcup/images/flags/<?php echo $teams[$visit]->id; ?>.png">
		</td>
		<input type="hidden" name="team1-<?php echo $match->id; ?>" value="<?php echo $teams[$local]->id; ?>" />
		<input type="hidden" name="team2-<?php echo $match->id; ?>" value="<?php echo $teams[$visit]->id; ?>" />
	</tr>
<?php
		unset($pos1);unset($pos2);
		unset($group1);unset($group2);
	}
?>
</tbody>
</table>


<table>
<tr>
	<td align="left" width="100%">
		<h3><?php echo $this->phases[4]; ?></h3>
	</td>
</tr>
</table>
<table class="fixture" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead>
	<tr>
		<td width="30"><?php echo JText::_( 'Match' ); ?></td>
		<td width="70"><?php echo JText::_( 'Date' ); ?> - <?php echo JText::_( 'Hour' ); ?></td>
		<td width="150"><?php echo JText::_( 'Place' ); ?></td>
		<td width="20"></td>
		<td width="100"></td>
		<td width="30" align="center"><?php echo JText::_( 'Result' ); ?></td>
		<td width="100"></td>
		<td width="20"></td>
	</tr>
</thead>
<tbody>
<?php		          
		$matches = $this->matches[12];
		//print_r($bets);

		for ($i=0, $n=count( $matches ); $i < $n; $i++) {
			$match = &$matches[$i];

			$date =& JFactory::getDate($match->date);          

			$winner1 = substr($match->team1, 1, 3);
			$winner2 = substr($match->team2, 1, 3);

			if ($bets[$winner1]->local < $bets[$winner1]->visit) {
				$local = $bets[$winner1]->team1;
			}else if ($bets[$winner1]->local > $bets[$winner1]->visit) {
				$local = $bets[$winner1]->team2;
			}

			if ($bets[$winner2]->local < $bets[$winner2]->visit) {
				$visit = $bets[$winner2]->team1;
			}else if ($bets[$winner2]->local > $bets[$winner2]->visit) {
				$visit = $bets[$winner2]->team2;
			}
		
?>
	<tr class="odd">
		<td align="left">
			<?php echo $match->id; ?>
		</td>
		<td align="left">
			<?php echo $date->format($format); ?>
		</td>
		<td>
			<?php echo $match->pname;?>
		</td>
		<td align="center">
			<img src="components/com_worldcup/images/flags/<?php echo $teams[$local]->id; ?>.png">
		</td>
		<td align="left">
			<?php echo $teams[$local]->name; ?>
		</td>
		<td align="center">
			<?php echo $bets[$match->id]->local; ?>&nbsp;-&nbsp;<?php echo $bets[$match->id]->visit; ?>
		</td>
		<td align="right">
			<?php echo $teams[$visit]->name;?>
		</td>
		<td>
			<img src="components/com_worldcup/images/flags/<?php echo $teams[$visit]->id; ?>.png">
		</td>
		<input type="hidden" name="team1-<?php echo $match->id; ?>" value="<?php echo $teams[$local]->id; ?>" />
		<input type="hidden" name="team2-<?php echo $match->id; ?>" value="<?php echo $teams[$visit]->id; ?>" />
	</tr>
<?php
		unset($pos1);unset($pos2);
		unset($group1);unset($group2);
	}
?>
</tbody>
</table>

<table>
<tr>
	<td align="left" width="100%">
		<h3><?php echo $this->phases[5]; ?></h3>
	</td>
</tr>
</table>
<table class="fixture" width="100%" cellpadding="0" cellspacing="0" border="0">
<thead>
	<tr>
		<td width="30"><?php echo JText::_( 'Match' ); ?></td>
		<td width="70"><?php echo JText::_( 'Date' ); ?> - <?php echo JText::_( 'Hour' ); ?></td>
		<td width="150"><?php echo JText::_( 'Place' ); ?></td>
		<td width="20"></td>
		<td width="100"></td>
		<td width="30" align="center"><?php echo JText::_( 'Result' ); ?></td>
		<td width="100"></td>
		<td width="20"></td>
	</tr>
</thead>
<tbody>
<?php		          
		$matches = $this->matches[13];
		//print_r($bets);

		for ($i=0, $n=count( $matches ); $i < $n; $i++) {
			$match = &$matches[$i];

			$date =& JFactory::getDate($match->date);          

			$winner1 = substr($match->team1, 1, 3);
			$winner2 = substr($match->team2, 1, 3);

			if ($bets[$winner1]->local > $bets[$winner1]->visit) {
				$local = $bets[$winner1]->team1;
			}else if ($bets[$winner1]->local < $bets[$winner1]->visit) {
				$local = $bets[$winner1]->team2;
			}

			if ($bets[$winner2]->local > $bets[$winner2]->visit) {
				$visit = $bets[$winner2]->team1;
			}else if ($bets[$winner2]->local < $bets[$winner2]->visit) {
				$visit = $bets[$winner2]->team2;
			}
		
?>
	<tr class="odd">
		<td align="left">
			<?php echo $match->id; ?>
		</td>
		<td align="left">
			<?php echo $date->format($format); ?>
		</td>
		<td>
			<?php echo $match->pname;?>
		</td>
		<td align="center">
			<img src="components/com_worldcup/images/flags/<?php echo $teams[$local]->id; ?>.png">
		</td>
		<td align="left">
			<?php echo $teams[$local]->name; ?>
		</td>
		<td align="center">
			<?php echo $bets[$match->id]->local; ?>&nbsp;-&nbsp;<?php echo $bets[$match->id]->visit; ?>
		</td>
		<td align="right">
			<?php echo $teams[$visit]->name;?>
		</td>
		<td>
			<img src="components/com_worldcup/images/flags/<?php echo $teams[$visit]->id; ?>.png">
		</td>
		<input type="hidden" name="team1-<?php echo $match->id; ?>" value="<?php echo $teams[$local]->id; ?>" />
		<input type="hidden" name="team2-<?php echo $match->id; ?>" value="<?php echo $teams[$visit]->id; ?>" />
	</tr>
<?php
		unset($pos1);unset($pos2);
		unset($group1);unset($group2);
	}
?>
</tbody>
</table>


</div>

<input type="hidden" name="option" value="com_worldcup" />
<input type="hidden" name="task" value="" />
<input name="jform[id]" id="jform_id" value="<?php echo $id; ?>" class="readonly" readonly="" type="hidden">
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHtml::_('form.token'); ?>
</form>
