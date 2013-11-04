<?php

$this->Paginator->options(array(
                'update' => '.eopfileentries',
                'evalScripts' => true
                ));


?>


<?php echo $this->Html->script('blockui'); ?>

<script type="text/javascript">

$(document).ready(function(){
    $(".searchbyprovider").click(function(){
            var option ='exclude';
            if($('#InvoicenoteInclude').is(':checked'))
             { 
                 option = 'include';
             }
             $.ajax({ 
                url: "<?php echo Router::url('/',true);?>eopfileentries/ajaxupdate/"+option+'/'+$('.providers').val(),
                cache: false, 
               	dataType:'html',
                beforeSend: function()
                {
                   $(".eopfileentries").html("<img src='./img/ajax-loader.gif' align='center' style='margin:150px 0 0 475px;'>"); 
                },
		success: function(data) { 
                   
                    $(".eopfileentries").html(data);
		 } 
            });            
    });
});
</script>

<script type="text/javascript">
        function addDenialcode(id)
        {
            $.ajax({ 
                url: "<?php echo Router::url('/', true);?>"+"Eopfileentries/addDenialcode/"+id,
                cache: false, 
               	dataType:'html',
		success: function(data) {
                    $.blockUI({
                        css: { 
                            border: 'none', 
                            padding: '15px',  
                            '-webkit-border-radius': '10px', 
			    '-moz-border-radius': '10px', 
                            color: '#fff',
                            width:'400px',
                            hight:'300px',	 
                            top:   '100px', 
			    left: ($(window).width() - 400) /2 + 'px', 
			}, 
			'message':'<pr>'+data+'</p>'
		    }); 
                        $('.blockOverlay').attr('title','Click to unblock').click($.unblockUI); 
		    } 
            }); 
        }
</script>

	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('payment_run');?></th>
                        <th><?php echo $this->Paginator->sort('invoice_notes');?></th>
                        <?php if($edit  ==  1) {?>
                        <th><?php echo __("Denial code");?></th>
                        <?php } ?>
                        <?php if($edit==1) echo "<th>Add Denial Code</th>";?>
			<th><?php echo $this->Paginator->sort('account_number');?></th>
			<th><?php echo $this->Paginator->sort('account_description');?></th>
			<th><?php echo $this->Paginator->sort('payment_number');?></th>
			<th><?php echo $this->Paginator->sort('payment_external_reference');?></th>
			<th><?php echo $this->Paginator->sort('payment_receipt_date');?></th>
			<th><?php echo $this->Paginator->sort('batch_number');?></th>
			<th><?php echo $this->Paginator->sort('batch_external_reference');?></th>
			<th><?php echo $this->Paginator->sort('batch_received_date');?></th>
			<th><?php echo $this->Paginator->sort('due_date');?></th>
			<th><?php echo $this->Paginator->sort('batch_claimed_amount');?></th>
			<th><?php echo $this->Paginator->sort('payer_code');?></th>
			<th><?php echo $this->Paginator->sort('payer_name');?></th>
			<th><?php echo $this->Paginator->sort('payee_code');?></th>
			<th><?php echo $this->Paginator->sort('payee_name');?></th>
			<th><?php echo $this->Paginator->sort('report_number');?></th>
			<th><?php echo $this->Paginator->sort('policy_number');?></th>
			<th><?php echo $this->Paginator->sort('policy_holder_name');?></th>
			<th><?php echo $this->Paginator->sort('insured_number');?></th>
			<th><?php echo $this->Paginator->sort('insured_member_first_name');?></th>
			<th><?php echo $this->Paginator->sort('insured_member_father_name');?></th>
			<th><?php echo $this->Paginator->sort('insured_member_last_name');?></th>
			<th><?php echo $this->Paginator->sort('claim_type');?></th>
			<th><?php echo $this->Paginator->sort('claim_number');?></th>
			<th><?php echo $this->Paginator->sort('external_invoice_ref');?></th>
			<th><?php echo $this->Paginator->sort('invoice_ref');?></th>
			<th><?php echo $this->Paginator->sort('invoice_date');?></th>
			<th><?php echo $this->Paginator->sort('report_date');?></th>
			<th><?php echo $this->Paginator->sort('inv_rejection_reason_code');?></th>
			<th><?php echo $this->Paginator->sort('inv_rejection_reason_desc');?></th>
			<th><?php echo $this->Paginator->sort('date_of_service');?></th>
			<th><?php echo $this->Paginator->sort('procedure_type');?></th>
			<th><?php echo $this->Paginator->sort('procedure_type_description');?></th>
			<th><?php echo $this->Paginator->sort('procedure_code');?></th>
			<th><?php echo $this->Paginator->sort('procedure_description');?></th>
			<th><?php echo $this->Paginator->sort('external_reference');?></th>
			<th><?php echo $this->Paginator->sort('quantity');?></th>
			<th><?php echo $this->Paginator->sort('claimed_amount');?></th>
			<th><?php echo $this->Paginator->sort('correction_amount');?></th>
			<th><?php echo $this->Paginator->sort('discount_amount');?></th>
			<th><?php echo $this->Paginator->sort('denied_amount');?></th>
			<th><?php echo $this->Paginator->sort('approved_amount');?></th>
			<th><?php echo $this->Paginator->sort('insured_part');?></th>
			<th><?php echo $this->Paginator->sort('insurer_part');?></th>
			<th><?php echo $this->Paginator->sort('paid_part');?></th>
			<th><?php echo $this->Paginator->sort('tax');?></th>
			<th><?php echo $this->Paginator->sort('provider_claimed_amount');?></th>
			<th><?php echo $this->Paginator->sort('invoice_line_notes');?></th>
			<th><?php echo $this->Paginator->sort('indicator1');?></th>
			<th><?php echo $this->Paginator->sort('indicator2');?></th>
			<th><?php echo $this->Paginator->sort('indicator3');?></th>
			
                        
			
	</tr>
	<?php
	foreach ($eopfileentries as $key=>$eopfileentry): ?>
            
        <tr <?php if(isset($eopfileentry['Eopfileentry']['denial_code'])) echo 'class="setbgcolor"'; ?>>
		<td ><?php echo h($key+1); ?>&nbsp;</td>
		<td><?php echo h(substr($eopfileentry['Eopfileentry']['invoice_notes'],0,30).'.....'); ?>&nbsp;</td>
                <?php if($edit==1) {?>
                <td><?php echo h($eopfileentry['Eopfileentry']['denial_code']); ?></td>
                <?php } ?>
		<td ><?php echo h($eopfileentry['Eopfileentry']['payment_run']); ?>&nbsp;</td>
		<?php
                        if($edit == 1)
                        {
                                echo '<td class="curpointer">'.$this->Html->image('edit9.png',array('class' => 'addcomment','onclick' => 'addDenialcode(\''.$eopfileentry['Eopfileentry']['id'].'\')','id' => $eopfileentry['Eopfileentry']['id'])).'</td>';
                        }
                ?>
                <td><?php echo h($eopfileentry['Eopfileentry']['account_number']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['account_description']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['payment_number']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['payment_external_reference']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['payment_receipt_date']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['batch_number']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['batch_external_reference']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['batch_received_date']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['due_date']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['batch_claimed_amount']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['payer_code']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['payer_name']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['payee_code']); ?>&nbsp;</td>
		<td><?php echo h(substr($eopfileentry['Eopfileentry']['payee_name'],0,20).'...'); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['report_number']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['policy_number']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['policy_holder_name']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['insured_number']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['insured_member_first_name']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['insured_member_father_name']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['insured_member_last_name']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['claim_type']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['claim_number']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['external_invoice_ref']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['invoice_ref']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['invoice_date']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['report_date']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['inv_rejection_reason_code']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['inv_rejection_reason_desc']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['date_of_service']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['procedure_type']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['procedure_type_description']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['procedure_code']); ?>&nbsp;</td>
                <td><?php echo h(substr($eopfileentry['Eopfileentry']['procedure_description'],0,30).'...'); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['external_reference']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['quantity']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['claimed_amount']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['correction_amount']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['discount_amount']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['denied_amount']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['approved_amount']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['insured_part']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['insurer_part']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['paid_part']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['tax']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['provider_claimed_amount']); ?>&nbsp;</td>
                <td><?php echo h($eopfileentry['Eopfileentry']['invoice_line_notes']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['indicator1']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['indicator2']); ?>&nbsp;</td>
		<td><?php echo h($eopfileentry['Eopfileentry']['indicator3']); ?>&nbsp;</td>
		
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
<?php
echo $this->Js->writeBuffer();
?>