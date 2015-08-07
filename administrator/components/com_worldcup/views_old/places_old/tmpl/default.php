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
$places = $this->places;
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

	<table class="adminlist">
	<thead>
		<tr>
			<th width="20">
				<?php echo JText::_( 'ID' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value=""  onclick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
			<th width="15%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort', 'Tournament', 'g.tournament', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
			<th width="75%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort', 'Name', 'g.name', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
		</tr>
	</thead>
	<tbody>
<?php		          
		//print_r($places);

		for ($i=0, $n=count( $places ); $i < $n; $i++) {
			$place = &$places[$i];
			$checked = JHTML::_('grid.checkedout', $place, $i );
?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $place->id; ?>
				</td>
				<td align="center">
					<?php echo $checked; ?>
				</td>
				<td>
					&nbsp;<?php echo $place->tournament;?>
				</td>
				<td>
					&nbsp;<?php echo $place->name;?>
				</td>
<?php
		}
?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="7">
				<?php echo $this->pageNav->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	</table>

<input type="hidden" name="option" value="com_worldcup" />
<input type="hidden" name="controller" value="places" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="tournament" value="<?php echo $this->tid; ?>" />
<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>

