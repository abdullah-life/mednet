<div class="providerdetails index">
    <div id="searchprovider">
        <?php echo $this->Form->create('search');?>
        <table>
            <tr>
                <td><?php echo $this->form->input('code'); ?></td>
            </tr>
            <tr>
                <td><?php echo $this->form->input('licence'); ?></td>
            </tr>
            <tr>
                <td><?php echo $this->Form->end('Search');?></td>
            </tr>
        </table>
        
    </div>
	<h2><?php echo __('Providerdetails');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('code');?></th>
			<th><?php echo $this->Paginator->sort('display_name');?></th>
			<th><?php echo $this->Paginator->sort('facility_name');?></th>
			<th><?php echo $this->Paginator->sort('licence');?></th>
			<th><?php echo $this->Paginator->sort('city');?></th>
			<th><?php echo $this->Paginator->sort('region');?></th>

			<th><?php echo $this->Paginator->sort('active');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($providerdetails as $providerdetail): ?>
	<tr>
		<td><?php echo h($providerdetail['Providerdetail']['code']); ?>&nbsp;</td>
		<td><?php echo h($providerdetail['Providerdetail']['display_name']); ?>&nbsp;</td>
		<td><?php echo h($providerdetail['Providerdetail']['facility_name']); ?>&nbsp;</td>
		<td><?php echo h($providerdetail['Providerdetail']['licence']); ?>&nbsp;</td>
		<td><?php echo h($providerdetail['Providerdetail']['city']); ?>&nbsp;</td>
		<td><?php echo h($providerdetail['Providerdetail']['region']); ?>&nbsp;</td>
		<td><?php if($providerdetail['Providerdetail']['active']==0)
                    echo $this->Html->link($this->Html->image('crosss.png',array('title'=>'Click to activate')), array('controller'=>'providerdetails','action' => 'markacive/', $providerdetail['Providerdetail']['id']),array('escape'=>FALSE, 'confirm' => 'Activate Provider?'));
                    else
                    echo $this->Html->link($this->Html->image('marked.png',array('title'=>'Click to inactivate')), array('controller'=>'providerdetails','action' => 'markacive/', $providerdetail['Providerdetail']['id']),array('escape'=>FALSE, 'confirm' => 'Deactivate Provider?'));
                        
                    ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $providerdetail['Providerdetail']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $providerdetail['Providerdetail']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $providerdetail['Providerdetail']['id']), null, __('Are you sure you want to delete # %s?', $providerdetail['Providerdetail']['region'])); ?>
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
		<li><?php echo $this->Html->link(__('New Providerdetail'), array('controller'=>'Providerdetails','action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Provider Pricing'), array('controller'=>'providerpricings','action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Add Provider Pricing'), array('controller'=>'providerpricings','action' => 'add')); ?></li>
	</ul>
</div>
<script type="text/javascript">
    function showmsg(){
        new Messi('Do you want to activate the provider?', {title: 'Buttons', buttons: [{id: 0, label: 'Yes', val: 'Y'}, {id: 1, label: 'No', val: 'N'}], callback: function(val) {
              //if(val=='Y')window.location = "<?php //echo Router::url(true,'/'); ?>providerdetails/markacive/<?php //echo $providerdetail['Providerdetail']['id']?>"  
                
        }});
    }
</script>