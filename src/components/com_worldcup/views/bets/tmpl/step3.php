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

?>

<section id="content" class="">
<div class="wrapper8">
    <div class="container">
			<div class="row">
				<div class="grid_12">

          <h2>Cuartos de final</h2>

          <form action="<?php echo JRoute::_('index.php?option=com_worldcup&view=bets&layout=step4&cid='.$this->competition->id); ?>" method="post" name="adminForm" onSubmit="submitbutton(); return false;">

          <table width="100%" cellpadding="2" cellspacing="2" border="0" class="wow bounceInDown" id="table1">
          <?php echo $this->printTableHeader(); ?>
          <tbody>
          <?php
            echo $this->printTableRows($this->matches, $this->bets, $this->oldbets);
          ?>
          <tr>
            <td align="center" colspan="8">
              <input type="submit" value="<?php echo JText::_( 'Send' ); ?>" />
            </td>
          </tr>
          </tbody>
          </table>

          </form>

      </div>
		</div>
	</div>
</div>
</section>
