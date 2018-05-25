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
<div class="wrapper6">
    <div class="container">
        <div class="row">
            <div class="grid_12">
                <h2 class="wow bounceInRight">competiciones</h2>
            </div>
        </div>
        <div class="row">
            <div class="grid_12">
                <table id="table1" class="wow bounceInDown">
                    <thead>
                        <tr>
                            <th>nombre</th>
                            <th>termina</th>
                            <th>creador</th>
                            <th>cantidad de miembros</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
<?php

  foreach ($this->competitions as $key => $competition)
  {
 ?>

                        <tr>
                            <td data-title="tournament"><a href="#"><span class="main-text"><?php echo $competition->name; ?></span></a>
                            <span class="secondary-text"><?php echo $competition->tname; ?></span></td>
                            <td data-title="ends"><span class="white">25d</span></td>
                            <td data-title="entry"><span class="white"><?php echo $competition->uname; ?></span></td>
                            <td data-title="casino"><a href="#"><span class="white"><?php echo $this->_competitions->getCompetitionCount($competition->id); ?></span></a></td>
                            <td><span class="white"></span></td>
                        </tr>
<?php
  }
 ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</section>
