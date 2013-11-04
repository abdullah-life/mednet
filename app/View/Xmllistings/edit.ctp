<div class="xmls form">
<?php echo $this->Form->create('Xml'); ?>
	<fieldset>
		<legend><?php echo __('Edit Xml'); ?></legend>
	<?php
		echo $this->Form->input('id');
		  echo $this->Upload->edit('name', $this->Form->fields['Xml.id']);
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<?php     echo $this->element('logo'); ?>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Xml.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Xml.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Xmls'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
