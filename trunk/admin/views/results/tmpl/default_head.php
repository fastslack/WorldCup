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
?>
<tr>
	<th width="20">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>
	<th>
		&nbsp;
	</th>
		<th>
		<?php echo JText::_('COM_WORLDCUP_RESULTS_TID'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_WORLDCUP_RESULTS_DATE'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_WORLDCUP_RESULTS_GROUP'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_WORLDCUP_RESULTS_PLACE'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_WORLDCUP_RESULTS_TEAM1'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_WORLDCUP_RESULTS_TEAM2'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_WORLDCUP_RESULTS_PHASE'); ?>
	</th>

	<th width="5">
		<?php echo JText::_('JGRID_HEADING_ID'); ?>
	</th>
</tr>
