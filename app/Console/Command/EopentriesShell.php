<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'PHPExcel.Classes.PHPExcel.php');
require_once APP . 'Vendor' . DS."PHPExcel".DS."Classes".DS."PHPExcel.php";
require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/Cell/AdvancedValueBinder.php';
require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/IOFactory.php';
class EopentriesShell extends AppShell {

    public $uses = array('Eopfile', 'Eopfileentry');
    public $objPHPExcel;


    public function main() {
        date_default_timezone_set('Europe/London');

        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        $this->objPHPExcel = new PHPExcel();
        echo date('H:i:s') , " xls details" , EOL;
        $this->objPHPExcel->getProperties()->setCreator("Hari Krishna S")
            ->setLastModifiedBy("Hari Krishna S")
            ->setTitle("PHPExcel remittance")
            ->setSubject("PHPExcel remittance")
            ->setDescription("Remittance")
            ->setKeywords("remittance")
            ->setCategory("remittance");
        $date = trim(date("Ymd"));
        $this->objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ProviderID')
            ->setCellValue('B1', 'ClaimID')
            ->setCellValue('C1', 'AcitivityID')
            ->setCellValue('D1', 'Description');
        $this->objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('A')->setWidth('30');
        $this->objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('B')->setWidth('30');
        $this->objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('C')->setWidth('30');
        $this->objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('D')->setWidth('30');
        $i=2;
        $eopfile = $this->Eopfile->find('first', array('conditions' => array('status' => 0)));
        $dataarray = array();
        $count = 0;
        app::import('controller','Eopfileentries');
        app::import('controller','Xmllistings');
        app::import('model','Activity');
        app::import('model','providerdetail');
        $xmllistingsobj =   new XmllistingsController();
        $Eopfileentries =   new EopfileentriesController();
        $activityobj    =   new Activity();
        $providerdetailobj  =   new Providerdetail();
        $inserted_num=0;
        $failed_num=0;
        if (count($eopfile) > 0) {
            $this->Eopfileentry->Eopfile->id=$eopfile['Eopfile']['id'];
             $this->Eopfileentry->Eopfile->saveField('status',1); 
            echo "Files found";
            if (file_exists(WWW_ROOT . 'files/eopfiles/' . $eopfile['Eopfile']['foldername'])) {
                app::import('Vendor','simplexlsx');
                $simple     =    new SimpleXLSX(WWW_ROOT . 'files/eopfiles/' . $eopfile['Eopfile']['foldername']);
                    list($cols) = $simple->dimension();
                    $i=2;
                    foreach( $simple->rows() as $k => $r){
                        if($k==0)                        continue;
                        
                        $data['Eopfileentry']['eopfile_id']=$eopfile['Eopfile']['id'];
                        $data['Eopfileentry']['payment_run']= (string)$r[0];
                        $data['Eopfileentry']['account_number']=(string)$r[1];
                        $data['Eopfileentry']['account_description']=(string)$r[2];
                        $data['Eopfileentry']['payment_number']=(string)$r[3];
                        $data['Eopfileentry']['payment_external_reference']=(string)$r[4];
                        //$data['Eopfileentry']['payment_receipt_date']=(string);
                        
                        
                        $data['Eopfileentry']['payment_receipt_date']   =  $this->getdatetime($r[5]);
                        
                        $data['Eopfileentry']['batch_number']=(string)$r[6];
                        $data['Eopfileentry']['batch_external_reference']=(string)$r[7];
                        if($r[8]!="")
                        $data['Eopfileentry']['batch_received_date']=$this->getdatetime($r[8]);
                        else{
                            $data['Eopfileentry']['batch_received_date']=$r[8];
                        }

                        $data['Eopfileentry']['due_date']=$this->getdatetime($r[9]);
                        $data['Eopfileentry']['batch_claimed_amount']=(string)$r[10];
                        $data['Eopfileentry']['payer_code']=(string)$r[11];
                        $data['Eopfileentry']['payer_name']=(string)$r[12];
                        $data['Eopfileentry']['payee_code']=(string)$r[13];
                        $data['Eopfileentry']['payee_name']=(string)$r[14];
                        $data['Eopfileentry']['report_number']=(string)$r[15];
                        $data['Eopfileentry']['policy_number']=(string)$r[16];
                        $data['Eopfileentry']['policy_holder_name']=(string)$r[17];
                        $data['Eopfileentry']['insured_member']=(string)$r[18];
                        $data['Eopfileentry']['insured_member_first_name']=(string)$r[19];
                        $data['Eopfileentry']['insured_member_father_name']=(string)$r[20];
                        $data['Eopfileentry']['insured_member_last_name']=(string)$r[21];
                        $data['Eopfileentry']['claim_type']=(string)$r[22];
                        $data['Eopfileentry']['claim_number']=(string)$r[23];
                        $data['Eopfileentry']['external_invoice_ref']=(string)$r[24];
                        $data['Eopfileentry']['invoice_ref']=(string)$r[25];
                        $data['Eopfileentry']['invoice_date']=$this->getdatetime($r[26]);
                        $data['Eopfileentry']['report_date']=$this->getdatetime($r[27]);
                        $data['Eopfileentry']['inv_rejection_reason_code']=(string)$r[28];
                        $data['Eopfileentry']['inv_rejection_reason_desc']=(string)$r[29];
                        $data['Eopfileentry']['date_of_service']=$this->getdatetime($r[30]);
                        $data['Eopfileentry']['procedure_type']=(string)$r[31];
                        $data['Eopfileentry']['procedure_type_description']=(string)$r[32];
                        $data['Eopfileentry']['procedure_code']=(string)$r[33];
                        $data['Eopfileentry']['procedure_description']=(string)$r[34];
                        $data['Eopfileentry']['external_reference']=(string)$r[35];
                        $data['Eopfileentry']['quantity']=(string)$r[36];
                        $data['Eopfileentry']['claimed_amount']=(string)$r[37];
                        $data['Eopfileentry']['correction_amount']=(string)$r[38];
                        $data['Eopfileentry']['discount_amount']=(string)$r[39];
                        $data['Eopfileentry']['denied_amount']=(string)$r[40];
                        $data['Eopfileentry']['approved_amount']=(string)$r[41];
                        $data['Eopfileentry']['insured_part']=(string)$r[42];
                        $data['Eopfileentry']['insurer_part']=(string)$r[43];
                        $data['Eopfileentry']['paid_part']=(string)$r[44];
                        $data['Eopfileentry']['tax']=(string)$r[45];
                        $data['Eopfileentry']['provider_claimed_amount']=(string)$r[46];
                        $data['Eopfileentry']['invoice_notes']=(string)$r[47];
                        $data['Eopfileentry']['invoice_line_notes']=trim((string)$r[48]);
                        $data['Eopfileentry']['indicator1']=(string)$r[49];
                        $data['Eopfileentry']['indicator2']=(string)$r[50];
                        $data['Eopfileentry']['indicator3']=(string)$r[51];
                        
                        
                        $providerdata       =       $providerdetailobj->find('first',array('conditions' => array('code' => $data['Eopfileentry']['payee_code'])));
                        if(!$this->findActivity($providerdata['Providerdetail']['licence'],$data['Eopfileentry']['external_invoice_ref'],$data['Eopfileentry']['invoice_line_notes'],$i)){
                            $i++;
                            unset ($data);
                            echo "Can not be inserted \n";
                        }else{
                            $netprice           =       $xmllistingsobj->getnetpricefromactivity($activity_id['Activity']['id'],$providerdata['Providerdetail']['licence']);
                            if($netprice != $data['Eopfileentry']['insurer_part'])
                            {
                                $data['Eopfileentry']['denial_code'] = "NCOV-003";
                            }
                            $this->Eopfileentry->create();
                            if($this->Eopfileentry->save($data)){
                            
                                $inserted_num++;
                                echo "Value inserted \n";
                            }  
                            else
                                echo "error";
                            
                        }
                }
                $this->objPHPExcel->getActiveSheet()->setTitle("Sheet1");
                $objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel5');
                $date = trim(date("Ymd"));
                if(!file_exists(WWW_ROOT.'files/EOPError/')){
                    mkdir(WWW_ROOT.'files/EOPError/');
                }
                $objWriter->save(WWW_ROOT.'files/EOPError/'.$eopfile['Eopfile']['id'].'_errors.xls');
                $this->Eopfile->id  =   $eopfile['Eopfile']['id'];
                $this->Eopfile->save(array('error_file' => $eopfile['Eopfile']['id'].'_errors.xls'));
                $Eopfileentries->createRemitanceBatch($eopfile['Eopfile']['id']);
            }
            else
                die("failed to read file");
        }
        else
        {
            die("No files to process...!!!!");
        }
        echo $inserted_num." are succesfully inserted and ".$failed_num." are failed to insert";
    }
    public function getdatetime($timevalue)
    {
        if($timevalue=="")
            return $timevalue;
        $d = floor($timevalue); 
        $t = $timevalue - $d;
        $date   =    ($d > 0) ? ( $d - 25569 ) * 86400 + $t * 86400 : $t * 86400;
        return date('d/m/Y',$date);
    }
    public function findActivity($provider,$claim,$activity,$j){  
        app::import('model','Claim');
        app::import('model','Activity');
        $claimobj       =   new Claim();
        $activityobj    =   new Activity();
        $claim_det      =   $claimobj->find('first',array('conditions' => array('claim.xmlclaimID' => $claim,'claim.ProviderID' => $provider)));
        if(isset($claim_det['Claim']['id'])){
            $activity_det   =   $activityobj->find('first',array('conditions' => array('claim_id' => $claim_det['Claim']['id'],'Activity_id' => $activity)));
            if(isset($activity_det['Activity']['id'])){
                return true;
            }
            else{
                
                $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$j,$provider);
                $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$j,$claim);
                $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$j,$activity);
                $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$j,"No such activity found");
                
                return false;
            }
        }
        else{
            echo "Claim not found";
            $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$j,$provider);
            $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$j,$claim);
            $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$j,$activity);
            $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$j,"No such claim found");
            echo "Updated";
            return false;
        }
    }
}

?>