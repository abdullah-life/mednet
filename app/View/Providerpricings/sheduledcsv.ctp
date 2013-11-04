
<div class="providerpricings index">
    
    <h2><?php echo __('CSV Generation details');?></h2>
	
        <table cellpadding="0" cellspacing="0">
        <tr>
            <th>Id</th>
            <th>Categoy</th>
            <th>Provider Code</th>
            <th>Activity Code</th>
            <th>Pricing date</th>
            <th>Status</th>
            <th>Action</th>
	</tr>
	<?php
            foreach ($sheduledata as $key=>$shedule):
        ?>
        <tr>
                
		<td><?php echo $key+1;; ?>&nbsp;</td>
		<td><?php 
                    if($shedule['Providerpricingscsvdata']['type']==0)
                        echo h('Providerpricings');
                    else
                        echo h('ObservationMappings')
                ?>&nbsp;</td>
		<td><?php echo h($shedule['Providerpricingscsvdata']['provider_code']); ?>&nbsp;</td>
		<td><?php echo h($shedule['Providerpricingscsvdata']['acitivitycode']); ?>&nbsp;</td>
		<td><?php echo h($shedule['Providerpricingscsvdata']['dateforsearch']); ?>&nbsp;</td>
		<td><?php  if($shedule['Providerpricingscsvdata']['status']==1 or $shedule['Providerpricingscsvdata']['status']==0)
                            echo h("Processing");
                          else if($shedule['Providerpricingscsvdata']['status']==3)
                              echo '<a href='.Router::url('/',true).'files/'.$shedule['Providerpricingscsvdata']['path'].'>Dowload CSV</a>';
                          else
                              echo '<a href='.Router::url('/',true).'files/pricingscsv/'.$shedule['Providerpricingscsvdata']['path'].'>Dowload CSV</a>';
                    ?>&nbsp;
                </td>
                <td><?php echo $this->Html->link('Delete',array('controller'  =>  'Providerpricings','action' =>  'deleteshedule/'.$shedule['Providerpricingscsvdata']['id']));?></td>
		
	</tr>
<?php endforeach; ?>
	</table>
	
        
</div>
<div class="actions">
	     
</div>
