<div class="providerdetails view">
<h2><?php  echo __('Providerdetail');?></h2>
	<dl>
		<dt><?php echo __('Provider Code'); ?></dt>
		<dd>
			<?php echo h($providerdetail['Providerdetail']['provider_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Name'); ?></dt>
		<dd>
			<?php echo h($providerdetail['Providerdetail']['display_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Provider Status'); ?></dt>
		<dd>
			<?php echo h($providerdetail['Providerdetail']['provider_status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Facility Name'); ?></dt>
		<dd>
			<?php echo h($providerdetail['Providerdetail']['facility_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Licence'); ?></dt>
		<dd>
			<?php echo h($providerdetail['Providerdetail']['licence']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($providerdetail['Providerdetail']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Region'); ?></dt>
		<dd>
			<?php echo h($providerdetail['Providerdetail']['region']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Providerdetail'), array('action' => 'edit', $providerdetail['Providerdetail']['region'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Providerdetail'), array('action' => 'delete', $providerdetail['Providerdetail']['region']), null, __('Are you sure you want to delete # %s?', $providerdetail['Providerdetail']['region'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Providerdetails'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Providerdetail'), array('action' => 'add')); ?> </li>
	</ul>
</div>
