<div class="haadobservationmappings view">
<h2><?php  echo __('Haadobservationmapping'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($haadobservationmapping['Haadobservationmapping']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Activity Type'); ?></dt>
		<dd>
			<?php echo h($haadobservationmapping['Haadobservationmapping']['activity_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Activity Code'); ?></dt>
		<dd>
			<?php echo h($haadobservationmapping['Haadobservationmapping']['activity_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Observation Code'); ?></dt>
		<dd>
			<?php echo h($haadobservationmapping['Haadobservationmapping']['observation_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gross Price'); ?></dt>
		<dd>
			<?php echo h($haadobservationmapping['Haadobservationmapping']['gross_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($haadobservationmapping['Haadobservationmapping']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Date'); ?></dt>
		<dd>
			<?php echo h($haadobservationmapping['Haadobservationmapping']['start_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($haadobservationmapping['Haadobservationmapping']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($haadobservationmapping['Haadobservationmapping']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($haadobservationmapping['Haadobservationmapping']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Haadobservationmapping'), array('action' => 'edit', $haadobservationmapping['Haadobservationmapping']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Haadobservationmapping'), array('action' => 'delete', $haadobservationmapping['Haadobservationmapping']['id']), null, __('Are you sure you want to delete # %s?', $haadobservationmapping['Haadobservationmapping']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Haadobservationmappings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Haadobservationmapping'), array('action' => 'add')); ?> </li>
	</ul>
</div>
