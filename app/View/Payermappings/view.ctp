<div class="payermappings view">
<h2><?php  echo __('Payermapping');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($payermapping['Payermapping']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Classification'); ?></dt>
		<dd>
			<?php echo h($payermapping['Payermapping']['classification']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Auth No Haad'); ?></dt>
		<dd>
			<?php echo h($payermapping['Payermapping']['auth_no_haad']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Company Name'); ?></dt>
		<dd>
			<?php echo h($payermapping['Payermapping']['company_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Auth No Dubai'); ?></dt>
		<dd>
			<?php echo h($payermapping['Payermapping']['auth_no_dubai']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($payermapping['Payermapping']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($payermapping['Payermapping']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($payermapping['Payermapping']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Payermapping'), array('action' => 'edit', $payermapping['Payermapping']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Payermapping'), array('action' => 'delete', $payermapping['Payermapping']['id']), null, __('Are you sure you want to delete # %s?', $payermapping['Payermapping']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Payermappings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Payermapping'), array('action' => 'add')); ?> </li>
	</ul>
</div>
