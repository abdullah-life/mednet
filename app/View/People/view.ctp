<div class="people view">
<h2><?php  echo __('Person');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($person['Person']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xmllisting'); ?></dt>
		<dd>
			<?php echo $this->Html->link($person['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $person['Xmllisting']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Claim'); ?></dt>
		<dd>
			<?php echo $this->Html->link($person['Claim']['id'], array('controller' => 'claims', 'action' => 'view', $person['Claim']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nationality'); ?></dt>
		<dd>
			<?php echo h($person['Person']['nationality']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Birthdate'); ?></dt>
		<dd>
			<?php echo h($person['Person']['birthdate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('UUID'); ?></dt>
		<dd>
			<?php echo h($person['Person']['UUID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Visafilenumber'); ?></dt>
		<dd>
			<?php echo h($person['Person']['visafilenumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('N/a'); ?></dt>
		<dd>
			<?php echo h($person['Person']['n/a']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($person['Person']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($person['Person']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($person['Person']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Person'), array('action' => 'edit', $person['Person']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Person'), array('action' => 'delete', $person['Person']['id']), null, __('Are you sure you want to delete # %s?', $person['Person']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List People'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Person'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
