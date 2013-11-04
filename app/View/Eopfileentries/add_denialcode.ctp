
<div class="denialadd" style="width:400px;">
    
    <fieldset>
        <legend align="center"><?php echo __('Add Denial Code'); ?></legend>
                <?php echo $this->Form->input('code',array('type'=>'select', 'label'=>'Leaf', 'options'=>$denial_code, 'default'=>'Select the Denial code','style' => 'margin-right:23px;')); ?>
                <?php echo $this->Form->submit("Add code",array('class' => 'btn','style' => 'margin:50px 0 0 75px;')) ?>
    </fieldset>
    <div style="color:black;font-size: 18px;" id="denialaddstatus"></div>
</div>



<script type="text/javascript">
    $(document).ready(function(){
        $('.btn').click(function(){
            var id      = "<?php echo $id; ?>";
            var code    = $("#code").val();
            $.ajax({ 
                url: "<?php echo Router::url('/', true);?>"+"Eopfileentries/saveComment/"+id+'/'+code,
                cache: false, 
               	dataType:'html',
		success: function(data) { 
                    $('#denialaddstatus').html('<p>Denial code added</p>');
		 } 
            }); 
        })
    })
</script>