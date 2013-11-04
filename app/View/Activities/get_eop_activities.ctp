<script type="text/javascript">
     $(document).ready(function(){
        $("#select_id").on('change',function(){
      
        
            if($(this).val()!=""){
               var providerid   =   $(this).val();
               var eopfileid    =   $('#eopfileid').val();
                 $.ajax({
                            type:"GET",
                            dataType: "html",
                            url: "<?php echo Router::url('/', true); ?>" + "Activities/getEopclaims/" + providerid+'/'+eopfileid,
                            beforeSend: function() {
                                   $("#claimslist").html("Loading....");
                            },
                           complete: function(data) {
                               $("#claimslist").html(data.responseText);
                           },
                       })
            }
        })
         $("#remitanceclaimid").on('change',function(){
            alert("asd");
         })

     })
     
 </script>    
<div class="activityholder" style="width:100%;">
<div id="search" style="width:950px;height:auto;float:left;border: 1px solid #CDCDCD !important;">
<?php echo $this->Form->create('Activity Search', array('class' => 'search_form')); ?>
        <div class="search_box" align="left">
            <table border="0" class="search_tbl">
                <tr>
                    <td>
                        <?php echo $this->Form->input('Provider_id', array('id'=>'providerid','label'=>'Select Provider','type' => 'select', 'options' => $providerlists, 'empty' => 'select Provider id', 'style' => 'margin-top:10px', 'id' => 'select_id','default'=>$claimid)); ?>
                        <?php echo $this->Form->input('eopfileid', array('type' => 'hidden', 'value' => $eopfileid, 'id' => 'eopfileid')); ?>
                    </td>
                </tr>
                <tr >
                    <td id="claimslist" >
                        
                    </td>
                </tr>
            </table>
        </div>
    </div>
<?php
echo $this->Js->writeBuffer();
?>
</div>
<div id="activity">


</div>
