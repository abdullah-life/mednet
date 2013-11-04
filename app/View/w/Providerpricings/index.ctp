
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



<div class="providerpricings index">
    
    <div id="search" style="width:100%;height:auto;float:left;border: 1px solid #CDCDCD !important;">
        
        <h2><?php echo __('Search ');?></h2>
        <?php echo $this->Form->create('Providerpricing' ,array('type' => 'file'));?>
        <table style="width:700px;" >
            
            <tr>
                
                <td width="30%">
                    <?php
                        echo $this->Form->input('providerdetail_id',array('type'=>'select','class'=>'providers','options' => $list,'selected'=>$this->Session->read('providerdetail_id'),'empty'=>'select provider')); 
                        
                        echo $this->Form->input('activityid',array('label' =>  'Activity code search'));
                        //echo $this->Form->input('Activity code search',array('type' =>  'select','options'  =>  $providers,,'name' => 'activityid'));
                    ?>
                </td>
            </tr>
            <tr>
                <td> <?php echo $this->Form->end(__('Submit'));?></td>
            </tr>
            <tr>
                <td> 
                		<?php echo $this->Html->link($this->Html->image('export.png',array('title'=>'download')), array('controller'=>'providerpricings','action' => 'createtxt'),array('escape'=>FALSE)); ?>
                </td>
            </tr>
            
        </table>
        
        
    </div>
        
    
	<h2><?php echo __('Provider pricings');?></h2>
	
        <table cellpadding="0" cellspacing="0">
        <tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('providerdetail_id');?></th>
			<th><?php echo $this->Paginator->sort('activity');?></th>
			<th><?php echo $this->Paginator->sort('code');?></th>
			<th><?php echo $this->Paginator->sort('servicedescription');?></th>
			<th><?php echo $this->Paginator->sort('Local Description');?></th>
			<th><?php echo $this->Paginator->sort('benefit');?></th>
                        <th><?php echo $this->Paginator->sort('gross');?></th>
			<th><?php echo $this->Paginator->sort('discount');?></th>
			<th><?php echo $this->Paginator->sort('start_date');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($providerpricings as $key=>$providerpricing): ?>
        
        
        <?php
        
        
       // $status     =   $this->requestAction(array('controller' => 'Benefits','action' => 'checkavailablityforProviderpricing/'.$providerpricing['Providerpricing']['code'].'/'.$providerpricing['Providerpricing']['acitvity']));
           $providername     =   $this->requestAction(array('controller' => 'providerdetails','action' => 'getProviderdetailsById/'.$providerpricing['Providerpricing']['providerdetail_id'])); 
          
           ?>
	<tr>
                
		<td><?php echo $key+1;; ?>&nbsp;</td>
		<td><?php echo h($providername); ?>&nbsp;</td>
		<td><?php echo h($providerpricing['Providerpricing']['activity']); ?>&nbsp;</td>
		<td><?php echo h($providerpricing['Providerpricing']['code']); ?>&nbsp;</td>
                
                    <?php  $benefitsdetails     =   $this->requestAction(array('controller' => 'Benefits','action' => 'descriptionforProviderpricing/'.$providerpricing['Providerpricing']['code'].'/'.$providerpricing['Providerpricing']['activity'])); ?>
                <td>
                    <?php
                         echo $benefitsdetails['Benefit']['LOCAL_DESCRIPTION_1']  ; 
                    ?>
                </td>
                <td>
                    <?php
                         echo $benefitsdetails['Benefit']['LOCAL_DESCRIPTION']  ; 
                    ?>
                </td>
               <td><?php  echo $benefitsdetails['Benefit']['BENEFIT'];?> &nbsp;</td>
               <td><?php echo h($providerpricing['Providerpricing']['gross']); ?>&nbsp;</td>
		<td><?php echo h($providerpricing['Providerpricing']['discount']); ?>&nbsp;</td>
		<td><?php echo h($providerpricing['Providerpricing']['start_date']['day'].'-'.$providerpricing['Providerpricing']['start_date']['month'].'-'.$providerpricing['Providerpricing']['start_date']['year']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $providerpricing['Providerpricing']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $providerpricing['Providerpricing']['id']), null, __('Are you sure you want to delete # %s?', $providerpricing['Providerpricing']['id'])); ?>
		</td>
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
		<li><?php echo $this->Html->link(__('New Provider pricing'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Provider pricing'), array('controller'=>'providerpricings','action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Provider'), array('controller'=>'providerdetails','action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Upload Provider details'), array('controller'=>'providerdetails','action' => 'uploadProvider')); ?></li>
		<li><?php echo $this->Html->link(__('List common DHA pricing'), array('controller'=>'Dhapricings','action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List common HAAD pricing'), array('controller'=>'Haadpricings','action' => 'index')); ?></li>
	</ul>
</div>
<style>
    .not_linked{
        background-color:#cfcfcf !important;
    }
    #ProviderpricingProviderdetailId
    {
        display: none;
    }
    .ui-state-default
    {
        margin-top: 10px;
    }
    
</style>

<script type="text/javascript">
    $(document).ready(function(){
         $( "#ProviderpricingProviderdetailId" ).combobox();
         
    });
</script>