<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
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
.addClass( "ui-corner-right ui-combobox-toggle" )
.mousedown(function() {
wasOpen = input.autocomplete( "widget" ).is( ":visible" );
})
.click(function() {
input.focus();
// Close if already visible
if ( wasOpen ) {
return;
}
// Pass empty string as value to search for, displaying all results
input.autocomplete( "search", "" );
});
},
_source: function( request, response ) {
var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
response( this.element.children( "option" ).map(function() {
var text = $( this ).text();
if ( this.value && ( !request.term || matcher.test(text) ) )
return {
label: text,
value: text,
option: this
};
}) );
},
_removeIfInvalid: function( event, ui ) {
// Selected an item, nothing to do
if ( ui.item ) {
return;
}
// Search for a match (case-insensitive)
var value = this.input.val(),
valueLowerCase = value.toLowerCase(),
valid = false;
this.element.children( "option" ).each(function() {
if ( $( this ).text().toLowerCase() === valueLowerCase ) {
this.selected = valid = true;
return false;
}
});
// Found a match, nothing to do
if ( valid ) {
return;
}
// Remove invalid value
this.input
.val( "" )
.attr( "title", value + " didn't match any item" )
.tooltip( "open" );
this.element.val( "" );
this._delay(function() {
this.input.tooltip( "close" ).attr( "title", "" );
}, 2500 );
this.input.data( "ui-autocomplete" ).term = "";
},
_destroy: function() {
this.wrapper.remove();
this.element.show();
}
});
})( jQuery );
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#ObservationMappingActivityType').combobox();
        $('#ObservationMappingActivityType').css('display','none');
    })
</script>
<div class="dhaobservationmappings index">
    <div id="search" style="width:100%;height:auto;float:left;border: 1px solid #CDCDCD !important;">
        
        <h2><?php echo __('Search ');?></h2>
        <?php echo $this->Form->create('ObservationMapping',array('method'  =>  'POST'));?>
        <table style="width:700px;" >
            
            <tr>
                
                <td width="30%">
                       <?php
                            echo $this->Form->input('activity_type',array('type'=>'select','class'=>'observation','options' => $activitytypes,'selected'=>$this->Session->read('activity_type'),'empty'=>'select Activity type')); 
                            echo $this->Form->input('activity_code',array('type'=>'select','class'=>'observation','options' => $activitycodes,'selected'=>$this->Session->read('activity_code'),'empty'=>'select Activity code')); 
                            echo $this->Form->input('observation_code',array('type'=>'select','class'=>'observation','options' => $observationcodes,'selected'=>$this->Session->read('observation_code'),'empty'=>'select Observation code')); 
                       ?>
                </td>
            </tr>
            <tr>
                <td> <?php echo $this->Form->end(__('Submit'));?></td>
            </tr>
            
        </table>
        
        
    </div>
	<h2><?php echo __('Dhaobservationmappings'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('activity_type'); ?></th>
			<th><?php echo $this->Paginator->sort('activity_code'); ?></th>
			<th><?php echo $this->Paginator->sort('observation_code'); ?></th>
			<th><?php echo $this->Paginator->sort('gross_price'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('start_date'); ?></th>
	</tr>
	<?php
	foreach ($dhaobservationmappings as $dhaobservationmapping): ?>
	<tr>
		<td><?php echo h($dhaobservationmapping['Dhaobservationmapping']['id']); ?>&nbsp;</td>
		<td><?php echo h($dhaobservationmapping['Dhaobservationmapping']['activity_type']); ?>&nbsp;</td>
		<td><?php echo h($dhaobservationmapping['Dhaobservationmapping']['activity_code']); ?>&nbsp;</td>
		<td><?php echo h($dhaobservationmapping['Dhaobservationmapping']['observation_code']); ?>&nbsp;</td>
		<td><?php echo h($dhaobservationmapping['Dhaobservationmapping']['gross_price']); ?>&nbsp;</td>
		<td><?php echo h($dhaobservationmapping['Dhaobservationmapping']['description']); ?>&nbsp;</td>
		<td><?php echo h($dhaobservationmapping['Dhaobservationmapping']['start_date']['day'].'-'.$dhaobservationmapping['Dhaobservationmapping']['start_date']['month'].'-'.$dhaobservationmapping['Dhaobservationmapping']['start_date']['year']); ?>&nbsp;</td>
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
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Dhaobservationmapping'), array('action' => 'addsingle')); ?></li>
		<li><?php echo $this->Html->link(__('Upload DHA Observationmappings'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Back to ObservationMappings'), array('controller' => 'ObservationMappings','action' => 'index')); ?></li>
	</ul>
</div>
