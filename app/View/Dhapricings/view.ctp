<div class="dhapricings view">
<h2><?php  echo __('Dhapricing'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($dhapricing['Dhapricing']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Providerdetail Id'); ?></dt>
		<dd>
			<?php echo h($dhapricing['Dhapricing']['providerdetail_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Date'); ?></dt>
		<dd>
			<?php echo h($dhapricing['Dhapricing']['start_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($dhapricing['Dhapricing']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($dhapricing['Dhapricing']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($dhapricing['Dhapricing']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($dhapricing['Dhapricing']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($dhapricing['Dhapricing']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Dhapricing'), array('action' => 'edit', $dhapricing['Dhapricing']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Dhapricing'), array('action' => 'delete', $dhapricing['Dhapricing']['id']), null, __('Are you sure you want to delete # %s?', $dhapricing['Dhapricing']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Dhapricings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dhapricing'), array('action' => 'add')); ?> </li>
	</ul>
</div>
