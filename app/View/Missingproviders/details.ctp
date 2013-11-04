<div class="medicalmanagerBatches index">
	<h2><?php echo __('Providers');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('licence');?></th>
			<th><?php echo $this->Paginator->sort('SenderID');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
	</tr>
	<?php
	foreach ($providers as $key =>  $provider): ?>
	<tr>
            <td><?php echo $key+1;?></td>
            <td><?php echo $provider['Missingprovider']['licence'];?></td>
            <td><?php echo $provider['Missingprovider']['ReceiverID'];?></td>
            <td><?php echo $provider['Missingprovider']['status'];?></td>
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
    <div class="download">
        <?php 
            if(!isset($providers[0])){
        ?>
            <span class="linktodonload"><?php echo '<a href="'.Router::url('/',true).'app/webroot/files/missingproviders.xlsx">Download Excel</a>';?></span>
        <?php
            }else{
            
        ?>
            <span class="btntodownload">Generate Excel</span>
        <?php } ?>
        
    </div>
</div>
<style>
    #header_main_nav{
        margin:0px !important;
    }
    .download{
        padding:20px 0px;
        margin-top: 94px;
        font-size: 16px;
    }
    .btntodownload{
        max-width: 250px;
        height: 10px;
        background-color:#3276b1;
        border:1px solid #bbb;
        padding:10px 20px;
        cursor: pointer;
        color:white;
        -webkit-border-radius: 5px;
        border-radius: 5px;
    }
    .btntodownload:hover{
        background-color: #3168B0;
    }
    .actions{
        padding-right: 40px;
    }
    .download img{
        margin-left:50px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $('.btntodownload').click(function(){
            $(this).removeClass('btntodownload');
            if($(this).hasClass("btntodownload")){
                $(this).html('<img src="<?php echo Router::url('/',true)?>app/webroot/img/ajax-loader.gif">');
            }
            var elem=$(this);
            $.ajax({
                url: "<?php echo Router::url('/',true)?>Missingproviders/create",
                context: document.body
            }).done(function(data) {
                $( elem ).html( data );
                $(elem).addClass('linktodonload');
            });
        });
    })
</script>