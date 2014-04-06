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

?>
<link rel="stylesheet" href="components/com_worldcup/css/worldcup.css" type="text/css" />
<script language="javascript">
/*
	function submitbutton(pressbutton)
	{
		var form = document.adminForm;

		if (form.name.value == ""){
			alert( "<?php echo JText::_( 'Team must have a name', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	
	}
*/
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
			<td width="30%" align="right">
				<?php echo JText::_( "Tournament" ); ?>
			</td>
			<td>
				<?php echo $this->lists['tournaments']; ?>
			</td>
    </tr>
		<tr>
			<td width="40%"  align="right">
				<?php echo JText::_( "Name" ); ?>
			</td>
			<td>
				<input type="text" name="name" value="<?php echo $this->teams->name;?>" />
			</td>
    </tr>
		<tr>
			<td align="right">
				<?php echo JText::_( "Assign to group" ); ?>
			</td>
			<td>
				<?php echo $this->lists['groups']; ?>
			</td>
    </tr>
		</table>
	</td>
</tr>
</table>

</div>

<input type="hidden" name="option" value="com_worldcup" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="id" value="<?php echo $this->teams->id;?>" />
<input type="hidden" name="uid" value="<?php echo $this->teams->uid;?>" />
<input type="hidden" name="controller" value="teams" />

</form>
