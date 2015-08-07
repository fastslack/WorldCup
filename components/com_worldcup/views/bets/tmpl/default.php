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

$groups = $this->groups;
$teams = $this->teams;
$matches = $this->matches;
$results = $this->results;

//print_r($teams);
//include(JPATH_ADMINISTRATOR.'/components/com_worldcup/worldcup_config.php');

?>
<script language="javascript">
	function submitbutton(pressbutton)
	{
		var form = document.adminForm;

		for(i=0;i<form.elements.length;i++) {
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

<div class="table table-striped table-bordered box">
  <div class="tab-header">
		<i class="icon-th-list"></i>
		 <?php echo JText::_( "My Bet" ); ?>
	</div>
  <div class="padded">

		<?php

//print_r($groups);

			for ($i=0;$i<count($groups);$i++){
		?>
		<form action="index.php?option=com_worldcup&task=bets&step=2" method="post" name="adminForm" onSubmit="submitbutton(); return false;">
		<table class="fixture" width="100%">
		<caption><?php echo JText::_( "Group" ); ?> <?php echo $groups[$i]->name; ?></caption>
		<thead>
			<tr>
				<td width="95"><?php echo JText::_( "Date" ); ?> - <?php echo JText::_( "Hour" ); ?></td>
				<!--<td width="150"><?php echo JText::_( "Seat" ); ?></td>-->
				<td></td>
				<td width="20"></td>
				<td width="120" align="center"><?php echo JText::_( "Result" ); ?></td>
				<td width="20"></td>
				<td></td>
			</tr>
		</thead>
		<tbody>
		<?php

				for ($y=0;$y<count($matches[$i]);$y++){

					//$date = new JDate($matches[$i][$y]->date);
					$date =& JFactory::getDate($matches[$i][$y]->date);
					$format = 'd/m H:i';

					// Declare variables
					$local = $visit = $disabled = 0;

					$local = isset($this->bets[$matches[$i][$y]->id]->local) ? $this->bets[$matches[$i][$y]->id]->local : '';
				  $visit = isset($this->bets[$matches[$i][$y]->id]->visit) ? $this->bets[$matches[$i][$y]->id]->visit : '';

		//			if ($worldcupConfig['disable']){
		//				$disable = 1;
		//			}

					if(isset($results[$matches[$i][$y]->id]->mid) && $results[$matches[$i][$y]->id]->mid == $matches[$i][$y]->id ){
						$disable = 1;
					}
		?>
		<tr class="odd">
			<td><?php echo $date->format($format); ?></td>
			<td align="right" style="text-align: right;">
				<?php echo $teams[$matches[$i][$y]->team1]->name; ?>
			</td>
			<td>
				<img src="<?php echo $teams[$matches[$i][$y]->team1]->flag; ?>">
			</td>
			<td align="center">
				<input class="input_result" size="1" type="text" name="l<?php echo $matches[$i][$y]->id; ?>" value="<?php echo $local == '' && isset($disable) ? 'X' : $local; ?>" <?php echo isset($disable) ? 'readonly="readonly" style="background-color:#666"' : ''; ?>>&nbsp;-&nbsp;
				<input class="input_result" size="1" type="text" name="v<?php echo $matches[$i][$y]->id; ?>" value="<?php echo $visit == '' && isset($disable) ? 'X' : $visit; ?>" <?php echo isset($disable) ? 'readonly="readonly" style="background-color:#666"' : ''; ?>>
			</td>
			<td>
				<img src="<?php echo $teams[$matches[$i][$y]->team2]->flag; ?>">
			</td>
			<td align="left">
				<?php echo $teams[$matches[$i][$y]->team2]->name; ?>
			</td>
		</tr>
		<?php
				unset($disable);
				}
			}

		//	if ($worldcupConfig['disable'] != 1) {
		?>
		<tr>
			<td align="center" colspan="8">
				<input type="submit" value="<?php echo JText::_( 'Send' ); ?>" />
			</td>
		</tr>
		<?php
		//	}
		?>
		</tbody>
		</table>
		</form>

	</div>
</div>
