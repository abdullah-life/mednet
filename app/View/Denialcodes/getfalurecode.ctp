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
    



    
</script>

<?php
    echo '<input name="activityid" id="activityid" value="'.$activityid.'" type="hidden"/>';
    echo '<select id="activitydenail" style="display:none">';
    echo '<option value=null></option>';
    
    
    foreach ($remittancecommentsarray as $key => $comment)
    {
        
        
            if($denial_code != $key)
            {
                echo '<option '.$default.'value="'.$key.'">'.$key.' '.$comment.'</option>';
            }
            else{
                echo '<option '.$default.'value="'.$key.'" selected="selected">'.$key.' '.$comment.'</option>';
            }
    }
    echo '</select>';
    ?>
<div>
<?php
    
    echo '<input type="submit" id="show_activity_denail" value="show Denial code">';
    echo '<input type="submit" style="display:none" id="add_activity_denail" onclick="savedenailcode()" value="Save Denial code">';
    echo '<input type="submit" id="remove_activity_denail" onclick="removeDenial()" value="Remove Denial code">';
?>
</div>
<style> 
    input{
        margin:10px;
    }
</style>
 <script type="text/javascript">
    $(document).ready(function(){
     
       
    })
    
</script>
<script type="text/javascript">
    
    
    function savedenailcode(){
     
            //Messi.load('<?php echo Router::url('/',true) ?>/denialcodes/updateactivitydenail/', {params: {'activity': 'demo', 'denyalcode': '1234'}});
               var denialcode    =   $("#activitydenail").val();
                $.ajax({
                        url: '<?php echo Router::url('/',true) ?>/denialcodes/updateactivitydenail/',
                        type: "POST",
                        data:{'activity':  $("#activityid").val(), 'denialcode': $("#activitydenail").val()},
                    }).done(function(data){
                       if(data){new Messi(data,{title: 'Title', titleClass: 'success', buttons: [{id: 0, label: 'Close', val: 'X'}]});
                            var innerhtml   =   '<img width="20" height="20" alt="" style="cursor:pointer" class="havedenial" onclick="activityfailure(&quot;5211f663fb24f8ce3b00383b&quot;)" data-original-title='+denialcode+' src="<?php echo Router::url('/',true)?>img/unfailedactivity1.png">';
                            $('.'+$("#activityid").val()).html(innerhtml);
                        }
                       else new Messi('Error adding Denail code', {title: 'Title', titleClass: 'anim error', buttons: [{id: 0, label: 'Close', val: 'X'}]});
                    });
                    value = 'null';
    }
    function removeDenial(){
        $.ajax({
            url:'<?php echo Router::url('/',true)?>/denialcodes/removeactivitydenial',
            type:'POST',
            data:{activity:$("#activityid").val()}
        }).done(function(data){
            new Messi(data,{title: 'Title', titleClass: 'success', buttons: [{id: 0, label: 'Close', val: 'X'}]});
            $('.ui-state-default').val('');
            var innerhtml   =   '<img width="20" height="20" alt="" style="cursor:pointer" onclick="activityfailure(&quot;5211f663fb24f8ce3b00383b&quot;)" title="Click here to mark/unmark as fail this activity" src="<?php echo Router::url('/',true)?>img/unfaliedactivity.png">';
            $('.'+$("#activityid").val()).html(innerhtml);
        })
    }
     $(document).ready(function(){
       
 
        $('#show_activity_denail').live('click',function(){
             
                $(this).hide();
                $('#add_activity_denail').show();
               $('#activitydenail').combobox();
               $('#activitydenail').css('display','none');
               $('.ui-autocomplete').css('z-index','100001');
        })
        
        $('.havedenial').live('mouseover',function(){
            //$( document ).tooltip();
        })
        
     
    })
    
</script>
