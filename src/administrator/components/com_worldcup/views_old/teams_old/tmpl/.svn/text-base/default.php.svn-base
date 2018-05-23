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
$teams = $this->teams;
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
			<th width="45%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort', 'Name', 't.name', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
			<th width="45%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort', 'Group', 't.group', @$lists['order_Dir'], @$lists['order'] ); ?>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="7">
				<?php echo $this->pageNav->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
<?php		          
		//print_r($teams);

		for ($i=0, $n=count( $teams ); $i < $n; $i++) {
			$team = &$teams[$i];
			$checked = JHTML::_('grid.checkedout', $team, $i );
			//$published 	= JHTML::_('grid.published', $team, $i );
?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $team->id; ?>
				</td>
				<td align="center">
					<?php echo $checked; ?>
				</td>
				<td>
					<img src="components/com_worldcup/images/flags/<?php echo $team->id; ?>.png">
					<?php echo $team->name;?>
				</td>
				<td>
					<?php echo $team->gname;?>
				</td>
			</tr>
<?php
		}
?>
	</tbody>
	</table>

<input type="hidden" name="option" value="com_worldcup" />
<input type="hidden" name="controller" value="teams" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="tournament" value="<?php echo $this->tid; ?>" />
<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>

