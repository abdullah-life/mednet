<style>
    
    .input label {
    float: left;
    font-size: 13px;
    height: 30px;
    line-height: 20px;
    margin-right: 20px;
    padding-left: 5px;
    text-align: left;
    width: 300px;
}
   </style> 
<div class="globalsettings form">
<?php echo $this->Form->create('Globalsetting');?>
	<fieldset>
		<legend><?php echo __('Edit Globalsetting'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('ROUND_OFF_INTEGERS');
		echo $this->Form->input('TRUNCATE_MEMBER_ID');
		echo $this->Form->input('DIAGNOSTIC_CODE_MAPPING');
		echo $this->Form->input('DENTAL_CODE_MAPPING');
		echo $this->Form->input('DRUG_CODE_MAPPING');
		echo $this->Form->input('CLINICIAN_CODE_MAPPING');
		echo $this->Form->input('DENIAL_REASON');
		echo $this->Form->input('PAYER_CODE_MAPPING');
		echo $this->Form->input('PROVIDER_CODE_MAPPING');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Globalsetting.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Globalsetting.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Globalsettings'), array('action' => 'index'));?></li>
	</ul>
</div>
