<script type="text/javascript">
     $(document).ready(function(){
        $(".viewclaims").on('click',function(){
            var element      =   this;
                   if($(this).hasClass('opened'))
                   {
                       alert("Please wait");
                   }
                   
                   else if($(this).hasClass('hasData'))
                   {   
                        $('.data').remove();
                        $(element).removeClass('hasData');
                   }
                   else
                   {
                        if($(element).hasClass('data'))
                        {
                            $('.data').remove();
                        }
                        var providerid   =   $(this).attr('id');
                        var eopfileid    =   $(this).attr('name');
                        
                        $.ajax({
                            type:"GET",
                            dataType: "html",
                            url: "<?php echo Router::url('/', true); ?>" + "Activities/getEopclaims/" + providerid+'/'+eopfileid,
                            beforeSend: function() {
                                   $(element).addClass('opened');
                                   $(element).parents('tr').first().after('<tr class="loading"><td colspan="4">Loading .....</td></tr>');
                            },
                           complete: function(data) {
                               $('.loading').remove();
                               $(element).removeClass('opened');
                               $(element).addClass('hasData');
                               $(element).parents('tr').first().after('<tr class="data"><td colspan="4">'+data.responseText+'</td></tr>');
                           },
                       })
                   }
            })
     })
     
 </script> 
<div class="eopbatches index">
    <h2><?php echo __('Eopbatches'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('providerlicence'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($eopbatches as $key => $eopbatch): $count=1?>
	<tr>

		<td><?php echo $key+1; ?>&nbsp;</td>
		<td><?php echo h($eopbatch['Eopbatch']['providerlicence']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->image('down.png',array(
                           'title'=>'View Claims Per Provider','class'=>'viewclaims','id'=>$eopbatch['Eopbatch']['providerlicence'],'name'=>$eopbatch['Eopbatch']['eopfileid'])); ?>
		</td>
	</tr>
        <tr id="claimslist">
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
		<li><?php echo $this->Html->link(__('New Eopbatch'), array('action' => 'add')); ?></li>
	</ul>
</div>
