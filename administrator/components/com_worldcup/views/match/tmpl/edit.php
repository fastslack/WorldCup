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
// No direct access
defined('_JEXEC') or die('Restricted access');

// get document to add scripts
$document	= JFactory::getDocument();
?>
<form action="<?php echo JRoute::_('index.php?option=com_worldcup&view=match&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-horizontal">
	
<div class="row-fluid">

<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_WORLDCUP_MATCHS_TITLE', true)); ?>
	<div>
		<!-- Begin Content -->
		<div class="span6 form-horizontal">
			<?php echo $this->getHtmlFieldSet('matchs'); ?>
		</div>
	</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<!-- End Content -->

</div>

<input type="hidden" name="option" value="com_worldcup" />
<input type="hidden" name="task" value="" />
<input name="jform[id]" id="jform_id" value="<?php echo $this->item->id; ?>" class="readonly" readonly="" type="hidden">
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHtml::_('form.token'); ?>
</form>
