
<?php echo $this->Html->script('blockui.js'); ?>
<?php
if ($batches != "error") {
    $this->Paginator->options(array(
        'update' => '#content',
        'evalScripts' => true,
        'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
        'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
    ));
}
?>
<script type="text/javascript">
    var batchid = null;
    $(document).ready(function() {
        $(".downloadlink").click(function() {
            var batchid = $(this).attr('batchid');
            $(this).addClass('clicked');

            $.ajax({
                url: "<?php echo Router::url('/', true); ?>" + "ClaimsprocessorBatches/checkdownloadstatus/" + batchid
            }).done(function(data) {
                var url = jQuery.parseJSON(data)
                //window.open(url['1'],'download');
                window.open(url['1']);
                window.focus();
                location.reload();

            });

            return false;

        })



    })
    $(document).ready(function() {
        $(".viewpricing").click(function() {
            var element = this;
            batchid = $(this).attr('id');
            $(".listingActivities").remove();
            if (!$(element).hasClass('opened')) {


                 Messi.load("<?php echo Router::url('/', true);?>"+"Activities/getActivitiesPricing/"+batchid,{width:'1200px'});
            } else {
                $(element).removeClass('opened');
                $(".listingActivities").remove();

            }
            ;

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

<div class="batches index">
    <h2><?php echo __('Batches'); ?></h2>

    <?php
    if ($batches != "error") {
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
                <th><?php echo 'id'; ?></th>
                <th width="30%"><?php echo 'Batch Number'; ?></th>
                <th width="30%"><?php echo 'Provider License'; ?></th>
                <th width="30%"><?php echo 'Provider name'; ?></th>
                <th width="30%"><?php echo "Provider code" ?></th>
                <th width="30%"><?php echo "Claim Count" ?></th>
                <th width="30%"><?php echo "Assigned By" ?></th>
                <th width="30%"><?php echo "Assign to Claims Manager" ?></th>
                <th width="30%"><?php echo "Created" ?></th>
                <th class="actions"><?php echo __('View Pricing'); ?></th>
                <?php ?>
            </tr>
            <?php foreach ($batches as $key=> $batch): ?>
                <?php
                $batchstatus = $this->requestAction(array('controller' => 'batches', 'action' => 'getstatus', $batch['Batch']['id']));
                $prviderdetails      =   $this->requestAction(array('controller'=>'Providerdetails','action'=>'getdetails',$batch['Batch']['provider_id']));    
           
                ?>
                <tr class="<?php echo $batchstatus; ?>">
                    <td><?php echo h($key+1); ?>&nbsp;</td>
                    <td><?php echo $batch['Batch']['name']; ?>&nbsp;</td>
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
                        echo $this->requestAction(array('controller' => 'batches', 'action' => 'getclaimcountforbatch', $batch['Batch']['id']));
                        ?>
                    </td>
                    <td><?php echo $this->requestAction(array('controller' =>  'Batches','action' => 'getAssignerName/'.$batch['Batch']['id'].'/4')) ?></td>
                    <td>
                        <?php
                        echo $this->requestAction(array('controller' => 'Batches', 'action' => 'getStatusvalue', $batch['Batch']['status'], 'assign.png', 'Batches', 'assignBackToClaimsManager/' . $batch['Batch']['id'],$batch['Batch']['id']));
                        //echo $this->Html->link($this->Html->image('assign.png',array('title'=>'view xmldetails')), array('controller'=>'Batches','action' => 'assignBackToClaimsProcessor', $batch['Batch']['id']),array('escape'=>FALSE));
                        ?>
                    </td>
                    <td>
                        <?php echo date('d-M-Y', $batch['Batch']['created']->sec); ?>&nbsp;
                    </td>
                    <td>
                        <?php
                        echo $this->Html->image('down.png', array('title' => 'View Activity Pricings', 'class' => 'viewpricing', 'id' => $batch['Batch']['id']));
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

        else {
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
    <?php echo $this->element('logo'); ?>
    <ul>
        <li><?php echo $this->Html->link('List Batches', array('controller'=>'Batches','action' => 'listbatchesformedicalreceiver')); ?> </li>
    </ul>
</div>
    <?php
    echo $this->Js->writeBuffer();
    ?>
