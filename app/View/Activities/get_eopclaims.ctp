<script type="text/javascript">
    $(document).ready(function(){
       $("#remitanceclaimid").on('change',function(){
            
            var claimid     =   $(this).val();
            $.ajax({
                        type:"GET",
                        dataType: "html",
                        url: "<?php echo Router::url('/', true); ?>" + "Activities/getclaimactivitiesforremittance/" + claimid,
                        beforeSend: function() {
                               $("#activity").html("Loading....");
                        },
                       complete: function(data) {
                           $("#activity").html(data.responseText);
                       },
                   })
            
         })
    });
</script>

<?php 
echo $this->Form->input('claim_id', array('label'=>'Select claim ID','id'=>'remitanceclaimid','type' => 'select', 'options' => $claimarray, 'empty' => 'select claim id', 'style' => 'margin-top:10px', 'id' => 'remitanceclaimid')); ?>
<div id="activity"></div>