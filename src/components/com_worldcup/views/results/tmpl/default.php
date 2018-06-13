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

function recursiveArraySearch($haystack, $needle, $index = null) {
	$aIt     = new RecursiveArrayIterator($haystack);
	$it    = new RecursiveIteratorIterator($aIt);

  while($it->valid()) {
    if (((isset($index) AND ($it->key() == $index)) OR (!isset($index))) AND ($it->current() == $needle)) {
        return $aIt->key();
    }

    $it->next();
  }

  return false;
}

$tid = 4;
$matches = $this->matches;
$results = $this->results;
$data = $this->data;
$groups = $this->groups;
$teams = $this->teams;

?>
<section id="content" class="">
<div class="wrapper8">
    <div class="container">
			<div class="row">

				<h2>Fixture Rusia 2018 <?php //echo $this->userObj->name; ?></h2><br />

				<h4>Clasificaci&oacute;n</h4>

				<?php
					$e = 1;

					foreach ($data as $key => $value)
					{

				?>

				<table width="100%" cellspacing="0" cellpadding="2" class="wow bounceInDown" id="table1">
				<h5><?php echo JText::_( "Group" ); ?> <?php echo $groups[$key]->name; ?></h5>
				<thead>
					<tr>
						<th><?php echo JText::_( "Team" ); ?></th>
						<th width="10"><?php echo JText::_( "Pts" ); ?></th>
						<th width="10"><?php echo JText::_( "Dif" ); ?></th>
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
					<td><?php echo $data[$key][$key2]['diff'] ? $data[$key][$key2]['diff'] : 0; ?></td>
					<td><?php echo $data[$key][$key2]['gf'] ? $data[$key][$key2]['gf'] : 0; ?></td>
					<td><?php echo $data[$key][$key2]['ge'] ? $data[$key][$key2]['ge'] : 0; ?></td>
				</tr>


				<?php
						}
						$e++;
					}
				?>

				</tbody>
				</table>
			</div>

				<div class="row">

				<h4><?php echo JText::_( "Results" ); ?></h4><br>

				<?php

					$i = 0;

					foreach ($groups as $key => $value)
					{

				?>
				<table id="table1" class="" border="1">
				<h5><?php echo JText::_( "Group" ); ?> <?php echo $value->name; ?></h5>
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

					$matches = $this->_matches->getMatchesList($tid, 0, $key);

					for ($y=0;$y<count($matches);$y++)
					{
						//$date = new JDate($matches[$y]->date);
						$date =& JFactory::getDate($matches[$y]->date);
						$format = 'd/m H:i';

						// Declare variables
						$local = $visit = $disabled = 0;

						$local = isset($this->results[$matches[$y]->id]->local) ? $this->results[$matches[$y]->id]->local : '';
					  $visit = isset($this->results[$matches[$y]->id]->visit) ? $this->results[$matches[$y]->id]->visit : '';

				?>
				<tr class="odd">

					<td align="" data-title="partido">
						<?php echo $teams[$matches[$y]->team1]->name;?>&nbsp;<img src="<?php echo $teams[$matches[$y]->team1]->flag; ?>">&nbsp;&nbsp;&nbsp;vs&nbsp;&nbsp;&nbsp;<img src="<?php echo $teams[$matches[$y]->team2]->flag; ?>">&nbsp;<?php echo $teams[$matches[$y]->team2]->name;?>
					</td>
					<td align="" data-title="resultado">
						<?php echo $local; ?>&nbsp;-&nbsp;<?php echo $visit; ?>
					</td>
					<td data-title="fecha">
						<?php echo $date->format($format); ?>
					</td>
					<td data-title="lugar">
						<?php echo $matches[$y]->pname;?>
					</td>

				</tr>
				<?php

							$i++;
							unset($disable);
						}
					}
				?>
				</tbody>
				</table>
				</form>

			</div>



</div></div></div>
</section>
