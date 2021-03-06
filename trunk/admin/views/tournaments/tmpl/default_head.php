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
		<?php echo JText::_('COM_WORLDCUP_TOURNAMENT_TITLE'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_WORLDCUP_TOURNAMENT_PLACE'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_WORLDCUP_TOURNAMENT_MODE'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_WORLDCUP_TOURNAMENT_START'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_WORLDCUP_TOURNAMENT_END'); ?>
	</th>
	<th width="5">
		<?php echo JText::_('COM_WORLDCUP_TOURNAMENTS_HEADING_ID'); ?>
	</th>
</tr>
