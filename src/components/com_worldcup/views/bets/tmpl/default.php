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

$groups = $this->groups;
$teams = $this->teams;
$matches = $this->matches;
//$results = $this->results;

?>
<script language="javascript">
	function submitbutton(pressbutton)
	{
		var form = document.adminForm;

/*
		for(i=0;i<form.elements.length;i++)
		{
			if (form.elements[i].value.length < 1 ) {
				//alert(form.elements[i].value + ' - ' + form.elements[i].name);
				alert('<?php echo JText::_( "Please complete all fields", true ); ?>');
				form.elements[i].focus();
				return false;
			}
		}
*/

		form.submit();
	}
</script>

<section>
<div class="container">
	<div class="row">

		<div class="grid_12">
			<br><br>
      <h2 class="wow bounceInRight"><?php echo $this->competition->name; ?></h2>
			<h4 class="wow bounceInLeft">Mi Fixture</h4>
    </div>
	</div>

	<form action="<?php echo JRoute::_('index.php?option=com_worldcup&view=bets&layout=step2&cid='.$this->competition->id); ?>" method="post" name="adminForm" onSubmit="submitbutton(); return false;">
	<div class="row">

		<div class="grid_12">

		<?php
			for ($i=0;$i<count($groups);$i++){
		?>
		<table id="table1" class="" border="1">
		<caption><?php echo JText::_( "Group" ); ?> <?php echo $groups[$i]->name; ?></caption>
		<thead>
			<tr>
				<th width="30%" nowrap="nowrap">
					<?php echo JText::_( 'Match' ); ?>
				</th>
				<th width="20%" nowrap="nowrap">
					<?php echo JText::_( 'Result' ); ?>
				</th>
				<th width="10%" nowrap="nowrap">
					<?php echo JText::_( 'Date' ); ?>
				</th>
				<th width="20%" nowrap="nowrap">
					<?php echo JText::_( 'Place' ); ?>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php

				for ($y=0;$y<count($matches[$i]);$y++)
				{
					$date = JFactory::getDate($matches[$i][$y]->date);
					$format = 'd/m H:i';

					$now = JFactory::getDate('now');

					// Declare variables
					$local = $visit = $disabled = 0;

					$local = isset($this->bets[$matches[$i][$y]->id]->local) ? $this->bets[$matches[$i][$y]->id]->local : '';
				  $visit = isset($this->bets[$matches[$i][$y]->id]->visit) ? $this->bets[$matches[$i][$y]->id]->visit : '';

					//if(isset($results[$matches[$i][$y]->id]->mid) && $results[$matches[$i][$y]->id]->mid == $matches[$i][$y]->id ){
					//	$disable = 1;
					//}

					$readonly = "";
					if ($now >= $date)
					{
						$readonly = "readonly='readonly'";
					}

		?>
		<tr class="odd">

			<td align="" data-title="partido">
				<?php echo $teams[$matches[$i][$y]->team1]->name;?>&nbsp;<img src="<?php echo $teams[$matches[$i][$y]->team1]->flag; ?>">&nbsp;&nbsp;&nbsp;vs&nbsp;&nbsp;&nbsp;<img src="<?php echo $teams[$matches[$i][$y]->team2]->flag; ?>">&nbsp;<?php echo $teams[$matches[$i][$y]->team2]->name;?>
			</td>
			<td align="" data-title="resultado">
				<input type="text" name="l-<?php echo $matches[$i][$y]->id; ?>" value="<?php echo $local == '' && isset($disable) ? 'X' : $local; ?>" size="1" class="input_result" <?php echo $readonly; ?>>&nbsp;-&nbsp;
				<input type="text" name="v-<?php echo $matches[$i][$y]->id; ?>" value="<?php echo $visit == '' && isset($disable) ? 'X' : $visit; ?>" size="1" class="input_result" <?php echo $readonly; ?>>
			</td>
			<td data-title="fecha">
				<?php echo $date->format($format); ?>
			</td>
			<td data-title="lugar">
				<?php echo $matches[$i][$y]->pname;?>
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
</div>
</section>
