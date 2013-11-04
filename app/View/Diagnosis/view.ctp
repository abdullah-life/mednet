<div class="diagnosis view">
<h2><?php  echo __('Diagnosi');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($diagnosi['Diagnosi']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xmllisting'); ?></dt>
		<dd>
			<?php echo $this->Html->link($diagnosi['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $diagnosi['Xmllisting']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Claim'); ?></dt>
		<dd>
			<?php echo $this->Html->link($diagnosi['Claim']['id'], array('controller' => 'claims', 'action' => 'view', $diagnosi['Claim']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($diagnosi['Diagnosi']['Type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($diagnosi['Diagnosi']['Code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($diagnosi['Diagnosi']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($diagnosi['Diagnosi']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($diagnosi['Diagnosi']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Diagnosi'), array('action' => 'edit', $diagnosi['Diagnosi']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Diagnosi'), array('action' => 'delete', $diagnosi['Diagnosi']['id']), null, __('Are you sure you want to delete # %s?', $diagnosi['Diagnosi']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Diagnosis'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Diagnosi'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
