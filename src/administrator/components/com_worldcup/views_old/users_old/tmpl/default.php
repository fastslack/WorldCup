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
$users = $this->users;
?>
<link rel="stylesheet" href="components/com_worldcup/css/worldcup.css" type="text/css" />
<form action="index.php?option=com_worldcup" method="post" name="adminForm">
<table>
<tr>
	<td align="left" width="100%">

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
		<th width="40%" nowrap="nowrap">
			<?php echo JHTML::_('grid.sort', 'Name', 'u.name', @$lists['order_Dir'], @$lists['order'] ); ?>
		</th>
		<th width="40%" nowrap="nowrap">
			<?php echo JHTML::_('grid.sort', 'EMail', 'u.email', @$lists['order_Dir'], @$lists['order'] ); ?>
		</th>
		<th width="20%" nowrap="nowrap">
			<?php echo JHTML::_('grid.sort', 'Bet', 'count', @$lists['order_Dir'], @$lists['order'] ); ?>
		</th>
	</tr>
</thead>
<tbody>
<?php		          
		//print_r($users);

		for ($i=0, $n=count( $users ); $i < $n; $i++) {
			$user = &$users[$i];
			$checked = JHTML::_('grid.checkedout', $user, $i );

			if ($user->count == 48) {
				$sended = 1;
			}else{
				$sended = 0;
			}

?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $user->id; ?>
				</td>
				<td align="center">
					<?php echo $checked; ?>
				</td>
				<td>
					<a href="index.php?option=com_worldcup&controller=users&task=detail&id=<?php echo $user->id; ?>">
					<?php echo $user->name; ?>
					</a>
				</td>
				<td>
					<?php echo $user->email;?>
				</td>
				<td align="center">
					<img src="images/<?php echo $this->lists['sended'][$sended]; ?>.png" />
				</td>
			</tr>
<?php
		}
?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5">
				<?php echo $this->pageNav->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	</table>

<input type="hidden" name="option" value="com_worldcup" />
<input type="hidden" name="controller" value="users" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>

