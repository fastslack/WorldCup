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
                <h2 class="wow bounceInRight"><?php echo $this->competition->name; ?></h2>
                <?php

                  if ($this->competition->created_by == $this->_my->id) {
                    echo '<h4 class="wow bounceInRight">Codigo: <b>'.$this->competition->code.'</b></h4>';
                  }

                ?>
            </div>
        </div>
        <div class="row">
            <div class="grid_12">
                <table id="table1" class="wow bounceInDown">
                    <thead>
                        <tr>
                            <th>nombre & usuario</th>
                            <th>puntos</th>
                            <th>acciones</th>
                        </tr>
                    </thead>
                    <tbody>
<?php

  foreach ($this->competition_users as $key => $user)
  {
    // Check if bets is there
    $betsCount = count($this->_bets->getBetsList($this->competition->id, $user->id));

    if ($betsCount == 64)
    {
      $l = JRoute::_('index.php?option=com_worldcup&view=bets&layout=step7&user_id='.$user->id.'&cid='.$this->competition->id);
      $txt = '<a href="'.$l.'" data-type="submit" class="btn-default">Ver fixture</a>';
    }elseif ($betsCount < 64) {
      $txt = '<a href="#" class="btn-warning">Fixture incompleto</a>';
    }

    if ($this->_my->id == $user->id)
    {
      $l = JRoute::_('index.php?option=com_worldcup&view=bets&cid='.$this->competition->id);
      $txt = $txt . '<br><a href="'.$l.'" data-type="submit" class="btn-default">Crear fixture</a>';
    }

    if ($this->competition->created_by == $this->_my->id && (int)$user->authorised == 1)
    {
      $txt = '<a href="#" data-cid="'.$this->competition->id.'" data-user_id="'.$user->id.'" data-type="submit" class="btn-default auth">autorizar</a>';
      $txt = $txt . '<br><a href="#" data-cid="'.$this->competition->id.'" data-user_id="'.$user->id.'" data-type="submit" class="btn-default revoke">revocar</a>';
    }


 ?>

                        <tr>
                            <td data-title="nombre"><span class="main-text"><?php echo $user->name; ?></span>
                            <span class="secondary-text"><?php echo $user->username; ?></span></td>
                            <td data-title="puntos"><span class="white">0</span></td>
                            <td data-title="acciones"><span class="white"><?php echo $txt; ?></span></td>
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

<script type="text/javascript">
	jQuery(function($, undefined) {

		var url = 'index.php?option=com_worldcup&format=raw&task=ajax.confirmAuth';

    //
  	// Authorization
  	//
  	$('.auth').click(function() {

      var that = $(this);

      url = url + '&cid=' + $(this).data('cid') + '&user_id=' + $(this).data('user_id');

      $.get(url,	function(response) {

        var row_object = JSON.parse(response);

        if (parseInt(row_object.code) == 200) {

          that.text('autorizado').css({
              color: '#6363db'
          });

        }

      });

  		return false;
  	});

    var url1 = 'index.php?option=com_worldcup&format=raw&task=ajax.revokeAuth';

    //
  	// Revoke
  	//
  	$('.revoke').click(function() {

      var that = $(this);

      url1 = url1 + '&cid=' + $(this).data('cid') + '&user_id=' + $(this).data('user_id');

      $.get(url1,	function(response) {

        var row_object = JSON.parse(response);

        if (parseInt(row_object.code) == 200) {

          that.text('revocado').css({
              color: '#6363db'
          });

        }

      });

  		return false;
  	});

    $('.btn-warning').click(function(e) {
        e.preventDefault();
    });

  });
</script>
