<div class="xmls view">
<h2><?php  echo __('Xml'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($xml['Xml']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($xml['User']['id'], array('controller' => 'users', 'action' => 'view', $xml['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($xml['Xml']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xmlstatus'); ?></dt>
		<dd>
			<?php echo h($xml['Xml']['xmlstatus']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($xml['Xml']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($xml['Xml']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($xml['Xml']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Xml'), array('action' => 'edit', $xml['Xml']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Xml'), array('action' => 'delete', $xml['Xml']['id']), null, __('Are you sure you want to delete # %s?', $xml['Xml']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Xmls'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xml'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
