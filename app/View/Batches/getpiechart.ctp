<tr>
<script src=<?php echo Router::url('/',true)?>js/highcharts.js></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>


<script>
    $(function() {
        $('#graph').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 5,
                plotShadow: false,
                type:'column'
            },
            title: {
                text: 'Claims Status'
            },
            
             xAxis: {
               categories: [
                   'Unnamed: <?php echo ($notnameed)?$notnameed:0 ?>',
                   'Claims Manager: <?php echo ($claimsmanager)?$claimsmanager:0 ?>',
                   'Claims Processor: <?php echo ($claimsprocessor)?$claimsprocessor:0 ?>',
                   'Medical Manager: <?php echo ($medicalmanage)?$medicalmanage:0 ?>',
                   'Medical Receiver: <?php echo ($medicalreceiver)?$medicalreceiver:0 ?>',
                   'Onhold: <?php echo ($onhold)?$onhold:0 ?>',
                   'Downloaded: <?php echo ($downloaded)?$downloaded:0 ?>', 
                   'Medically Reviewed: <?php echo ($backmedicalmanager)?$backmedicalmanager:0 ?>' ,
                   'Success: <?php echo ($success)?$success:0 ?>' 
               ],
               labels: {
                   rotation: 0,
                   align: 'right',
                   style: {
                       fontSize: '13px',
                       fontFamily: 'Verdana, sans-serif'
                   }
               }
           },
            plotOptions: {
                column: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false,
                        rotation:-90,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>' + this.point.name + '</b>: ' + this.point.y + ' ';
                        }
                    }
                }
            },
            plotOptions: {
               column: {
                   pointPadding: 0.2,
                   borderWidth: 0
               }
           },
            series: [{
               name: 'Unnamed',
               data: [<?php echo ($notnameed)?$notnameed:0 ?>]
   
                    }, {
                name: 'Claims Manager',
               data: [<?php echo ($claimsmanager)?$claimsmanager:0 ?>]
   
                    }, {
                name: 'Claims Processor',
               data: [<?php echo ($claimsprocessor)?$claimsprocessor:0 ?>]
   
                    }, {
                name: 'Medical Manager',
               data: [<?php echo ($medicalmanage)?$medicalmanage:0 ?>]
                    }, {
                name: 'Medical Reviewer',
               data: [<?php echo ($medicalreceiver)?$medicalreceiver:0 ?>]
                    }, {
                name: 'On Hold',
               data: [<?php echo ($onhold)?$onhold:0 ?>]
                    }, {
                name: 'Success',
               data: [<?php echo ($success)?$success:0 ?>]
                    },{
                name: 'Downloaded',
               data: [<?php echo ($downloaded)?$downloaded:0 ?>]
                    },{
                name: 'Medically Reviewed',
               data: [<?php echo ($backmedicalmanager)?$backmedicalmanager:0 ?>]
               
           }]
        });
    });
</script>
<td colspan="3">
    <div id="graph"></div>
</td>
</tr>
