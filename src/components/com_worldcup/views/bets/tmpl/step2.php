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

$data = $this->data;
$groups = $this->groups;
$matches = $this->matches;
$oldbets = $this->oldbets;

?>
<section id="content">
<div class="wrapper8">
    <div class="container">
			<div class="row">
				<div class="grid_12">
			    <h2>Fase de grupos</h2>

					<form action="<?php echo JRoute::_('index.php?option=com_worldcup&view=bets&layout=step3&cid='.$this->competition->id); ?>" method="post" name="adminForm" onSubmit="submitbutton(); return false;">
					<table width="100%" border="0">
					<tr>
					<?php
						$e = 1;

						foreach ($data as $key => $value)
						{

							//if($e==3 || $e == 5 || $e == 7 ){
							//	echo "</tr><tr>";
							//}
					?>
					<td>
					<table width="100%" cellspacing="0" cellpadding="2" class="wow bounceInDown" id="table1">
					<h5><?php echo JText::_( "Group" ); ?> <?php echo $groups[$key]->name; ?></h5>
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
								<td data-title="equipo">
									<img src="<?php echo $this->teams[$val2['id']]->flag; ?>">&nbsp;<?php echo $data[$key][$key2]['name']; ?></td>
								<td data-title="puntos" align="center"><?php echo $data[$key][$key2]['points'] ? $data[$key][$key2]['points'] : 0; ?></td>
								<td data-title="GF"><?php echo $data[$key][$key2]['gf'] ? $data[$key][$key2]['gf'] : 0; ?></td>
								<td data-title="GE"><?php echo $data[$key][$key2]['ge'] ? $data[$key][$key2]['ge'] : 0; ?></td>
							</tr>

					<?php
							}
							echo "</tbody></table></td><tr>";

							$e++;
						}
					?>

					</tr>
					</table>

					<h2>Octavos de final</h2>

					<table width="100%" cellpadding="2" cellspacing="2" border="1" class="" id="table1">
					<?php echo $this->printTableHeader(); ?>
					<tbody>
					<?php

							for ($i=0, $n=count( $matches ); $i < $n; $i++)
							{
								$match = &$matches[$i];

								$date =& JFactory::getDate($match->date);
								$format = 'd/m H:i';

								$pos1 = substr($match->team1, 0, 1);

								$group1 = $this->recursiveArraySearch($groups, substr($match->team1, 1, 2) );

								$pos2 = substr($match->team2, 0, 1);

								$group2 = $this->recursiveArraySearch($groups, substr($match->team2, 1, 2) );

								$idL = $data[$group1][$pos1-1]['id'];
								$idV = $data[$group2][$pos2-1]['id'];

								if ($oldbets[$match->id]->pLocal == 0 && $oldbets[$match->id]->pVisit == 0)
								{
									$readonly = "readonly='readonly'";
								}

					?>
								<tr>

									<td align="" data-title="partido">
										<?php echo $data[$group1][$pos1-1]['name'];?>&nbsp;<img src="<?php echo $this->teams[$idL]->flag; ?>">&nbsp;&nbsp;&nbsp;vs&nbsp;&nbsp;&nbsp;<img src="<?php echo $this->teams[$idV]->flag; ?>">&nbsp;<?php echo $data[$group2][$pos2-1]['name'];?>
									</td>
									<td align="" data-title="resultado">
										<input type="text" data-mid="<?php echo $match->id; ?>" id="l-<?php echo $match->id; ?>" name="l-<?php echo $match->id; ?>" value="<?php echo $oldbets[$match->id]->local; ?>" size="1" class="input_result">&nbsp;-&nbsp;
										<input type="text" data-mid="<?php echo $match->id; ?>" id="v-<?php echo $match->id; ?>" name="v-<?php echo $match->id; ?>" value="<?php echo $oldbets[$match->id]->visit; ?>" size="1" class="input_result">
									</td>
									<td align="" data-title="penales">
										<input type="text" id="pLocal-<?php echo $match->id; ?>" name="pLocal-<?php echo $match->id; ?>" value="<?php echo $oldbets[$match->id]->pLocal; ?>" size="1" class="" <?php echo $readonly; ?>>&nbsp;-&nbsp;
										<input type="text" id="pVisit-<?php echo $match->id; ?>" name="pVisit-<?php echo $match->id; ?>" value="<?php echo $oldbets[$match->id]->pVisit; ?>" size="1" class="" <?php echo $readonly; ?>>
									</td>
									<td data-title="fecha">
										<?php echo $date->format($format); ?>
									</td>
									<td data-title="lugar">
										<?php echo $match->pname;?>
									</td>

									<input type="hidden" name="team1-<?php echo $match->id; ?>" value="<?php echo $idL; ?>" />
									<input type="hidden" name="team2-<?php echo $match->id; ?>" value="<?php echo $idV; ?>" />
								</tr>
					<?php
								unset($pos1);unset($pos2);
								unset($group1);unset($group2);
							}
					?>
					<tr>
						<td align="center" colspan="7">
							<input type="submit" value="<?php echo JText::_( 'Send' ); ?>" />
						</td>
					</tr>

					</tbody>
					</table>
					</form>

			</div>
		</div>
	</div>
</div>
</section>
<script type="text/javascript">
	jQuery(function($, undefined) {

		$('.input_result').on('input', function() {

			var that = $(this);
			var mid = $(this).data('mid');

			if ($('#l-'+mid).val() == $('#v-'+mid).val())
			{
				$('#pLocal-'+mid).prop('readonly', false);
				$('#pVisit-'+mid).prop('readonly', false);
			}

		});

  });


	function submitbutton(pressbutton)
	{
		var form = document.adminForm;

/*
		for(i=0;i<form.elements.length;i++)
		{
			//alert(form.elements[i].name);
			if (form.elements[i].value.length < 1 )
			{
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
