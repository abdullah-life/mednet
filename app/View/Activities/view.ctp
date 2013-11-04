<div class="activities view">
<h2><?php  echo __('Activity');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($activity['Activity']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xmllisting'); ?></dt>
		<dd>
			<?php echo $this->Html->link($activity['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $activity['Xmllisting']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Claim'); ?></dt>
		<dd>
			<?php echo $this->Html->link($activity['Claim']['id'], array('controller' => 'claims', 'action' => 'view', $activity['Claim']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Activity Id'); ?></dt>
		<dd>
			<?php echo h($activity['Activity']['activity_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start'); ?></dt>
		<dd>
			<?php echo h($activity['Activity']['start']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($activity['Activity']['Type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($activity['Activity']['Code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Quantity'); ?></dt>
		<dd>
			<?php echo h($activity['Activity']['Quantity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Net'); ?></dt>
		<dd>
			<?php echo h($activity['Activity']['Net']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Clinician'); ?></dt>
		<dd>
			<?php echo h($activity['Activity']['Clinician']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('PriorAuthorizationID'); ?></dt>
		<dd>
			<?php echo h($activity['Activity']['PriorAuthorizationID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($activity['Activity']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($activity['Activity']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($activity['Activity']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Activity'), array('action' => 'edit', $activity['Activity']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Activity'), array('action' => 'delete', $activity['Activity']['id']), null, __('Are you sure you want to delete # %s?', $activity['Activity']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Activities'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Activity'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Observations'), array('controller' => 'observations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Observation'), array('controller' => 'observations', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Observations');?></h3>
	<?php if (!empty($activity['Observation'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Xmllisting Id'); ?></th>
		<th><?php echo __('Claim Id'); ?></th>
		<th><?php echo __('Activity Id'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Value'); ?></th>
		<th><?php echo __('ValueType'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($activity['Observation'] as $observation): ?>
		<tr>
			<td><?php echo $observation['id'];?></td>
			<td><?php echo $observation['xmllisting_id'];?></td>
			<td><?php echo $observation['claim_id'];?></td>
			<td><?php echo $observation['activity_id'];?></td>
			<td><?php echo $observation['Type'];?></td>
			<td><?php echo $observation['Code'];?></td>
			<td><?php echo $observation['Value'];?></td>
			<td><?php echo $observation['ValueType'];?></td>
			<td><?php echo $observation['created'];?></td>
			<td><?php echo $observation['modified'];?></td>
			<td><?php echo $observation['status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'observations', 'action' => 'view', $observation['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'observations', 'action' => 'edit', $observation['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'observations', 'action' => 'delete', $observation['id']), null, __('Are you sure you want to delete # %s?', $observation['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Observation'), array('controller' => 'observations', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
