<div class="eopbatches form">
<?php echo $this->Form->create('Eopbatch'); ?>
	<fieldset>
		<legend><?php echo __('Add Eopbatch'); ?></legend>
	<?php
		echo $this->Form->input('eopfileid');
		echo $this->Form->input('providerlicence');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Eopbatches'), array('action' => 'index')); ?></li>
	</ul>
</div>
