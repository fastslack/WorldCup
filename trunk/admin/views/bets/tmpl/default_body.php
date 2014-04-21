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
$tid = $this->state->get('filter.tid');

foreach($this->items as $i => $item): 

	$item->checked_out = $item->created_by = '';

	if ($item->count == 64) {
		$sended = 1;
	}else{
		$sended = 0;
	}

	$ordering   = ($listOrder == 't.id');
	$canCreate  = $user->authorise('core.create',     'com_worldcup.bet.'.$item->id);
	$canEdit    = $user->authorise('core.edit',       'com_worldcup.bet.'.$item->id);
	$canCheckin = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
	$canEditOwn = $user->authorise('core.edit.own',   'com_worldcup.bet.'.$item->id) && $item->created_by == $userId;
	$canChange  = $user->authorise('core.edit.state', 'com_worldcup.bet.'.$item->id) && $canCheckin;
?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td class="center" width="50">
			<div class="btn-group">
				<?php //echo JHtml::_('jgrid.published', $item->published, $i, 'bets.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
				<?php
				// Create dropdown items
				//$action = ($item->published == 1) ? 'unpublish' : 'publish';
				//JHtml::_('actionsdropdown.' . $action, 'cb' . $i, 'bets');

				// Render dropdown list
				//echo JHtml::_('actionsdropdown.render', $this->escape($item->title));
				?>
			</div>
		</td>
		<td>
			<a href="index.php?option=com_worldcup&view=bet&layout=edit&tid=<?php echo $tid; ?>&id=<?php echo $item->id; ?>"><?php echo $item->name; ?></a>
		</td>
		<td>
			<?php echo $item->email; ?>
		</td>
		<td>
			<?php echo JHtml::_('jgrid.published', $sended, $i); ?>
		</td>

		<td>
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>
