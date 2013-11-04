<div class="observationmappingfiles view">
<h2><?php  echo __('Observationmappingfile'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($observationmappingfile['Observationmappingfile']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('File Name'); ?></dt>
		<dd>
			<?php echo h($observationmappingfile['Observationmappingfile']['file_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($observationmappingfile['Observationmappingfile']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($observationmappingfile['Observationmappingfile']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($observationmappingfile['Observationmappingfile']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Observationmappingfile'), array('action' => 'edit', $observationmappingfile['Observationmappingfile']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Observationmappingfile'), array('action' => 'delete', $observationmappingfile['Observationmappingfile']['id']), null, __('Are you sure you want to delete # %s?', $observationmappingfile['Observationmappingfile']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Observationmappingfiles'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Observationmappingfile'), array('action' => 'add')); ?> </li>
	</ul>
</div>
