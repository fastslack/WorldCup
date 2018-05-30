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
                            <?php if ($this->_my->id) {  echo "<th>Acciones</th>"; } ?>
                        </tr>
                    </thead>
                    <tbody>
<?php

  foreach ($this->competitions as $key => $competition)
  {
    if (!empty($this->_my->id))
    {
      $checkAuth = (int) $this->_competitions->checkAuth($competition->id, $this->_my->id);

      if ($checkAuth == 1)
      {
        $link = '<span class="main-text" style="color: #6363db;">autorizacion enviada</span>';
        $title = '<span class="main-text">'.$competition->name.'</span>';
      }
      else if ($checkAuth == 2)
      {
        $l = JRoute::_('index.php?option=com_worldcup&view=competition&layout=show&id='.$competition->id);
        $link = '<a id="" href="'.$l.'" class="btn-default" style="color: #e07e00;">autorizado</a>';
        $title = '<a href="'.$l.'"><span class="main-text">'.$competition->name.'</span></a>';
      }
      else
      {
        $link = '<a href="#" data-cid="'.$competition->id.'" data-type="submit" class="btn-default auth">pedir autorización</a>';
        $title = '<span class="main-text">'.$competition->name.'</span>';
      }
    }
    else
    {
      $title = '<span class="main-text">'.$competition->name.'</span>';
    }

 ?>

                        <tr>
                            <td data-title="nombre">
                              <?php echo $title; ?>
                              <span class="secondary-text"><?php echo $competition->tname; ?></span>
                            </td>
                            <td data-title="termina"><span class="white">25d</span></td>
                            <td data-title="creador"><span class="white"><?php echo $competition->uname; ?></span></td>
                            <td data-title="cantidad de miembros" align="center"><a href="#"><span class="white"><?php echo $this->_competitions->getCompetitionCount($competition->id); ?></span></a></td>

<?php
  if (!empty($this->_my->id)) {
?>
                            <td data-title="acciones">
                              <?php echo $link; ?>&nbsp;&nbsp;&nbsp;
                            </td>
<?php  } ?>
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

		var url = 'index.php?option=com_worldcup&format=raw&task=ajax.requestAuth';

    //
  	// Authorization
  	//
  	$('.auth').click(function() {

      var that = $(this);

      console.log(that.data('cid'));

      url = url + '&cid=' + $(this).data('cid');
console.log(url);
      $.get(url,	function(response) {

        console.log(response);

        var row_object = JSON.parse(response);

console.log(row_object);

        if (parseInt(row_object.code) == 200) {

          that.text('autorizacion enviada').css({
              color: '#6363db'
          });

        }


      });


  		return false;
  	});



  });
</script>
