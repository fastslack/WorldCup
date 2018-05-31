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

$return = 'index.php?option=com_worldcup&view=competitions';
?>
<style>
#competition-form input[type="text"] {
    width: 100%;
    border-radius: 0;
    line-height: 20px;
    font-size: 14px;
    font-family: "Roboto", sans-serif;
    color: #5e5e5e;
    padding: 7px 10px;
    outline: none;
    height: 34px;
    border: none;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    margin: 0;
    -webkit-appearance: none;
    background: #202020;
}
</style>
<section id="content" class="">
<div class="wrapper8">
    <div class="container">
			<div class="row">
				<div class="grid_12">
				    <h2>crear una nueva competición</h2>

						<form id="competition-form" action="<?php echo JRoute::_('index.php?option=com_worldcup&task=competition.save'); ?>" method="post" class="form-validate form-horizontal well">
							<fieldset>

                <label class="name">
                    <span class="_placeholder" style="left: 0px; top: 0px; width: 360px; height: 34px;">Nombre de la competición:</span>
                    <input name="name" id="" type="text" style="border: 1px dotted #313030;" required="required">
                    <span class="empty-message">* Este valor es requerido.</span>
                </label>

								<div class="control-group">
									<div class="controls">
                    <br />
                    <a href="javascript:{}" class="btn-default" onclick="document.getElementById('competition-form').submit(); return false;"><?php echo JText::_('JSUBMIT'); ?></a>
									</div>
								</div>

								<input type="hidden" name="return" value="<?php echo base64_encode($return); ?>" />
								<?php echo JHtml::_('form.token'); ?>
							</fieldset>
						</form>

          </div>
     </div>
  </div>
</div>
</section>

<script>

	$(function() {

    $('#competition-form').validate({
        rules: {
            name: {
                required: true
            }
        }
    });
/*
    $('input,textarea').focus(function(){
       $('._placeholder').hide();
    });
*/
    //$('.datepicker').datepicker();

  });

</script>
