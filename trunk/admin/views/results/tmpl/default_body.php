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

$user		= JFactory::getUser();
$listOrder	= $this->escape($this->state->get('list.ordering'));
$userId		= $user->get('id');

foreach($this->items as $i => $item): 

	$ordering   = ($listOrder == 't.id');
	$canCreate  = $user->authorise('core.create',     'com_worldcup.result.'.$item->id);
	$canEdit    = $user->authorise('core.edit',       'com_worldcup.result.'.$item->id);
	$canCheckin = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
	$canEditOwn = $user->authorise('core.edit.own',   'com_worldcup.result.'.$item->id) && $item->created_by == $userId;
	$canChange  = $user->authorise('core.edit.state', 'com_worldcup.result.'.$item->id) && $canCheckin;
?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td class="center" width="50">
			<div class="btn-group">
				<?php echo JHtml::_('jgrid.published', $item->published, $i, 'results.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
				<?php
				// Create dropdown items
				$action = ($item->published == 1) ? 'unpublish' : 'publish';
				JHtml::_('actionsdropdown.' . $action, 'cb' . $i, 'results');

				// Render dropdown list
				echo JHtml::_('actionsdropdown.render', $this->escape($item->title));
				?>
			</div>
		</td>
				<td>
			<?php echo $item->tid; ?>
		</td>
		<td>
			<a href="index.php?option=com_worldcup&view=result&layout=edit&id=<?php echo $item->id; ?>"><?php echo $item->date; ?></a>
		</td>
		<td>
			<?php echo $item->group; ?>
		</td>
		<td>
			<?php echo $item->place; ?>
		</td>
		<td>
			<?php echo $item->team1; ?>
		</td>
		<td>
			<?php echo $item->team2; ?>
		</td>
		<td>
			<?php echo $item->phase; ?>
		</td>

		<td>
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>
