<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'PHPExcel.Classes.PHPExcel.php');
require_once APP . 'Vendor' . DS."PHPExcel".DS."Classes".DS."PHPExcel.php";
require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/Cell/AdvancedValueBinder.php';
require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/IOFactory.php';

error_reporting(0);
App::uses('AppController', 'Controller');
/**
 * Claims Controller
 *
 * @property Claim $Claim
 */
class ClaimsController extends AppController {
    
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
    
    
	public function index($id=null) {
            
                app::import('model','Log');
                $logobj                         =   new Log();
                $data                           =   array();
                $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                $data['Log']['Object']          =   "";
                $data['Log']['Objectcategory']  =   "";
                $data['Log']['Header']          =   "User - Page access";
                $data['Log']['Desc']            =   $this->Session->read('Auth.User.username')." accessed the  page for listing Claims";
                $logobj->create();
                $logobj->save($data);
		$this->Claim->recursive = 0;
                if($id){
                    $this->paginate = array(
                        'conditions' => array('Claim.xmllisting_id' => $id)
                    );
                    
                }
		$this->set('claims', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
        
        public function resubmission(){
             return $this->Claim->find('count',array('conditions'=>array('created'=>$this->getDateForSearch('Claim'),'claim.markedresubmission'=>1)));
             $this->autoRender  =   false;
             
             
        }
        
public function listbatchesandclaims(){
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
            app::import('model',  'BatchesClaim');
            app::import('model','Batch');
            $batchesclaimobj    =   new BatchesClaim();
            $batchesobj         =   new Batch();
            $date = trim(date("Ymd"));
            $i=1;
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Number')
                ->setCellValue('B1', 'ClaimID')
                ->setCellValue('C1', 'BatchName');
            $failedclaims   =   $this->Claim->find('all',array('conditions' => array('comment_id' => '518ce0ab1da29af942000001')));
            
            foreach ($failedclaims as $failedclaim)
            {
                $batchdetails   =   $batchesclaimobj->find('first',array('conditions' => array('claim_id' => $failedclaim['Claim']['id'])));
                $batchinfo      =   $batchesobj->find('first',array('conditions' => array('id' => $batchdetails['BatchesClaim']['batch_id'])));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i+1,$i);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i+1,$failedclaim['Claim']['claim']['xmlclaimID']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i+1,$batchinfo['Batch']['name']);
                $i++;
            }
            $objPHPExcel->getActiveSheet()->setTitle("Sheet1");
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $date = trim(date("Ymd"));
            $objWriter->save(WWW_ROOT.'files/failedclaims.xls');
}
        
        public function updatedenialcodeforclaims(){
                app::import('model','Beforedenial');
                $denialcodeobj          =       new Beforedenial();
                $failedclaims           =       $this->Claim->find('all',array('conditions' => array('comment_id' =>array('$ne' => null))));
                $count  =   0;
                foreach($failedclaims as $failedclaim)
                {
                    
                    $denial_code    =       $denialcodeobj->find('first',array('conditions' => array('id' => $failedclaim['Claim']['comment_id'])));
                   echo $failedclaim['Claim']['comment_id']." \n";
                  
                    if(isset($denial_code['Beforedenial']['Code'])){
                        
                                if($this->Claim->save(array('id' => $failedclaim['Claim']['id'],'comment_id' => $denial_code['Beforedenial']['Code']))){
                                        echo "Claim comment updated for ".$failedclaim['Claim']['id']." \n";
                                        app::import('model','Log');
                                        $logobj                         =   new Log();
                                        $data                           =   array();
                                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                                        $data['Log']['Object']          =   $failedclaim['Claim']['id'];
                                        $data['Log']['Objectcategory']  =   "claim";
                                        $data['Log']['Header']          =   "Updating denialcode for Claims";
                                        $data['Log']['Desc']            =   "The claim ".$failedclaim['Claim']['claim']['xmlclaimID']."is marked as failed by adding the denialcode : ".$denial_code['Beforedenial']['Code']." by ".$this->Session->read('Auth.User.username');
                                        $logobj->create();
                                        $logobj->save($data);
                                     
                                }
                        }else{
                            echo $failedclaim['Claim']['id']." \n";
                            echo $count++." \n";;
                            //exit;
                        }
                }
        }
        
        
        public function listmarkedclaims($provider=null)
        {
            if(isset($provider))
            {
                die("Provider search is not implemented");
            }
            else
            {
                if(isset($this->request->data['Claim']['providerids']))
                {
                    $markedclaim         =   $this->Claim->find('first',array('conditions'   =>  array('Claim.claim.ProviderID'  =>  $this->request->data['Claim']['providerids'],'comment_id'=>array('$ne'=>null),'remitance_status'=>array('$ne' => 1))));
                }
                else if(isset($this->request->data['Claim']['Claimids']))
                {
                    $markedclaim         =   $this->Claim->find('first',array('conditions'   =>  array('id'  =>  $this->request->data['Claim']['Claimids'])));
                }
                else
                {
                    $markedclaim            =   $this->Claim->find('first',array('conditions' =>  array('comment_id'=>array('$ne'=>null),'remitance_status'=>array('$ne' => 1))));
                }
                $providers              =   $this->Claim->query(array('distinct'    =>  'claims',   'key'   =>  'claim.ProviderID'));
                foreach ($providers['values'] as $provider)
                {
                    $providerlist[$provider]    =   $provider;
                }
                $activities             =   $this->Claim->Activity->find('all',array('conditions'   =>  array('claim_id'    =>  $markedclaim['Claim']['id'])));
                $markedclaimsarray      =   $this->Claim->find('list',array('conditions' =>array('comment_id'=>array('$ne'=>null),'remitance_status'=>array('$ne' => 1)),'fields' =>  array('id','Claim.claim.xmlclaimID')));
                $this->set('providerlist',$providerlist);
                $this->set('activities', $activities);
                $this->set('markedclaimsarray',$markedclaimsarray);
                $this->set('markedclaim',$markedclaim);
            }
        }
        
        
        
        
        
        public function resubmission_index(){
            $this->Claim->recursive = 0;
            $this->paginate = array('conditions'=>array('created'=>$this->getDateForSearch('Claim'),'claim.markedresubmission'=>1));
            $this->set('claims', $this->paginate());
            
        }
        
        
        public function getclaimtree($id=null){
            if($id){
               
                $this->set('claims',$this->Claim->read(null,$id));
                
            }else{
                throw  new NotFoundException();
            }
            
            
        }
        
        public function markclaimcomment($claimid,$commentid){
            $claimdarray   =   $this->Claim->find('first',array('conditions'=>array('claim.xmlclaimID'=>$claimid)));
            app::import('model','Denialcode');
            $denialcodeobj= new Denialcode();
            $codearray      =   $denialcodeobj->find('first',array('conditions' => array('id' => $commentid)));
            if($this->Claim->save(array('Claim'=>array('comment_id'=>$codearray['Denialcode']['Code'],'id'=>$claimdarray['Claim']['id'])))){
                    echo "True";
                    app::import('model','Log');
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   $claimdarray['Claim']['id'];
                    $data['Log']['Objectcategory']  =   "claim";
                    $data['Log']['Header']          =   "Updating denialcode for Claims";
                    $data['Log']['Desc']            =   "The claim ".$claimdarray['Claim']['claim']['xmlclaimID']." for the provider ".$claimdarray['Claim']['claim']['ProviderID']." is marked as failed by adding the denialcode : ".$codearray['Denialcode']['Code']." by ".$this->Session->read('Auth.User.username');
                    $logobj->create();
                    $logobj->save($data);
            }
            else
                    echo "Error";
            $this->autoRender   =   false;
            
        }
        public function deleteclaimcomment($claimid=null)
        {
                $claimdarray   =   $this->Claim->find('first',array('conditions'=>array('claim.xmlclaimID'=>$claimid)));
                if($this->Claim->save(array('Claim'=>array('comment_id'=>null,'id'=>$claimdarray['Claim']['id'])))){
                    echo "True";
                    app::import('model','Log');
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   $claimdarray['Claim']['id'];
                    $data['Log']['Objectcategory']  =   "claim";
                    $data['Log']['Header']          =   "Updating denialcode for Claims";
                    $data['Log']['Desc']            =   "The claim ".$claimdarray['Claim']['claim']['xmlclaimID']." for the provider ".$claimdarray['Claim']['claim']['ProviderID']." is unmarked by ".$this->Session->read('Auth.User.username');
                    $logobj->create();
                    $logobj->save($data);
                }
            else
                    echo "Error";
            $this->autoRender   =   false;
        }
        
	public function view($id = null) {
		$this->Claim->id = $id;
		if (!$this->Claim->exists()) {
			throw new NotFoundException(__('Invalid claim'));
		}
		$this->set('claim', $this->Claim->read(null, $id));
	}
        
        public function generateclaims($claimid=null){
            $this->autoRender   =   FALSE;
            
           
            if($claimid){
                    $claims    =  $this->Claim->find('first',array('conditions'=>array('Claim.id'=>$claimid)));
            }
           
            $claim          =   "<ul> <li><b>Claim</b><ul>";
                $claim     .=   "<li><b>ID &nbsp;:</b>".$claims['Claim']['xmlclaimID'].'</li>';
                $claim     .=   "<li><b>IDPayer &nbsp;:</b>".$claims['Claim']['IDPayer'].'</li>';
                $claim     .=   "<li><b>MemberID &nbsp;:</b>".$claims['Claim']['MemberID'].'</li>';
                $claim     .=   "<li><b>PayerID &nbsp;:</b>".$claims['Claim']['PayerID'].'</li>';
                $claim     .=   "<li><b>ProviderID &nbsp;:</b>".$claims['Claim']['ProviderID'].'</li>';
                $claim     .=   "<li><b>EmiratesIDNumber &nbsp;:</b>".$claims['Claim']['EmiratesIDNumber'].'</li>';
                $claim     .=   "<li><b>Gross &nbsp;:</b>".$claims['Claim']['Gross'].'</li>';
                $claim     .=   "<li><b>PatientShare &nbsp;:</b>".$claims['Claim']['PatientShare'].'</li>';
                $claim     .=   "<li><b>Net &nbsp;:</b>".$claims['Claim']['Net'].'</li>';
          $claim   .=  "</ul>"  ;
       
          
          $encounter            =    "<ul> <li><b>Encounter</b><ul>";
          $encounter           .=  "<li><b>FacilityID &nbsp;:</b>".$claims['Encounter'][0]['FacilityID'].'</li>';
          $encounter           .=  "<li><b>Type &nbsp;:</b>".$claims['Encounter'][0]['Type'].'</li>';
          $encounter           .=  "<li><b>PatientID &nbsp;:</b>".$claims['Encounter'][0]['Type'].'</li>';
          $encounter           .=  "<li><b>Start &nbsp;:</b>".$claims['Encounter'][0]['Start'].'</li>';
          $encounter           .=  "<li><b>End &nbsp;:</b>".$claims['Encounter'][0]['End'].'</li>';
          $encounter           .=  "<li><b>EndType &nbsp;:</b>".$claims['Encounter'][0]['EndType'].'</li>';
          $encounter           .=  "<li><b>TransferSource &nbsp;:</b>".$claims['Encounter'][0]['TransferSource'].'</li>';
          $encounter           .=  "<li><b>TransferDestination &nbsp;:</b>".$claims['Encounter'][0]['TransferDestination'].'</li>';
          $encounter           .=  "</ul></li></ul>"  ;
          
          
         
          
          
         foreach($claims['Diagnosi'] as $diagnosis)
         {
              $diagnosi          =    "<ul> <li><b>Diagnosis</b><ul>";
              $diagnosi         .=  "<li><b>Type &nbsp;:</b>".$diagnosis['Type'].'</li>';
              $diagnosi         .=  "<li><b>Code &nbsp;:</b>".$diagnosis['Code'].'</li>';
              $diagnosi         .=  "</ul></li></ul> ";
              $alldignosis      .=   $diagnosi;
         }
          
         foreach($claims['Activity'] as $act)
         {
             $activutystring    =     "<ul> <li><b>Activity</b><ul>";
             $activutystring    .=     "<li><b>ID &nbsp;:</b>".$act['activity_id'].'</li>';
             $activutystring    .=     "<li><b>start &nbsp;:</b>".$act['start'].'</li>';
             $activutystring    .=     "<li><b>Type &nbsp;:</b>".$act['Type'].'</li>';
             $activutystring    .=     "<li><b>Code &nbsp;:</b>".$act['Code'].'</li>';
             $activutystring    .=     "<li><b>Quantity &nbsp;:</b>".$act['Quantity'].'</li>';
             $activutystring    .=     "<li><b>Net &nbsp;:</b>".$act['Net'].'</li>';
             $activutystring    .=     "<li><b>Clinician &nbsp;:</b>".$act['Clinician'].'</li>';
             $activutystring    .=     "<li><b>PriorAuthorizationID &nbsp;:</b>".$act['PriorAuthorizationID'].'</li>';
                
                $activity       =   $this->getobservations($act['id']);
             
             
             $activutystring    .=  "</ul></li></ul> ";
             $allactivitues     .=   $activutystring;
             
         }
         $claimed               =   "</li></ul>";
          
       
          return $claim.$encounter.$alldignosis.$allactivitues.$claimed;
          
        }
        public function getcount($date=null){
            
             $claims    = $this->Claim->find('count',array('conditions'=>array('created'=>$this->getDateForSearch('Claim'))));
           
            return $claims;
           
        }
        
        
/**
 * add method
 *
 * @return void
 */
        public function getobservations($activityid=null){
            $observations   =       $this->Claim->Activity->Observation->find('all',array('conditoions'=>array('Observation.activity_id'=>$activityid)));
            pr($observations);
           
        }
        
        
	public function add() {
		if ($this->request->is('post')) {
			$this->Claim->create();
			if ($this->Claim->save($this->request->data)) {
				$this->Session->setFlash(__('The claim has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The claim could not be saved. Please, try again.'));
			}
		}
		$xmllistings = $this->Claim->Xmllisting->find('list');
		$this->set(compact('xmllistings'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Claim->id = $id;
		if (!$this->Claim->exists()) {
			throw new NotFoundException(__('Invalid claim'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Claim->save($this->request->data)) {
				$this->Session->setFlash(__('The claim has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The claim could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Claim->read(null, $id);
		}
		$xmllistings = $this->Claim->Xmllisting->find('list');
		$this->set(compact('xmllistings'));
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
		$this->Claim->id = $id;
		if (!$this->Claim->exists()) {
			throw new NotFoundException(__('Invalid claim'));
		}
		if ($this->Claim->delete()) {
			$this->Session->setFlash(__('Claim deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Claim was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Claim->recursive = 0;
		$this->set('claims', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Claim->id = $id;
		if (!$this->Claim->exists()) {
			throw new NotFoundException(__('Invalid claim'));
		}
		$this->set('claim', $this->Claim->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Claim->create();
			if ($this->Claim->save($this->request->data)) {
				$this->Session->setFlash(__('The claim has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The claim could not be saved. Please, try again.'));
			}
		}
		$xmllistings = $this->Claim->Xmllisting->find('list');
		$this->set(compact('xmllistings'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Claim->id = $id;
		if (!$this->Claim->exists()) {
			throw new NotFoundException(__('Invalid claim'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Claim->save($this->request->data)) {
				$this->Session->setFlash(__('The claim has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The claim could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Claim->read(null, $id);
		}
		$xmllistings = $this->Claim->Xmllisting->find('list');
		$this->set(compact('xmllistings'));
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
		$this->Claim->id = $id;
		if (!$this->Claim->exists()) {
			throw new NotFoundException(__('Invalid claim'));
		}
		if ($this->Claim->delete()) {
			$this->Session->setFlash(__('Claim deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Claim was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        public function find_claims($xmlid=null)
        {
                
                $count = $this->Claim->find('count',array('conditions'=>array('Claim.xmllisting_id'=>$xmlid),'fields' => array('Claim.claim')));
                echo $count;
                $result = $this->Claim->find('all',array('conditions'=>array('Claim.xmllisting_id'=>$xmlid),'fields' => array('Claim.claim.Activity.Activity')));
                pr($result);
                exit;
        }
        
        public function getclaimdetails($claimid){
            return $this->Claim->read(null,$claimid);
            
        }
        
        
        
        
        public function findProviders()
        {
            app::import('model','Providerdetail');
            $ProviderDetail = new Providerdetail();
            $providers = $this->Claim->find('all',array('fields'    =>  array('claim.ProviderID')));
            foreach ($providers as $provider)
            {
                $providerlist[] =   $provider['Claim']['claim']['ProviderID'];
            }
            $providerlist1 = array_unique($providerlist);
            foreach ($providerlist1 as $providerlist)
            {
                $providerlicence[]=$providerlist;
            }
            foreach ($providerlicence as $provider)
            {
                $mapedproviders    =   $ProviderDetail->find('all',array('conditions'  =>  array('licence' => $provider)));
                if($mapedproviders){
                    $providerdetails[]  =   $mapedproviders;    
                }
            }
            
            if($filename = tempnam(sys_get_temp_dir(), "csv"))
            {
                ob_clean();
                if($file = fopen($filename,"w"))
                {
                    fputcsv($file, array('ProviderCode','CITY','DisplayName','FacilityName','Licence','modified','created','id'));
                    $count=0;
                    foreach ($providerdetails as $providerdetail)
                    {
                        if(isset($providerdetail[0]['Providerdetail']['id']))
                        {
                            fputcsv($file, $providerdetail[0]['Providerdetail']); 
                        }
                        else {
                            $otherproviders[]   =   $providerlicence[$count];  
                        }
                        $count++;
                    }
                
                    fputcsv($file,array('Other Providers(Licence number)'));
                    foreach ($otherproviders as $otherprovider)
                    {
                        fputcsv($file,array($otherprovider));
                    }
                
                    fclose($file);
                    header("Content-Type: application/xls");
                    header("Content-Disposition: attachment;Filename=providerdetails.xls");
                    header("charset: UTF-8");
                    echo readfile($filename);
                    unlink($filename);
                    exit;
                }
                else
                {
                    die("Unable to open the stream.. Please check system Settings");
                }
            }
            else
            {
                die("Unable to create CSV file.. Please check system Settings");
            }
//            if($filename = tempnam(sys_get_temp_dir(), "csv"))
//                        {
//                            
//                            $file = fopen($filename,"w");
//                            fputcsv($file, array('CRITERION_NBR','LOCAL_DESCRIPTION','BENEFIT','TYPE','CODE','LOCAL_DESCRIPTION_1','id'));
//                            foreach ($benefits as $row)
//                            {
//                                fputcsv($file, $row['Benefit']);
//                            }
//                            fclose($file);
//                            header("Content-Type: application/csv");
//                            header("Content-Disposition: attachment;Filename=Benefits.csv");
//                            header("charset: UTF-8");
//                            echo readfile($filename);
//                            unlink($filename);
//                            exit;
//                        
//                        }
//                        else {
//                            echo 'Error';
//                        }
//            foreach ($providers as $provider)
//            {
//                $providerlist[] =   $provider['Claim']['claim']['ProviderID'];
//            }
//            $providerlist1 = array_unique($providerlist);
//            
//            $providers  =   $ProviderDetail->find('all',array('fields'  =>  array('licence'),con));
//            
//            foreach ($providers as $provider)
//            {
//                $providerlist[] =   $provider['Providerdetail']['licence'];
//            }
//            $providerlist2  = array_unique($providerlist);
            
            
             
        }
        
        
        
}
