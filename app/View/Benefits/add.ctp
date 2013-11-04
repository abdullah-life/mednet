<div class="benefits form">
<?php echo $this->Form->create('Benefit');?>
	<fieldset>
		<legend><?php echo __('Add Benefit'); ?></legend>
	<?php
		echo $this->Form->input('CRITERION_NBR',array('label'=> 'Criterion Nbr'));
		echo $this->Form->input('LOCAL_DESCRIPTION',array('label'=> 'Local Dscrptn'));
		echo $this->Form->input('BENEFIT',array('label'=> 'Benefit'));
		echo $this->Form->input('TYPE',array('label'=> 'Type'));
		echo $this->Form->input('CODE',array('label'=> 'Code'));
		echo $this->Form->input('LOCAL_DESCRIPTION_1',array('label'=> 'Local Dscrptn'));
		echo $this->Form->input('ADDITIONAL CRITERIA',array('label'=> 'Additional Criteria'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Benefits'), array('action' => 'index'));?></li>
	</ul>
</div>
