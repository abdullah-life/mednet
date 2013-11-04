<?php
    class ObservationmappingdupShell extends AppShell{
        public function main(){
            app::import('model','Observationmappingfile');
            app::import('model','ObservationMapping');
            $observationmappingfileobj  =   new Observationmappingfile();
            $observationmappingobj      =   new ObservationMapping();
            $filedet                    =   $observationmappingfileobj->find('first',array('conditions' => array('status' => 0)));
            if(isset($filedet['Observationmappingfile']['id'])){
                $filepath = WWW_ROOT.'files/Observationmappings/'.$filedet['Observationmappingfile']['file'];
                $data = new Spreadsheet_Excel_Reader($filepath, true);
                $exeldata = $data->sheets['0']['cells'];
                $mappingdetails = array();
                app::import('model','Providerdetail');
                $providerdetailobj  = new Providerdetail();
                $providerdetails    =   $providerdetailobj->find('first',  array('conditions'=>array('code'=>$file['Observationmappingfile']['mednet_code'])));
                $count = 0;
                foreach ($exeldata as $key => $val) {
                    $conditions     =   array(
                                            'providerdetail_id' =>  $providerdetails['Providerdetail']['id'],
                                            'acitivity_type'    =>  (string) $val[1],
                                            'activity_code'     =>  (string) $val[2],
                                            'observation_code'  =>  (string) $val[3],
                                            'start_date.day'    =>  $filedet['Observationmappingfile']['start_date']['day'],
                                            'start_date.month'  =>  $filedet['Observationmappingfile']['start_date']['month'],
                                            'start_date.year'   =>  $filedet['Observationmappingfile']['start_date']['year']
                                        );
                    $values         =   $observationmappingobj->find('all',array('conditions' => $conditions));
                    if(!isset($values['ObservationMapping']['id'])){
                        if(count($values)>1)
                        {
                            echo "Multiple records for : \n";
                            print_r($values);
                            echo " \n";
                        }
                        echo "No records found for : \n";
                        print_r($val);
                        echo " \n";
                    }
                    else{
                        echo "Values present in the database \n";
                    }
                }
            }else{
                echo "No files to process";
            }
     }
    }
?>
