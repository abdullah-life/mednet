
<link rel="stylesheet" href="/resources/demos/style.css" />
<script>
     
(function( $ ) {
$.widget( "ui.combobox", {
_create: function() {
this.wrapper = $( "<span>" )
.addClass( "ui-combobox" )
.insertAfter( this.element );
this._createAutocomplete();
this._createShowAllButton();
},
_createAutocomplete: function() {
var selected = this.element.children( ":selected" ),
value = selected.val() ? selected.text() : "";
this.input = $( "<input>" )
.appendTo( this.wrapper )
.val( value )
.attr( "title", "" )
.addClass( "ui-state-default ui-combobox-input ui-widget ui-widget-content ui-corner-left" )
.autocomplete({
delay: 0,
minLength: 0,
source: $.proxy( this, "_source" )
})
.tooltip({
tooltipClass: "ui-state-highlight"
});
this._on( this.input, {
autocompleteselect: function( event, ui ) {
ui.item.option.selected = true;
this._trigger( "select", event, {
item: ui.item.option
});
},
autocompletechange: "_removeIfInvalid"
});
},
_createShowAllButton: function() {
return true;
var wasOpen = true;
$( "<a>" )
.attr( "tabIndex", -1 )
.attr( "title", "Show All Items" )
.tooltip()
.appendTo( this.wrapper )
.button({
icons: {
primary: "ui-icon-triangle-1-s"
},
text: false
})
.removeClass( "ui-corner-all" )
.addClass( "ui-corner-right ui-combobox-toggle")
                        .mousedown(function() {
                    wasOpen = input.autocomplete("widget").is(":visible");
                })
                        .click(function() {
                    input.focus();
// Close if already visible
                    if (wasOpen) {
                        return;
                    }
// Pass empty string as value to search for, displaying all results
                    input.autocomplete("search", "");
                });
            },
            _source: function(request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function() {
                    var text = $(this).text();
                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }));
            },
            _removeIfInvalid: function(event, ui) {
// Selected an item, nothing to do
                if (ui.item) {
                    return;
                }
// Search for a match (case-insensitive)
                var value = this.input.val(),
                        valueLowerCase = value.toLowerCase(),
                        valid = false;
                this.element.children("option").each(function() {
                    if ($(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });
// Found a match, nothing to do
                if (valid) {
                    return;
                }
// Remove invalid value
                this.input
                        .val("")
                        .attr("title", value + " didn't match any item")
                        .tooltip("open");
                this.element.val("");
                this._delay(function() {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.data("ui-autocomplete").term = "";
            },
            _destroy: function() {
                this.wrapper.remove();
                this.element.show();
            }
        });
    })(jQuery);
    function activityfailure(activityid){
           Messi.load("<?php echo Router::url('/',true) ?>"+"/denialcodes/getfalurecode/"+activityid,{width:'600px',title: 'Add Activity Denial Code'});
    }
</script>
<div class="activityholder" style="width:100%;">

    <?php
    $this->Paginator->options(array(
        'update' => '.activityholder',
        'evalScripts' => true
    ));
    ?>

    <style>
        tr{
            white-space: nowrap;
        }
        .markactivity{
            
            cursor: pointer;
        }
        #activity tr td,th{
            font-size:10px;
            padding:0px !important;
        }
        .ui-autocomplete
        {
            z-index: 100000;
        }
        .claimcomment
        {
            display: none;
        }
        .searchclaim
        {
            margin-top: 25px;
        }
        .comboitem
        {
            float: left;                
        }
        .deletecomment
        {
            float: left;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
           $('.searchclaim').removeClass("now");
        });
    $('.paging a').live('click',function(){
       
       if($(this).attr('href')){
             //Messi.load($(this).attr('href'));
       }
        
    })
    function markactivity(activity,element){
        var invoice =   activity;
        
         $.ajax({ 
                url: "<?php echo Router::url('/', true);?>"+"Activities/markactivity/"+invoice,
                cache: false, 
               	dataType:'html',
		success: function(data) { 
                   if(data=="unmarked"){
                        $(element).attr("src",'<?php echo Router::url('/', true);?>img/unmarked.png')
                   }
                   if(data=="marked"){
                      $(element).attr("src",'<?php echo Router::url('/', true);?>img/marked.png')
                    }
                    
		 } 
            }); 
    
    }
    
    function makeajaxcallforcomment(e)
    {
        var claimid     =   '<?php if(!$claimid){$sortedaray   =   array_values($claimslisting); echo $sortedaray[0];} else echo  $claimid;?>';
        var commentid   =   $('.claimcomment').val();
        if(commentid=='')
        {
            alert("Please choose a comment from the list");
        }
        else
        {    
            $.ajax({ 
                url: "<?php echo Router::url('/', true);?>"+"claims/markclaimcomment/"+claimid+'/'+commentid,
                cache: false, 
               	dataType:'html',
		success: function(data) { 
                   if(data=="True"){
                       new Messi('<p class="success">Claim comment updated</p>');
                   }
                   if(data=="false"){
                     new Messi('<p class="error">Claim comment could not be updated</p>');
                    }
                    
		 } 
            });
        }
        e.stopImmediatePropagation();
        e.preventDefault(); 
    }
    function makeajaxcallfordeletecomment()
    {
           //var claimid     =   $("#select_id").val();
           var claimid     =   '<?php if(!$claimid){$sortedaray   =   array_values($claimslisting); echo $sortedaray[0];} else echo  $claimid;?>';
           $.ajax({ 
                url: "<?php echo Router::url('/', true);?>"+"claims/deleteclaimcomment/"+claimid,
                cache: false, 
               	dataType:'html',
		success: function(data) { 
                   if(data=="True"){
                       new Messi('<p class="success">Claim comment updated</p>');
                   }
                   if(data=="false"){
                     new Messi('<p class="error">Claim comment could not be updated</p>');
                    }
                    
		 } 
            });
    }
    
    $(document).ready(function(){
       $(".paging a").live('click',function(){
           var url  =   $(this).attr('href');
            $.ajax({ 
                url: url,
                cache: false, 
               	dataType:'html',
		success: function(data) { 
                  $(".activityholder").html(data);
               } 
            });
           return false;

       })
    
    })

    </script>
    <div id="search" style="width:950px;height:auto;float:left;border: 1px solid #CDCDCD !important;">
<?php echo $this->Form->create('Activity Search', array('class' => 'search_form')); ?>
        <div class="search_box" align="left">
            <table border="0" class="search_tbl">
                <tr>
                    <td class="searchforclaim">
                            <span id="currentclaim"><?php if(!$claimid){$sortedaray   =   array_values($claimslisting); echo $sortedaray[0];} else echo  $claimid;?></span>
                        
                        <select id="select_id" style="display:none">
                                <?php
                                    foreach ($claimslisting as $claimidlist)
                                    {
                                        $flag=0;
                                        foreach ($mclaims as $mclaim)
                                        {
                                            if($claimidlist ==  $mclaim)
                                            {
                                                
                                                foreach($claimsmarked as $claimmarked)
                                                {
                                                    if($claimidlist == $claimmarked)
                                                    {
                                                        $flag=3;
                                                        break; 
                                                    }
                                                }
                                                if($flag==0)
                                                {
                                                    $flag=2;
                                                }
                                                break;
                                            }
                                        }
                                      
                                       
                                        
                                        foreach($claimsmarked as $claimmarked)
                                        {
                                            if($claimidlist == $claimmarked)
                                            {
                                                if($flag==0)
                                                {
                                                    $flag=1;
                                                }
                                                break;
                                            }
                                        }
                                        if($flag == 3)
                                        {
                                            if($claimid==$claimidlist)
                                            {
                                                echo '<option selected="selected" value="'.$claimidlist.'">(M) (F) '.$claimidlist.'</option>';

                                            }
                                            else 
                                                echo '<option value="'.$claimidlist.'">(M) (F) '.$claimidlist.'</option>';

                                        }
                                        else if($flag==2)
                                        {
                                            if($claimid==$claimidlist)
                                            {
                                                echo '<option selected="selected" value="'.$claimidlist.'">(M) '.$claimidlist.'</option>';
                                                
                                            }
                                            else 
                                                echo '<option value="'.$claimidlist.'">(M) '.$claimidlist.'</option>';

                                        }
                                        else if($flag==1)
                                        {
                                            if($claimid==$claimidlist)
                                            {
                                                echo '<option selected="selected" value="'.$claimidlist.'">(F) '.$claimidlist.'</option>';

                                            }
                                            else 
                                                echo '<option value="'.$claimidlist.'">(F) '.$claimidlist.'</option>';
                                        }
                                        else
                                        {
                                            if($claimid==$claimidlist)
                                            {
                                                echo '<option selected="selected" value="'.$claimidlist.'">'.$claimidlist.'</option>';

                                            }
                                            else 
                                                echo '<option value="'.$claimidlist.'">'.$claimidlist.'</option>';

                                        }
                                    }
                                ?>
                                </select>
                            <div>
                        <button class="searchclaim" onclick="return false;">Click to search Claims</button>
                        </div> 
                            <?php //echo $this->Form->input('claim_id', array('label'=>'Select claim ID','type' => 'select', 'options' => $claimslisting, 'empty' => 'select claim id', 'style' => 'margin-top:10px', 'id' => 'select_id','default'=>$claimid)); ?>
                            <?php echo $this->Form->input('batchid', array('type' => 'hidden', 'value' => $batchid, 'id' => 'batchid')); ?>
                    </td>
                    <?php 
                        if($this->Session->read('Auth.User.group_id')==16 or $this->Session->read('Auth.User.group_id')==17 )
                        ?>
                    <td class="commentstoclaim">
                        <span id="currentcomment"><?php 
                            foreach ($remittancecommentsarray  as $key => $comments)
                            {
                                foreach($comments as $newkey => $code)
                                {
                                    if($code == $presentclaim['Claim']['comment_id'])
                                    {
                                        echo $code;
                                        $selected   =  $code; 
                                    }
                                }
                            }
                            //echo $remittancecommentsarray[$presentclaim['Claim']['comment_id']];
                        ?></span>
                          <?php
                                echo '<select class="claimcomment">';
                                echo '<option value=null>Select a Comment</option>';
                                foreach ($remittancecommentsarray as $key => $comment)
                                {
                                    foreach ($comment as $newkey => $code)
                                    {
                                        if( $selected==$code) $default =   "selected = 'selected'";
                                        else $default = "";
                                            
                                        echo '<option '.$default.'value="'.$newkey.'">'.$code.' '.$key.'</option>';
                                    }
                                }
                                echo '</select>';
                                //echo $this->Form->input('', array('type' => 'select', 'options' => $remittancecommentsarray, 'class' => 'claimcomment', 'empty' => 'select a comment', 'style' => 'margin-top:10px', 'id' => 'comments'.$claimidformessi,'default'=>$presentclaim['Claim']['comment_id'])); 
                          ?>
                         <div style="margin-top:26px;">
                            <button class="comboitem" onclick="return false;">Click here to add comment</button>
                            <button class="deletecomment" onclick="return false;" style="display: none;">Delete Comment</button>
                        </div> 
                    </td>
                    <?php 
                        ?>
                </tr>
            </table>
        </div>
    </div>

    <table cellpadding="0" cellspacing="0" id="activity" >
        <tr>
            <th><?php echo 'Claim'; ?></th>
            <th><?php echo 'activity id'; ?></th>
            <th><?php echo 'member id'; ?></th>
            <th><?php echo $this->Paginator->sort( 'start'); ?></th>
            <th><?php echo 'Type'; ?></th>
            <th><?php echo 'benefit'; ?></th>
            <th><?php echo "benefit <br/> Desc"; ?></th>
            <th><?php echo 'Code'; ?></th>
            <th><?php echo 'Qnty'; ?></th>
            <th><?php echo "RND price"?></th>
            <th><?php echo 'Net'; ?></th>
            <th><?php echo 'Clinician'; ?></th>
            <th><?php echo "Prior  <br/> Auth  <br/>  ID"; ?></th>
            <th><?php echo "Gross  <br/>  Price"; ?></th>
            <th><?php echo 'Discount'; ?></th>
            <th><?php echo "Discount<br/> Price"; ?></th>
           
            <th><?php echo $this->Paginator->sort( 'date'); ?></th>
            <th><?php echo $this->Paginator->sort('marked'); ?></th>
            
             <th><?php echo "Obs"; ?></th>
             <th><?php echo 'Denial codes'; ?></th>
             <th><?php echo ' comment'; ?></th>
        </tr>
       
<?php foreach ($activities as $activity): ?>
            
          <?php
              $benefitsdetails = $this->requestAction(array('controller' => 'Benefits', 'action' => 'descriptionforProviderpricing/' . $activity['Activity']['Code'] . '/' . $activity['Activity']['Type']));
              $claimdetails    =$this->requestAction(array('controller' => 'claims', 'action' => 'getclaimdetails/' . $activity['Activity']['claim_id'] ));
             
              ?>
        
            <tr>
                <td ><?php echo $claimdetails['Claim']['claim']['xmlclaimID'];?>&nbsp;</td>
                <td ><?php echo h($activity['Activity']['Activity_id']); ?>&nbsp;</td>
                <td ><?php echo h($claimdetails['Claim']['claim']['MemberID']); ?>&nbsp;</td>
                <td ><?php echo date('Y-m-d',strtotime($activity['Activity']['start'])); ?>&nbsp;</td>
                <td ><?php echo h($activity['Activity']['Type']); ?>&nbsp;</td>
                <td ><?php echo $benefitsdetails['Benefit']['BENEFIT']; ?>&nbsp;</td>
                <td ><?php if(strlen($benefitsdetails['Benefit']['LOCAL_DESCRIPTION_1'])>10) echo substr($benefitsdetails['Benefit']['LOCAL_DESCRIPTION_1'],0,10).'....'; else  echo $benefitsdetails['Benefit']['LOCAL_DESCRIPTION_1']; ?>&nbsp;</td>
                <td ><?php echo h($activity['Activity']['Code']); ?>&nbsp;</td>
                <td ><?php echo h($activity['Activity']['Quantity']); ?>&nbsp;</td>
                <td ><?php echo h(round($activity['Activity']['Quantity'],2)); ?>&nbsp;</td>
                <td ><?php echo h($activity['Activity']['Net']); ?>&nbsp;</td>
                <td  ><?php echo h($activity['Activity']['Clinician']); ?>&nbsp;</td>
                 <?php 
                  if($activity['Activity']['Type']!=5){
                    $gorss = $this->requestAction(array('controller' => 'Xmllistings', 'action' => 'getnetpricefromactivity/'.$presentclaim['Claim']['claim']['ProviderID'].'/'.$activity['Activity']['id']));
                  }else{
                    
                    $gorss = $this->requestAction(array('controller' => 'Typefivepricings', 'action' => 'getnetpricefromactivity/'.$presentclaim['Claim']['claim']['ProviderID'].'/'.$activity['Activity']['id']));  
                      
                      
                  }
?>
                <td ><?php echo $activity['Activity']['ProrAuthorizationID']; ?></td>
                
                <td ><?php print_r($gorss) ; ?></td>
                
                <td ><?php if($discound_details['0']['Providerpricing']['discount']=='') echo "-"; else echo $discound_details['0']['Providerpricing']['discount']; ?>&nbsp;</td>
                <td ><?php if($discound_details['0']['Providerpricing']['discountprice']=='') echo "-"; else echo $discound_details['0']['Providerpricing']['discountprice']; ?>&nbsp;</td>
                <td ><?php if($discound_details['0']['Providerpricing']['start_date']=='') echo "-"; else echo substr($discound_details['0']['Providerpricing']['start_date'],0,10);?>&nbsp;</td>
                <?php 
                    if($activity['Activity']['marked']==1)
                       echo '<td>' .$this->Html->image('marked.png',array('class'=>'markactivity','title'=>'UnMark this invoice','onclick'=>'markactivity("'.$activity['Activity']['id'].'",this)', 'invid'=>$activity['Activity']['id']))."</td>";
                    else
                        echo'<td>' . $this->Html->image('unmarked.png',array('class'=>'markactivity', 'title'=>'mark this invoice','onclick'=>'markactivity("'.$activity['Activity']['id'].'",this)','invid'=>$activity['Activity']['id']))."</td>";
                ?>
                <td>
                    <?php
                        if(isset($activity['Activity']['Observation']))
                        {
                            echo  $this->Html->image('folder-closed.gif',array('class'=>'observations', 'title'=>'View Observations','invid'=>$activity['Activity']['id'],'clid' => $claimdetails['Claim']['claim']['xmlclaimID']));
                        }
                        else
                        {
                            echo '-';
                        }
                    ?>
                </td>
                <td id="addactivity" class="<?php echo $activity['Activity']['id']?>">
                   <?php 
                        if($activity['Activity']['denailcode']==null)
                        {
                            echo  $this->Html->image('unfaliedactivity.png',array('width'=>'20','height'=>'20','title'=>'Click here to mark fail this activity','onclick'=>'activityfailure("'.$activity['Activity']['id'].'")','style'=>'cursor:pointer')); 
                        }else{
                            echo  $this->Html->image('unfailedactivity1.png',array('width'=>'20','height'=>'20','class' => 'havedenial','title'=>$activity['Activity']['denailcode'],'denaildesc'=>$activity['Activity']['Description'],'onclick'=>'activityfailure("'.$activity['Activity']['id'].'")','style'=>'cursor:pointer')); 
                        }    
                   ?>
                    
                </td> 
                <td id="commenttd"><?php  echo $this->requestAction(array('controller'   =>  'Activities','action'=>'getLink',$activity['Activity']['id'],count($activity['Activity']['comments'])));?>
                 </tr>
                 <?php 
                 
     
                 ?>
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
</div>
<script type="text/javascript">
    $(document).ready(function(e){
        
        
        $('.observations').live("click",function(){
            
            Messi.load("<?php echo Router::url('/',true) ?>"+"Activities/viewObservation/"+$(this).attr('invid')+'/'+$(this).attr('clid'),{width:'1200px'});
            e.stopImmediatePropagation();
            e.preventDefault(); 
        });
    });
</script>



<script type="text/javascript">
    $(document).ready(function(){
        $('body').popover({
        trigger:'hover',
        title:$(this).attr('data-original-title'),
         content: function () {
             
            return $(this).attr('denaildesc');
            },
        selector: '[class=havedenial]'
    });
             
        $('.searchclaim').live("click",function(e){
            if($(this).hasClass("now"))
            {
               makeajaxcall();
            }
            else
            {
                
               $("#currentclaim").html("");
                $(this).addClass("now");
                $('#select_id').combobox();
                $(this).html('Search Claims');
                $('.ui-state-default').addClass("searchclaims");
            }
            e.stopImmediatePropagation();
            e.preventDefault();
        });
        $('.comboitem').live("click",function(e){
            if($(this).hasClass("now"))
            {
                makeajaxcallforcomment();
            }
            else
            {
                $("#currentcomment").html("");
                $(this).html("Add comment");
                $('.claimcomment').combobox();
                $(this).css('marginRight','20px');
                $(this).css('marginLeft','66px');
                $(this).addClass("now");
                $('.deletecomment').css('display','block');
                $(this).parent().parent().find('input').css('marginRight','84px');
            }
             e.stopImmediatePropagation();
            e.preventDefault();
        });
        $('.deletecomment').live("click",function(e){
            makeajaxcallfordeletecomment();
            e.stopImmediatePropagation();
            e.preventDefault();
        });
    });
</script>
