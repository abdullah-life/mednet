
<div class="icd10toicd9cmmappings form">
<?php echo $this->Form->create('Icd10toicd9cmmapping',array('type'=>'file'));?>
	<fieldset>
		<legend><?php echo __('Add New File'); ?></legend>
	<?php
		echo $this->Form->input('file',array('type'=>'file'));
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

