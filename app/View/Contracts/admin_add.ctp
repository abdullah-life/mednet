<div class="contracts form">
<?php echo $this->Form->create('Contract');?>
	<fieldset>
		<legend><?php echo __('Admin Add Contract'); ?></legend>
	<?php
		echo $this->Form->input('xmllisting_id');
		echo $this->Form->input('claim_id');
		echo $this->Form->input('renewaldate');
		echo $this->Form->input('startdate');
		echo $this->Form->input('expirydate');
		echo $this->Form->input('grosspremium');
		echo $this->Form->input('packagename');
		echo $this->Form->input('starttype');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Contracts'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
