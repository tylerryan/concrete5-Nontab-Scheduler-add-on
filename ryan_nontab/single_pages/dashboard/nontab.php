<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<h1><span><?php echo t('Nontab Schedule Settings')?></span></h1>
<div class="ccm-dashboard-inner">
	<form method="post" action="<?php echo $this->action('save_settings')?>" id="ccm-nontab-settings-form">
	<h2><?php echo $form->checkbox('NONTAB_ENABLED', 1, $nontab_enabled)?> <span><?php echo t('Enabled')?></span></h2>
	<h2><span><?php  echo t('Run Maintenance Jobs Every')?></span></h2>
	<div style="line-height:26px">
		<?php echo $form->text('NONTAB_VALUE',$nontab_value,array('size'=>'3'))?>
		<?php echo $form->select('NONTAB_UNIT',$unit_values, $nontab_unit)?>
	</div>
    <div class="ccm-buttons">
	<a href="javascript:void(0)" onclick="$('#ccm-nontab-settings-form').get(0).submit()" class="ccm-button-right accept"><span><?php echo t('Update Settings')?></span></a>
	</div>
    <div class="ccm-spacer">&nbsp;</div>
	</form>
</div>