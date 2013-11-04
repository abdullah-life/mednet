<div class="simpletypes view">
<h2><?php  echo __('Simpletype');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($simpletype['Simpletype']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xmllisting'); ?></dt>
		<dd>
			<?php echo $this->Html->link($simpletype['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $simpletype['Xmllisting']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Claim'); ?></dt>
		<dd>
			<?php echo $this->Html->link($simpletype['Claim']['id'], array('controller' => 'claims', 'action' => 'view', $simpletype['Claim']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Datefrom'); ?></dt>
		<dd>
			<?php echo h($simpletype['Simpletype']['datefrom']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($simpletype['Simpletype']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($simpletype['Simpletype']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h($simpletype['Simpletype']['deleted']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Simpletype'), array('action' => 'edit', $simpletype['Simpletype']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Simpletype'), array('action' => 'delete', $simpletype['Simpletype']['id']), null, __('Are you sure you want to delete # %s?', $simpletype['Simpletype']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Simpletypes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Simpletype'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
