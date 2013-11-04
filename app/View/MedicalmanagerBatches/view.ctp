<div class="medicalmanagerBatches view">
<h2><?php  echo __('Medicalmanager Batch');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($medicalmanagerBatch['MedicalmanagerBatch']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Batch'); ?></dt>
		<dd>
			<?php echo $this->Html->link($medicalmanagerBatch['Batch']['name'], array('controller' => 'batches', 'action' => 'view', $medicalmanagerBatch['Batch']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($medicalmanagerBatch['Group']['name'], array('controller' => 'groups', 'action' => 'view', $medicalmanagerBatch['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($medicalmanagerBatch['MedicalmanagerBatch']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($medicalmanagerBatch['MedicalmanagerBatch']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($medicalmanagerBatch['MedicalmanagerBatch']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Medicalmanager Batch'), array('action' => 'edit', $medicalmanagerBatch['MedicalmanagerBatch']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Medicalmanager Batch'), array('action' => 'delete', $medicalmanagerBatch['MedicalmanagerBatch']['id']), null, __('Are you sure you want to delete # %s?', $medicalmanagerBatch['MedicalmanagerBatch']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Medicalmanager Batches'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Medicalmanager Batch'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Batches'), array('controller' => 'batches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Batch'), array('controller' => 'batches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
