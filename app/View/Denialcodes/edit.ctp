<div class="denialcodes form">
<?php echo $this->Form->create('Denialcode'); ?>
	<fieldset>
		<legend><?php echo __('Edit Denialcode'); ?></legend>
	<?php
		//echo $this->Form->input('id');
		echo $this->Form->input('Code',array('value' => $denialvalues['Denialcode']['Code']));
		echo $this->Form->input('Description',array('value' => $denialvalues['Denialcode']['Description']));
		echo $this->Form->input('Exmpdesc',array('value' => $denialvalues['Denialcode']['Examples/Descriptions']));
		echo $this->Form->input('Status',array('value' => $denialvalues['Denialcode']['Status']));
		echo $this->Form->input('Type',array('value' => $denialvalues['Denialcode']['Type']));
		echo $this->Form->input('location',array('type' => 'select','selected' => $denialvalues['Denialcode']['location'],'options' => array('0' => 'HAAD','1' => 'DHA')));
		echo $this->Form->input('Effective',array('value' => $denialvalues['Denialcode']['Effective']));
		echo $this->Form->input('Expired',array('value' => $denialvalues['Denialcode']['Expired']));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Denialcode.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Denialcode.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Denialcodes'), array('action' => 'index')); ?></li>
	</ul>
</div>
