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
defined('_JEXEC') or die('Restricted access');

$version = "v{$this->version}";

?>
<link rel="stylesheet" href="components/com_worldcup/css/worldcup.css" type="text/css" />
<table class="cpanel_about">
<tr class="cpanel_about">
	<td width="65%" valign="top" class="cpanel_about">
    <table width="100%" class="cpanel_icon">
    <tr class="cpanel_icon">
    	<td align="center" height="100px" width="20%" class="cpanel_icon">
        	<a href="index.php?option=com_worldcup&amp;view=tournaments" style="text-decoration:none;">
            	<img src="components/com_worldcup/images/soccer_3_48.png" align="middle" border="0"/><br />
							<?php echo JText::_( 'Tournaments' ); ?>
            </a>
        </td>
        <td align="center" height="100px" width="20%" class="cpanel_icon">
            <a href="index.php?option=com_worldcup&amp;view=users" style="text-decoration:none;">
            	<img src="components/com_worldcup/images/subscribers.png" align="middle" border="0" />
            	<br />
            	<?php echo JText::_( "Users") ;?>
            	</a>
        </td>
        <td align="center" height="100px" width="20%" class="cpanel_icon">
            <a href="index.php?option=com_worldcup&amp;view=places" style="text-decoration:none;">
            	<img src="components/com_worldcup/images/soccer_4_48.png" align="middle" border="0" />
            	<br />
            	<?php echo JText::_( "Places") ;?>
            	</a>
        </td>
        <td align="center" height="100px" width="20%" class="cpanel_icon">
            <a href="index.php?option=com_worldcup&amp;view=groups" style="text-decoration:none;">
            	<img src="components/com_worldcup/images/soccer_2_48.png" align="middle" border="0" />
            	<br />
            	<?php echo JText::_( "Groups") ;?>
            	</a>
        </td>
	    	<td align="center" height="100px" width="20%" class="cpanel_icon">
        	<a href="index.php?option=com_worldcup&amp;view=teams" style="text-decoration:none;">
            	<img src="components/com_worldcup/images/soccer_5_48.png" align="middle" border="0"/><br />
				<?php echo JText::_( 'Teams' ); ?>
            </a>
        </td>
	</tr>
    <tr class="cpanel_icon">
    	<td align="center" height="100px" class="cpanel_icon">
        	<a href="index.php?option=com_worldcup&amp;view=matches" style="text-decoration:none;">
            	<img src="components/com_worldcup/images/soccer_1_48.png" align="middle" border="0"/><br />
				<?php echo JText::_( 'Matches' ); ?>
            </a>
        </td>
	    	<td align="center" height="100px" class="cpanel_icon">
        	<a href="index.php?option=com_worldcup&amp;view=results" style="text-decoration:none;">
            	<img src="components/com_worldcup/images/statistics.png" align="middle" border="0"/><br />
				<?php echo JText::_( 'Results' ); ?>
            </a>
        </td>
	    	<td align="center" height="100px" class="cpanel_icon">
        	<a href="index.php?option=com_worldcup&amp;view=bets" style="text-decoration:none;">
            	<img src="components/com_worldcup/images/soccer_6_48.png" align="middle" border="0"/><br />
				<?php echo JText::_( 'Bets' ); ?>
            </a>
        </td>
	    	<td align="center" height="100px" class="cpanel_icon">
        	<a href="index.php?option=com_worldcup&amp;view=score" style="text-decoration:none;">
            	<img src="components/com_worldcup/images/statistics.png" align="middle" border="0"/><br />
				<?php echo JText::_( 'Score' ); ?>
            </a>
        </td>
        <td align="center" height="100px" class="cpanel_icon">
            <a href="http://matware.com.ar/foros/world-cup.html" style="text-decoration:none;">
            	<img src="components/com_worldcup/images/support.png" align="middle" border="0" />
            	<br />
            	<?php echo JText::_( "Support") ;?>
            	</a>
        </td>
    </tr>
	</tr>
    </table>
      </td>
      <td width="50%" valign="top" align="center">
      <table border="1" width="100%" class="cpanel_about">
         <tr class="cpanel_about">
            <th class="cpanel" colspan="2">WorldCup Component</th></td>
         </tr>
         <tr class="cpanel_about">
					<td bgcolor="#FFFFFF" colspan="2" align="center">
						<br />
						<div align="center">
							<img width="200" src="components/com_worldcup/images/logo-copa-brasil.jpg" align="middle" alt="worldcup Logo"/>
							<br />
						</div>
				  </td>
				</tr>
         <tr class="cpanel_about">
            <td width="120" bgcolor="#FFFFFF"><?php echo JText::_( "Installed version:") ;?></td>
            <td bgcolor="#FFFFFF"><?php echo $version;?></td>
         </tr>
         <tr class="cpanel_about">
            <td colspan="2" bgcolor="#FFFFFF"><?php echo JText::_( "") ;?></td>
         </tr>
      </table>
      </td>
   </tr>
</table>

