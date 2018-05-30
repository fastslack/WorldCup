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
?>
<!--
<div id="myTabs">
	<ul class="mootabs_title">
		<li title="Tab1"><?php echo JText::_( "Clasification" ); ?></li>
		<li title="Tab2"><?php echo JText::_( "Round of 16" ); ?></li>
		<li title="Tab3"><?php echo JText::_( "Quarter-finals" ); ?></li>
		<li title="Tab4"><?php echo JText::_( "Semi-finals" ); ?></li>
		<li title="Tab5"><?php echo JText::_( "Final" ); ?></li>
	</ul>

	<div id="Tab1" class="mootabs_panel">

		<!--
		##
		## Clasification
		##
		-->
		<table>
		<tr>
			<td align="left" width="100%">
				<h3><?php echo JText::_( 'All matches' ); ?></h3>
			</td>
		</tr>
		</table>

		<table class="adminlist" width="99%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Date" ); ?>
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Seat" ); ?>
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Team" ); ?>
			</th>
			<th width="10%" nowrap="nowrap">
				&nbsp;
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Team" ); ?>
			</th>
		</tr>
		<?php
		//print_r($results);

		for ($i=0, $n=count( $matches[0] ); $i < $n; $i++) {
			$match = &$matches[0][$i];

			$date =  \JFactory::getDate($match->date);
			$format = '%b/%d %H:%M';

			$result = &$results[$match->id];

			if ($result['mid'] != "") {
				$res = explode("-", $result['goals']);
				$local = $result['local'];
				$visit = $result['visit'];
			}

			if ($local != "" && $visit != "") {
				$fill = "fill";
			}

		?>
			<tr>
				<td align="center">
					<?php echo $date->toFormat($format); ?>
				</td>
				<td>
					<?php echo $match->pname;?>
				</td>
				<td align="right">
					<img src="components/com_worldcup/images/flags/<?php echo $match->team1; ?>.png">
					<?php echo $this->teams[$match->team1]['name'];?>
				</td>
				<td align="center">
					<b><?php echo $local; ?></b>&nbsp;&nbsp;<small>vs</small>&nbsp;&nbsp;<b><?php echo $visit; ?></b>
				</td>
				<td>
					<img src="components/com_worldcup/images/flags/<?php echo $match->team2; ?>.png">
					<?php echo $this->teams[$match->team2]['name'];?>
				</td>
			</tr>
		<?php
				unset($fill);
				unset($local);
				unset($visit);
			}
		?>
		</table>

	</div>
  <div id="Tab2" class="mootabs_panel">

		<!--
		##
		## Round of 16
		##
		-->
		<table>
		<tr>
			<td align="left" width="100%">
				<h3><?php echo JText::_( 'Round of 16' ); ?></h3>
			</td>
		</tr>
		</table>
		<table class="adminlist" width="99%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Date" ); ?>
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Seat" ); ?>
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Team" ); ?>
			</th>
			<th width="10%" nowrap="nowrap">
				&nbsp;
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Team" ); ?>
			</th>
		</tr>
		<?php

			for ($i=0, $n=count( $matches[1] ); $i < $n; $i++) {
				$match = &$matches[1][$i];

				$date =& JFactory::getDate($match->date);
				$format = '%b/%d %H:%M';

				$pos1 = substr($match->team1, 0, 1);
				$group1 = recursiveArraySearch($groups, substr($match->team1, 1, 2) );

				$pos2 = substr($match->team2, 0, 1);
				$group2 =recursiveArraySearch($groups, substr($match->team2, 1, 2) );

				$result = &$results[$match->id];
				//print_r($result);echo "<br>";

				if ($result['mid'] != "") {
				  $local = $result['local'];
				  $visit = $result['visit'];
				  $disabled = "disabled";
				}

		?>
			<tr>
				<td align="center">
					<?php echo $date->toFormat($format); ?>
				</td>
				<td>
					<?php echo $match->pname;?>
				</td>
				<td align="right">
					<img src="components/com_worldcup/images/flags/<?php echo $data[$group1][$pos1-1]['id']; ?>.png">
					<?php echo $data[$group1][$pos1-1]['name'];?>
				</td>
				<td align="center">
					<b><?php echo $local; ?></b>&nbsp;&nbsp;<small>vs</small>&nbsp;&nbsp;<b><?php echo $visit; ?></b>
				</td>
				<td>
					<img src="components/com_worldcup/images/flags/<?php echo $data[$group2][$pos2-1]['id']; ?>.png">
					<?php echo $data[$group2][$pos2-1]['name'];?>
				</td>
			</tr>
		<?php
				unset($pos1);unset($pos2);
				unset($group1);unset($group2);
			}
		?>
		</table>

  </div>
  <div id="Tab3" class="mootabs_panel">

		<!--
		##
		## Quarter-finals
		##
		-->

		<table>
		<tr>
			<td align="left" width="100%">
				<h3><?php echo JText::_( 'Quarter-finals' ); ?></h3>
			</td>
		</tr>
		</table>
		<table class="adminlist" width="99%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Date" ); ?>
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Seat" ); ?>
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Team" ); ?>
			</th>
			<th width="10%" nowrap="nowrap">
				&nbsp;
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Team" ); ?>
			</th>
		</tr>
		<?php

			for ($i=0, $n=count( $matches[2] ); $i < $n; $i++) {
				$match = &$matches[2][$i];

				$date =& JFactory::getDate($match->date);
				$format = '%b/%d %H:%M';

				$winner1 = substr($match->team1, 1, 3);
				$winner2 = substr($match->team2, 1, 3);

				if ($results[$winner1]['local'] > $results[$winner1]['visit']) {
					$local = $results[$winner1]['team1'];
				}else if ($results[$winner1]['local'] < $results[$winner1]['visit']) {
					$local = $results[$winner1]['team2'];
				}

				if ($results[$winner2]['local'] > $results[$winner2]['visit']) {
					$visit = $results[$winner2]['team1'];
				}else if ($results[$winner2]['local'] < $results[$winner2]['visit']) {
					$visit = $results[$winner2]['team2'];
				}

				$result = &$results[$match->id];
				if ($result['mid'] != "") {
				  $local_r = $result['local'];
				  $visit_r = $result['visit'];
				}
//print_r($match);
		?>
			<tr>
				<td align="center">
					<?php echo $date->toFormat($format); ?>
				</td>
				<td>
					<?php echo $match->pname;?>
				</td>
				<td align="right">
					<img src="components/com_worldcup/images/flags/<?php echo $local; ?>.png">
					<?php echo $teams[$local]['name'];?>
				</td>
				<td align="center">
					<b><?php echo $local_r; ?></b>&nbsp;&nbsp;<small>vs</small>&nbsp;&nbsp;<b><?php echo $visit_r; ?></b>
				</td>
				<td>
					<img src="components/com_worldcup/images/flags/<?php echo $visit; ?>.png">
					<?php echo $teams[$visit]['name'];?>
				</td>
			</tr>
		<?php
				unset($pos1);unset($pos2);
				unset($local_r);unset($visit_r);
			}
		?>
		</table>







  </div>
  <div id="Tab4" class="mootabs_panel">


		<!--
		##
		## Semi-finals
		##
		-->

		<table>
		<tr>
			<td align="left" width="100%">
				<h3><?php echo JText::_( 'Semi-finals' ); ?></h3>
			</td>
		</tr>
		</table>
		<table class="adminlist" width="99%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Date" ); ?>
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Seat" ); ?>
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Team" ); ?>
			</th>
			<th width="10%" nowrap="nowrap">
				&nbsp;
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Team" ); ?>
			</th>
		</tr>
		<?php

			for ($i=0, $n=count( $matches[3] ); $i < $n; $i++) {
				$match = &$matches[3][$i];

				$date =& JFactory::getDate($match->date);
				$format = '%b/%d %H:%M';

				$pos1 = substr($match->team1, 0, 1);
				$group1 = recursiveArraySearch($groups, substr($match->team1, 1, 2) );

				$pos2 = substr($match->team2, 0, 1);
				$group2 =recursiveArraySearch($groups, substr($match->team2, 1, 2) );

				$result = &$results[$match->id];
				//print_r($result);echo "<br>";

				if ($result['mid'] != "") {
				  $local = $result['local'];
				  $visit = $result['visit'];
				  $disabled = "disabled";
				}

		?>
			<tr>
				<td align="center">
					<?php echo $date->toFormat($format); ?>
				</td>
				<td>
					<?php echo $match->pname;?>
				</td>
				<td align="right">
					<img src="components/com_worldcup/images/flags/<?php echo $data[$group1][$pos1-1]['id']; ?>.png">
					<?php echo $data[$group1][$pos1-1]['name'];?>
				</td>
				<td align="center">
					<b><?php echo $local; ?></b>&nbsp;&nbsp;<small>vs</small>&nbsp;&nbsp;<b><?php echo $visit; ?></b>
				</td>
				<td>
					<img src="components/com_worldcup/images/flags/<?php echo $data[$group2][$pos2-1]['id']; ?>.png">
					<?php echo $data[$group2][$pos2-1]['name'];?>
				</td>
			</tr>
		<?php
				unset($pos1);unset($pos2);
				unset($group1);unset($group2);
			}
		?>
		</table>




  </div>
  <div id="Tab5" class="mootabs_panel">

		<!--
		##
		## Finals
		##
		-->

		<table>
		<tr>
			<td align="left" width="100%">
				<h3><?php echo JText::_( 'Finals' ); ?></h3>
			</td>
		</tr>
		</table>
		<table class="adminlist" width="99%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Date" ); ?>
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Seat" ); ?>
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Team" ); ?>
			</th>
			<th width="10%" nowrap="nowrap">
				&nbsp;
			</th>
			<th width="20%" nowrap="nowrap">
				<?php echo JText::_( "Team" ); ?>
			</th>
		</tr>
		<?php

			for ($i=0, $n=count( $matches[5] ); $i < $n; $i++) {
				$match = &$matches[5][$i];

				$date =& JFactory::getDate($match->date);
				$format = '%b/%d %H:%M';

				$pos1 = substr($match->team1, 0, 1);
				$group1 = recursiveArraySearch($groups, substr($match->team1, 1, 2) );

				$pos2 = substr($match->team2, 0, 1);
				$group2 =recursiveArraySearch($groups, substr($match->team2, 1, 2) );

				$result = &$results[$match->id];
				//print_r($result);echo "<br>";

				if ($result['mid'] != "") {
				  $local = $result['local'];
				  $visit = $result['visit'];
				  $disabled = "disabled";
				}

		?>
			<tr>
				<td align="center">
					<?php echo $date->toFormat($format); ?>
				</td>
				<td>
					<?php echo $match->pname;?>
				</td>
				<td align="right">
					<img src="components/com_worldcup/images/flags/<?php echo $data[$group1][$pos1-1]['id']; ?>.png">
					<?php echo $data[$group1][$pos1-1]['name'];?>
				</td>
				<td align="center">
					<b><?php echo $local; ?></b>&nbsp;&nbsp;<small>vs</small>&nbsp;&nbsp;<b><?php echo $visit; ?></b>
				</td>
				<td>
					<img src="components/com_worldcup/images/flags/<?php echo $data[$group2][$pos2-1]['id']; ?>.png">
					<?php echo $data[$group2][$pos2-1]['name'];?>
				</td>
			</tr>
		<?php
				unset($pos1);unset($pos2);
				unset($group1);unset($group2);
			}
		?>
		</table>


  </div>

</div>
