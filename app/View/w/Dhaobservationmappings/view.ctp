<div class="dhaobservationmappings view">
<h2><?php  echo __('Dhaobservationmapping'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($dhaobservationmapping['Dhaobservationmapping']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Activity Type'); ?></dt>
		<dd>
			<?php echo h($dhaobservationmapping['Dhaobservationmapping']['activity_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Activity Code'); ?></dt>
		<dd>
			<?php echo h($dhaobservationmapping['Dhaobservationmapping']['activity_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Observation Code'); ?></dt>
		<dd>
			<?php echo h($dhaobservationmapping['Dhaobservationmapping']['observation_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gross Price'); ?></dt>
		<dd>
			<?php echo h($dhaobservationmapping['Dhaobservationmapping']['gross_price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($dhaobservationmapping['Dhaobservationmapping']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Date'); ?></dt>
		<dd>
			<?php echo h($dhaobservationmapping['Dhaobservationmapping']['start_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($dhaobservationmapping['Dhaobservationmapping']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($dhaobservationmapping['Dhaobservationmapping']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($dhaobservationmapping['Dhaobservationmapping']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Dhaobservationmapping'), array('action' => 'edit', $dhaobservationmapping['Dhaobservationmapping']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Dhaobservationmapping'), array('action' => 'delete', $dhaobservationmapping['Dhaobservationmapping']['id']), null, __('Are you sure you want to delete # %s?', $dhaobservationmapping['Dhaobservationmapping']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Dhaobservationmappings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dhaobservationmapping'), array('action' => 'add')); ?> </li>
	</ul>
</div>
