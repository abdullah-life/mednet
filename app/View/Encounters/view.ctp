<div class="encounters view">
<h2><?php  echo __('Encounter');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($encounter['Encounter']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xmllisting'); ?></dt>
		<dd>
			<?php echo $this->Html->link($encounter['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $encounter['Xmllisting']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Claim'); ?></dt>
		<dd>
			<?php echo $this->Html->link($encounter['Claim']['id'], array('controller' => 'claims', 'action' => 'view', $encounter['Claim']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('FacilityID'); ?></dt>
		<dd>
			<?php echo h($encounter['Encounter']['FacilityID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($encounter['Encounter']['Type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('PatientID'); ?></dt>
		<dd>
			<?php echo h($encounter['Encounter']['PatientID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start'); ?></dt>
		<dd>
			<?php echo h($encounter['Encounter']['Start']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('End'); ?></dt>
		<dd>
			<?php echo h($encounter['Encounter']['End']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('EndType'); ?></dt>
		<dd>
			<?php echo h($encounter['Encounter']['EndType']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($encounter['Encounter']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($encounter['Encounter']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($encounter['Encounter']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Encounter'), array('action' => 'edit', $encounter['Encounter']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Encounter'), array('action' => 'delete', $encounter['Encounter']['id']), null, __('Are you sure you want to delete # %s?', $encounter['Encounter']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Encounters'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Encounter'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
