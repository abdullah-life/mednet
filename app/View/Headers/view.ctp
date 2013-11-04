<div class="headers view">
<h2><?php  echo __('Header');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($header['Header']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xmllisting'); ?></dt>
		<dd>
			<?php echo $this->Html->link($header['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $header['Xmllisting']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('SenderID'); ?></dt>
		<dd>
			<?php echo h($header['Header']['SenderID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ReceiverID'); ?></dt>
		<dd>
			<?php echo h($header['Header']['ReceiverID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TransactionDate'); ?></dt>
		<dd>
			<?php echo h($header['Header']['TransactionDate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('RecordCount'); ?></dt>
		<dd>
			<?php echo h($header['Header']['RecordCount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('DispositionFlag'); ?></dt>
		<dd>
			<?php echo h($header['Header']['DispositionFlag']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($header['Header']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($header['Header']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($header['Header']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Header'), array('action' => 'edit', $header['Header']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Header'), array('action' => 'delete', $header['Header']['id']), null, __('Are you sure you want to delete # %s?', $header['Header']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Headers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Header'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
	</ul>
</div>
