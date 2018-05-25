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
// no direct access
defined('_JEXEC') or die('Restricted access');

$teams = $this->teams;
$bets = $this->bets;
$oldbets = $this->oldbets;
$matches = $this->matches;
?>

<section id="content" class="">
<div class="wrapper8">
    <div class="container">
			<div class="row">
				<div class="grid_12">

          <h2>Final</h2>

          <form action="index.php?option=com_worldcup&amp;view=bets&amp;layout=step7" method="post" name="adminForm" onSubmit="submitbutton(); return false;">

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
