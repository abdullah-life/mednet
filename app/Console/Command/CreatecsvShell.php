<?php
error_reporting(0);
class CreatecsvShell extends AppShell{
    public function main()
    {
        app::import('model',  'Providerdetail');
        app::import('model',  'Benefit');
        app::import('model','Providerpricingscsvdata');
        app::import('model','Providerpricing');
        $providerpricingobj             =   new Providerpricing();  
        $providerdetailobj              =   new Providerdetail();
        $benefitobj                     =   new Benefit();
        $providerpricingcsvdataobj      =   new Providerpricingscsvdata();
        $count                          =   $providerpricingcsvdataobj->find('count',array('conditions' =>  array('status'  =>  1)));
        if($count>0){
            echo "exiting";
            exit;
         } 
         
        $sheduledata                    =   $providerpricingcsvdataobj->find('first',array('conditions' =>  array('status'  =>  0)));  
       
        
        
        if($sheduledata){
            $providerpricingcsvdataobj->save(array('Providerpricingscsvdata'=>array('status'   =>  1,'id' => $sheduledata['Providerpricingscsvdata']['id'])));
       
        if($sheduledata['Providerpricingscsvdata']['type']==0){
                    if($sheduledata['Providerpricingscsvdata']['acitivitycode'])
                    {
                       
                        if($sheduledata['Providerpricingscsvdata']['dateforsearch'])
                        {
                            $dates  = explode('-',$sheduledata['Providerpricingscsvdata']['dateforsearch']);
                            $conditions     =   array(
                                                    'providerdetail_id' => $sheduledata['Providerpricingscsvdata']['providerdetail_id'],
                                                    'start_date.day'    =>  $dates[0],
                                                    'start_date.month'    =>  $dates[1],
                                                    'start_date.year'    =>  $dates[2],
                                                    'code'   => $sheduledata['Providerpricingscsvdata']['acitivitycode']
                                                );
                        }
                        else
                        {
                            $conditions     =   array(
                                                    'providerdetail_id' =>   $sheduledata['Providerpricingscsvdata']['providerdetail_id'],
                                                    'code'   => $sheduledata['Providerpricingscsvdata']['acitivitycode']
                                                );
                        }
                    }
                    else
                    {
                        if($sheduledata['Providerpricingscsvdata']['dateforsearch'])
                        {
                             $dates  = explode('-', $sheduledata['Providerpricingscsvdata']['dateforsearch']);
                             $conditions    =   array(
                                                    'providerdetail_id' =>   $sheduledata['Providerpricingscsvdata']['providerdetail_id'],
                                                    'start_date.day'    =>  $dates[0],
                                                    'start_date.month'    =>  $dates[1],
                                                    'start_date.year'    =>  $dates[2]
                                                );
                        }
                        else
                        {
                            $conditions    =   array(
                                                    'providerdetail_id' =>    $sheduledata['Providerpricingscsvdata']['providerdetail_id']
                                               );
                        }
                    }
                    if(!file_exists(WWW_ROOT.'files/pricingscsv/'))
                    {
                        mkdir(WWW_ROOT.'files/pricingscsv');
                    }
                    
                    $providerpricing    =    $providerpricingobj->find('all',array(
                        'conditions' => $conditions
                        )); 
                    $providerdetails     =   $providerdetailobj->find('first',array('conditions' =>  array('id' => $sheduledata['Providerpricingscsvdata']['providerdetail_id']),'fields' => array('code','display_name')));
		    $filename           = rand(10, 1000).$providerdetails['Providerdetail']['code'];
                    while(file_exists(WWW_ROOT.'files/pricingscsv/'.$filename.'/'))
                    {
                        $filename           = rand(10, 1000).$filename;
                    }
		    mkdir(WWW_ROOT.'files/pricingscsv/'.$filename);
                   // if(!($file=fopen(WWW_ROOT.'files/pricingscsv/'.$filename,"w")))
                   // {
                       // die("Unable to open the specified file..!!!");
                   // }
		    $count=0;
                    //fputcsv($file, array('Provider Code','Provider Name','Procedure Type','Procedure Code','Procedure Description','Price'));
                    for($i=0;$i<sizeof($providerpricing);$i++){
                       //echo 'Starting loop number '.($count+1);
                        
                        if($count%50000==0)
		     	{
				if($file)
					fclose($file);
				if(!($file	=	fopen(WWW_ROOT.'files/pricingscsv/'.$filename.'/'.$providerdetails['Providerdetail']['code'].'part'.(($count/2000)+1).'.csv','w')))
				{
					die("Unable to open the specified file");
				}
				else
				{
                                        $fnames[]    =   $providerdetails['Providerdetail']['code'].'part'.(($count/2000)+1).'.csv';
					fputcsv($file, array('Provider Code','Provider Name','Procedure Type','Procedure Code','Procedure Description','Price'." "));
                                       
                                }	
		       }
                      
                       if($providerpricing[$i]['Providerpricing']['activity']=="5")
                       {
                           continue; 
                       }
                       $count++;
                       $benefitdetails      =   $benefitobj->find('first',array('conditions'    =>  array('TYPE' => (string)$providerpricing[$i]['Providerpricing']['activity'],'CODE' => $providerpricing[$i]['Providerpricing']['code'])));
                       switch($providerpricing[$i]['Providerpricing']['activity']){
                           case 3:
                                $code  =    'CPT';
                           break;
                           case 4:
                                $code  =  'HCP';
                           break;
                           case 6:
                               $code    =   'CDA';
                           break;
                           case 8:
                                $code  =  'HAD';
                           break;
                           case 9:
                                $code  =  'IR-DRG';
                           break;
                           case 96:
                                $code  =  'CDT';
                           break;
                           case 5:
                                $code  =  'DRUGS';
                           break;
                               
                       }
                      // $mappingsarray     =   $observationmappingsobj->find('all',array('conditions'  =>  array('activity_code'   =>  $val['Providerpricing']['code'],    'activity_type' =>  $val['Providerpricing']['activity'])));
                       $gross  = $providerpricing[$i]['Providerpricing']['gross'];
                       fputcsv($file, array($providerdetails['Providerdetail']['code']."",$providerdetails['Providerdetail']['display_name'],$code,$providerpricing[$i]['Providerpricing']['code'],$benefitdetails['Benefit']['LOCAL_DESCRIPTION_1'],$gross));     
                   }
                   $zip         =   new ZipArchive();
                   $zipname     =   $filename.'.zip';
                   if ($zip->open(WWW_ROOT.'files/pricingscsv/'.$zipname, ZIPARCHIVE::CREATE)!=TRUE) {
                        die("cannot open <$filename>\n");
                   }
                   foreach ($fnames as $fname)
                   {
                       if(!($zip->addFile(WWW_ROOT.'files/pricingscsv/'.$filename.'/'.$fname,$fname)))
                               die("can not add file");
                   }
                   $zip->close();
                   $providerpricingcsvdataobj->save(array('Providerpricingscsvdata'=>array('path' => $zipname,'id' => $sheduledata['Providerpricingscsvdata']['id'])));
                 }
                 if($sheduledata['Providerpricingscsvdata']['type']==1)
                 {
                     app::import('model','ObservationMapping');
                     $observationmappingobj     =   new ObservationMapping();
                     if($sheduledata['Providerpricingscsvdata']['providerdetail_id'])
                     {
                         if($sheduledata['Providerpricingscsvdata']['dateforsearch'])
                         {
                             $datesearch = explode('-', $sheduledata['Providerpricingscsvdata']['dateforsearch']);
                             $conditions =   array(
                                        'providerdetail_id'     =>  $sheduledata['Providerpricingscsvdata']['providerdetail_id'],
                                        'start_date.day'        =>  $datesearch[0],
                                        'start_date.month'      =>  $datesearch[1],
                                        'start_date.year'       =>  $datesearch[2]
                             );
                        }
                        else
                        {
                            $conditions =   array('providerdetail_id'     =>  $sheduledata['Providerpricingscsvdata']['providerdetail_id']);
                            
                            
                            
                        }
                     }
                     
                     if(!file_exists(WWW_ROOT.'files/pricingscsv/'))
                    {
                        mkdir(WWW_ROOT.'files/pricingscsv');
                    }
                    
                    $observationsarray    =    $observationmappingobj->find('all',array(
                        'conditions' => $conditions
                        )); 
                    $providerdetails     =   $providerdetailobj->find('first',array('conditions' =>  array('id' => $sheduledata['Providerpricingscsvdata']['providerdetail_id']),'fields' => array('code','display_name')));
		    $filename           = rand(10, 1000).$providerdetails['Providerdetail']['code'];
                    while(file_exists(WWW_ROOT.'files/pricingscsv/'.$filename.'/'))
                    {
                        $filename           = rand(10, 1000).$filename;
                    }
                    $count=0;
		    mkdir(WWW_ROOT.'files/pricingscsv/'.$filename);
                    for($i=0;$i<sizeof($observationsarray);$i++)
                    {
                        echo $count;
                        
                        if($count%15000==0)
		     	{
				if($file)
					fclose($file);
				if(!($file	=	fopen(WWW_ROOT.'files/pricingscsv/'.$filename.'/'.$providerdetails['Providerdetail']['code'].'part'.(($count/2000)+1).'.csv','w')))
				{
					die("Unable to open the specified file");
				}
				else
				{
                                        $fnames[]    =   $providerdetails['Providerdetail']['code'].'part'.(($count/2000)+1).'.csv';
					fputcsv($file, array('Provider Code','Provider Name','Procedure Type','Procedure Code','Observation Code','Procedure Description','Price'." "));
				}	
                        }
 			$count++;
                        switch($observationsarray[$i]['ObservationMapping']['activity_type']){
                           case 3:
                                $code  =    'CPT';
                           break;
                           case 4:
                                $code  =  'HCP';
                           break;
                           case 6:
                               $code    =   'CDA';
                           break;
                           case 8:
                                $code  =  'HAD';
                           break;
                           case 9:
                                $code  =  'IR-DRG';
                           break;
                           case 96:
                                $code  =  'CDT';
                           break;
                           case 5:
                                $code  =  'DRUGS';
                           break;
                               
                       }
                        $providerdetails    =   $providerdetailobj->find('first',array('conditions' =>  array('id' =>   $observationsarray[$i]['ObservationMapping']['providerdetail_id']),'fields'   =>  array('code','display_name')));
                        $benefitarray       =   $benefitobj->find('first',array('conditions' => array('CODE' => $observationsarray[$i]['ObservationMapping']['activity_code'],'TYPE' => $observationsarray[$i]['ObservationMapping']['activity_type'])));
                        $datastoprint       =   array($providerdetails['Providerdetail']['code']." ",$providerdetails['Providerdetail']['display_name'],$code,$observationsarray[$i]['ObservationMapping']['activity_code'],$observationsarray[$i]['ObservationMapping']['observation_code'],$benefitarray['Benefit']['LOCAL_DESCRIPTION_1'],$observationsarray[$i]['ObservationMapping']['gross_price']);
                        fputcsv($file,$datastoprint);
                    }
                    $zip         =   new ZipArchive();
                    
                    $zipname     =   $filename.'.zip';
                    if ($zip->open(WWW_ROOT.'files/pricingscsv/'.$zipname, ZIPARCHIVE::CREATE)!=TRUE) {
                        die("cannot open <$filename>\n");
                    }
                    
                    if($fnames){
                    foreach ($fnames as $fname)
                    {
                       if(!($zip->addFile(WWW_ROOT.'files/pricingscsv/'.$filename.'/'.$fname,$fname)))
                               die("can not add file");
                    }
                    }
                    $zip->close();
                    $providerpricingcsvdataobj->save(array('Providerpricingscsvdata'=>array('path' => $zipname,'id' => $sheduledata['Providerpricingscsvdata']['id'])));
                 
              }
         $providerpricingcsvdataobj->save(array('Providerpricingscsvdata'=>array('status'   =>  2,'id' => $sheduledata['Providerpricingscsvdata']['id'])));       
        }   
        
        
    }
}
?>
