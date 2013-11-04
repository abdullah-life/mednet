<div class="claims form">
<?php echo $this->Form->create('Claim');?>
	<fieldset>
		<legend><?php echo __('Edit Claim'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('xmllisting_id');
		echo $this->Form->input('xmlclaimID');
		echo $this->Form->input('MemberID');
		echo $this->Form->input('PayerID');
		echo $this->Form->input('ProviderID');
		echo $this->Form->input('EmiratesIDNumber');
		echo $this->Form->input('Gross');
		echo $this->Form->input('PatientShare');
		echo $this->Form->input('Net');
		echo $this->Form->input('entry_status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Claim.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Claim.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Claims'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Activities'), array('controller' => 'activities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Activity'), array('controller' => 'activities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Diagnosis'), array('controller' => 'diagnosis', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Diagnosi'), array('controller' => 'diagnosis', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Encounters'), array('controller' => 'encounters', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Encounter'), array('controller' => 'encounters', 'action' => 'add')); ?> </li>
	</ul>
</div>
