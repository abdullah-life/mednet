<div class="denialtables view">
<h2><?php  echo __('Denialtable'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($denialtable['Denialtable']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('File Name'); ?></dt>
		<dd>
			<?php echo h($denialtable['Denialtable']['file_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($denialtable['Denialtable']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($denialtable['Denialtable']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($denialtable['Denialtable']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Denialtable'), array('action' => 'edit', $denialtable['Denialtable']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Denialtable'), array('action' => 'delete', $denialtable['Denialtable']['id']), null, __('Are you sure you want to delete # %s?', $denialtable['Denialtable']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Denialtables'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Denialtable'), array('action' => 'add')); ?> </li>
	</ul>
</div>
