<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?=Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Nontab Schedule Settings'), false, false, false);?>
<form method="post" action="<?php echo $this->action('save_settings')?>" id="ccm-nontab-settings-form" class="form-stacked">
<div class="ccm-pane-body">	
	<fieldset>
	<div class="clearfix">
		<div class="input">
		<ul class="inputs-list">
			<li><label><?php echo $form->checkbox('NONTAB_ENABLED', 1, $nontab_enabled)?> <span><?php echo t('Enabled')?></span></label></li>
		</ul>
		</div>
	</div>	
	<div class="clearfix">
		<label><?php  echo t('Run Maintenance Jobs Every')?></label>
		<div class="input">
			<?php echo $form->text('NONTAB_VALUE',$nontab_value,array('class'=>'span2'))?>
			<?php echo $form->select('NONTAB_UNIT',$unit_values, $nontab_unit, array('class'=>'span2'))?>
		</div>
	</div>
    </fieldset>
</div>
<div class="ccm-pane-footer">
	<?php echo $concrete_interface->submit(t('Save'),'ccm-nontab-settings-form', 'right', 'primary')?>
</div>
</form>
<?=Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false);?>