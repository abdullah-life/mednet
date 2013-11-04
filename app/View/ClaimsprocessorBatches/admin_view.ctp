<div class="claimsprocessorBatches view">
<h2><?php  echo __('Claimsprocessor Batch');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($claimsprocessorBatch['ClaimsprocessorBatch']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Batch'); ?></dt>
		<dd>
			<?php echo $this->Html->link($claimsprocessorBatch['Batch']['name'], array('controller' => 'batches', 'action' => 'view', $claimsprocessorBatch['Batch']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($claimsprocessorBatch['Group']['name'], array('controller' => 'groups', 'action' => 'view', $claimsprocessorBatch['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($claimsprocessorBatch['ClaimsprocessorBatch']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($claimsprocessorBatch['ClaimsprocessorBatch']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($claimsprocessorBatch['ClaimsprocessorBatch']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Claimsprocessor Batch'), array('action' => 'edit', $claimsprocessorBatch['ClaimsprocessorBatch']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Claimsprocessor Batch'), array('action' => 'delete', $claimsprocessorBatch['ClaimsprocessorBatch']['id']), null, __('Are you sure you want to delete # %s?', $claimsprocessorBatch['ClaimsprocessorBatch']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Claimsprocessor Batches'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claimsprocessor Batch'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Batches'), array('controller' => 'batches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Batch'), array('controller' => 'batches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
