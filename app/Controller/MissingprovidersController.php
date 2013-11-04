<?php
    App::uses('AppController', 'Controller');
    App::import('Vendor', 'PHPExcel.Classes.PHPExcel.php');
    require_once APP . 'Vendor' . DS."PHPExcel".DS."Classes".DS."PHPExcel.php";
    require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/Cell/AdvancedValueBinder.php';
    require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/IOFactory.php';
    class MissingprovidersController extends AppController{
        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('*');
            $this->checkpermission();
        }
        
        public function create(){
            $this->autoRender=false;
            $this->layout='ajax';
            $providerdetails    =   $this->Missingprovider->find("all",array('conditions' => array('status' => 0)));
            date_default_timezone_set('Europe/London');

            define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
            $objPHPExcel = new PHPExcel();

        // Set document properties
           //echo date('H:i:s') , " xls details" , EOL;
            $objPHPExcel->getProperties()->setCreator("Hari Krishna S")
                ->setLastModifiedBy("Hari Krishna S")
                ->setTitle("PHPExcel Providers")
                ->setSubject("PHPExcel Providers")
                ->setDescription("Providers")
                ->setKeywords("Providers")
                ->setCategory("Providers");
            $date = trim(date("Ymd"));
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Sl No.')
                ->setCellValue('B1', 'Licence')
                ->setCellValue('C1', 'ReceiverID');
            $objPHPExcel->getActiveSheet()->getStyle('L3:N2048')
                              ->getNumberFormat()->setFormatCode('0000');
            $i=2;
            foreach ($providerdetails as $providerdetail){
                $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A'.($i), ($i-1))
                                ->setCellValue('B'.($i), $providerdetail['Missingprovider']['licence'])
                                ->setCellValue('C'.($i), $providerdetail['Missingprovider']['ReceiverID']);
                        $this->Missingprovider->id=$providerdetail['Missingprovider']['id'];
                         $this->Missingprovider->saveField('status', 1);
                $i++;
            }
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save(WWW_ROOT."files/missingproviders.xlsx");
            echo '<a href="'.Router::url('/',true).'app/webroot/files/missingproviders.xlsx">Download Excel</a>';
            app::import('model','Log');
            $logobj                         =   new Log();
            $data                           =   array();
            $data['Log']['User']            =   $this->Session->read('Auth.User.id');
            $data['Log']['Object']          =   "";
            $data['Log']['Objectcategory']  =   "providers";
            $data['Log']['Header']          =   "Missing providers";
            $data['Log']['Desc']            =   "The list of missing providers were generated by: ".$this->Session->read('Auth.User.username');
            $logobj->create();
            $logobj->save($data);
        }
        public function details(){
            $missingproviders   = $this->paginate(array('status' => 0));
            $this->set('providers',$missingproviders);
        }
    }
?>
