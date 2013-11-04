<div class="resubmissions view">
<h2><?php  echo __('Resubmission');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($resubmission['Resubmission']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Claim'); ?></dt>
		<dd>
			<?php echo $this->Html->link($resubmission['Claim']['id'], array('controller' => 'claims', 'action' => 'view', $resubmission['Claim']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($resubmission['Resubmission']['Type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo h($resubmission['Resubmission']['Comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Attachment'); ?></dt>
		<dd>
			<?php echo h($resubmission['Resubmission']['Attachment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($resubmission['Resubmission']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($resubmission['Resubmission']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($resubmission['Resubmission']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Resubmission'), array('action' => 'edit', $resubmission['Resubmission']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Resubmission'), array('action' => 'delete', $resubmission['Resubmission']['id']), null, __('Are you sure you want to delete # %s?', $resubmission['Resubmission']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Resubmissions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Resubmission'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
