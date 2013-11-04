<div class="denialcodes view">
<h2><?php  echo __('Denialcode'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($denialcode['Denialcode']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice Note'); ?></dt>
		<dd>
			<?php echo h($denialcode['Denialcode']['invoice_note']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Denial Code'); ?></dt>
		<dd>
			<?php echo h($denialcode['Denialcode']['denial_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($denialcode['Denialcode']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($denialcode['Denialcode']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Denialcode'), array('action' => 'edit', $denialcode['Denialcode']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Denialcode'), array('action' => 'delete', $denialcode['Denialcode']['id']), null, __('Are you sure you want to delete # %s?', $denialcode['Denialcode']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Denialcodes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Denialcode'), array('action' => 'add')); ?> </li>
	</ul>
</div>
