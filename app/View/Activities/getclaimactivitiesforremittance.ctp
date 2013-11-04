<table cellpadding="0" cellspacing="0" id="activity" >
        <tr>
            <th  ><?php echo 'Claim'; ?></th>
            <th  ><?php echo 'activity id'; ?></th>
            <th  ><?php echo 'member id'; ?></th>
            <th  ><?php echo $this->Paginator->sort( 'start'); ?></th>
            <th  ><?php echo 'Type'; ?></th>
            <th  ><?php echo 'benefit'; ?></th>
            <th  ><?php echo "benefit <br/> Desc"; ?></th>
            <th  ><?php echo 'Code'; ?></th>
            <th  ><?php echo 'Qnty'; ?></th>
            <th  ><?php echo 'Net'; ?></th>
            <th  ><?php echo 'Clinician'; ?></th>
            <th  ><?php echo "Prior  <br/> Auth  <br/>  ID"; ?></th>
            <th  ><?php echo "Gross  <br/>  Price"; ?></th>
            <th  ><?php echo 'Discount'; ?></th>
            <th ><?php echo "Discount<br/> Price"; ?></th>
            <th  ><?php echo $this->Paginator->sort( 'date'); ?></th>
            <th  ><?php echo $this->Paginator->sort('marked'); ?></th>
            <th ><?php echo ' comment'; ?></th>
        </tr>
<?php foreach ($activities as $activity): ?>
        
          <?php
              $benefitsdetails = $this->requestAction(array('controller' => 'Benefits', 'action' => 'descriptionforProviderpricing/' . $activity['Activity']['Code'] . '/' . $activity['Activity']['Type']));
              $claimdetails    =$this->requestAction(array('controller' => 'claims', 'action' => 'getclaimdetails/' . $activity['Activity']['claim_id'] ));
              ?>
            <tr>
                <td ><?php echo $claimdetails['Claim']['claim']['xmlclaimID'];?>&nbsp;</td>
                <td ><?php echo h($activity['Activity']['Activity_id']); ?>&nbsp;</td>
                <td ><?php echo h($claimdetails['Claim']['claim']['MemberID']); ?>&nbsp;</td>
                <td ><?php echo date('Y-m-d',strtotime($activity['Activity']['start'])); ?>&nbsp;</td>
                <td ><?php echo h($activity['Activity']['Type']); ?>&nbsp;</td>
                <td ><?php echo $benefitsdetails['Benefit']['BENEFIT']; ?>&nbsp;</td>
                <td ><?php if(strlen($benefitsdetails['Benefit']['LOCAL_DESCRIPTION_1'])>10) echo substr($benefitsdetails['Benefit']['LOCAL_DESCRIPTION_1'],0,10).'....'; else  echo $benefitsdetails['Benefit']['LOCAL_DESCRIPTION_1']; ?>&nbsp;</td>
                <td ><?php echo h($activity['Activity']['Code']); ?>&nbsp;</td>
                <td ><?php echo h($activity['Activity']['Quantity']); ?>&nbsp;</td>
                <td ><?php echo h($activity['Activity']['Net']); ?>&nbsp;</td>
                <td  ><?php echo h($activity['Activity']['Clinician']); ?>&nbsp;</td>
                <?php $discound_details = $this->requestAction(array('controller' => 'Activities', 'action' => 'getPricing/' . $activity['Activity']['id'] . '/' . $activity['Activity']['Type'].'/'.$activity['Activity']['Code'])); ?>
                <td ><?php echo "-"; ?>&nbsp;</td>
                <td ><?php if($discound_details['0']['Providerpricing']['gross']=='') echo "-"; else echo $discound_details['0']['Providerpricing']['gross']; ?>&nbsp;</td>
                <td ><?php if($discound_details['0']['Providerpricing']['discount']=='') echo "-"; else echo $discound_details['0']['Providerpricing']['discount']; ?>&nbsp;</td>
                <td ><?php if($discound_details['0']['Providerpricing']['discountprice']=='') echo "-"; else echo $discound_details['0']['Providerpricing']['discountprice']; ?>&nbsp;</td>
                <td ><?php if($discound_details['0']['Providerpricing']['start_date']=='') echo "-"; else echo substr($discound_details['0']['Providerpricing']['start_date'],0,10);?>&nbsp;</td>
                <?php 
                    if($activity['Activity']['marked']==1)
                       echo '<td>' .$this->Html->image('marked.png',array('class'=>'markactivity','title'=>'Mark this invoice','invid'=>$activity['Activity']['id']))."</td>";
                    else
                        echo'<td>' . $this->Html->image('unmarked.png',array('class'=>'markactivity', 'title'=>'Unmark this invoice','invid'=>$activity['Activity']['id']))."</td>";
                ?>
                
                <td ><?php echo $this->requestAction(array('controller'   =>  'Activities','action'=>'getLink',$activity['Activity']['id'],count($activity['Activity']['comments'])));?></td>
                 </tr>
                 <?php 
                 
     
                 ?>
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