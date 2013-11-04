<script type="text/javascript">
        $(document).ready(function() {
            var oTable = $('#datatable').dataTable( {
		bProcessing: true,
		sAjaxSource: "http://localhost/mednet/Eopfileentries/getEoplist"
            } );
        });
</script>

<div class="actions">
    <table id="datatable">
      <thead>
		<tr>
			<th width="20%">Rendering engine</th>
			<th width="25%">Browser</th>
			<th width="25%">Platform(s)</th>
			<th width="15%">Engine version</th>
			<th width="15%">CSS grade</th>
		</tr>
	</thead>  
        
    </table>
    
</div>