<div class="providerpricings form" >
<?php echo $this->Form->create('Payermapping' ,array('type' => 'file'));?>
	<fieldset>
		<legend><?php echo __('Add Payer mapping'); ?></legend>
	<?php
		
		
		echo $this->Form->input('mappings',array('type'=>'file'));
                
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	
</div>
