<div class="eopfiles form">
<?php echo $this->Form->create('Eopfile');?>
	<fieldset>
		<legend><?php echo __('Add Eopfile'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Eopfiles'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Eopfileentries'), array('controller' => 'eopfileentries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eopfileentry'), array('controller' => 'eopfileentries', 'action' => 'add')); ?> </li>
	</ul>
</div>
