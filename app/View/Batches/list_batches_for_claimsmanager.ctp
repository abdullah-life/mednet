

<?php echo $this->Html->script('blockui.js'); ?>
<?php
   if($batches!="error"){
    $this->Paginator->options(array(
    'update' => '#content',
    'evalScripts' => true,
     'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
     'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),   
  ));
 }
?>
<style>
.searchbatch tr td
{
    background-color: #E9E9E9;
}
</style>
<script type="text/javascript">

     var batchid=null;
    $(document).ready(function(){
        

        
    
        $(".viewpricing").click(function(){
           $(document).find(".messi").remove();
           var element  =   this;
           batchid  =   $(this).attr('id');
           $(".listingActivities").remove();
           if(!$(element).hasClass('opened')){
           Messi.load("<?php echo Router::url('/',true) ?>"+"Activities/getActivitiesPricing/"+batchid,{width:'1200px'});
          
//           $.ajax({
//               
//            url: "<?php echo Router::url('/', true);?>"+"Activities/getActivitiesPricing/"+batchid,
//            beforeSend: function () {
//                 if(!$(element).hasClass('opened'))
//                    {
//                        $(element).parents('tr').after('<tr class="beforesend"><td colspan="18"><table><tr><td>Populating data....</td></tr></table></td></tr>');
//                    }
//                }
//            }).done(function(data) {
//                if(!$(element).hasClass('opened'))
//                   { 
//                     $(element).addClass('opened');
//                     $(".beforesend").remove();
//                     $(element).parents('tr').after('<tr class="listingActivities"><td colspan="14">'+data+'</td></tr>');
//                   }
//                else{
//                    $(element).removeClass('opened')
//                   
//                }
//            });
            
                }else{
                 $(element).removeClass('opened');
                 
            
            };
            
        });
    })
    </script>
    <script type="text/javascript">
        function makeajaxcall(){
        var bach=batchid;
        var claimids     =   $('.searchforclaim').find('input').val().split(') ');
        var claimid      =   claimids[(claimids.length)-1];
       
//        alert($("#select_id").val());
            if($('.ui-state-default').val()=='')
            {
                alert("Please choose a valid claimid from the dropdown menu");
            }
            else
            {
                    $.ajax({
                        url: "<?php echo Router::url('/', true);?>Activities/getActivitiesPricing/" + bach + '/' + claimid + '/' + 'true/',
                        beforeSend: function () {

                            $('.activityholder').html('<table><tr class="beforesend"><td colspan="18">Populating data....</td></tr></table>');
                        }
                    }).done(function(data){
                        $('.searchclaim').removeClass('now');
                        $('.activityholder').html(data);
                    });
                    
            }
        }   
      $(document).ready(function(){
                
                $('.comments').live('click',function(e){
                    
                var acid = ($(this).attr('value'));
                Messi.load("<?php echo Router::url('/', true);?>"+"Activities/getactivityComments/"+acid);
                return false;
//                $.ajax({ 
//                url: "<?php echo Router::url('/', true);?>"+"Activities/getactivityComments/"+acid,
//                cache: false, 
//               	dataType:'html',
//		success: function(data) {
//				 $.blockUI({
//						 css: { 
//         						   border: 'none', 
//						            padding: '15px', 
//						           // backgroundColor: '#000', 
//						            '-webkit-border-radius': '10px', 
//						            '-moz-border-radius': '10px', 
//						         //   opacity: .5, 
//						            color: '#fff',
//								width:'400px',
//								hight:'300px',	 
//								top:   '100px', 
//						                left: ($(window).width() - 400) /2 + 'px', 
//						
//						      } 
//						,'message':'<pr>'+data+'</p>'
//					}); 
//                                         $('.blockOverlay').attr('title','Click to unblock').click($.unblockUI); 
//            	
//		    } 
//            }); 
                 
                 e.stopImmediatePropagation();
                e.preventDefault(); 
                 
                 
                 
                 
                 
                 
                 
                 
                });
       });
</script>
<div id="popupbox" style="display:none; cursor: default">
        
    <textarea name="tarea" id="tarea" rows="4" cols="50">
         
    </textarea>
    <br>
    <input type="button" id="yes" value="Add comment" style="margin-left: -40px;margin-right: 20px;font-size: 111%" />
    <input type="button" id="no" value="Cancel" style="font-size: 111%"/>
       
<!--        <input type="button" id="yes" value="Add new Comment" /> 
        <input type="button" id="no" value="Exit" /> -->
</div> 
<div class="batches index">
	<h2><?php echo __('Batches');?></h2>
        <?php
            if($batches!="error"){
                
        ?>
        <div>
             <div id="searchbox">
                <table cellpadding="0" cellspacing="0" class="searchbatch">
                    <tr>
                        <?php echo $this->Form->create('Search');?>
                                
			<td><?php echo $this->Form->input('provider_code',$this->Session->read('provider_code'));?></td>
			<td><?php echo $this->Form->input('License',$this->Session->read('License'));?></td>
			<td><?php echo $this->Form->input('Name',$this->Session->read('Name'));?></td>
                        <?php $this->Form->end('Submit')?>
                    </tr>
                    <tr>
                        <td colspan="3" style="background-color: ">
                            <?php echo $this->Form->end(__('Submit'));?>
                        </td>
                    </tr>
                </table>
                
            </div>
        <?php
             echo $this->element('statustile');
           ?>
            </div>
        <div class="batchestable">
       <table cellpadding="0" cellspacing="0">
           
           <tr>
			<th width="15px;" ><?php echo 'id';?></th>
			<th width="35px;"><?php echo $this->Paginator->sort('name','Batch Number');?></th>
			<th width="35px;"><?php echo $this->Paginator->sort('provider_id','Provider License');?></th>
			<th width="35px;"><?php echo 'Provider code';?></th>
                        <th width="35px;"><?php echo"Provider Name"?></th>
			<th width="35px;"><?php echo"Claim Count"?></th>
                       <th width="35px;"><?php echo $this->Paginator->sort('created','created');?></th>
                        <th width="30px;"  ><?php echo"Claim status"?></th>
                        <th width="30px;"  class="actions"><?php echo __('On hold ');?></th>
			<?php
                         if($this->Session->read('Auth.User.group_id')==15){
                        ?>
			<th width="30px;"  class="actions"><?php echo __('Assign to  ClaimsManager');?></th>
			
                        <?php
                         }
			
                         if($this->Session->read('Auth.User.group_id')==16){
                        ?>
                        <th  width="30px;" class="actions"><?php echo __('Assign To <br/>Medi  <br/> Manager');?></th>
			<th width="30px;" class="actions"><?php echo __('Assign to  Claims Processor');?></th>
			<?php
                         }
                         
                        
                        ?>
                        <th width="30px;"><?php echo __('Assignd By');?></th>
                        <th width="30px;"   class="actions"><?php echo __('Download XMl');?></th>
                        <th  width="30px;" class="actions"><?php echo __('View Pricing');?></th>
                        
                        <?php
                        ?>
	</tr>
	<?php
        
  
     foreach ($batches as $key=>$batch): ?>
   
                
        <?php
            
            $batchstatus         =   $this->requestAction(array('controller'=>'batches','action'=>'getstatus', $batch['Batch']['id']));
            $prviderdetails      =   $this->requestAction(array('controller'=>'Providerdetails','action'=>'getdetails',$batch['Batch']['provider_id']));    
           
           
            ?>
	<tr class="<?php echo $batchstatus; ?>">
		<td><?php echo $key+1; ?>&nbsp;</td>
		<td><?php echo $batch['Batch']['name'];?>&nbsp;</td>
		<td><?php echo h($batch['Batch']['provider_id']); ?>&nbsp;</td>
                
              	<td>
                    <?php
                        if(isset($batch['Batch']['resubmission']))
                        {
                            echo h($prviderdetails['Providerdetail']['code'].' (R)');
                        }
                        else
                        {
                            echo h($prviderdetails['Providerdetail']['code']);
                        }
                    ?>&nbsp;
                </td>
                <td>
                   <?php echo h($prviderdetails['Providerdetail']['display_name']); ?>&nbsp;
                </td>
                <td>
                   <?php
                        echo $this->requestAction(array('controller' => 'batches','action' => 'getclaimcountforbatch',$batch['Batch']['id']));
                   ?>
                </td>
                <td>
                    <?php echo date ('d-M-Y',  $batch['Batch']['created']->sec); ?>&nbsp;
                </td>
  	          <td>
                          
         <?php 
                         $claimsprocessstatus = $this->requestAction( array('controller' => 'Batches',
                                                          'action' => 'getclaimstatus',
                                                          $batch['Batch']['id'])); 
                         if($claimsprocessstatus == 6){
                            echo $this->Html->link($this->Html->image('processed.png',array('title'=>'Xml Processed')), array('controller'=>'ClaimsprocessorBatches','action' => 'markprocessed/0', $batch['Batch']['id'],'list_batches_for_claimsmanager'),array('escape'=>FALSE));
                         }
                         else{
                          echo $this->Html->link($this->Html->image('crosss.png',array('title'=>'Xml not Processed')), array('controller'=>'ClaimsprocessorBatches','action' => 'markprocessed/1', $batch['Batch']['id'],'list_batches_for_claimsmanager'),array('escape'=>FALSE));
                         //echo $this->Html->image('',array('title'=>'Xml not Processed'));
                             
                         }	

                         ?>&nbsp;   
                 </td>
                 
                 <td>
                     <?php
                     $claimsprocessholdstatus = $this->requestAction( array('controller' => 'Batches',
                                                          'action' => 'getclaimstatus',
                                                          $batch['Batch']['id']));
                     
                     if($claimsprocessholdstatus==5)
                        echo $this->Html->link($this->Html->image('watchglass.png',array('title'=>'on hold')), array('controller'=>'ClaimsprocessorBatches','action' => 'markhold/0', $batch['Batch']['id'],'list_batches_for_claimsmanager'),array('escape'=>FALSE));
                     else
                         echo $this->Html->link($this->Html->image('not_on_hold.png',array('title'=>'')), array('controller'=>'ClaimsprocessorBatches','action' => 'markhold/1', $batch['Batch']['id'],'list_batches_for_claimsmanager'),array('escape'=>FALSE));
                     ?>
                 </td>
		<?php
                    if($this->Session->read('Auth.User.group_id')==15){
                   ?>
		<td>
			<?php echo $this->Html->link($this->Html->image('assign.png',array('title'=>'view xmldetails')), array('controller'=>'Batches','action' => 'Assign_to_claims_manager', $batch['Batch']['id']),array('escape'=>FALSE)); ?>
                </td> 
                 <?php
                    }
		
                    if($this->Session->read('Auth.User.group_id')==16){
                   ?>
                <td>
                        <?php 
                                echo $this->requestAction(array('controller' => 'Batches','action'=> 'getStatusvalue',$batch['Batch']['status'],'assign.png','MedicalmanagerBatches','assignfromclaimsManager/'.$batch['Batch']['id'],$batch['Batch']['id']));
//                        if($batch['Batch']['status']!=4)
//                            echo $this->Html->link('Assign to Med.Manager', array('controller'=>'MedicalmanagerBatches','action'=>'assignbatch',$batch['Batch']['id']));
//                        else
//                            echo $this->Html->image('assgned_to_medical.png',array('title'=>'assged to medical manager'));
                        ?>
                    </td> 
		<td>
			<?php echo $this->requestAction(array('controller' => 'Batches','action'=> 'getStatusvalue',$batch['Batch']['status'],'assign.png','Batches','Assign_to_claims_processor/'.$batch['Batch']['id'],$batch['Batch']['id'])); //echo $this->Html->link($this->Html->image('assign.png',array('title'=>'view xmldetails')), array('controller'=>'Batches','action' => 'Assign_to_claims_processor', $batch['Batch']['id']),array('escape'=>FALSE)); ?>
                </td> 
                 <?php
                    }
                         
                         if(!$this->Session->read('Auth.User.group_id')==5){
                        ?>
                <td>
			<?php echo $this->Html->link($this->Html->image('view-icon.png',array('title'=>'view xmldetails')), array('controller'=>'BatchesClaims','action' => 'viewclaims', $batch['Batch']['id']),array('escape'=>FALSE)); ?>
                </td> 
                <?php
                         }
                 ?>
                <td><?php echo $this->requestAction(array('controller' =>  'Batches','action' => 'getAssignerName/'.$batch['Batch']['id'].'/1')) ?></td>
                 <td>
                     <?php $trimmeddate              =        date('Ymd', $batch['Batch']['created']->sec); ?>
                     <?php 
            if($batch['Batch']['resubmission']==0){
                     ?>
                     <a href="<?php echo  Router::url('/', true);?>files/batch/<?php echo $trimmeddate.'/'.str_replace(' ','',$batch['Batch']['name']).'_'.$batch['Batch']['provider_id'].'.zip'?>">Download</a>
                <?php }else{
                ?>
                  <a href="<?php echo  Router::url('/', true);?>files/batch/<?php echo $trimmeddate.'/'.str_replace(' ','',$batch['Batch']['name']).'_'.$batch['Batch']['provider_id'].'_resubmission_files.zip'?>">Download</a>
                <?php    
                }
?>
                 </td>
                 <td>
                     <?php
                        echo $this->Html->image('down.png',array(
                            'title'=>'View Activity Pricings','class'=>'viewpricing','id'=>$batch['Batch']['id']));
                     ?>
                     
                 </td>
                 
                 
	</tr>
<?php endforeach; ?>
	</table>
            </div>
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
        
        <?php
            }
            else{
               ?>
        <table cellpadding="0" cellspacing="0">
            <?php
                  echo $this->element('statustile');
            ?>
            <tr>
                <td>
                    No records found;
                </td>
            </tr>
        </table>
               
        <?php
            }
        ?>
</div>
<div class="actions">
	 <?php     echo $this->element('logo'); ?>
    <ul>
        <li><?php echo $this->Html->link('List Batches', array('controller'=>'Batches','action' => 'list_batches_for_claimsmanager')); ?> </li>
    </ul>
</div>
<?php
    echo $this->Js->writeBuffer();

?>
