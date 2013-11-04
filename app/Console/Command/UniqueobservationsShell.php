<?php
	App::uses('AppController', 'Controller');
	App::import('Vendor', 'PHPExcel.Classes.PHPExcel.php');
	require_once APP . 'Vendor' . DS."PHPExcel".DS."Classes".DS."PHPExcel.php";
	require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/Cell/AdvancedValueBinder.php';
	require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/IOFactory.php';
	class UniqueobservationsShell extends AppShell{
		public function main(){
                    $flag=0;
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
				->setCellValue('A1', 'MEDNET CODE')
            			->setCellValue('B1', 'ACTIVITY TYPE')
            			->setCellValue('C1', 'ACTIVITY CODE')
            			->setCellValue('D1', 'OBSERVATION CODE')
                                ->setCellValue('E1', 'START DATE')
				->setCellValue('F1', 'GROSS PRICE');
			$objPHPExcel->getActiveSheet()->getStyle("A1:F1")->getFont()->setBold(true);
			
		
			
			//Importing the ObservationMapping Model 
			app::import('model','ObservationMapping');
			app::import('model','Providerdetail');
                        //app::import('model','Benefit');
                        $count = 0;
                        $rowvalue=0;
			$observationmappingobj		=	new ObservationMapping();
			$providerdetailobj		=	new Providerdetail();
                        //$benefitobj                     =       new Benefit();
			$providers			=	$observationmappingobj->query(array('distinct'    =>  'Observation_mappings',   'key'   =>  'providerdetail_id', 'query'=>array() ));
			
                        $providercount                          =   0;
                        $observationcoun        =0;
                        foreach($providers['values'] as $providerid)
			{
                            
                                echo $providercount++;
                                //echo $providerid." \n";
				$providerdetails	=	$providerdetailobj->find('first',array('conditions' => array('id' => $providerid)));
                                
                                $observationcodes	=	$observationmappingobj->query(array('distinct'    =>  'Observation_mappings',   'key'   =>  'observation_code', 'query'=>array('providerdetail_id' => $providerid) ));
                                if(!$providerdetails){
                                    echo $providerid;
                                    
                                
                                    
                                }
                                echo $observationcoun   += sizeof($observationmappings);
                                foreach($observationcodes['values'] as $observationcode)
				{
                                        $observationarray       =   $observationmappingobj->find('all',array('conditions' => array('providerdetail_id' => $providerid,'observation_code' => $observationcode)));
                                        $observationmappings    =   $observationarray[0];
                                        $differencetime         = strtotime(date('d-m-Y'))-strtotime($observationarray[0]['ObservationMapping']['start_date']['day'] . "-" . $observationarray[0]['ObservationMapping']['start_date']['month'] . "-" . $observationarray[0]['ObservationMapping']['start_date']['year']);;
                                        foreach ($observationarray as $observation)
                                        {
                                            $strtostarttime = strtotime(date('d-m-Y'))-strtotime($observation['ObservationMapping']['start_date']['day'] . "-" . $observation['ObservationMapping']['start_date']['month'] . "-" . $observation['ObservationMapping']['start_date']['year']);
                                            if ($strtostarttime < $differencetime) {
                                                $observationmappings    =   $observation;
                                            }
                                        }
                                        //$benefitdetails      =   $benefitobj->find('first',array('conditions'    =>  array('TYPE' => (string)$observationmappings['ObservationMapping']['activity_type'],'CODE' => $observationmappings['ObservationMapping']['activity_code'])));
                                        if(!isset($benefitdetails['Benefit']['LOCAL_DESCRIPTION_1'])){
                                            $benefitdetails['Benefit']['LOCAL_DESCRIPTION_1']   =   '-';
                                        }
                                        $count++;
					switch($observationmappings['ObservationMapping']['activity_type'])
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
					$observationvalues	=	array($providerdetails['Providerdetail']['code'],$code,$observationmappings['ObservationMapping']['activity_code'],$observationmappings['ObservationMapping']['observation_code'],$observationmappings['ObservationMapping']['start_date']['day'].'-'.$observationmappings['ObservationMapping']['start_date']['month'].'-'.$observationmappings['ObservationMapping']['start_date']['year'],$observationmappings['ObservationMapping']['gross_price']);
					$j=0;
                                        unset($benefitdetails);
                                        echo $count." \n";
                                        if($count==60500)
                                        {
                                            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                                            $date = trim(date("Ymd"));
                                            $objWriter->save(WWW_ROOT.'files/Observationmappingcsv/UniqueObservationMapping_part01.xls');
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
               		$objWriter->save(WWW_ROOT.'files/Observationmappingcsv/UniqueObservationMapping_part02.xls');
		}
	}

?>
