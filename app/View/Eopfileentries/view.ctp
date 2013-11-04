<div class="eopfileentries view">
<h2><?php  echo __('Eopfileentry');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Eopfile'); ?></dt>
		<dd>
			<?php echo $this->Html->link($eopfileentry['Eopfile']['name'], array('controller' => 'eopfiles', 'action' => 'view', $eopfileentry['Eopfile']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment Run'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['payment_run']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Account Number'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['account_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Account Description'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['account_description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment Number'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['payment_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment External Reference'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['payment_external_reference']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment Receipt Date'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['payment_receipt_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Batch Number'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['batch_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Batch External Reference'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['batch_external_reference']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Batch Received Date'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['batch_received_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Due Date'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['due_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Batch Claimed Amount'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['batch_claimed_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payer Code'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['payer_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payer Name'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['payer_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payee Code'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['payee_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payee Name'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['payee_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Report Number'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['report_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Policy Number'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['policy_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Policy Holder Name'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['policy_holder_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Insured Number'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['insured_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Insured Member First Name'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['insured_member_first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Insured Member Father Name'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['insured_member_father_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Insured Member Last Name'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['insured_member_last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Claim Type'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['claim_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Claim Number'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['claim_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('External Invoice Ref'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['external_invoice_ref']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice Ref'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['invoice_ref']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice Date'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['invoice_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Report Date'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['report_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Inv Rejection Reason Code'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['inv_rejection_reason_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Inv Rejection Reason Desc'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['inv_rejection_reason_desc']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Of Service'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['date_of_service']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Procedure Type'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['procedure_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Procedure Type Description'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['procedure_type_description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Procedure Code'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['procedure_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Procedure Description'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['procedure_description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('External Reference'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['external_reference']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Quantity'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['quantity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Claimed Amount'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['claimed_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Correction Amount'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['correction_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Discount Amount'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['discount_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Denied Amount'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['denied_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Approved Amount'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['approved_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Insured Part'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['insured_part']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Insurer Part'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['insurer_part']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Paid Part'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['paid_part']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tax'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['tax']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Provider Claimed Amount'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['provider_claimed_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice Notes'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['invoice_notes']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Invoice Line Notes'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['invoice_line_notes']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Indicator1'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['indicator1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Indicator2'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['indicator2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Indicator3'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['indicator3']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($eopfileentry['Eopfileentry']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Eopfileentry'), array('action' => 'edit', $eopfileentry['Eopfileentry']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Eopfileentry'), array('action' => 'delete', $eopfileentry['Eopfileentry']['id']), null, __('Are you sure you want to delete # %s?', $eopfileentry['Eopfileentry']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Eopfileentries'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eopfileentry'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Eopfiles'), array('controller' => 'eopfiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eopfile'), array('controller' => 'eopfiles', 'action' => 'add')); ?> </li>
	</ul>
</div>
