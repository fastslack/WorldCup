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

// No direct access to this file
defined('_JEXEC') or die;

$score = $this->score;
$usersnames = $this->usersnames;

?>
<section id="content" class="">
<div class="wrapper8">
    <div class="container">
			<div class="row">
				<div class="grid_12">

          <h2>Tabla de posiciones</h2>

          <table width="100%" cellpadding="2" cellspacing="2" border="0" class="wow bounceInDown" id="table1">
            <thead>
        			<tr>
        				<th><?php echo JText::_( "User" ); ?></td>
        				<th><?php echo JText::_( "Points" ); ?></td>
        			</tr>
        		</thead>
        		<?php
        			for ($i=0;$i<count($score);$i++){
        				if($score[$i]->count == 64) {
        		?>
        		<tbody>
        		<tr class="odd">
        			<td><a href="<?php echo JRoute::_( 'index.php?option=com_worldcup&view=details&id='.$usersnames[$score[$i]->uid]->id ); ?>"><?php echo $usersnames[$score[$i]->uid]->name; ?></a></td>
        			<td><?php echo $score[$i]->points; ?></td>
        		<?php
        				}
        			}
        		?>

        		</tbody>
          </table>

      </div>
		</div>
	</div>
</div>
</section>
