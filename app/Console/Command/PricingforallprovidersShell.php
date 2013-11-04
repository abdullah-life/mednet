<?php
	App::uses('AppController', 'Controller');
	App::import('Vendor', 'PHPExcel.Classes.PHPExcel.php');
	require_once APP . 'Vendor' . DS."PHPExcel".DS."Classes".DS."PHPExcel.php";
	require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/Cell/AdvancedValueBinder.php';
	require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/IOFactory.php';
	error_reporting(0);
	class PricingforallprovidersShell extends AppShell{
    		public function main(){
        		app::import('model',  'Providerdetail');
        		app::import('model',  'Providerpricingscsvdata');
                        app::import('model','Providerpricing');
        		$providerpricingobj         =   new Providerpricing();
        		$providerdetailobj              =   new Providerdetail();
        		$providerpricingcsvdataobj      = new Providerpricingscsvdata(); 
        		if(!file_exists(WWW_ROOT.'files/Providerpricingcsv_bulk/'))
        		{			
                		mkdir(WWW_ROOT.'files/Providerpricingcsv_bulk');
        		}		
        		$limit  =   0;
//        		App::import('Vendor', 'excel_reader2');
//        		$data = new Spreadsheet_Excel_Reader(WWW_ROOT . 'files/ramdom/providers.xls', true);
//        		$exeldata = $data->sheets['0']['cells'];
                        $providers                      =       $providerpricingobj->query(array('distinct'    =>  'providerpricings',   'key'   =>  'providerdetail_id', 'query'=>array() ));
                        echo 'Creating zip';
                    	$zip         =   new ZipArchive();
                    	$zipname     =   'pricings_for_all'.date("j-j-Y").'.zip';
                    	if ($zip->open(WWW_ROOT.'files/Providerpricingcsv_bulk/'.$zipname, ZIPARCHIVE::CREATE)!=TRUE) {
                            die("cannot open <$filename>\n");
                        }
                        foreach($providers['values'] as $provider){
            			$providerdetails                   =   $providerdetailobj->find('first',array('conditions' => array('id' =>$provider)));
                                if($providerdetails['Providerdetail']['code']!='C2027')
                                    contintue;
                                //foreach ($providerlist as $provider){
                			echo "Creating csv for ".($limit+1);
//                			if($limit%1000==0)
//                			{
//                    				if(isset($zip))
//                    				{
//                        				$zip->close();
//                        
//                    				}
//                    				
//                    			//}
//                		}
                		$limit++;
				
                		if(!file_exists(WWW_ROOT.'files/Providerpricingcsv_bulk/'.$provider['Providerdetail']['code'].'/'))
                    			mkdir (WWW_ROOT.'files/Providerpricingcsv_bulk/'.$provider['Providerdetail']['code']);
                		$foldername =   $provider['Providerdetail']['code'];
                		while(file_exists(WWW_ROOT.'files/Providerpricingcsv_bulk/'.$provider['Providerdetail']['code'].'/'.$foldername))
                		{
                    			$foldername = rand(10, 1000).$foldername;
               		 	}
                		mkdir(WWW_ROOT.'files/Providerpricingcsv_bulk/'.$provider['Providerdetail']['code'].'/'.$foldername);
                		$this->createcsv($provider['Providerdetail'],$foldername,$zip);
            			
        		}
        		$dataarray['Providerpricingscsvdata']['providerdetail_id']   =   date("j-n-Y");
        		$dataarray['Providerpricingscsvdata']['path']                =   'Providerpricingcsv_bulk/'.$zipname;
        		$dataarray['Providerpricingscsvdata']['status']              =   3;
        		$dataarray['Providerpricingscsvdata']['type']                =   0;
        		$providerpricingcsvdataobj->create();
        		if($providerpricingcsvdataobj->save($dataarray))
            			echo 'The CSV updated to database';
        		else
            			echo 'Failed to update the database';
    		}
    		public function createcsv($provider,$filename,$zip)
    		{
                        $index          =       array(0 => 'A', 1=> 'B', 2 => 'C', 3 => 'D', 4 => 'E', 5 => 'F');
        		app::import('model',  'Benefit');
        		app::import('model','Providerpricing');
        		$providerpricingobj         =   new Providerpricing();
        		$benefitobj                 =   new Benefit();
        		$count=0;
        		$providerpricings           =   $providerpricingobj->find('all',array('conditions' => array('providerdetail_id' => $provider['id'])));
        		//$file   = fopen(WWW_ROOT.'files/Providerpricingcsv/'.$provider['code'].'/'.$filename.'/'.$provider['code'].'pricings.csv', 'w');
			 date_default_timezone_set('Europe/London');

            		define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
            		$objPHPExcel = new PHPExcel();
        
        		// Set document properties
            		echo date('H:i:s') , " xls details" , EOL;
           	 	$objPHPExcel->getProperties()->setCreator("Hari Krishna S")
                		->setLastModifiedBy("Hari Krishna S")
                		->setTitle("PHPExcel Providerpricings")
                		->setSubject("PHPExcel Providerpricings")
                		->setDescription("Providerpricings")
                		->setKeywords("Providerpricings")
                		->setCategory("Providerpricings");

			$objPHPExcel->setActiveSheetIndex(0)
                		->setCellValue('A1', 'Provider Code')
                		->setCellValue('B1', 'Provider Name')
                		->setCellValue('C1', 'Procedure Type')
                		->setCellValue('D1', 'Procedure Code')
                		->setCellValue('E1', 'procedure Description')
                		->setCellValue('F1', 'price');
			$objPHPExcel->getActiveSheet()->getStyle("A1:F1")->getFont()->setBold(true);
			//fputcsv($file, array('Provider Code','Provider Name','Procedure Type','Procedure Code','Procedure Description','Price '));
				
                        for($i=0;$i<sizeof($providerpricings);$i++)
        		{
            			if($providerpricings[$i]['Providerpricing']['activity']=="5")
            			{
                			continue; 
            			}
            			$count++;
            			$benefitdetails      =   $benefitobj->find('first',array('conditions'    =>  array('TYPE' => (string)$providerpricings[$i]['Providerpricing']['activity'],'CODE' => $providerpricings[$i]['Providerpricing']['code'])));
            			switch($providerpricings[$i]['Providerpricing']['activity']){
					case 3:
                    				$code  =    'CPT';
                			break;
					case 6:
                    				$code  =  'CDA';
					break;
                			case 4:
                    				$code  =  'HCP';
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
            			$gross  = (string) $providerpricings[$i]['Providerpricing']['gross'];
            			$csvdata    =   array(
                              			0 => $provider['code'],
                              			1 => $provider['display_name'],
                              			2 => $code,
                              			3 => $providerpricings[$i]['Providerpricing']['code'],
                              			4 => $benefitdetails['Benefit']['LOCAL_DESCRIPTION_1'],
                              			5 => $gross
                            			);
				$j=0;
            			foreach($csvdata as $key => $data)
				{
                                        if($key != 4 AND $key != 5){
                                            $objRichText = new PHPExcel_RichText();
                                            $objRichText->createText($data);
                                            $objPHPExcel->getActiveSheet()->getCell($index[$key].''.($i+2))->setValue($objRichText);
                                        }
                                        else{
                                            $objPHPExcel->getActiveSheet()->getCell($index[$key].''.($i+2))->setValue($data);
                                        }
				}
        		}
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                        $objWriter->save(WWW_ROOT.'files/Providerpricingcsv_bulk/'.$provider['code'].'/'.$filename.'/'.$provider['code'].'_pricings.xls');

        		echo 'Adding file :'.WWW_ROOT.'files/Providerpricingcsv_bulk/'.$provider['code'].'/'.$filename.'/'.$provider['code'].'_pricings.xls to zip';
        		if(!($zip->addFile(WWW_ROOT.'files/Providerpricingcsv_bulk/'.$provider['code'].'/'.$filename.'/'.$provider['code'].'_pricings.xls',$filename.'/'.$provider['code'].'_pricings.xls')))
                		die("can not add file");
    		}
	}
?>
