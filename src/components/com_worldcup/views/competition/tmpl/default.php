<section id="content" class="">
<div class="wrapper8">
    <div class="container">
			<div class="row">
				<div class="grid_12">
				    <h2>crear una nueva competición</h2>

						<form id="contact-form" action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="form-validate form-horizontal well">
							<fieldset>

                <label class="name">
                    <input name="name" id="" type="text" style="border: 1px dotted #313030;">
                    <span class="empty-message">*This field is required.</span>
                <span class="_placeholder" style="left: 0px; top: 0px; width: 360px; height: 34px;">Nombre de la competición:</span></label>

								<div class="control-group">
									<div class="controls">
                    <br />
                    <a href="javascript:{}" class="btn-default" onclick="document.getElementById('contact-form').submit(); return false;"><?php echo JText::_('JSUBMIT'); ?></a>
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


    $('.datepicker').datepicker();

  });

</script>
