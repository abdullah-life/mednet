<style>
    .index th a{
        font-size:11px;
    }
    .index tr {
        font-size:11px;
    }
    .index{
        
        height: 400px;
    }
    
    .providers option
    {
        display: none;
    }
    .providers
    {
        display: none;
    }
    .ui-state-default
    {
        margin-top: 20px;
        margin-left: 10px;
    }
    .select input
    {
        margin-top: 30px;
    }
    .input label
    {
        width:150px;
    }
    .select label
    {
        line-height: 75px;
    }
   
</style>

<?php
   if($eopfileentries!="error"){
    $this->Paginator->options(array(
    'update' => '#content',
    'evalScripts' => true,
     'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
     'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),   
  ));
 }
?>


 

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
<div class="eopfileentries index">
	
	
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var checkboxvalue1   =   '<?php echo $_SESSION['select']?>';
        if(checkboxvalue1 == 'include')
        {
            $('#InvoicenoteInclude').prop('checked', true);
        }
        var checkboxvalue2   =   '<?php echo $_SESSION['approvedamount']?>';
        if(checkboxvalue2 == 'yes')
        {
            $('#approved').prop('checked', true);
        }
        var checkboxvalue3   =   '<?php echo $_SESSION['denialamount']?>';
        if(checkboxvalue3 == 'yes')
        {
            $('#denial').prop('checked', true);
        }
    })
</script>

<div class="searcheop">
    <div id="Searchboxleft" style="border:1px solid black;width:220px;height:auto;">
        <div class="eoplinks">
            <ul>
                <li><?php echo $this->Html->link('List Eop Files',array('controller'    =>  'Eopfiles', 'actions'   =>  'index'))?></li>
            </ul>
        </div>
        <div class="searchbutton" style="margin:10px;float:left;">
            
              <?php echo $this->Form->input('Providers',array('type' =>  'select','options'  =>  $providers,'class'=>'providers','empty' => 'Select Provider')); ?>
              <?php echo $this->Form->input('Invoicenote', array(
                'type' => 'select',
                'multiple' => 'checkbox',
                'options' => array(
                    'include' => 'include invoice note'
                 )
              ));  ?>
              <?php echo $this->Form->input('Approved amount = 0',array('type' => 'checkbox','id' => 'approved'))?>
              <?php echo $this->Form->input('Denailamount > 0',array('type' => 'checkbox','id' => 'denial'));  ?>
            
        </div>
        <div class="searchbutton" style="margin:10px;float:left;">
            <input type="submit" class="searchbyproviderbutton" id="search" value="search box" style="height:27px;position:relative;botton:0px;float:left;">
        </div>
     </div>
</div>



<script type="text/javascript">
    $(document).ready(function(){
         $( ".test" ).combobox();
         $( "#Providers" ).combobox();
         
    });
     
</script>
<script type="text/javascript">

$(document).ready(function(){
    $.ajax({ 
                url: "<?php echo Router::url('/',true);?>eopfileentries/ajaxupdate/",
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

    $(".searchbyproviderbutton").click(function(){
            var option          ='exclude';
            var approvedamount  = 'no';
            var denialamount    = 'no';  
            if($('#InvoicenoteInclude').is(':checked'))
             { 
                 option = 'include';
             }
             if($('#approved').is(':checked'))
             {
                 approvedamount =   'yes';
             }
             if($('#denial').is(':checked'))
             {
                 denialamount =   'yes';
             }
             $.ajax({ 
                url: "<?php echo Router::url('/',true);?>eopfileentries/ajaxupdate/",
                data:{'providerid':$('.providers').val(),'select':option,'approved':approvedamount,'denial':denialamount},
                type:'post',
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
            return false;
    });
});

</script>


