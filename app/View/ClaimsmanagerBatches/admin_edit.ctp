<div class="claimsmanagerBatches form">
<?php echo $this->Form->create('ClaimsmanagerBatch');?>
	<fieldset>
		<legend><?php echo __('Admin Edit Claimsmanager Batch'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('batch_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ClaimsmanagerBatch.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('ClaimsmanagerBatch.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Claimsmanager Batches'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Batches'), array('controller' => 'batches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Batch'), array('controller' => 'batches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
