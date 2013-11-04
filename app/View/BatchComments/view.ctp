<div class="batchComments view">
<h2><?php  echo __('Batch Comment');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($batchComment['BatchComment']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Batch'); ?></dt>
		<dd>
			<?php echo $this->Html->link($batchComment['Batch']['name'], array('controller' => 'batches', 'action' => 'view', $batchComment['Batch']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($batchComment['User']['id'], array('controller' => 'users', 'action' => 'view', $batchComment['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($batchComment['Group']['name'], array('controller' => 'groups', 'action' => 'view', $batchComment['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo h($batchComment['BatchComment']['comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($batchComment['BatchComment']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($batchComment['BatchComment']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($batchComment['BatchComment']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Batch Comment'), array('action' => 'edit', $batchComment['BatchComment']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Batch Comment'), array('action' => 'delete', $batchComment['BatchComment']['id']), null, __('Are you sure you want to delete # %s?', $batchComment['BatchComment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Batch Comments'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Batch Comment'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Batches'), array('controller' => 'batches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Batch'), array('controller' => 'batches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
