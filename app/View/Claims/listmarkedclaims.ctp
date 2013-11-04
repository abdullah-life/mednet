<div class="eopfiles index">
        <table>
            <tr>
                <td>
                    <?php
                        echo $this->Form->create();
                        echo $this->Form->input('Claimids',array('label' => 'Claim IDs','type' =>  'select','options'  =>  $markedclaimsarray,'empty' => 'Choose the Claim id'));
                        echo $this->Form->end('Search');
                    ?>
                </td>
                <td>
                    <?php
                        echo $this->Form->create();
                        echo $this->Form->input('providerids',array('label' => 'Select Provider','type' =>  'select','options'  =>  $providerlist,'empty' => 'Choose the Provider'));
                        echo $this->Form->end('Search');
                    ?>
                </td>
            </tr>
        </table>
	<h2><?php echo __('Marked Claims');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Claim');?></th>
			<th><?php echo $this->Paginator->sort('Activity id');?></th>
			<th><?php echo __('Member ID')?></th>
			<th><?php echo __('Start');?></th>
                        <th><?php echo __('Type')?></th>
                        <th><?php echo __('Benefit')?></th>
                        <th><?php echo __('Benefit desc')?></th>
                        <th><?php echo __('Code')?></th>
                        <th><?php echo __('Qnty')?></th>
                        <th><?php echo __('Net')?></th>
                        <th><?php echo __('Clainician')?></th>
                        <th><?php echo __('Prior Autherization ID')?></th>
                        <th><?php echo __('Gross Price')?></th>
                        <th><?php echo __('Observations')?></th>
	</tr>
	<?php
        foreach ($activities as $activity): 
        $benefitsdetails = $this->requestAction(array('controller' => 'Benefits', 'action' => 'descriptionforProviderpricing/' . $activity['Activity']['Code'] . '/' . $activity['Activity']['Type']));    
        ?>
	<tr>
                <td><?php echo $markedclaim['Claim']['claim']['xmlclaimID'];?></td>
                <td><?php echo $activity['Activity']['Activity_id'];?></td>
                <td><?php echo $markedclaim['Claim']['claim']['MemberID'];?></td>
                <td><?php echo date('Y-m-d',strtotime($activity['Activity']['start']));?></td>
                <td><?php echo $activity['Activity']['Type'];?></td>
                <td><?php echo $benefitsdetails['Benefit']['BENEFIT']; ?></td>
                <td><?php if(strlen($benefitsdetails['Benefit']['LOCAL_DESCRIPTION_1'])>10) echo substr($benefitsdetails['Benefit']['LOCAL_DESCRIPTION_1'],0,10).'....'; else  echo $benefitsdetails['Benefit']['LOCAL_DESCRIPTION_1']; ?></td>
                <td><?php echo $activity['Activity']['Code'];?></td>
                <td><?php echo $activity['Activity']['Quantity'];?></td>
                <td><?php echo $activity['Activity']['Net'];?></td>
                <td><?php echo $activity['Activity']['Clinician'];?></td>
                <?php $gorss = $this->requestAction(array('controller' => 'Xmllistings', 'action' => 'getnetpricefromactivity/'.$presentclaim['Claim']['claim']['ProviderID'].'/'.$activity['Activity']['id']))?>
                <td ><?php echo $activity['Activity']['ProrAuthorizationID']; ?></td>
                <td ><?php echo $gorss; ?></td>
                <td>
                    <?php
                        if(isset($activity['Activity']['Observation']))
                        {
                            echo  $this->Html->image('folder-closed.gif',array('class'=>'observations', 'title'=>'View Observations','invid'=>$activity['Activity']['id'],'clid' => $claimdetails['Claim']['claim']['xmlclaimID']));
                        }
                        else
                        {
                            echo '-';
                        }
                    ?>
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
		<li><?php echo $this->Html->link(__('New Explanation of Payment'), array('controller' => 'eopfileentries', 'action' => 'neweop')); ?> </li>
		<li><?php echo $this->Html->link(__('List Explanation of Payment'), array('controller' => 'eopfiles', 'action' => 'index')); ?> </li>
		
	</ul>
</div>

