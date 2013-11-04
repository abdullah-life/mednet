<div class="denialtables form">
<?php echo $this->Form->create('Denialtable'); ?>
	<fieldset>
		<legend><?php echo __('Add Denialtable'); ?></legend>
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

		<li><?php echo $this->Html->link(__('List Denialtables'), array('action' => 'index')); ?></li>
	</ul>
</div>
