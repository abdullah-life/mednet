<div class="payerslists view">
<h2><?php  echo __('Payerslist'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($payerslist['Payerslist']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Insurance Company'); ?></dt>
		<dd>
			<?php echo h($payerslist['Payerslist']['insurance_company']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Eclaimlinkid'); ?></dt>
		<dd>
			<?php echo h($payerslist['Payerslist']['eclaimlinkid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Haad'); ?></dt>
		<dd>
			<?php echo h($payerslist['Payerslist']['haad']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($payerslist['Payerslist']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($payerslist['Payerslist']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($payerslist['Payerslist']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Payerslist'), array('action' => 'edit', $payerslist['Payerslist']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Payerslist'), array('action' => 'delete', $payerslist['Payerslist']['id']), null, __('Are you sure you want to delete # %s?', $payerslist['Payerslist']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Payerslists'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Payerslist'), array('action' => 'add')); ?> </li>
	</ul>
</div>
