<div class="eopfileentries form">
<?php echo $this->Form->create('Eopfileentry');?>
	<fieldset>
		<legend><?php echo __('Edit Eopfileentry'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('eopfile_id');
		echo $this->Form->input('payment_run');
		echo $this->Form->input('account_number');
		echo $this->Form->input('account_description');
		echo $this->Form->input('payment_number');
		echo $this->Form->input('payment_external_reference');
		echo $this->Form->input('payment_receipt_date');
		echo $this->Form->input('batch_number');
		echo $this->Form->input('batch_external_reference');
		echo $this->Form->input('batch_received_date');
		echo $this->Form->input('due_date');
		echo $this->Form->input('batch_claimed_amount');
		echo $this->Form->input('payer_code');
		echo $this->Form->input('payer_name');
		echo $this->Form->input('payee_code');
		echo $this->Form->input('payee_name');
		echo $this->Form->input('report_number');
		echo $this->Form->input('policy_number');
		echo $this->Form->input('policy_holder_name');
		echo $this->Form->input('insured_number');
		echo $this->Form->input('insured_member_first_name');
		echo $this->Form->input('insured_member_father_name');
		echo $this->Form->input('insured_member_last_name');
		echo $this->Form->input('claim_type');
		echo $this->Form->input('claim_number');
		echo $this->Form->input('external_invoice_ref');
		echo $this->Form->input('invoice_ref');
		echo $this->Form->input('invoice_date');
		echo $this->Form->input('report_date');
		echo $this->Form->input('inv_rejection_reason_code');
		echo $this->Form->input('inv_rejection_reason_desc');
		echo $this->Form->input('date_of_service');
		echo $this->Form->input('procedure_type');
		echo $this->Form->input('procedure_type_description');
		echo $this->Form->input('procedure_code');
		echo $this->Form->input('procedure_description');
		echo $this->Form->input('external_reference');
		echo $this->Form->input('quantity');
		echo $this->Form->input('claimed_amount');
		echo $this->Form->input('correction_amount');
		echo $this->Form->input('discount_amount');
		echo $this->Form->input('denied_amount');
		echo $this->Form->input('approved_amount');
		echo $this->Form->input('insured_part');
		echo $this->Form->input('insurer_part');
		echo $this->Form->input('paid_part');
		echo $this->Form->input('tax');
		echo $this->Form->input('provider_claimed_amount');
		echo $this->Form->input('invoice_notes');
		echo $this->Form->input('invoice_line_notes');
		echo $this->Form->input('indicator1');
		echo $this->Form->input('indicator2');
		echo $this->Form->input('indicator3');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Eopfileentry.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Eopfileentry.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Eopfileentries'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Eopfiles'), array('controller' => 'eopfiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eopfile'), array('controller' => 'eopfiles', 'action' => 'add')); ?> </li>
	</ul>
</div>
