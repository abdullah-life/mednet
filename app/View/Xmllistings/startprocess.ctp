<script type="text/javascript">
    var jQ         =    jQuery.noConflict();
    
    jQ(document).ready(function(){
        
       jQ("#pickxmlbutton").click(function(){
        jQ.ajax({
            url: './pickallxml',
            beforeSend:function(){
                jQ("#xml_picking_message").html("please wait while the xml is being picked");
            },
            success: function(data) {
                jQ("#xml_picking_message").html("<b style='color:red'>xml's were successfully picked. Click the button bellow to process the xml</b>");
                jQ("#pickxmlbutton").hide();
                jQ("#savexml").show();
                
            }
        }) 
    });
       jQ("#savexml").click(function(){
        jQ.ajax({
            url: './getNewFileUnprocessedXml',
            beforeSend:function(){
                jQ("#xml_picking_message").html("please wait while the xml is parsed and saved!!!");
            },
            success: function(data) {
                if(data==1){
                jQ("#xml_picking_message").html("<b style='color:red'>xml's were successfully parsed successfully and saved");
                jQ("#pickxmlbutton").hide();
                jQ("#savexml").show();
                }
                else{
                    jQ("#xml_picking_message").html("<b style='color:red'>time to set batch");
                    
                }
            }
        }) 
    });
    
    
    
    
  });
</script>

<div class="xmls index">
    <div id="picking xml" style="margin:20px;cursor: pointer">
       <input style="cursor:pointer" id="pickxmlbutton" type="submit" value="PICK DHA AND HAAD XMLS">
       <div id="xml_picking_message">
           
           
       </div>
    </div>
    <div id="savexml" style="margin:20px;display:none;">
        <input type="submit" id="savexml" value="parse and save xmls">
    </div>
</div>
<div class="actions">
	 <?php     echo $this->element('logo'); ?>
	<ul>
		<li><?php echo $this->Html->link(__('New Xml'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
