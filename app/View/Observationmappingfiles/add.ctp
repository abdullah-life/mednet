<div class="observationmappingfiles form">
<?php echo $this->Form->create('Observationmappingfile'); ?>
	<fieldset>
		<legend><?php echo __('Add Observationmappingfile'); ?></legend>
	<?php
		echo $this->Form->input('file_name');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Observationmappingfiles'), array('action' => 'index')); ?></li>
	</ul>
</div>
