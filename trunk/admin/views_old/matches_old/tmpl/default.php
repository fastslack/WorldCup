<?php
/**
 * WorldCup
 *
 * @author      Matias Aguirre
 * @email       maguirre@matware.com.ar
 * @url         http://www.matware.com.ar
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
defined('_JEXEC') or die('Restricted access'); 

//JHTML::_('behavior.tooltip');

?>
<link rel="stylesheet" href="components/com_worldcup/css/worldcup.css" type="text/css" />
<form action="index.php?option=com_worldcup" method="post" name="adminForm">
<table>
<tr>
<!--
	<td align="left" width="100%">
		<?php echo JText::_( 'Filter' ); ?>:
		<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
		<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
		<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_catid').value='0';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Filter Reset' ); ?></button>
	</td>
	<td nowrap="nowrap">
	</td>
-->
	<td align="left" width="100%">
		<?php echo JText::_( 'Tournament' ); ?>:&nbsp;<?php echo $this->lists['tournaments']; ?>
		<button onclick="this.form.submit();"><?php echo JText::_( 'Change' ); ?></button>
	</td>
	<td nowrap="nowrap">
	</td>
</tr>
</table>

<?php 
	echo $this->getPhaseHTML(0);
	echo $this->getPhaseHTML(1);
	echo $this->getPhaseHTML(2);
	echo $this->getPhaseHTML(3);
	echo $this->getPhaseHTML(4);
	if ($this->teamscount > 12) {
		echo $this->getPhaseHTML(5);
	}
?>

<input type="hidden" name="option" value="com_worldcup" />
<input type="hidden" name="controller" value="matches" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="tournament" value="<?php echo $this->tid; ?>" />
<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>

