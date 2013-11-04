<div class="batches view">
<h2><?php  echo __('Batch');?></h2>
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
<div class="related">
	<h3><?php echo __('Related Xmllistings');?></h3>
	<?php if (!empty($batch['Xmllisting'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Place'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Xml Url'); ?></th>
		<th><?php echo __('Xmlstatus'); ?></th>
		<th><?php echo __('Cronstatus'); ?></th>
		<th><?php echo __('Xml Header'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($batch['Xmllisting'] as $xmllisting): ?>
		<tr>
			<td><?php echo $xmllisting['id'];?></td>
			<td><?php echo $xmllisting['user_id'];?></td>
			<td><?php echo $xmllisting['place'];?></td>
			<td><?php echo $xmllisting['name'];?></td>
			<td><?php echo $xmllisting['xml_url'];?></td>
			<td><?php echo $xmllisting['xmlstatus'];?></td>
			<td><?php echo $xmllisting['cronstatus'];?></td>
			<td><?php echo $xmllisting['xml_header'];?></td>
			<td><?php echo $xmllisting['created'];?></td>
			<td><?php echo $xmllisting['modified'];?></td>
			<td><?php echo $xmllisting['status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'xmllistings', 'action' => 'view', $xmllisting['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'xmllistings', 'action' => 'edit', $xmllisting['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'xmllistings', 'action' => 'delete', $xmllisting['id']), null, __('Are you sure you want to delete # %s?', $xmllisting['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
