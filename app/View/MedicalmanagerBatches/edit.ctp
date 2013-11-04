<div class="medicalmanagerBatches form">
<?php echo $this->Form->create('MedicalmanagerBatch');?>
	<fieldset>
		<legend><?php echo __('Edit Medicalmanager Batch'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('batch_id');
		echo $this->Form->input('group_id');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('MedicalmanagerBatch.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('MedicalmanagerBatch.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Medicalmanager Batches'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Batches'), array('controller' => 'batches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Batch'), array('controller' => 'batches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
