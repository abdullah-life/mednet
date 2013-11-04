<div class="claimsmanagerBatches view">
<h2><?php  echo __('Claimsmanager Batch');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($claimsmanagerBatch['ClaimsmanagerBatch']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Batch'); ?></dt>
		<dd>
			<?php echo $this->Html->link($claimsmanagerBatch['Batch']['name'], array('controller' => 'batches', 'action' => 'view', $claimsmanagerBatch['Batch']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($claimsmanagerBatch['User']['id'], array('controller' => 'users', 'action' => 'view', $claimsmanagerBatch['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($claimsmanagerBatch['ClaimsmanagerBatch']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($claimsmanagerBatch['ClaimsmanagerBatch']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($claimsmanagerBatch['ClaimsmanagerBatch']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Claimsmanager Batch'), array('action' => 'edit', $claimsmanagerBatch['ClaimsmanagerBatch']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Claimsmanager Batch'), array('action' => 'delete', $claimsmanagerBatch['ClaimsmanagerBatch']['id']), null, __('Are you sure you want to delete # %s?', $claimsmanagerBatch['ClaimsmanagerBatch']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Claimsmanager Batches'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claimsmanager Batch'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Batches'), array('controller' => 'batches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Batch'), array('controller' => 'batches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
