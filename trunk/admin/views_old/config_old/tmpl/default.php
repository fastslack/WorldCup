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
JHTML::_('behavior.tooltip');

//print_r($this);

?>
<link rel="stylesheet" href="components/com_worldcup/css/worldcup.css" type="text/css" />
<form action="index.php" method="post" name="adminForm">
<div id="editcell">

<table border="0" width="100%">
<tr>
	<td width="50%" valign="top">

	<table class="adminlist">
	<tr>
		<td colspan="2">
			<h3><?php echo JText::_( "Global Settings" ); ?></h3>
		</td>
	</tr>
  <tr>
      <td align="right">
			<?php
				echo JHTML::tooltip( JText::_( "Title" ),
						 JText::_( "Title" ), '', JText::_( "Title" ), '');
			?>
      </td>
      <td>
          <input type="text" name="title" size="50" value="<?php echo $this->items['title'];?>" />
      </td>
  </tr>
  <tr>
      <td align="right">
			<?php
				echo JHTML::tooltip( JText::_( "Disable frontend bets" ),
						 JText::_( "Disable frontend bets" ), '', JText::_( "Disable frontend bets" ), '');
			?>
      </td>
      <td>
					<input type="checkbox" name="disable" value="1" <?php echo $this->items['disable'] ? 'checked' : '';?>/>
      </td>
  </tr>
  <tr>
      <td align="right">
			<?php
				echo JHTML::tooltip( JText::_( "Exact match points" ),
						 JText::_( "Exact match points" ), '', JText::_( "Exact match points" ), '');
			?>
      </td>
      <td>
          <input type="text" name="exactmatch" size="2" value="<?php echo $this->items['exactmatch'];?>" />
      </td>
  </tr>
  <tr>
      <td align="right">
			<?php
				echo JHTML::tooltip( JText::_( "Simple match points" ),
						 JText::_( "Simple match points" ), '', JText::_( "Simple match points" ), '');
			?>
      </td>
      <td>
          <input type="text" name="simplematch" size="2" value="<?php echo $this->items['simplematch'];?>" />
      </td>
  </tr>
  <tr>
      <td align="right">
			<?php
				echo JHTML::tooltip( JText::_( "Equal match potins" ),
						 JText::_( "Equal match potins" ), '', JText::_( "Equal match potins" ), '');
			?>
      </td>
      <td>
          <input type="text" name="equalmatch" size="2" value="<?php echo $this->items['equalmatch'];?>" />
      </td>
  </tr>
  <tr>
      <td align="right">
			<?php
				echo JHTML::tooltip( JText::_( "Exact match points for second phase" ),
						 JText::_( "Exact match points for second phase" ), '', JText::_( "Exact match points for second phase" ), '');
			?>
      </td>
      <td>
          <input type="text" name="exactmatch2" size="2" value="<?php echo $this->items['exactmatch2'];?>" />
      </td>
  </tr>
  <tr>
      <td align="right">
			<?php
				echo JHTML::tooltip( JText::_( "Simple match points for second phase" ),
						 JText::_( "Simple match points for second phase" ), '', JText::_( "Simple match points for second phase" ), '');
			?>
      </td>
      <td>
          <input type="text" name="simplematch2" size="2" value="<?php echo $this->items['simplematch2'];?>" />
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
<input type="hidden" name="controller" value="config" />

</form>

