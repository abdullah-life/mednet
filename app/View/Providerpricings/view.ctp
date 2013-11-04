<div class="providerpricings view">
<h2><?php  echo __('Providerpricing');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($providerpricing['Providerpricing']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Providerdetail'); ?></dt>
		<dd>
			<?php echo $this->Html->link($providerpricing['Providerdetail']['id'], array('controller' => 'providerdetails', 'action' => 'view', $providerpricing['Providerdetail']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($providerpricing['Providerpricing']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gross Price'); ?></dt>
		<dd>
			<?php echo h($providerpricing['Providerpricing']['gross_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Discount'); ?></dt>
		<dd>
			<?php echo h($providerpricing['Providerpricing']['discount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Date'); ?></dt>
		<dd>
			<?php echo h($providerpricing['Providerpricing']['start_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($providerpricing['Providerpricing']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($providerpricing['Providerpricing']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h($providerpricing['Providerpricing']['deleted']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Providerpricing'), array('action' => 'edit', $providerpricing['Providerpricing']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Providerpricing'), array('action' => 'delete', $providerpricing['Providerpricing']['id']), null, __('Are you sure you want to delete # %s?', $providerpricing['Providerpricing']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Providerpricings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Providerpricing'), array('action' => 'add')); ?> </li>
		
	</ul>
</div>
