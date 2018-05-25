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
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.file');

$my =& JFactory::getUser();

$data = $this->data;
$groups = $this->groups;
$matches = $this->matches;
$oldbets = $this->oldbets;

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

<section id="content">
<div class="wrapper8">
    <div class="container">
			<div class="row">
				<div class="grid_12">

        <h2>Resultados de tu fixture</h2>

				<h4>Fase de grupos</h4>

        <table width="100%" border="0">
        <tr>
        <?php
        	$e = 1;

        	//for ($i=1;$i<=count($data);$i++){

        	foreach ($data as $key => $value) {



        		if($e==3 || $e == 5 || $e == 7 ){
        			echo "</tr><tr>";
        		}
        ?>
        <td>
        <table width="100%" cellspacing="0" cellpadding="2" class="wow bounceInDown" id="table1">
        <caption><?php echo JText::_( "Group" ); ?> <?php echo $groups[$key]->name; ?></caption>
        <thead>
        	<tr>
        		<th><?php echo JText::_( "Team" ); ?></th>
        		<th width="10"><?php echo JText::_( "Points" ); ?></th>
        		<th width="10"><?php echo JText::_( "GF" ); ?></th>
        		<th width="10"><?php echo JText::_( "GE" ); ?></th>
        	</tr>
        </thead>
        <tbody>
        <?php

        		foreach ($value as $key2 => $val2)
        		{
        ?>

        		<tr>
        			<td>
        				<img src="<?php echo $this->teams[$val2['id']]->flag; ?>">&nbsp;<?php echo $data[$key][$key2]['name']; ?></td>
        			<td align="center"><?php echo $data[$key][$key2]['points'] ? $data[$key][$key2]['points'] : 0; ?></td>
        			<td><?php echo $data[$key][$key2]['gf'] ? $data[$key][$key2]['gf'] : 0; ?></td>
        			<td><?php echo $data[$key][$key2]['ge'] ? $data[$key][$key2]['ge'] : 0; ?></td>
        		</tr>

        <?php
        		}
        		echo "</tbody></table></td>";

        		$e++;
        	}
        ?>

        </tr>
        </table>

				<h4>Octavos de final</h4>

        <table width="100%" cellpadding="2" cellspacing="2" border="1" class="wow bounceInDown" id="table1">
        <?php echo $this->printTableHeader(); ?>
        <tbody>
        <?php

        		for ($i=0, $n=count( $matches ); $i < $n; $i++) {
        			$match = &$matches[$i];

        			$date =& JFactory::getDate($match->date);
        			$format = 'd/m H:M';

        			$pos1 = substr($match->team1, 0, 1);
        			$group1 = $this->recursiveArraySearch($groups, substr($match->team1, 1, 2) );

        			$pos2 = substr($match->team2, 0, 1);
        			$group2 = $this->recursiveArraySearch($groups, substr($match->team2, 1, 2) );

        			$idL = $data[$group1][$pos1-1]['id'];
        			$idV = $data[$group2][$pos2-1]['id'];
        ?>
        			<tr>
        				<td>
        					<?php echo $date->format($format); ?>
        				</td>
        				<td>
        					<?php echo $match->pname;?>
        				</td>
        				<td align="right">
        					<?php echo $data[$group1][$pos1-1]['name'];?>&nbsp;<img src="<?php echo $this->teams[$idL]->flag; ?>">
        				</td>
        				<td align="center">
        					<input type="text" name="l-<?php echo $match->id; ?>" value="<?php echo $oldbets[$match->id]->local; ?>" size="1" readonly="readonly">&nbsp;-&nbsp;
        					<input type="text" name="v-<?php echo $match->id; ?>" value="<?php echo $oldbets[$match->id]->visit; ?>" size="1" readonly="readonly">
        				</td>
        				<td>
        					<img src="<?php echo $this->teams[$idV]->flag; ?>">
        					<?php echo $data[$group2][$pos2-1]['name'];?>
        				</td>
        				<input type="hidden" name="team1-<?php echo $match->id; ?>" value="<?php echo $idL; ?>" />
        				<input type="hidden" name="team2-<?php echo $match->id; ?>" value="<?php echo $idV; ?>" />
        			</tr>
        <?php
        			unset($pos1);unset($pos2);
        			unset($group1);unset($group2);
        		}
        ?>

        </tbody>
        </table>

				<h4>Cuartos de final</h4>

				<table class="wow bounceInDown" id="table1" width="100%" cellpadding="2" cellspacing="2" border="0">
				<?php echo $this->printTableHeader(); ?>
				<tbody>
				<?php
					echo $this->printTableRows($this->matches2, $this->bets2, $this->oldbets2, false, true);
				?>
				</tbody>
				</table>

				<h4>Semifinal</h4>

				<table class="wow bounceInDown" id="table1" width="100%" cellpadding="2" cellspacing="2" border="0">
				<?php echo $this->printTableHeader(); ?>
				<tbody>
				<?php
					echo $this->printTableRows($this->matches3, $this->bets3, $this->oldbets3, false, true);
				?>
				</tbody>
				</table>

				<h4>Tercer puesto</h4>

				<table class="wow bounceInDown" id="table1" width="100%" cellpadding="2" cellspacing="2" border="0">
				<?php echo $this->printTableHeader(); ?>
				<tbody>
				<?php
					echo $this->printTableRows($this->matches4, $this->bets4, $this->oldbets4, true, true);
				?>
				</tbody>
				</table>

				<h4>Final</h4>

				<table class="wow bounceInDown" id="table1" width="100%" cellpadding="2" cellspacing="2" border="0">
				<?php echo $this->printTableHeader(); ?>
				<tbody>
				<?php
					echo $this->printTableRows($this->matches5, $this->bets5, $this->oldbets5, false, true);
				?>
				</tbody>
				</table>


			</div>
		</div>
	</div>
</div>
</section>
