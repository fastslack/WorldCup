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
<?php foreach($this->items as $i => $item): ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td width="20%">
			<a href="index.php?option=com_worldcup&view=user&layout=edit&id=<?php echo $item->id; ?>"><?php echo $item->name; ?></a>
		</td>
		<td>
			<?php echo $item->count; ?>
		</td>
		<td width="1%">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>
