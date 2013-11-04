<div class="contracts view">
<h2><?php  echo __('Contract');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xmllisting'); ?></dt>
		<dd>
			<?php echo $this->Html->link($contract['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $contract['Xmllisting']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Claim'); ?></dt>
		<dd>
			<?php echo $this->Html->link($contract['Claim']['id'], array('controller' => 'claims', 'action' => 'view', $contract['Claim']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Renewaldate'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['renewaldate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Startdate'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['startdate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Expirydate'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['expirydate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Grosspremium'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['grosspremium']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Packagename'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['packagename']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Starttype'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['starttype']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($contract['Contract']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Contract'), array('action' => 'edit', $contract['Contract']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Contract'), array('action' => 'delete', $contract['Contract']['id']), null, __('Are you sure you want to delete # %s?', $contract['Contract']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Contracts'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contract'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
