<script type="text/javascript">
     $(document).ready(function(){
        $(".viewclaims").click(function(){
           var element  =   this;
           eopfileid  =   $(this).attr('id');
           $(".listingActivities").remove();
           if(!$(element).hasClass('opened')){
           
           $.ajax({
           type:"GET",
           dataType: "html",
           url: "<?php echo Router::url('/', true);?>"+"Activities/getEopActivities/"+eopfileid,
            beforeSend: function () {
                 if(!$(element).hasClass('opened'))
                    {
                        $(element).parents('tr').after('<tr class="beforesend"><td colspan="15"><table><tr><td>Populating data....</td></tr></table></td></tr>');
                    }
                },
            complete:  function(data) {
                if(!$(element).hasClass('opened'))
                   { 
                     $(element).addClass('opened');
                     $(".beforesend").remove();
                     $(element).parents('tr').after('<tr class="listingActivities"><td colspan="15" width="80%">'+data.responseText+'</td></tr>');
                   }
                else{
                    $(element).removeClass('opened')
                   
                }
            },      
            })
            }else{
                 $(element).removeClass('opened');
                 $(".listingActivities").remove();
            
            };
            
        });
    })
</script>
<div class="eopfiles index">
	<h2><?php echo __('Eopfiles');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo __('Listing')?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo __('Eop Batches');?></th>
                        <th><?php echo __('Download zip for DHA')?></th>
                        <th><?php echo __('Download zip for HAAD')?></th>
                        <th><?php echo __('Download excel for DHA')?></th>
                        <th><?php echo __('Download excel for HAAD')?></th>
                        <th><?php echo __('Status')?></th>
                        <th><?php echo __('Error Status')?></th>
	</tr>
	<?php
	foreach ($eopfiles as $key=>$eopfile): ?>
	<tr>
                
		<td><?php echo $key+1; ?>&nbsp;</td>
		<td><?php echo $eopfile['Eopfile']['name']?>&nbsp;</td>
		<td><?php echo $this->Html->link('List Explanation of payment entries',array('controller' =>  'Eopfileentries','action'   =>  'eopsearch/'.$eopfile['Eopfile']['id'])); ?>&nbsp;</td>
		<td><?php echo date('Y-m-d H:i:s', $eopfile['Eopfile']['created']->sec); ?>&nbsp;</td>
                <td><?php echo $this->Html->link('View Batch Details',array('controller' => 'Eopbatches', 'action' => 'index',$eopfile['Eopfile']['id'])); ?>&nbsp;</td>
                <td><?php echo $this->requestAction(array('controller' => 'Eopfiles','action' => 'getdownloadlink/'.$eopfile['Eopfile']['id'].'/0')); ?></td>
                <td><?php echo $this->requestAction(array('controller' => 'Eopfiles','action' => 'getdownloadlink/'.$eopfile['Eopfile']['id'].'/1')); ?></td>
                <td><?php echo $this->requestAction(array('controller' => 'Eopfiles','action' => 'getdownloadlink/'.$eopfile['Eopfile']['id'].'/2')); ?></td>
                <td><?php echo $this->requestAction(array('controller' => 'Eopfiles','action' => 'getdownloadlink/'.$eopfile['Eopfile']['id'].'/3')); ?></td>
                <td><?php echo $this->requestAction(array('controller' => 'Eopfiles','action' => 'getStatus/'.$eopfile['Eopfile']['id']));?></td>
                <td><?php echo $this->requestAction(array('controller' => 'Eopfiles','action' => 'geterrorfile/'.$eopfile['Eopfile']['id']));?></td>
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
		<li><?php echo $this->Html->link(__('New Explanation of Payment'), array('controller' => 'eopfileentries', 'action' => 'neweop')); ?> </li>
		<li><?php echo $this->Html->link(__('List Mareked Claims'), array('controller' => 'Claims', 'action' => 'listmarkedclaims')); ?> </li>
		
	</ul>
</div>
