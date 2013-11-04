<?php
App::import('Vendor', 'PHPExcel.Classes.PHPExcel.php');
require_once APP . 'Vendor' . DS."PHPExcel".DS."Classes".DS."PHPExcel.php";
require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/Cell/AdvancedValueBinder.php';
require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/IOFactory.php';
    class BatchlistShell extends AppShell{
        public function main(){
            app::import('model','ClaimsmanagerBatch');
            app::import('model','Batch');
            $claimsmanagerbatchobj      =   new ClaimsmanagerBatch();
            $batchobj                   =   new Batch();
            date_default_timezone_set('Europe/London');

            define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
            $objPHPExcel = new PHPExcel();

        // Set document properties
            echo date('H:i:s') , " xls details" , EOL;
            $objPHPExcel->getProperties()->setCreator("Hari Krishna S")
                ->setLastModifiedBy("Hari Krishna S")
                ->setTitle("PHPExcel remittance")
                ->setSubject("PHPExcel remittance")
                ->setDescription("Remittance")
                ->setKeywords("remittance")
                ->setCategory("remittance");
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'BatchName')
                ->setCellValue('B1', 'ProviderID')
                ->setCellValue('C1', 'CreatedDate');
            $i=1;
            $claimsmanagerbatches       =   $claimsmanagerbatchobj->find('all',array('conditions' =>array('created' => array('$gte' =>new MongoDate(strtotime('2013-09-01 00:00:00'))))));
            foreach ($claimsmanagerbatches as $claimsmanagerbatch){
                $batchdetails           =   $batchobj->find('first',array('conditions' => array('id' =>$claimsmanagerbatch['ClaimsmanagerBatch']['batch_id'])));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i+1, $batchdetails['Batch']['name']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i+1, $batchdetails['Batch']['provider_id']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i+1, date('d-m-Y', $claimsmanagerbatch['ClaimsmanagerBatch']['created']->sec));
                $i++;
            }
            $objPHPExcel->getActiveSheet()->setTitle("Sheet1");
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
               $objWriter->save(WWW_ROOT.'files/Batches.xls');
        }
    }
?>
