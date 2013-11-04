<div class="medicalreceiverBatches view">
<h2><?php  echo __('Medicalreceiver Batch');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($medicalreceiverBatch['MedicalreceiverBatch']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Batch'); ?></dt>
		<dd>
			<?php echo $this->Html->link($medicalreceiverBatch['Batch']['name'], array('controller' => 'batches', 'action' => 'view', $medicalreceiverBatch['Batch']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($medicalreceiverBatch['Group']['name'], array('controller' => 'groups', 'action' => 'view', $medicalreceiverBatch['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($medicalreceiverBatch['User']['id'], array('controller' => 'users', 'action' => 'view', $medicalreceiverBatch['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($medicalreceiverBatch['MedicalreceiverBatch']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($medicalreceiverBatch['MedicalreceiverBatch']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($medicalreceiverBatch['MedicalreceiverBatch']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Medicalreceiver Batch'), array('action' => 'edit', $medicalreceiverBatch['MedicalreceiverBatch']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Medicalreceiver Batch'), array('action' => 'delete', $medicalreceiverBatch['MedicalreceiverBatch']['id']), null, __('Are you sure you want to delete # %s?', $medicalreceiverBatch['MedicalreceiverBatch']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Medicalreceiver Batches'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Medicalreceiver Batch'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Batches'), array('controller' => 'batches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Batch'), array('controller' => 'batches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
