<?php
App::import('Vendor', 'PHPExcel.Classes.PHPExcel.php');
require_once APP . 'Vendor' . DS."PHPExcel".DS."Classes".DS."PHPExcel.php";
require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/Cell/AdvancedValueBinder.php';
require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/IOFactory.php';





class CreateexcelShell extends AppShell{
    public function main()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        echo date('H:i:s') , " xls details" , EOL;
        $objPHPExcel->getProperties()->setCreator("Hari Krishna S")
        ->setLastModifiedBy("Hari Krishna S")
        ->setTitle("PHPExcel provider pricings")
        ->setSubject("PHPExcel provider pricings")
        ->setDescription("provider pricings")
        ->setKeywords("provider pricings")
        ->setCategory("provider pricings");
        
       
        
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
        if($sheduledata)
            {
            
                $providerpricingcsvdataobj->save(array('Providerpricingscsvdata'=>array('status'   =>  1,'id' => $sheduledata['Providerpricingscsvdata']['id'])));
             
              if($sheduledata['Providerpricingscsvdata']['type']==0)
                  {
                 
                       
                    $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A1', 'Provider Code')
                                ->setCellValue('B1', 'Provider Name')
                                ->setCellValue('C1', 'Procedure Type')
                                ->setCellValue('D1', 'Procedure Code')
                                ->setCellValue('E1', 'Procedure Description')
                                ->setCellValue('F1', 'Price');
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
                    $providerdetails        =   $providerdetailobj->find('first',array('conditions' =>  array('id' => $sheduledata['Providerpricingscsvdata']['providerdetail_id']),'fields' => array('code','display_name')));
		    $filename               =   rand(10, 1000).$providerdetails['Providerdetail']['code'];
                   
                    while(file_exists(WWW_ROOT.'files/pricingscsv/'.$filename.'/'))
                    {
                        $filename           = rand(10, 1000).$filename;
                    }
		    mkdir(WWW_ROOT.'files/pricingscsv/'.$filename);
                    $arraysize  =   sizeof($providerpricing);
                    //echo $arraysize;
                    for($i=0,$j=0;$i<$arraysize;$i++){
                        
                     if($providerpricing[$i]['Providerpricing']['activity']=="5"){
                         
                            
                        }else{
                           
                        // echo $providerpricing[$i]['Providerpricing']['activity']."__$i \n";
                       $benefitdetails      =   $benefitobj->find('first',array('conditions'    =>  array('TYPE' => trim((string)$providerpricing[$i]['Providerpricing']['activity']),'CODE' =>trim( $providerpricing[$i]['Providerpricing']['code']))));
                       
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
                       
                       

                        //echo $providerpricing[$i]['Providerpricing']['activity'];
                       
                       
                       
                        $j++;
                        $gross  = $providerpricing[$i]['Providerpricing']['gross'];
                          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$j+1,$providerdetails['Providerdetail']['code']." ");
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$j+1,$providerdetails['Providerdetail']['display_name']);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$j+1,$code);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$j+1,$providerpricing[$i]['Providerpricing']['code']." ");
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$j+1,($benefitdetails['Benefit']['LOCAL_DESCRIPTION_1'])?$benefitdetails['Benefit']['LOCAL_DESCRIPTION_1']:$benefitdetails['Benefit']['LOCAL_DESCRIPTION']);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$j+1,$gross);
                          
                        }
                       
                    }
                    //echo WWW_ROOT.'files/pricingscsv/'.$filename.'/'.$providerdetails['Providerdetail']['code'].'.xls';
                     $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                    $objWriter->save(WWW_ROOT.'files/pricingscsv/'.$filename.'/'.$providerdetails['Providerdetail']['code'].'.xls');
                    $zip         =   new ZipArchive();
                    
                   $zipname     =   $filename.'.zip';
                   echo $zipname;
                   if ($zip->open(WWW_ROOT.'files/pricingscsv/'.$zipname, ZIPARCHIVE::CREATE)!=TRUE) {
                        die("cannot open <$filename>\n");
                   }
                   
                       if(!($zip->addFile(WWW_ROOT.'files/pricingscsv/'.$filename.'/'.$providerdetails['Providerdetail']['code'].'.xls',$providerdetails['Providerdetail']['code'].'.xls')))
                               die("can not add file");
                  
                   $zip->close();
                   $providerpricingcsvdataobj->save(array('Providerpricingscsvdata'=>array('path' => $zipname,'id' => $sheduledata['Providerpricingscsvdata']['id'])));   
                } 
                
//                =============================================
                
                
                
                if($sheduledata['Providerpricingscsvdata']['type']==1)
                 {
                    
                    $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A1', 'Provider Code')
                                ->setCellValue('B1', 'Provider Name')
                                ->setCellValue('C1', 'Procedure Type')
                                ->setCellValue('D1', 'Procedure Code')
                                ->setCellValue('D1', 'Observation Code')
                                ->setCellValue('E1', 'Procedure Description')
                                ->setCellValue('E1', 'Price');
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
                        
                        
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('0',$i+2,$providerdetails['Providerdetail']['code']." ");
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('1',$i+2,$providerdetails['Providerdetail']['display_name']);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('2',$i+2,$code);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('3',$i+2,$observationsarray[$i]['ObservationMapping']['activity_code']);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('4',$i+2,$observationsarray[$i]['ObservationMapping']['observation_code']." ");
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('5',$i+2,$benefitarray['Benefit']['LOCAL_DESCRIPTION_1']);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('6',$i+2,$observationsarray[$i]['ObservationMapping']['gross_price']);
                        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                        
                    }
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                    $objWriter->save(WWW_ROOT.'files/pricingscsv/'.$filename.'/'.$providerdetails['Providerdetail']['code'].'.xls');
                     $zip         =   new ZipArchive();
                    
                    $zipname     =   $filename.'.zip';
                    if ($zip->open(WWW_ROOT.'files/pricingscsv/'.$zipname, ZIPARCHIVE::CREATE)!=TRUE) {
                        die("cannot open <$filename>\n");
                    }
                    if(!($zip->addFile(WWW_ROOT.'files/pricingscsv/'.$filename.'/'.$providerdetails['Providerdetail']['code'].'.xls',$providerdetails['Providerdetail']['code'].'.xls')))
                               die("can not add file");
                   
                    $zip->close();
                    $providerpricingcsvdataobj->save(array('Providerpricingscsvdata'=>array('path' => $zipname,'id' => $sheduledata['Providerpricingscsvdata']['id'])));
                 
                    
                    
                    
                    
                    
                    
                }
                
                
                
                
           
                
                
                
              $providerpricingcsvdataobj->save(array('Providerpricingscsvdata'=>array('status'   =>  2,'id' => $sheduledata['Providerpricingscsvdata']['id'])));         
            
            }
        
        
    }
}
?>
