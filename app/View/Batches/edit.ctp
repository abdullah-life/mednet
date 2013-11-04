<div class="batches form">
<?php echo $this->Form->create('Batch');?>
	<fieldset>
		<legend><?php echo __('Edit Batch'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<?php     echo $this->element('logo'); ?>
	<ul>

		
	</ul>
</div>
