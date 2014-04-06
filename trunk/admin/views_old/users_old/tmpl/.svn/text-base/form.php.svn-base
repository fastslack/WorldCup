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

JHTML::_('behavior.calendar');

?>
<script language="javascript">
	function submitbutton(pressbutton)
	{
		var form = document.adminForm;

		submitform( pressbutton );
	}
//-->
</script>

<form action="index.php" method="post" name="adminForm">
<div id="editcell">

<table border="0" width="100%">
<tr>
	<td valign="top">
		<table class="adminlist">
		<tr>
			<td colspan="2">
				<h3><?php echo $this->title; ?></h3>
			</td>
		</tr>
		<tr>
			<td width="30%"  align="right">
				<?php echo JText::_( "Date" ); ?>
			</td>
			<td>
				<input type="text" name="tdate" id="tdate" value="<?php echo $this->mdate; ?>">
				<input type="reset" class="button" value="Select Date" onclick="return showCalendar('tdate','%Y-%m-%d');" />
			</td>
    </tr>
		<tr>
			<td align="right">
				<?php echo JText::_( "Hour" ); ?>
			</td>
			<td>
				<?php echo $this->lists['hour']; ?>&nbsp;&nbsp;
				<?php echo $this->lists['minutes']; ?>
			</td>
    </tr>
		<tr>
			<td align="right">
				<?php echo JText::_( "Place" ); ?>
			</td>
			<td>
				<?php echo $this->lists['places']; ?>
			</td>
    </tr>
		<tr>
			<td align="right">
				<?php echo JText::_( "Group" ); ?>
			</td>
			<td>
				<?php echo $this->lists['groups']; ?>
			</td>
    </tr>
		<tr>
			<td align="right">
				<?php echo JText::_( "Teams" ); ?>
			</td>
			<td>
				<?php echo $this->lists['team1']; ?>&nbsp;&nbsp;vs&nbsp;&nbsp;
				<?php echo $this->lists['team2']; ?>
			</td>
    </tr>
		</table>
	</td>
</tr>
</table>

</div>

<input type="hidden" name="option" value="com_worldcup" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="id" value="<?php echo $this->matches->id;?>" />
<input type="hidden" name="uid" value="<?php echo $this->matches->uid;?>" />
<input type="hidden" name="controller" value="matches" />

</form>
