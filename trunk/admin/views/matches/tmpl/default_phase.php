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
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// Get the user
$user		= JFactory::getUser();
// Get the filter phase
$phase = !empty($this->state->get('filter.phase')) ? $this->state->get('filter.phase') : 0;
?>

<thead><?php echo $this->loadTemplate('head');?></thead>

<tbody>
<?php		          

$listOrder	= $this->escape($this->state->get('list.ordering'));

foreach($this->items as $i => $item): 

	$ordering   = ($listOrder == 't.id');
	$canCreate  = $user->authorise('core.create',     'com_worldcup.team.'.$item->id);
	$canEdit    = $user->authorise('core.edit',       'com_worldcup.team.'.$item->id);
	$canCheckin = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
	//$canEditOwn = $user->authorise('core.edit.own',   'com_worldcup.team.'.$item->id) && $item->created_by == $userId;
	$canChange  = $user->authorise('core.edit.state', 'com_worldcup.team.'.$item->id) && $canCheckin;

	$date =& JFactory::getDate($item->date);          
	$format = '%b/%d %H:%M';
?>
		<tr class="<?php echo $i % 2; ?>">
			<td>
				<?php echo JHtml::_('grid.id', $i, $item->id); ?>
			</td>
			<td class="center" >
				<div class="btn-group">
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'matches.', $canChange, 'cb', '', ''); ?>
					<?php
					// Create dropdown items
					$action = ($item->published == 1) ? 'unpublish' : 'publish';
					JHtml::_('actionsdropdown.' . $action, 'cb' . $i, 'matches');

					// Render dropdown list
					echo JHtml::_('actionsdropdown.render', $this->escape($item->date));
					?>
				</div>
			</td>
			<td>
				<a href="index.php?option=com_worldcup&view=match&layout=edit&id=<?php echo $item->id; ?>"><?php echo $item->date; ?></a>
			</td>
			<td>
				<?php echo $item->group_name; ?>
			</td>
			<td>
				<?php echo $item->place; ?>
			</td>
			<td align="right">
				<?php 
					if ($phase > 0){
						echo $item->team1;
					}else{
						?><img src="components/com_worldcup/images/flags/<?php echo $item->team1; ?>.png">&nbsp;&nbsp;<?php
						echo $this->teams[$item->team1]['name'];
					}
				?>
			</td>
			<td>
				<small>vs</small>
			</td>
			<td>
				<?php 
					if ($phase > 0){
						echo $item->team2;
					}else{
						?><img src="components/com_worldcup/images/flags/<?php echo $item->team2; ?>.png">&nbsp;&nbsp;<?php
						echo $this->teams[$item->team2]['name'];
					}
				?>
			</td>
			<td align="center">
				<?php echo $this->phases[$item->phase];?>
			</td>
		</tr>
<?php endforeach; ?>
</tbody>
