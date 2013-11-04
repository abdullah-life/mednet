<div class="batches view">

<h2 style="width:100%;clear:right"><?php  echo __('Batch');?></h2>

<br/>

	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($batch['Batch']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($batch['Batch']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Provider Id'); ?></dt>
		<dd>
			<?php echo h($batch['Batch']['provider_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($batch['Batch']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($batch['Batch']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($batch['Batch']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Batch'), array('action' => 'edit', $batch['Batch']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Batch'), array('action' => 'delete', $batch['Batch']['id']), null, __('Are you sure you want to delete # %s?', $batch['Batch']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Batches'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Batch'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
	</ul>
</div>
