<div class="eopfiles view">
<h2><?php  echo __('Eopfile');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($eopfile['Eopfile']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($eopfile['Eopfile']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($eopfile['Eopfile']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($eopfile['Eopfile']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($eopfile['Eopfile']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Eopfile'), array('action' => 'edit', $eopfile['Eopfile']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Eopfile'), array('action' => 'delete', $eopfile['Eopfile']['id']), null, __('Are you sure you want to delete # %s?', $eopfile['Eopfile']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Eopfiles'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eopfile'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Eopfileentries'), array('controller' => 'eopfileentries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eopfileentry'), array('controller' => 'eopfileentries', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Eopfileentries');?></h3>
	<?php if (!empty($eopfile['Eopfileentry'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Eopfile Id'); ?></th>
		<th><?php echo __('PAYRUN NBR'); ?></th>
		<th><?php echo __('ACCOUNT NUMBER'); ?></th>
		<th><?php echo __('ACCOUNT DESCRIPTION'); ?></th>
		<th><?php echo __('PAYMENT NUMBER'); ?></th>
		<th><?php echo __('PAYMENT EXTERNAL REFERENCE'); ?></th>
		<th><?php echo __('PAYMENT RECEIPT DATE'); ?></th>
		<th><?php echo __('BATCH NUMBER'); ?></th>
		<th><?php echo __('BATCH EXTERNAL REFERENCE'); ?></th>
		<th><?php echo __('BATCH RECEIVED DATE'); ?></th>
		<th><?php echo __('DUE DATE'); ?></th>
		<th><?php echo __('BATCH CLAIMED AMOUNT'); ?></th>
		<th><?php echo __('PAYER CODE'); ?></th>
		<th><?php echo __('PAYER NAME'); ?></th>
		<th><?php echo __('PAYEE CODE'); ?></th>
		<th><?php echo __('PAYEE NAME'); ?></th>
		<th><?php echo __('REPORT NUMBER'); ?></th>
		<th><?php echo __('POLICY NUMBER'); ?></th>
		<th><?php echo __('POLICY HOLDER NAME'); ?></th>
		<th><?php echo __('INSURED MEMBER'); ?></th>
		<th><?php echo __('INSURED MEMBER FIRST NAME'); ?></th>
		<th><?php echo __('INSURED MEMBER FATHER NAME'); ?></th>
		<th><?php echo __('INSURED MEMBER LAST NAME'); ?></th>
		<th><?php echo __('CLAIM TYPE'); ?></th>
		<th><?php echo __('CLAIM NUMBER'); ?></th>
		<th><?php echo __('EXTERNAL INVOICE REF'); ?></th>
		<th><?php echo __('INVOICE REF'); ?></th>
		<th><?php echo __('INVOICE DATE'); ?></th>
		<th><?php echo __('REPORT DATE'); ?></th>
		<th><?php echo __('INV REJECTION REASON CODE'); ?></th>
		<th><?php echo __('INV REJECTION REASON DESC'); ?></th>
		<th><?php echo __('DATE OF SERVICE'); ?></th>
		<th><?php echo __('PROCEDURE TYPE'); ?></th>
		<th><?php echo __('PROCEDURE TYPE DESCRIPTION'); ?></th>
		<th><?php echo __('PROCEDURE CODE'); ?></th>
		<th><?php echo __('PROCEDURE DESCRIPTION'); ?></th>
		<th><?php echo __('DRUG EXTERNAL REFERENCE'); ?></th>
		<th><?php echo __('QUANTITY'); ?></th>
		<th><?php echo __('CLAIMED AMOUNT'); ?></th>
		<th><?php echo __('CORRECTION AMOUNT'); ?></th>
		<th><?php echo __('DISCOUNT AMOUNT'); ?></th>
		<th><?php echo __('DENIED AMOUNT'); ?></th>
		<th><?php echo __('APPROVED AMOUNT'); ?></th>
		<th><?php echo __('INSURED PART'); ?></th>
		<th><?php echo __('INSURER PART'); ?></th>
		<th><?php echo __('PAID PART'); ?></th>
		<th><?php echo __('TAX,PROVIDER CLAIMED AMOUNT'); ?></th>
		<th><?php echo __('INVOICE NOTES'); ?></th>
		<th><?php echo __('INVOICE LINE NOTES'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($eopfile['Eopfileentry'] as $eopfileentry): ?>
		<tr>
			<td><?php echo $eopfileentry['id'];?></td>
			<td><?php echo $eopfileentry['eopfile_id'];?></td>
			<td><?php echo $eopfileentry['PAYRUN_NBR'];?></td>
			<td><?php echo $eopfileentry['ACCOUNT_NUMBER'];?></td>
			<td><?php echo $eopfileentry['ACCOUNT_DESCRIPTION'];?></td>
			<td><?php echo $eopfileentry['PAYMENT_NUMBER'];?></td>
			<td><?php echo $eopfileentry['PAYMENT_EXTERNAL_REFERENCE'];?></td>
			<td><?php echo $eopfileentry['PAYMENT_RECEIPT_DATE'];?></td>
			<td><?php echo $eopfileentry['BATCH_NUMBER'];?></td>
			<td><?php echo $eopfileentry['BATCH_EXTERNAL_REFERENCE'];?></td>
			<td><?php echo $eopfileentry['BATCH_RECEIVED_DATE'];?></td>
			<td><?php echo $eopfileentry['DUE_DATE'];?></td>
			<td><?php echo $eopfileentry['BATCH_CLAIMED_AMOUNT'];?></td>
			<td><?php echo $eopfileentry['PAYER_CODE'];?></td>
			<td><?php echo $eopfileentry['PAYER_NAME'];?></td>
			<td><?php echo $eopfileentry['PAYEE_CODE'];?></td>
			<td><?php echo $eopfileentry['PAYEE_NAME'];?></td>
			<td><?php echo $eopfileentry['REPORT_NUMBER'];?></td>
			<td><?php echo $eopfileentry['POLICY_NUMBER'];?></td>
			<td><?php echo $eopfileentry['POLICY_HOLDER_NAME'];?></td>
			<td><?php echo $eopfileentry['INSURED_MEMBER'];?></td>
			<td><?php echo $eopfileentry['INSURED_MEMBER_FIRST_NAME'];?></td>
			<td><?php echo $eopfileentry['INSURED_MEMBER_FATHER_NAME'];?></td>
			<td><?php echo $eopfileentry['INSURED_MEMBER_LAST_NAME'];?></td>
			<td><?php echo $eopfileentry['CLAIM_TYPE'];?></td>
			<td><?php echo $eopfileentry['CLAIM_NUMBER'];?></td>
			<td><?php echo $eopfileentry['EXTERNAL_INVOICE_REF'];?></td>
			<td><?php echo $eopfileentry['INVOICE_REF'];?></td>
			<td><?php echo $eopfileentry['INVOICE_DATE'];?></td>
			<td><?php echo $eopfileentry['REPORT_DATE'];?></td>
			<td><?php echo $eopfileentry['INV_REJECTION_REASON_CODE'];?></td>
			<td><?php echo $eopfileentry['INV_REJECTION_REASON_DESC'];?></td>
			<td><?php echo $eopfileentry['DATE_OF_SERVICE'];?></td>
			<td><?php echo $eopfileentry['PROCEDURE_TYPE'];?></td>
			<td><?php echo $eopfileentry['PROCEDURE_TYPE_DESCRIPTION'];?></td>
			<td><?php echo $eopfileentry['PROCEDURE_CODE'];?></td>
			<td><?php echo $eopfileentry['PROCEDURE_DESCRIPTION'];?></td>
			<td><?php echo $eopfileentry['DRUG_EXTERNAL_REFERENCE'];?></td>
			<td><?php echo $eopfileentry['QUANTITY'];?></td>
			<td><?php echo $eopfileentry['CLAIMED_AMOUNT'];?></td>
			<td><?php echo $eopfileentry['CORRECTION_AMOUNT'];?></td>
			<td><?php echo $eopfileentry['DISCOUNT_AMOUNT'];?></td>
			<td><?php echo $eopfileentry['DENIED_AMOUNT'];?></td>
			<td><?php echo $eopfileentry['APPROVED_AMOUNT'];?></td>
			<td><?php echo $eopfileentry['INSURED_PART'];?></td>
			<td><?php echo $eopfileentry['INSURER_PART'];?></td>
			<td><?php echo $eopfileentry['PAID_PART'];?></td>
			<td><?php echo $eopfileentry['TAX,PROVIDER_CLAIMED_AMOUNT'];?></td>
			<td><?php echo $eopfileentry['INVOICE_NOTES'];?></td>
			<td><?php echo $eopfileentry['INVOICE_LINE_NOTES'];?></td>
			<td><?php echo $eopfileentry['created'];?></td>
			<td><?php echo $eopfileentry['modified'];?></td>
			<td><?php echo $eopfileentry['status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'eopfileentries', 'action' => 'view', $eopfileentry['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'eopfileentries', 'action' => 'edit', $eopfileentry['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'eopfileentries', 'action' => 'delete', $eopfileentry['id']), null, __('Are you sure you want to delete # %s?', $eopfileentry['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Eopfileentry'), array('controller' => 'eopfileentries', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
