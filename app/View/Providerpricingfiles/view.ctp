<div class="providerpricingfiles view">
<h2><?php  echo __('Providerpricingfile');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($providerpricingfile['Providerpricingfile']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($providerpricingfile['Providerpricingfile']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($providerpricingfile['Providerpricingfile']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($providerpricingfile['Providerpricingfile']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($providerpricingfile['Providerpricingfile']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Providerpricingfile'), array('action' => 'edit', $providerpricingfile['Providerpricingfile']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Providerpricingfile'), array('action' => 'delete', $providerpricingfile['Providerpricingfile']['id']), null, __('Are you sure you want to delete # %s?', $providerpricingfile['Providerpricingfile']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Providerpricingfiles'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Providerpricingfile'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Providerpricings'), array('controller' => 'providerpricings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Providerpricing'), array('controller' => 'providerpricings', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Providerpricings');?></h3>
	<?php if (!empty($providerpricingfile['Providerpricing'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Providerpricingfile Id'); ?></th>
		<th><?php echo __('Providerdetail Id'); ?></th>
		<th><?php echo __('Acitvity'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Servicedescription'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Gross'); ?></th>
		<th><?php echo __('Discount'); ?></th>
		<th><?php echo __('Discountprice'); ?></th>
		<th><?php echo __('Start Date'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Deleted'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($providerpricingfile['Providerpricing'] as $providerpricing): ?>
		<tr>
			<td><?php echo $providerpricing['id'];?></td>
			<td><?php echo $providerpricing['providerpricingfile_id'];?></td>
			<td><?php echo $providerpricing['providerdetail_id'];?></td>
			<td><?php echo $providerpricing['acitvity'];?></td>
			<td><?php echo $providerpricing['code'];?></td>
			<td><?php echo $providerpricing['servicedescription'];?></td>
			<td><?php echo $providerpricing['type'];?></td>
			<td><?php echo $providerpricing['gross'];?></td>
			<td><?php echo $providerpricing['discount'];?></td>
			<td><?php echo $providerpricing['discountprice'];?></td>
			<td><?php echo $providerpricing['start_date'];?></td>
			<td><?php echo $providerpricing['created'];?></td>
			<td><?php echo $providerpricing['modified'];?></td>
			<td><?php echo $providerpricing['deleted'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'providerpricings', 'action' => 'view', $providerpricing['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'providerpricings', 'action' => 'edit', $providerpricing['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'providerpricings', 'action' => 'delete', $providerpricing['id']), null, __('Are you sure you want to delete # %s?', $providerpricing['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<ul>
		<li><?php echo $this->Html->link(__('New Providerpricing'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Provider Details'), array('controller'=>'providerpricings','action' => 'index')); ?></li>
	</ul>
</div>
