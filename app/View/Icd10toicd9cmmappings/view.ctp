<div class="icd10toicd9cmmappings view">
<h2><?php  echo __('Icd10toicd9cmmapping');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($icd10toicd9cmmapping['Icd10toicd9cmmapping']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Icd 10'); ?></dt>
		<dd>
			<?php echo h($icd10toicd9cmmapping['Icd10toicd9cmmapping']['icd_10']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Icd9 Cm'); ?></dt>
		<dd>
			<?php echo h($icd10toicd9cmmapping['Icd10toicd9cmmapping']['icd9_cm']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status Code'); ?></dt>
		<dd>
			<?php echo h($icd10toicd9cmmapping['Icd10toicd9cmmapping']['status_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($icd10toicd9cmmapping['Icd10toicd9cmmapping']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($icd10toicd9cmmapping['Icd10toicd9cmmapping']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($icd10toicd9cmmapping['Icd10toicd9cmmapping']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Icd10toicd9cmmapping'), array('action' => 'edit', $icd10toicd9cmmapping['Icd10toicd9cmmapping']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Icd10toicd9cmmapping'), array('action' => 'delete', $icd10toicd9cmmapping['Icd10toicd9cmmapping']['id']), null, __('Are you sure you want to delete # %s?', $icd10toicd9cmmapping['Icd10toicd9cmmapping']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Icd10toicd9cmmappings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Icd10toicd9cmmapping'), array('action' => 'add')); ?> </li>
	</ul>
</div>
