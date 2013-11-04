<div class="observations view">
<h2><?php  echo __('Observation');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($observation['Observation']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xmllisting'); ?></dt>
		<dd>
			<?php echo $this->Html->link($observation['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $observation['Xmllisting']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Claim'); ?></dt>
		<dd>
			<?php echo $this->Html->link($observation['Claim']['id'], array('controller' => 'claims', 'action' => 'view', $observation['Claim']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($observation['Observation']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($observation['Observation']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Value'); ?></dt>
		<dd>
			<?php echo h($observation['Observation']['value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Valuetype'); ?></dt>
		<dd>
			<?php echo h($observation['Observation']['valuetype']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($observation['Observation']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($observation['Observation']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($observation['Observation']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Observation'), array('action' => 'edit', $observation['Observation']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Observation'), array('action' => 'delete', $observation['Observation']['id']), null, __('Are you sure you want to delete # %s?', $observation['Observation']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Observations'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Observation'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
