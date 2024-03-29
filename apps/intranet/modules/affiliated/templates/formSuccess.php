<script type="text/javascript" src="/sfFormExtraPlugin/js/double_list.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
  $("#fancybox-manual-b").click(function()
  {
    $.fancybox.open({
      href : '<?php echo url_for($url_register_videos) ?>',
      type : 'iframe',
      padding : 5,
      afterClose: function () {
       jQuery.ajax({
        type: 'GET',
        url: '<?php echo url_for($url_get_videos) ?>',
        success: function(data) { $('#videos').html(data); }
       });
      }
    });
  });
  //
  $("#fancybox-manual-c").click(function()
  {
    $.fancybox.open({
      height: '290px',
      href : '<?php echo url_for("@google_drive") ?>?theme=1',
      type : 'iframe',
      padding : 5,
      afterClose: function () {
       jQuery.ajax({
        type: 'GET',
        url: '<?php echo url_for($url_document) ?>',
        success: function(data) { $('#drive').html(data); }
       });
      }
    });
  });
});
</script>
<?php
	$str_module = $sf_params->get('module');
	$str_action = $sf_params->get('action');
	$request_id = $id ?  "?id=$id" : '';
?>
<div class="content">
  <div class="rightside">
		<div class="paneles" style="text-align:center;">
			<img src="/<?php echo $logo ? 'uploads/company/'.$logo : 'images/no_image.jpg' ?>" border="0" width="150" height="150"/>
		</div>
	</div>
	<div class="leftside" style="margin-left:260px;">
		<div class="mapa">
			<a href="<?php echo url_for('home/index') ?>"><strong><?php echo __('Home') ?></strong></a>
			&nbsp;&gt;&nbsp;
			<a href="<?php echo url_for('affiliated/index') ?>"><strong><?php echo __('Empresas Participadas') ?></strong></a>
			&nbsp;&gt;&nbsp;
			<?php echo __(ucfirst($str_action)) ?>
		</div>
		<?php if ($form->hasErrors()): ?>
			<div class="mensajeSistema error">
				<ul>
					<?php foreach($form->getFormFieldSchema() as $name=>$formField) { if ($formField->getError()) { echo '<li>'.$formField->getError().'</li>'; } } ?>
				</ul>
			</div>
		<?php endif; ?>
		<?php if ($sf_user->hasFlash('success_participada')): ?>
			<div class="mensajeSistema ok"><?php echo $sf_user->getFlash('success_participada') ?></div>
		<?php endif; ?>
		<h1 class="titulos">
			<?php echo __(ucfirst($str_action)).' '.__('Empresas Participadas') ?>
		</h1>
		<form enctype="multipart/form-data" method="post" action="<?php echo url_for('@'.$str_module.'-'.$str_action.$request_id) ?>">
      <label class="lineaListados"><?php echo __('Mandatory fields') ?>&nbsp;(*)</label><br />
			<fieldset>
	      <table width="100%" cellspacing="4" cellpadding="0" border="0">
	        <tr>
	          <td style="width:60%;">
	            <table width="100%" cellspacing="4" cellpadding="0" border="0">
	              <tr>
	                <td width="10%"><label><?php echo __('Date') ?> *</label></td>
	                <td><?php echo $form['date'] ?></td>
	              </tr>
	              <tr>
	                <td><label><?php echo __('Name') ?> *</label></td>
	                <td><?php echo $form['name'] ?></td>
	              </tr>
	              <tr>
	                <td><label><?php echo __('Phone') ?></label></td>
	                <td><?php echo $form['phone'] ?></td>
	              </tr>
	              <tr>
	                <td><label><?php echo __('Skype') ?></label></td>
	                <td><?php echo $form['skype'] ?></td>
	              </tr>
	              <tr>
	                <td><label><?php echo __('Logo') ?></label></td>
	                <td valign="middle">
	                  <input type="file" name="logo" class="form_input"/>
	                  <?php if ($logo): ?>
	                  	<input type="checkbox" name="reset_logo" style="vertical-align:middle;margin-left:10px;"/>&nbsp;<label><?php echo __('Check to delete') ?></label>
	                  <?php endif; ?>
	                </td>
	              </tr>
	              <tr><td height="15"></td></tr>
	              <tr>
	                <td><label>Cuenta de Basecamp</label></td>
	                <td><?php echo $form['basecamp_id'] ?></td>
	              </tr>
	              <tr><td height="15"></td></tr>
	              <tr>
	                <td width="6%"><label><?php echo __('Socios Representantes') ?></label></td>
	                <td><?php echo $form['contacts'] ?></td>
	              </tr>
                      <tr>
                        <td width="6%"><label><?php echo __('Productos') ?></label></td>
                        <td><?php echo $form['product'] ?></td>
                      </tr>
	            </table>
	          </td>
            <td valign="top">
              <fieldset>
                <legend>&nbsp;CEO&nbsp;</legend>
                <table width="100%" cellspacing="4" cellpadding="0" border="0">
                  <tr>
                    <td width="10%"><label><?php echo __('Name') ?></label></td>
                    <td><?php echo $form['contact_first_name'] ?></td>
                  </tr>
                  <tr>
                    <td width="6%"><label><?php echo __('Last name') ?></label></td>
                    <td><?php echo $form['contact_last_name'] ?></td>
                  </tr>
                  <tr>
                    <td width="10%"><label><?php echo __('Phone') ?></label></td>
                    <td><?php echo $form['contact_phone'] ?></td>
                  </tr>
                  <tr>    
                    <td width="6%"><label><?php echo __('Email') ?></label></td>
                    <td><?php echo $form['contact_email'] ?></td>
                  </tr>
                </table>
              </fieldset>
            </td>
          </tr>
        </table>
        <table width="100%" cellspacing="4" cellpadding="0" border="0">
          <tr><td style="height:15px;"></td></tr>
        	<tr><td colspan="2"><label>Descripción</label></td></tr>
          <tr><td colspan="2"><?php echo $form['description'] ?></td></tr>
          <tr>
	          <td width="17%">
	            <a id="fancybox-manual-b">
	              <img src="/images/video.jpeg" border="0" width="50" title="Ingresar video"  style="cursor:pointer;vertical-align:middle;"/>
	              <span style="cursor:pointer;font-size:14px;">Ingresar video</span>
	            </a>
	          </td>
	          <td>
	            <a id="fancybox-manual-c">
	              <img src="/images/drive.jpeg" border="0" width="60" title="Ingresar documento" style="cursor:pointer;vertical-align:middle;"/>
	              <span style="cursor:pointer;font-size:14px;">Ingresar documento</span>
	            </a>
	          </td>
	        </tr>    
	        </table>
	        <div id="videos"><?php include_component('affiliated', 'getVideos') ?></div>
	        <div id="drive"><?php include_component('affiliated', 'getDocument') ?></div>
       	</fieldset>
        <div style="padding-top:10px;" class="botonera">
            <input type="button" onclick="document.location='<?php echo url_for($str_module.'/index') ?>';" value="<?php echo __('Cancel') ?>" class="boton" />
            <?php if($id): ?>
                <input type="button" onclick="document.location='<?php echo url_for('@'.$str_module.'-show?id='.$id) ?>';" value="<?php echo __('See') ?>" class="boton" />
            <?php endif; ?>
            <input type="submit" name="btn_action" value="<?php echo __('Register') ?>" class="boton" id="btn_action"/>
            <?php echo $form->renderHiddenFields() ?>
        </div>
     	</form>
		</div>
		<div class="clear"></div>
</div>