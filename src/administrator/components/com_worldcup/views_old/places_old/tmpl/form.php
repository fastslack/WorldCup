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
			<td width="30%" align="right">
				<?php echo JText::_( "Name" ); ?>
			</td>
			<td>
				<input type="text" size="55" name="name" value="<?php echo $this->place->name;?>" />
			</td>
    </tr>
		</table>
	</td>
</tr>
</table>

</div>

<input type="hidden" name="option" value="com_worldcup" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="id" value="<?php echo $this->place->id;?>" />
<input type="hidden" name="tid" value="<?php echo $this->tid; ?>" />
<input type="hidden" name="controller" value="places" />

</form>
