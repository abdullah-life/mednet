<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'PHPExcel.Classes.PHPExcel.php');
require_once APP . 'Vendor' . DS."PHPExcel".DS."Classes".DS."PHPExcel.php";
require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/Cell/AdvancedValueBinder.php';
require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/IOFactory.php';

error_reporting(0);
App::uses('AppController', 'Controller');
/**
 * Newfiles Controller
 *
 * @property Newfile $Newfile
 */
class NewfilesController extends AppController {

/**
 * Helpers
 *
 * @var array
 */
	public $displayField = 'id';

/**
 * index method
 *
 * @return void
 */
        public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
        $this->checkpermission();
    }
    
    public function test(){
         $params = array(
			'conditions' => array('created' => $this->getDateForConsoleSearch()),
                        
		);
                $savedxml = $this->Newfile->find('all');
                
                foreach($savedxml as $key )
                {
                    
                   
                    $count  =   $this->Newfile->find('count',array('conditions'=>array('FileID'=>$key['Newfile']['FileID'])));
                  
                    if($count>1){
                        echo $count;
                        echo "<pre>";
                        print_r($key);
                    }
                }
                
                exit;
                
                exit;
    }
        
        public function getTodaysCount(){
             
            $params = array(
			'conditions' => array('created' => $this->getDateForConsoleSearch())
		);
                echo 'here';
                $results = $this->Newfile->find('count', $params);
                return $results;
        }    
        
	public function index() {
                
                $fromdate   =    $this->Session->read('from_date');
                $todate     =    $this->Session->read('to_date');
                
                $start      =    end(explode('-',$fromdate));
                $end        =    end(explode('-',$todate));
                for($i=$start;$i<=$end;$i++){
                    $regex  .=   $i."|";
                }
                $trimed     =    substr($regex,0,-1);
                $cond       =   array( );
            	$this->paginate     =   array('conditions'=>array('TransactionDate'=>new MongoRegex("/[0-9]{4}-[0-9]{2}-($trimed).*/")));
                
                $this->set('newfiles', $this->paginate());
        }
        public function markeddownloaded(){
            $newfiles   =   $this->Newfile->find('all');
            foreach ($newfiles as $file){
               
               if(!$file['Newfile']['FileID']){
                  echo  "fileid not found ..contnueing loop /n";
                   continue;
               }
               if($file['Newfile']['ReceiverID']=="C004"){
                 echo "coo4 \n";
                $client = new SoapClient("https://www.shafafiya.org/v2/webservices.asmx?wsdl",array(  "trace"    => 1, "exceptions" => 0));
                    
                try{
                           $haadxml                  =     $client->SetTransactionDownloaded( array (
                                                                            "login" => "Mednet",
                                                                            "pwd"  => "ph7gAbe4", 
                                                                            "fileId" => $file['Newfile']['FileID']
                                                                          ));
                           print_r($haadxml);
                    }catch (SoapFault $exception) {
                        print_r( $exception);
                        exit;
                        
                }
               }
            
               
               if($file['Newfile']['ReceiverID']=='TPA009'){
                   
                
                ECHO "calling api to SetTransactionDownloaded \n";
                echo "file id ".$file['Newfile']['FileID'] ." \n";
                echo "file name ".$file['Newfile']['FileName'] ." \n";
                echo "TransactionDate  ".$file['Newfile']['TransactionDate'] ." \n";
                $client = new SoapClient("http://www.eclaimlink.ae/dhpo/ValidateTransactions.asmx?wsdl",array(  "trace"    => 1, "exceptions" => 0));
                $tdate  = strtotime($file['Newfile']['TransactionDate']);
                $cutofdate = strtotime(date("18-5-2013"));
//                if($cutofdate>=$tdate)
//                   continue;
               
                
                
                
                    
                try{
                    
                            $params  =   array (
                                                                                           "login" => "MedNet UAE",
                                                                                           "pwd" => "claimsmnu", 
                                                                                           "fieldId" =>$file['Newfile']['FileID'],
                                                                                           
                                                                                         );
                        
                            $x = $client->SetTransactionDownloaded($params);
                           
                            print_r($x);        
                             

//    echo "Exiting after first loop...\n";
                          //exit;
                            
                }catch (SoapFault $exception) {
                print_r ($exception);
                exit;
                }
            }
            
            }
        } 
        
      
        
/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Newfile->id = $id;
		if (!$this->Newfile->exists()) {
			throw new NotFoundException(__('Invalid newfile'));
		}
		$this->set('newfile', $this->Newfile->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Newfile->create();
			if ($this->Newfile->save($this->request->data)) {
				$this->Session->setFlash(__('The newfile has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The newfile could not be saved. Please, try again.'));
			}
		}
	}
        
         public function printdhaprovider(){
            date_default_timezone_set('Europe/London');

            define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
            $objPHPExcel = new PHPExcel();
        
        // Set document properties
            echo date('H:i:s') , " xls details" , EOL;
            $objPHPExcel->getProperties()->setCreator("Hari Krishna S")
                ->setLastModifiedBy("Hari Krishna S")
                ->setTitle("PHPExcel providers")
                ->setSubject("PHPExcel providers")
                ->setDescription("Providers")
                ->setKeywords("providers")
                ->setCategory("providers");
            app::import('model','Providerdetail');
            $providerdetailobj  =   new Providerdetail();
            $date = trim(date("Ymd"));
            $i=1;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Provider licence')
                ->setCellValue('B1', 'Provider code')
                ->setCellValue('C1', 'Status');
            $this->autoRender=FALSE;
            $files  =   null;
            $client = new SoapClient("http://www.eclaimlink.ae/dhpo/ValidateTransactions.asmx?wsdl",array(  "trace"    => 1, "exceptions" => 0));
                try{
                     $x = $client->SearchTransactions( array( "login" => "MedNet UAE",
                                                                                   "pwd" => "claimsmnu",
                                                                                   'transactionID'=>-1,
                                                                                    'direction'=>2,
                                                                                    'TransactionStatus'=>2,
                                                                                     'transactionFromDate'=>'15-05-2013',
                                                                                     'transactionToDate'=>'20-06-2013',
                                                                                     'minRecordCount'=>-1,
                                                                                     'maxRecordCount'=>-1,
                       
                                                                               ));
                     if($x){
                        
                         $files     =    Xml::build($x->foundTransactions);
                        
                     }
                  }catch (SoapFault $exception) {
                      echo "error";
                     
                    
                }
                $i=1;
               foreach ($files as $records)
                        {
                            $senderID   =   (array) $records->attributes()->SenderID;
                            echo $senderID[0];
                            $count      =   $providerdetailobj->find('count',array('conditions'    =>      array('licence'    =>  $senderID[0])));
                            if($count==0)
                            {
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i+1,$senderID[0]);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i+1,'-');
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i+1,'Not present');
                            }
                            else{
                                $details    =   $providerdetailobj->find('first',array('licence' => $senderID[0]));
                                if($details['Providerdetail']['active'] == 1){
                                    echo 'Provider present and active';
                                    continue;
                                }
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i+1,$senderID[0]);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i+1,$details['Providerdetail']['code']);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i+1,'Not active');
                            }
                            $i++;
                        }
                        echo 'Saving the excel';
            $objPHPExcel->getActiveSheet()->setTitle("Sheet1");
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $date = trim(date("Ymd"));
            $objWriter->save(WWW_ROOT.'files/providerlist_dha.xls');
           echo 'Excel saved';
               
          
        }
        

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Newfile->id = $id;
		if (!$this->Newfile->exists()) {
			throw new NotFoundException(__('Invalid newfile'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Newfile->save($this->request->data)) {
				$this->Session->setFlash(__('The newfile has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The newfile could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Newfile->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Newfile->id = $id;
		if (!$this->Newfile->exists()) {
			throw new NotFoundException(__('Invalid newfile'));
		}
		if ($this->Newfile->delete()) {
			$this->Session->setFlash(__('Newfile deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Newfile was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Newfile->recursive = 0;
		$this->set('newfiles', $this->paginate());
	}
        
        public function printotherhaadprovider(){
            
            app::import('model','Providerdetail');
            $providerdetailsobj     =       new Providerdetail();
            $this->autoRender=FALSE;
            $files  =   null;
            date_default_timezone_set('Europe/London');

            define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
            $objPHPExcel = new PHPExcel();
        
        // Set document properties
            echo date('H:i:s') , " xls details" , EOL;
            $objPHPExcel->getProperties()->setCreator("Hari Krishna S")
                ->setLastModifiedBy("Hari Krishna S")
                ->setTitle("PHPExcel providers")
                ->setSubject("PHPExcel providers")
                ->setDescription("Providers")
                ->setKeywords("providers")
                ->setCategory("providers");
            app::import('model','Providerdetail');
            $providerdetailobj  =   new Providerdetail();
            $date = trim(date("Ymd"));
            $i=1;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Provider licence')
                ->setCellValue('B1', 'Provider code')
                ->setCellValue('C1', 'Status');
            $client = new SoapClient("https://www.shafafiya.org/v2/webservices.asmx?wsdl",array(  "trace"    => 1, "exceptions" => 0));
                try{
                     $x = $client->SearchTransactions( array( "login" => "Mednet",
                                                                                   "pwd" => "ph7gAbe4",
                                                                                    'transactionID'=>-1,
                                                                                    'direction'=>2,
                                                                                    'transactionStatus'=>2,
                                                                                     'transactionFromDate'=>'15-04-2013',
                                                                                     'transactionToDate'=>'20-05-2013',
                                                                                     'minRecordCount'=>-1,
                                                                                     'maxRecordCount'=>-1
                                                                               ));
                     if($x){
                         
                         $files     =    Xml::build($x->foundTransactions);
                         
                     }
                  }catch (SoapFault $exception) {
                      echo "error";
                      
                     
                }
                
                $i=1;
                
                $client = new SoapClient("https://www.shafafiya.org/v2/webservices.asmx?wsdl", array("trace" => 1, "exceptions" => 0));
                try {
                        $x = $client->GetNewTransactions(array("login" => "Mednet", "pwd" => "ph7gAbe4"));
                        if ($x){
                            $x->xmlTransaction = ereg_replace(" & ", "&amp; ", $x->xmlTransaction);
                            $newxmltransactions = Xml::toArray(Xml::build($x->xmlTransactions));
                        }
                } catch (SoapFault $exception) {
                    echo $exception;
                }
                
                        foreach ($files as $records)
                        {
                            
                            $senderID   =   (array) $records->attributes()->SenderID;
                            print_r($senderID);
                            $count      =   $providerdetailsobj->find('count',array('conditions'    =>      array('licence'    =>  $senderID[0])));
                            if($count==0)
                            {
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i+1, $senderID[0]);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i+1, ' - ');
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i+1, 'provider not found');
                            }
                            else{
                                $details        =   $providerdetailsobj->find('first',array('conditions' => array('licence'    =>  $senderID[0])));
                                if($details['Providerdetail']['active']==1)
                                    continue;
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i+1, $senderID[0]);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i+1, $details['Providerdetail']['code']);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i+1, 'Provider Not active');
                            }
                            $i++;
                        }
                        foreach ($newxmltransactions['Files']['File'] as $records)
                        {
                            $senderID   =   $records['@SenderID'];
                            $count      =   $providerdetailsobj->find('count',array('conditions'    =>      array('licence'    =>  $senderID)));
                            if($count==0)
                            {
                                  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i+1, $senderID);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i+1, ' - ');
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i+1, 'provider not found');
                            }
                            else{
                                $details        =   $providerdetailsobj->find('first',array('conditions' => array('licence'    =>  $senderID)));
                                if($details['Providerdetail']['active']==1)
                                    continue;
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i+1, $senderID);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i+1, $details['Providerdetail']['code']);
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i+1, 'Provider Not active');
                            }
                            $i++;
                        }
                        echo 'Saving the excel';
            $objPHPExcel->getActiveSheet()->setTitle("Sheet1");
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $date = trim(date("Ymd"));
            $objWriter->save(WWW_ROOT.'files/providerlist_haad.xls');
           echo 'Excel saved';
        }
        

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Newfile->id = $id;
		if (!$this->Newfile->exists()) {
			throw new NotFoundException(__('Invalid newfile'));
		}
		$this->set('newfile', $this->Newfile->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Newfile->create();
			if ($this->Newfile->save($this->request->data)) {
				$this->Session->setFlash(__('The newfile has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The newfile could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Newfile->id = $id;
		if (!$this->Newfile->exists()) {
			throw new NotFoundException(__('Invalid newfile'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Newfile->save($this->request->data)) {
				$this->Session->setFlash(__('The newfile has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The newfile could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Newfile->read(null, $id);
		}
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Newfile->id = $id;
		if (!$this->Newfile->exists()) {
			throw new NotFoundException(__('Invalid newfile'));
		}
		if ($this->Newfile->delete()) {
			$this->Session->setFlash(__('Newfile deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Newfile was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
