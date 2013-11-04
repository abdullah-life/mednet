<div class="dhapricings index">
    <div id="search" style="width:100%;height:auto;float:left;border: 1px solid #CDCDCD !important;">
        
        <h2><?php echo __('Search ');?></h2>
        <?php echo $this->Form->create('Providerpricing' ,array('type' => 'file'));?>
        <table style="width:700px;" >
            
            <tr>
                
                <td width="30%">
                    <?php
                        echo $this->Form->input('activityid',array('label' =>  'Activity code search'));
                        //echo $this->Form->input('Activity code search',array('type' =>  'select','options'  =>  $providers,,'name' => 'activityid'));
                    ?>
                </td>
            </tr>
            <tr>
                <td> <?php echo $this->Form->end(__('Submit'));?></td>
            </tr> 
        </table>
        
        
	<h2><?php echo __('Dhapricings'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo 'start_date'; ?></th>
			<th><?php echo $this->Paginator->sort('activity'); ?></th>
			<th><?php echo $this->Paginator->sort('code'); ?></th>
			<th><?php echo $this->Paginator->sort('gross'); ?></th>
			<th><?php echo $this->Paginator->sort('discount'); ?></th>
			<th><?php echo $this->Paginator->sort('Discount Price'); ?></th>
	</tr>
	<?php
	foreach ($dhapricings as $key => $dhapricing): ?>
	<tr>
		<td><?php echo h($key+1); ?>&nbsp;</td>
		<td><?php echo h($dhapricing['Dhapricing']['start_date']['day'].'-'.$dhapricing['Dhapricing']['start_date']['month'].'-'.$dhapricing['Dhapricing']['start_date']['year']); ?>&nbsp;</td>
		<td><?php echo h($dhapricing['Dhapricing']['activity']); ?>&nbsp;</td>
		<td><?php echo h($dhapricing['Dhapricing']['code']); ?>&nbsp;</td>
		<td><?php echo h($dhapricing['Dhapricing']['gross']); ?>&nbsp;</td>
		<td><?php echo h($dhapricing['Dhapricing']['discount']); ?>&nbsp;</td>
		<td><?php echo h($dhapricing['Dhapricing']['discountprice']); ?>&nbsp;</td>
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
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Upload DHA pricings'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Add DHA pricing'), array('action' => 'addsingle')); ?></li>
                <li><?php echo $this->Html->link(__('Back to Dashboard'), array('controller' => 'Providerpricings','action' => 'index')); ?></li>
	</ul>
</div>
