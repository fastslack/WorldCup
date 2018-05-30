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

$matches = $this->matches;
$results = $this->results;
$data = $this->data;
$groups = $this->groups;
$teams = $this->teams;

$document = &JFactory::getDocument();
//$document->addScript('media/system/js/mootools.js' );
//$document->addScript('components/com_worldcup/js/mootabs1.2.js' );

?>
<!--<link rel="stylesheet" href="components/com_worldcup/css/worldcup.css" type="text/css" />-->
<section id="content" class="negative-margin1">
<div class="wrapper8">
    <div class="container">
			<div class="row">

				<form action="index.php?option=com_worldcup&task=bets&step=3" method="post" name="adminForm" onSubmit="submitbutton(); return false;">


				<?php
					$e = 1;

					for ($i=1;$i<=count($data);$i++)
					{

				?>

				<table width="100%" cellspacing="0" cellpadding="2" id="group_table" border="1">
				<caption><?php echo JText::_( "Group" ); ?> <?php echo $groups[$i]['name']; ?></caption>
				<thead>
					<tr>
						<td><?php echo JText::_( "Team" ); ?></td>
						<td width="10"><?php echo JText::_( "Pts" ); ?></td>
						<td width="10"><?php echo JText::_( "Dif" ); ?></td>
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
							<td><?php //echo $data[$i][$y]['diff'] ? $data[$i][$y]['diff'] : 0; ?></td>
							<td><?php //echo $data[$i][$y]['gf'] ? $data[$i][$y]['gf'] : 0; ?></td>
							<td><?php //echo $data[$i][$y]['ge'] ? $data[$i][$y]['ge'] : 0; ?></td>
						</tr>

				<?php
						}
						$e++;
					}
				?>

				</tbody>
				</table>




</div></div></div>
</section>
