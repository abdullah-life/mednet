<div class="benefitsTests view">
<h2><?php  echo __('Benefits Test');?></h2>
	<dl>
		<dt><?php echo __('CRITERION NBR'); ?></dt>
		<dd>
			<?php echo h($benefitsTest['BenefitsTest']['CRITERION_NBR']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('LOCAL DESCRIPTION'); ?></dt>
		<dd>
			<?php echo h($benefitsTest['BenefitsTest']['LOCAL_DESCRIPTION']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('BENEFIT'); ?></dt>
		<dd>
			<?php echo h($benefitsTest['BenefitsTest']['BENEFIT']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TYPE'); ?></dt>
		<dd>
			<?php echo h($benefitsTest['BenefitsTest']['TYPE']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('CODE'); ?></dt>
		<dd>
			<?php echo h($benefitsTest['BenefitsTest']['CODE']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('LOCAL DESCRIPTION 1'); ?></dt>
		<dd>
			<?php echo h($benefitsTest['BenefitsTest']['LOCAL_DESCRIPTION_1']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Benefits Test'), array('action' => 'edit', $benefitsTest['BenefitsTest']['LOCAL_DESCRIPTION_1'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Benefits Test'), array('action' => 'delete', $benefitsTest['BenefitsTest']['LOCAL_DESCRIPTION_1']), null, __('Are you sure you want to delete # %s?', $benefitsTest['BenefitsTest']['LOCAL_DESCRIPTION_1'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Benefits Tests'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Benefits Test'), array('action' => 'add')); ?> </li>
	</ul>
</div>
