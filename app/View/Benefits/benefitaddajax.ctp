<div class="benefits form">
<?php echo $this->Form->create('Benefit');?>
	<fieldset>
		<legend><?php echo __('Add Benefit'); ?></legend>
	<?php
		echo $this->Form->input('CRITERION_NBR',array('label'=> 'CriterionNbr'));
		echo $this->Form->input('LOCAL_DESCRIPTION',array('label'=> 'LocalDscrptn'));
		echo $this->Form->input('BENEFIT',array('label'=> 'Benefit'));
		echo $this->Form->input('TYPE',array('label'=> 'Type'));
		echo $this->Form->input('CODE',array('label'=> 'Code'));
		echo $this->Form->input('LOCAL_DESCRIPTION_1',array('label'=> 'LocalDscrptn'));
		echo $this->Form->input('ADDITIONAL CRITERIA',array('label'=> 'AdditionalCriteria'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<style>
	input[type="submit"]{
		margin-left:257px;
	}
	input{
		margin-left:43px;
	}
	.benefits{
		margin-right:40px;
	}
</style>
