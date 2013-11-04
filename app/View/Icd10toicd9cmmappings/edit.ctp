<div class="icd10toicd9cmmappings form">
<?php echo $this->Form->create('Icd10toicd9cmmapping');?>
	<fieldset>
		<legend><?php echo __('Edit Icd10toicd9cmmapping'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('icd_10');
		echo $this->Form->input('icd9_cm');
		echo $this->Form->input('status_code');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Icd10toicd9cmmapping.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Icd10toicd9cmmapping.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Icd10toicd9cmmappings'), array('action' => 'index'));?></li>
	</ul>
</div>
