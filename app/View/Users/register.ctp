<script type="text/javascript">
var jQ = jQuery.noConflict();
jQ(document).ready(function(){
    jQ("#country_id").change(function(){
        var country_id = jQ("#country_id").attr('value');
        jQ.ajax({
          url: "../States/get_states_list",
          cache: false,
          type: "POST",
          data: "country_id="+country_id+"&form_name=User",
          success: function(html){
            jQ("#State_list_block").html(html);
          }
        });
    })
    jQ("#state_id").live("change",function(){
        var state_id = jQ("#state_id").attr('value');
        jQ.ajax({
          url: "../Cities/get_city_list",
          cache: false,
          type: "POST",
          data: "state_id="+state_id+"&form_name=User",
          success: function(html){
            jQ("#City_list_block").html(html);
          }
        });
    })
    
});    
    
</script>
<div>
<?php echo $this->Form->create('User');?>
         <?php
                echo $this->Form->input('fname',array('label' => 'First Name'));
		echo $this->Form->input('lname',array('label' => 'Last Name'));
		echo $this->Form->input('username');
                echo $this->Form->input('email');
		echo $this->Form->input('password');
//                $country = $this->requestAction(array('controller' => 'countries','action' => 'get_country'));
//                echo $this->Form->input('country_id',array('id'=>'country_id','empty'=>'select','options' => $country));
            ?>
                <div id="State_list_block">
               
                </div>
                <div id="City_list_block">
                    
                </div>
                
                <?php
		echo $this->Form->input('phone');
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
