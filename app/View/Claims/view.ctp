<div class="claims view">
<h2><?php  echo __('Claim');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($claim['Claim']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xmllisting'); ?></dt>
		<dd>
			<?php echo $this->Html->link($claim['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $claim['Xmllisting']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('XmlclaimID'); ?></dt>
		<dd>
			<?php echo h($claim['Claim']['xmlclaimID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('MemberID'); ?></dt>
		<dd>
			<?php echo h($claim['Claim']['MemberID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('PayerID'); ?></dt>
		<dd>
			<?php echo h($claim['Claim']['PayerID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ProviderID'); ?></dt>
		<dd>
			<?php echo h($claim['Claim']['ProviderID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('EmiratesIDNumber'); ?></dt>
		<dd>
			<?php echo h($claim['Claim']['EmiratesIDNumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gross'); ?></dt>
		<dd>
			<?php echo h($claim['Claim']['Gross']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('PatientShare'); ?></dt>
		<dd>
			<?php echo h($claim['Claim']['PatientShare']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Net'); ?></dt>
		<dd>
			<?php echo h($claim['Claim']['Net']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($claim['Claim']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($claim['Claim']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Entry Status'); ?></dt>
		<dd>
			<?php echo h($claim['Claim']['entry_status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Claim'), array('action' => 'edit', $claim['Claim']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Claim'), array('action' => 'delete', $claim['Claim']['id']), null, __('Are you sure you want to delete # %s?', $claim['Claim']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php echo __('Related Activities');?></h3>
	<?php if (!empty($claim['Activity'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Xmllisting Id'); ?></th>
		<th><?php echo __('Claim Id'); ?></th>
		<th><?php echo __('Start'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Quantity'); ?></th>
		<th><?php echo __('Net'); ?></th>
		<th><?php echo __('Clinician'); ?></th>
		<th><?php echo __('PriorAuthorizationID'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($claim['Activity'] as $activity): ?>
		<tr>
			<td><?php echo $activity['id'];?></td>
			<td><?php echo $activity['xmllisting_id'];?></td>
			<td><?php echo $activity['claim_id'];?></td>
			<td><?php echo $activity['start'];?></td>
			<td><?php echo $activity['type'];?></td>
			<td><?php echo $activity['Code'];?></td>
			<td><?php echo $activity['Quantity'];?></td>
			<td><?php echo $activity['Net'];?></td>
			<td><?php echo $activity['Clinician'];?></td>
			<td><?php echo $activity['PriorAuthorizationID'];?></td>
			<td><?php echo $activity['created'];?></td>
			<td><?php echo $activity['modified'];?></td>
			<td><?php echo $activity['status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'activities', 'action' => 'view', $activity['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'activities', 'action' => 'edit', $activity['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'activities', 'action' => 'delete', $activity['id']), null, __('Are you sure you want to delete # %s?', $activity['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Activity'), array('controller' => 'activities', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Diagnosis');?></h3>
	<?php if (!empty($claim['Diagnosi'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Xmllisting Id'); ?></th>
		<th><?php echo __('Claim Id'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($claim['Diagnosi'] as $diagnosi): ?>
		<tr>
			<td><?php echo $diagnosi['id'];?></td>
			<td><?php echo $diagnosi['xmllisting_id'];?></td>
			<td><?php echo $diagnosi['claim_id'];?></td>
			<td><?php echo $diagnosi['Type'];?></td>
			<td><?php echo $diagnosi['Code'];?></td>
			<td><?php echo $diagnosi['created'];?></td>
			<td><?php echo $diagnosi['modified'];?></td>
			<td><?php echo $diagnosi['status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'diagnosis', 'action' => 'view', $diagnosi['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'diagnosis', 'action' => 'edit', $diagnosi['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'diagnosis', 'action' => 'delete', $diagnosi['id']), null, __('Are you sure you want to delete # %s?', $diagnosi['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Diagnosi'), array('controller' => 'diagnosis', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Encounters');?></h3>
	<?php if (!empty($claim['Encounter'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Xmllisting Id'); ?></th>
		<th><?php echo __('Claim Id'); ?></th>
		<th><?php echo __('FacilityID'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('PatientID'); ?></th>
		<th><?php echo __('Start'); ?></th>
		<th><?php echo __('End'); ?></th>
		<th><?php echo __('EndType'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($claim['Encounter'] as $encounter): ?>
		<tr>
			<td><?php echo $encounter['id'];?></td>
			<td><?php echo $encounter['xmllisting_id'];?></td>
			<td><?php echo $encounter['claim_id'];?></td>
			<td><?php echo $encounter['FacilityID'];?></td>
			<td><?php echo $encounter['Type'];?></td>
			<td><?php echo $encounter['PatientID'];?></td>
			<td><?php echo $encounter['Start'];?></td>
			<td><?php echo $encounter['End'];?></td>
			<td><?php echo $encounter['EndType'];?></td>
			<td><?php echo $encounter['created'];?></td>
			<td><?php echo $encounter['modified'];?></td>
			<td><?php echo $encounter['status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'encounters', 'action' => 'view', $encounter['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'encounters', 'action' => 'edit', $encounter['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'encounters', 'action' => 'delete', $encounter['id']), null, __('Are you sure you want to delete # %s?', $encounter['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Encounter'), array('controller' => 'encounters', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
