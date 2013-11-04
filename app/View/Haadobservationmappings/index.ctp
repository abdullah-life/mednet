<div class="haadobservationmappings index">
    <div id="search" style="width:100%;height:auto;float:left;border: 1px solid #CDCDCD !important;">
        
        <h2><?php echo __('Search ');?></h2>
        <?php echo $this->Form->create('ObservationMapping',array('method'  =>  'POST'));?>
        <table style="width:700px;" >
            
            <tr>
                
                <td width="30%">
                       <?php
                            echo $this->Form->input('activity_type',array('type'=>'select','class'=>'observation','options' => $activitytypes,'selected'=>$this->Session->read('activity_type'),'empty'=>'select Activity type')); 
                            echo $this->Form->input('activity_code',array('type'=>'select','class'=>'observation','options' => $activitycodes,'selected'=>$this->Session->read('activity_code'),'empty'=>'select Activity code')); 
                            echo $this->Form->input('observation_code',array('type'=>'select','class'=>'observation','options' => $observationcodes,'selected'=>$this->Session->read('observation_code'),'empty'=>'select Observation code')); 
                       ?>
                </td>
            </tr>
            <tr>
                <td> <?php echo $this->Form->end(__('Submit'));?></td>
            </tr>
            
        </table>
        
        
    </div>
	<h2><?php echo __('Haadobservationmappings'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('activity_type'); ?></th>
			<th><?php echo $this->Paginator->sort('activity_code'); ?></th>
			<th><?php echo $this->Paginator->sort('observation_code'); ?></th>
			<th><?php echo $this->Paginator->sort('gross_price'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('start_date'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($haadobservationmappings as $haadobservationmapping): ?>
	<tr>
		<td><?php echo h($haadobservationmapping['Haadobservationmapping']['id']); ?>&nbsp;</td>
		<td><?php echo h($haadobservationmapping['Haadobservationmapping']['activity_type']); ?>&nbsp;</td>
		<td><?php echo h($haadobservationmapping['Haadobservationmapping']['activity_code']); ?>&nbsp;</td>
		<td><?php echo h($haadobservationmapping['Haadobservationmapping']['observation_code']); ?>&nbsp;</td>
		<td><?php echo h($haadobservationmapping['Haadobservationmapping']['gross_price']); ?>&nbsp;</td>
		<td><?php echo h($haadobservationmapping['Haadobservationmapping']['description']); ?>&nbsp;</td>
		<td><?php echo h($haadobservationmapping['Haadobservationmapping']['start_date']); ?>&nbsp;</td>
		<td><?php echo h($haadobservationmapping['Haadobservationmapping']['status']); ?>&nbsp;</td>
		<td><?php echo h($haadobservationmapping['Haadobservationmapping']['modified']); ?>&nbsp;</td>
		<td><?php echo h($haadobservationmapping['Haadobservationmapping']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $haadobservationmapping['Haadobservationmapping']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $haadobservationmapping['Haadobservationmapping']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $haadobservationmapping['Haadobservationmapping']['id']), null, __('Are you sure you want to delete # %s?', $haadobservationmapping['Haadobservationmapping']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Haadobservationmapping'), array('action' => 'addsingle')); ?></li>
		<li><?php echo $this->Html->link(__('Upload Haadobservationmapping'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Back to ObservationMappings'), array('controller' => 'ObservationMappings','action' => 'index')); ?></li>
	</ul>
</div>
