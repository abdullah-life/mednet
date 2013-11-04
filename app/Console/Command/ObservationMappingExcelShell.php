<?php
	App::uses('AppController', 'Controller');
	App::import('Vendor', 'PHPExcel.Classes.PHPExcel.php');
	require_once APP . 'Vendor' . DS."PHPExcel".DS."Classes".DS."PHPExcel.php";
	require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/Cell/AdvancedValueBinder.php';
	require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/IOFactory.php';
	class ObservationMappingExcelShell extends AppShell{
		public function main(){
			date_default_timezone_set('Europe/London');
            		define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
            		$objPHPExcel = new PHPExcel();
        
       			 // Set document properties
           		echo date('H:i:s') , " xls details" , EOL;
            		$objPHPExcel->getProperties()->setCreator("Hari Krishna S")
                		->setLastModifiedBy("Hari Krishna S")
               			->setTitle("PHP Excel ObservationMappings")
                		->setSubject("PHP Excel ObservationMappings")
                		->setDescription("ObservationMappings")
                		->setKeywords("ObservationMappings")
                		->setCategory("ObservationMappings");

			//Innetialize the headings for columns
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'PROVIDER CODE')
            			->setCellValue('B1', 'PROVIDER NAME')
            			->setCellValue('C1', 'PROCEDURE TYPE')
            			->setCellValue('D1', 'PROCEDURE CODE')
                                ->setCellValue('E1', 'PROCEDURE DESCRIPTION')
				->setCellValue('F1', 'OBSERVATION MAPPING')
            			->setCellValue('G1', 'PRICE');
			$objPHPExcel->getActiveSheet()->getStyle("A1:G1")->getFont()->setBold(true);
			
		
			
			//Importing the ObservationMapping Model 
			app::import('model','ObservationMapping');
			app::import('model','Providerdetail');
                        app::import('model','Benefit')
    ;                    $count = 0;
			$observationmappingobj		=	new ObservationMapping();
			$providerdetailobj		=	new Providerdetail();
                        $benefitobj                     =       new Benefit();
			$providers			=	$observationmappingobj->query(array('distinct'    =>  'Observation_mappings',   'key'   =>  'providerdetail_id', 'query'=>array() ));
			
                        $providercount                          =   0;
                        $observationcoun        =0;
                        foreach($providers['values'] as $providerid)
			{
                                echo $providercount++;
                                echo $providerid." \n";
				$providerdetails	=	$providerdetailobj->find('first',array('conditions' => array('id' => $providerid)));
                                
                                $observationmappings	=	$observationmappingobj->find('all',array('conditions' => array('providerdetail_id' => trim($providerid))));
				if(!$providerdetails){
                                    echo $providerid;
                                    
                                
                                    
                                }
                                echo $observationcoun   += sizeof($observationmappings);
                                for($i=0;$i<sizeof($observationmappings);$i++)
				{
                                        //if($observationmappings[$i]['ObservationMapping']['activity_type']==5)
                                           // continue;
                                        $benefitdetails      =   $benefitobj->find('first',array('conditions'    =>  array('TYPE' => (string)$observationmappings[$i]['ObservationMapping']['activity_type'],'CODE' => $observationmappings[$i]['ObservationMapping']['activity_code'])));
                                        if(!isset($benefitdetails['Benefit']['LOCAL_DESCRIPTION_1'])){
                                            $benefitdetails['Benefit']['LOCAL_DESCRIPTION_1']   =   '-';
                                        }
                                        $count++;
					switch($observationmappings[$i]['ObservationMapping']['activity_type'])
					{
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
					$observationvalues	=	array($providerdetails['Providerdetail']['code'],$providerdetails['Providerdetail']['display_name'],$code,$observationmappings[$i]['ObservationMapping']['activity_code'],$benefitdetails['Benefit']['LOCAL_DESCRIPTION_1'],$observationmappings[$i]['ObservationMapping']['observation_code'],$observationmappings[$i]['ObservationMapping']['gross_price']);
					$j=0;
                                        unset($benefitdetails);
                                        echo $count." \n";
                                        if($count==60500)
                                        {
                                            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                                            $date = trim(date("Ymd"));
                                            $objWriter->save(WWW_ROOT.'files/Observationmappingcsv/ObservationMappingforAllproviders_part1.xls');
                                            date_default_timezone_set('Europe/London');
                                            define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
                                            $objPHPExcel = new PHPExcel();
        
                                            // Set document properties
                                            echo date('H:i:s') , " xls details" , EOL;
                                            $objPHPExcel->getProperties()->setCreator("Hari Krishna S")
                                                    ->setLastModifiedBy("Hari Krishna S")
                                                    ->setTitle("PHP Excel ObservationMappings")
                                                    ->setSubject("PHP Excel ObservationMappings")
                                                    ->setDescription("ObservationMappings")
                                                    ->setKeywords("ObservationMappings")
                                                    ->setCategory("ObservationMappings");

                                            //Innetialize the headings for columns
                                            $objPHPExcel->setActiveSheetIndex(0)
                                                    ->setCellValue('A1', 'PROVIDER CODE')
                                                    ->setCellValue('B1', 'PROVIDER NAME')
                                                    ->setCellValue('C1', 'PROCEDURE TYPE')
                                                    ->setCellValue('D1', 'PROCEDURE CODE')
                                                    ->setCellValue('E1', 'PROCEDURE DESCRIPTION')
                                                    ->setCellValue('F1', 'OBSERVATION MAPPING')
                                                    ->setCellValue('G1', 'PRICE');
                                            $objPHPExcel->getActiveSheet()->getStyle("A1:G1")->getFont()->setBold(true);
                                            $count = 1;
                                            
                                        }
					foreach($observationvalues as $observationvalue)
					{
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$count+1,$observationvalue.'');
						$j++;
					}
				}
			}
			//Saving the excel data
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                	$date = trim(date("Ymd"));
               		$objWriter->save(WWW_ROOT.'files/Observationmappingcsv/ObservationMappingforAllproviders_part2.xls');
			app::import('model','Providerpricingscsvdata');
			$providerpricingcsvdataobj					=	new Providerpricingscsvdata();
			$dataarray['Providerpricingscsvdata']['providerdetail_id']  	=  	$provider['Providerdetail']['id'];
        		$dataarray['Providerpricingscsvdata']['path']               	=   	'Observationmappingcsv/ObservationMappingforAllproviders.xls';
        		$dataarray['Providerpricingscsvdata']['status']              	=   	3;
        		$dataarray['Providerpricingscsvdata']['type']                	=   	1;
        		$providerpricingcsvdataobj->create();
        		if($providerpricingcsvdataobj->save($dataarray))
            			echo 'The CSV updated to database';
       	 		else
            			echo 'Failed to update the database';
		
		}
	}

?>
