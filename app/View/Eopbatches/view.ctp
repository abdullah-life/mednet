<div class="eopbatches view">
<h2><?php  echo __('Eopbatch'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($eopbatch['Eopbatch']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Eopfileid'); ?></dt>
		<dd>
			<?php echo h($eopbatch['Eopbatch']['eopfileid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Providerlicence'); ?></dt>
		<dd>
			<?php echo h($eopbatch['Eopbatch']['providerlicence']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($eopbatch['Eopbatch']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($eopbatch['Eopbatch']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($eopbatch['Eopbatch']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Eopbatch'), array('action' => 'edit', $eopbatch['Eopbatch']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Eopbatch'), array('action' => 'delete', $eopbatch['Eopbatch']['id']), null, __('Are you sure you want to delete # %s?', $eopbatch['Eopbatch']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Eopbatches'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eopbatch'), array('action' => 'add')); ?> </li>
	</ul>
</div>
