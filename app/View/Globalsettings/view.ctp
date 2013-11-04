<div class="globalsettings view">
<h2><?php  echo __('Globalsetting');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($globalsetting['Globalsetting']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ROUND OFF INTEGERS'); ?></dt>
		<dd>
			<?php echo h($globalsetting['Globalsetting']['ROUND_OFF_INTEGERS']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TRUNCATE MEMBER ID'); ?></dt>
		<dd>
			<?php echo h($globalsetting['Globalsetting']['TRUNCATE_MEMBER_ID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('DENTAL CODE MAPPING'); ?></dt>
		<dd>
			<?php echo h($globalsetting['Globalsetting']['DENTAL_CODE_MAPPING']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('DRUG CODE MAPPING'); ?></dt>
		<dd>
			<?php echo h($globalsetting['Globalsetting']['DRUG_CODE_MAPPING']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('CLINICIAN CODE MAPPING'); ?></dt>
		<dd>
			<?php echo h($globalsetting['Globalsetting']['CLINICIAN_CODE_MAPPING']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('DENIAL REASON'); ?></dt>
		<dd>
			<?php echo h($globalsetting['Globalsetting']['DENIAL_REASON']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('PAYER CODE MAPPING'); ?></dt>
		<dd>
			<?php echo h($globalsetting['Globalsetting']['PAYER_CODE_MAPPING']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('PROVIDER CODE MAPPING'); ?></dt>
		<dd>
			<?php echo h($globalsetting['Globalsetting']['PROVIDER_CODE_MAPPING']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($globalsetting['Globalsetting']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($globalsetting['Globalsetting']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Globalsetting'), array('action' => 'edit', $globalsetting['Globalsetting']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Globalsetting'), array('action' => 'delete', $globalsetting['Globalsetting']['id']), null, __('Are you sure you want to delete # %s?', $globalsetting['Globalsetting']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Globalsettings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Globalsetting'), array('action' => 'add')); ?> </li>
	</ul>
</div>
