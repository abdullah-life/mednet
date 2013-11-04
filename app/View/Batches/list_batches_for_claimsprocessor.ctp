<?php echo $this->Html->script('tooltip.js'); ?>

<?php echo $this->Html->script('blockui.js'); 
 if($batches!="error"){
    $this->Paginator->options(array(
    'update' => '#content',
    'evalScripts' => true,
     'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
     'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),   
  ));
 }
?>
<style type="text/css">
        html { height: 100% }
        body { height: 100%; margin: 0; padding: 0 }
        #map_canvas { height: 100% }
	#tt {position:absolute; display:block; background:url(images/tt_left.gif) top left no-repeat}
        #tttop {display:block; height:4px; margin-left:5px; background:url(images/tt_top.gif) top right no-repeat; overflow:hidden}
        #ttcont {display:block; padding:2px 12px 3px 7px; margin-left:5px; color:#FFF;width:285px}
        #ttbot {display:block; height:4px; margin-left:5px; background:url(images/tt_bottom.gif) top right no-repeat; overflow:hidden}
</style>
<script type="text/javascript">
    var batchid;
    $(document).ready(function(){
         $(".downloadlink").click(function(){
             var batchid    =   $(this).attr('batchid');
             $(this).addClass('clicked');
                
              $.ajax({
           url: "<?php echo Router::url('/', true);?>"+"ClaimsprocessorBatches/checkdownloadstatus/"+batchid
            }).done(function(data) {
                var url =   jQuery.parseJSON(data)
                window.open(url['1']);
                window.focus();
                location.reload();
                
            });
             
              return false;
        
         })
         
         
        
    })
     $(document).ready(function(){
        $(".viewpricing").click(function(){
           var element  =   this;
           batchid  =   $(this).attr('id');
           $(".listingActivities").remove();
           if(!$(element).hasClass('opened')){
           
                Messi.load("<?php echo Router::url('/', true);?>"+"Activities/getActivitiesPricing/"+batchid,{width:'1200px'});
           
            }else{
                 $(element).removeClass('opened');
                 $(".listingActivities").remove();
            
            };
            
        });
    })
    $(document).ready(function(){
        $('.comments').mouseover(function(){
            var msg = '<div id="tool_tip">'+$(this).attr('msg')+'</div>';
            tooltip.show(msg);
        });
        $('.comment').mouseout(function(){
            tooltip.hide();
        });
    });
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
                $('.comments').live('click',function(){
                var acid = ($(this).attr('value'));
                Messi.load("<?php echo Router::url('/', true);?>"+"Activities/getactivityComments/"+acid)
//                $.ajax({ 
//                url: "<?php echo Router::url('/', true);?>"+"Activities/getactivityComments/"+acid,
//                cache: false, 
//               	dataType:'html',
//		success: function(data) { 
//              		 
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
                 
                });
       });   
         
    
</script>    
<?php
    $count= count($downloaded);
?>

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
                        <?php $this->Form->end('Submit')?>
                    </tr>
                    <tr>
                        <td colspan="2" style="background-color: ">
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
			<th><?php echo 'id';?></th>
			<th width="30%"><?php echo $this->Paginator->sort('name','Batch Number');?></th>
			<th width="30%"><?php echo $this->Paginator->sort('provider_id','Provider License');?></th>
                        <th width="30%"><?php echo 'Provider name';?></th>
			<th width="30%"><?php echo"Provider code"?></th>
                        <th width="30%"><?php echo"Claim Count"?></th>
                        <th width="30%"><?php echo"Comment"?></th>
                        <th><?php echo $this->Paginator->sort('created','created');?></th>
			<th class="actions"><?php echo __('Assign To Medi.Manager');?></th>
                        <th class="actions"><?php echo __('Process Status');?></th>
                        <th class="actions"><?php echo __('On hold ');?></th>
                        <th><?php echo __('Assigned By ');?></th>
                        <th class="actions"><?php echo __('Download XMl');?></th>
                         <th class="actions"><?php echo __('View Pricing');?></th>
                        <?php
                        ?>
	</tr>
        
        <?php
        
        ?>
        
	<?php
	foreach ($batches as $key=>$batch): ?>
        
        <?php 
            //pr($batch);
        ?>
        <?php
            
        ?>
	<?php
            $batchstatus         =   $this->requestAction(array('controller'=>'batches','action'=>'getstatus', $batch['Batch']['id']));
            $prviderdetails      =   $this->requestAction(array('controller'=>'Providerdetails','action'=>'getdetails',$batch['Batch']['provider_id']));    
           
            ?>
	<tr class="<?php echo $batchstatus; ?>">
               
		<td><?php echo h($key+1); ?>&nbsp;</td>
		<td><?php echo $batch['Batch']['name'];?>&nbsp;</td>
		<td><?php 
                    if(isset($batch['Batch']['resubmission']))
                    {
                        echo h($batch['Batch']['provider_id'].' (R)');
                    }
                    else
                    {
                        echo h($batch['Batch']['provider_id']);
                    }
                ?>&nbsp;</td>
                <td>
                    <?php echo h($prviderdetails['Providerdetail']['code']); ?>&nbsp;
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
                    <?php
                            if(isset($batch['BatchComment']['0']['comment']))
                               echo  $this->Html->image('comment.png',array('msg'=>$batch['BatchComment']['0']['comment'],'class'=>'comment')); 
                        ?>
                    </td>

                    <td>
                    <?php echo date ('d-M-Y',  $batch['Batch']['created']->sec); ?>&nbsp;
                </td>
	               <td>
                        <?php 
                                echo $this->requestAction(array('controller' => 'Batches','action'=> 'getStatusvalue',$batch['Batch']['status'],'assign.png','MedicalmanagerBatches','assignbatch/'.$batch['Batch']['id'],$batch['Batch']['id']));
//                        if($batch['Batch']['status']!=4)
//                            echo $this->Html->link('Assign to Med.Manager', array('controller'=>'MedicalmanagerBatches','action'=>'assignbatch',$batch['Batch']['id']));
//                        else
//                            echo $this->Html->image('assgned_to_medical.png',array('title'=>'assged to medical manager'));
                        ?>
                    </td>    
                <td>
                     <?php 
                         $claimsprocessstatus = $this->requestAction( array('controller' => 'Batches',
                                                          'action' => 'getclaimstatus',
                                                          $batch['Batch']['id'])); 

                         if($claimsprocessstatus == 6){
                            echo $this->Html->image('processed.png',array('title'=>'Xml Processed'));
                         }
                         else{
                           echo $this->Html->link($this->Html->image('crosss.png',array('title'=>'Xml not Processed')), array('controller'=>'ClaimsprocessorBatches','action' => 'markprocessed/1', $batch['Batch']['id'],'list_batches_for_claimsprocessor'),array('escape'=>FALSE));
                         }	
                         ?>&nbsp;   
                 </td>
                 <td>
                     <?php
                     $claimsprocessholdstatus = $this->requestAction( array('controller' => 'Batches',
                                                          'action' => 'getclaimstatus',
                                                          $batch['Batch']['id']));
                     
                     if($claimsprocessholdstatus==5)
                        echo $this->Html->link($this->Html->image('watchglass.png',array('title'=>'on hold')), array('controller'=>'ClaimsprocessorBatches','action' => 'markhold/0', $batch['Batch']['id'],'list_batches_for_claimsprocessor'),array('escape'=>FALSE));
                     else
                         echo $this->Html->link($this->Html->image('not_on_hold.png',array('title'=>'')), array('controller'=>'ClaimsprocessorBatches','action' => 'markhold/1', $batch['Batch']['id'],'list_batches_for_claimsprocessor'),array('escape'=>FALSE));
                     ?>
                 </td>
                 <td><?php echo $this->requestAction(array('controller' =>  'Batches','action' => 'getAssignerName/'.$batch['Batch']['id'].'/2')) ?></td>
                 <td class="download">
                     <?php 
                     
                     if(count($downloaded)==0){
                  ?>   
                     <?php $trimmeddate              =         trim(date("Ymd",strtotime($batch['Batch']['created'])));?>
                     <a  class="downloadlink" batchid="<?php  echo $batch['Batch']['id']; ?>" href="<?php echo Router::url('/', true);?>/files/batch/<?php echo $trimmeddate.'/'.str_replace(' ','',$batch['Batch']['name'])."_".$batch['Batch']['provider_id'].'.zip'?>">Download</a>
                 <?php }
                 else{
                     if(in_array($batch['Batch']['id'], $downloaded[0]['Batch'])){
                       ?>
                         <?php $trimmeddate              =         trim(date("Ymd",strtotime($batch['Batch']['created'])));?>
                     <a  class="downloadlink" batchid="<?php  echo $batch['Batch']['id']; ?>" href="<?php echo Router::url('/', true);?>/files/batch/<?php echo $trimmeddate.'/'.str_replace(' ','',$batch['Batch']['name'])."_".$batch['Batch']['provider_id'].'_files.zip'?>">Download</a>
                     <?php
                     }
                 }
                 ?>
                 
                 </td>
                  <td>
                     <?php
                        echo $this->Html->image('down.png',array('title'=>'View Activity Pricings','class'=>'viewpricing','id'=>$batch['Batch']['id']));
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
        <li><?php echo $this->Html->link('List Batches', array('controller'=>'Batches','action' => 'list_batches_for_claimsprocessor')); ?> </li>
    </ul>
</div>
      
<?php
    echo $this->Js->writeBuffer();
?>