<div class="observationMappings view">
<h2><?php  echo __('Observation Mapping'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($observationMapping['ObservationMapping']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($observationMapping['ObservationMapping']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($observationMapping['ObservationMapping']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Value'); ?></dt>
		<dd>
			<?php echo h($observationMapping['ObservationMapping']['value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Value Type'); ?></dt>
		<dd>
			<?php echo h($observationMapping['ObservationMapping']['value_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start'); ?></dt>
		<dd>
			<?php echo h($observationMapping['ObservationMapping']['start']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($observationMapping['ObservationMapping']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($observationMapping['ObservationMapping']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($observationMapping['ObservationMapping']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Observation Mapping'), array('action' => 'edit', $observationMapping['ObservationMapping']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Observation Mapping'), array('action' => 'delete', $observationMapping['ObservationMapping']['id']), null, __('Are you sure you want to delete # %s?', $observationMapping['ObservationMapping']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Observation Mappings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Observation Mapping'), array('action' => 'add')); ?> </li>
	</ul>
</div>
