<?php
App::uses('AppController', 'Controller');



/**
 * Eopfileentries Controller
 *
 * @property Eopfileentry $Eopfileentry
 */
class EopfileentriesController extends AppController {

public $components = array('RequestHandler');
public $helpers = array('Js');

/**
 * index method
 *
 * @return void
 */
    public function ajaxupdate(){
                $eopfileid  =   $this->Session->read('eop_file_id');
                if(isset($this->request->data['select']))
                {
                    $select =   $this->request->data['select'];
                    $this->Session->write('select', $select);
                }
                if(isset($this->request->data['providerid']))
                {
                    $id     =   $this->request->data['providerid'];
                    $this->Session->write('id', $id);
                }
                if(isset($this->request->data['approved']))
                {
                    $approvedamount     =   $this->request->data['approved'];
                    $this->Session->write('approvedamount', $approvedamount);
                }
                if(isset($this->request->data['denial']))
                {
                    $denialamount     =   $this->request->data['denial'];
                    $this->Session->write('denialamount', $denialamount);
                }
                
               $select              =   $this->Session->read('select');
               $id                  =   $this->Session->read('id');
               $approvedamount      =   $this->Session->read('approvedamount');
               $denialamount        =   $this->Session->read('denialamount');
        
            if($id=='')
            {
                
                if($select == 'include')
                {
                     if($approvedamount=='yes')
                     {
                         if($denialamount == 'yes')
                         {
                             $this->paginate = array('conditions'=>  array('eopfile_id'=>$eopfileid,'denied_amount' => array('$gt' => 0),'approved_amount' => 0,'invoice_notes' =>  array('$ne' => '')));
                             $this->set('eopfileentries', $this->paginate());
                             $edit=1;
                         }
                         else
                         {
                            $this->paginate = array('conditions'=>  array('eopfile_id'=>$eopfileid,'approved_amount' => 0,'invoice_notes' =>  array('$ne' => '')));
                            $this->set('eopfileentries', $this->paginate());
                            $edit=1;
                         }
                        
                     }
                     else
                     {
                         if($denialamount == 'yes')
                         {
                             $this->paginate = array('conditions'=>  array('eopfile_id'=>$eopfileid,'denied_amount' => array('$gt' => 0),'invoice_notes' =>  array('$ne' => '')));
                             $this->set('eopfileentries', $this->paginate());
                             $edit=1;
                         }
                         else
                         {
                              $this->paginate = array('conditions'=>  array('eopfile_id'=>$eopfileid,'invoice_notes' =>  array('$ne' => '')));
                              $this->set('eopfileentries', $this->paginate());
                              $edit=1;
                         }
                     }
                }
                else
                {
                    if($approvedamount=='yes')
                    {
                        if($denialamount == 'yes')
                        {
                            $this->paginate = array('conditions'=>  array('eopfile_id'=>$eopfileid,'denied_amount' => array('$gt' => 0),'approved_amount' => 0));
                            $this->set('eopfileentries', $this->paginate());
                            $edit=0;
                        }
                        else
                        {
                            $this->paginate = array('conditions'=>  array('eopfile_id'=>$eopfileid,'approved_amount' => 0));
                            $this->set('eopfileentries', $this->paginate());
                            $edit=0;
                        }
                    }
                    else
                    {
                        if($denialamount == 'yes')
                        {
                            $this->paginate = array('conditions'=>  array('eopfile_id'=>$eopfileid,'denied_amount' => array('$gt' => 0)));
                            $this->set('eopfileentries', $this->paginate());
                            $edit=0;
                        }
                        else
                        {
                            $this->paginate = array('conditions'=>  array('eopfile_id'=>$eopfileid));
                            $this->set('eopfileentries', $this->paginate());
                            $edit=0;
                        }
                    }
                }
            }
            else
            {
                if($select == 'include')
                {
                    if($approvedamount=='yes')
                    {
                        if($denialamount == 'yes')
                        {
                            $this->paginate = array('conditions'=>  array('payee_code'=>$id,'eopfile_id'=>$eopfileid,'denied_amount' => array('$gt' => 0),'approved_amount' => 0,'invoice_notes'=>array('$ne'=>'')));
                            $this->set('eopfileentries', $this->paginate());
                            $edit=1; 
                        }
                        else
                        {
                            $this->paginate = array('conditions'=>  array('payee_code'=>$id,'approved_amount' => 0,'eopfile_id'=>$eopfileid,'invoice_notes'=>array('$ne'=>'')));
                            $this->set('eopfileentries', $this->paginate());
                            $edit=1;
                        }
                    }
                    else
                    {
                        if($denialamount == 'yes')
                        {
                            $this->paginate = array('conditions'=>  array('payee_code'=>$id,'denied_amount' => array('$gt' => 0),'eopfile_id'=>$eopfileid,'invoice_notes'=>array('$ne'=>'')));
                            $this->set('eopfileentries', $this->paginate());
                            $edit=1;
                        }
                        else {
                            $this->paginate = array('conditions'=>  array('payee_code'=>$id,'eopfile_id'=>$eopfileid,'invoice_notes'=>array('$ne'=>'')));
                            $this->set('eopfileentries', $this->paginate());
                            $edit=1;
                        }
                    }
                    
                }
                else
                {
                    if($approvedamount=='yes')
                    {
                        if($denialamount == 'yes')
                        {
                            $this->paginate = array('conditions'=>  array('payee_code'=>$id,'eopfile_id'=>$eopfileid,'denied_amount' => array('$gt' => 0),'approved_amount' => 0));
                            $this->set('eopfileentries', $this->paginate());
                            $edit=0;
                        }
                        else {
                            $this->paginate = array('conditions'=>  array('payee_code'=>$id,'eopfile_id'=>$eopfileid,'approved_amount' => 0));
                            $this->set('eopfileentries', $this->paginate());
                            $edit=0;
                        }
                    }
                    else
                    {
                        if($denialamount == 'yes')
                        {
                            $this->paginate = array('conditions'=>  array('payee_code'=>$id,'eopfile_id'=>$eopfileid,'denied_amount' => array('$gt' => 0)));
                            $this->set('eopfileentries', $this->paginate());
                            $edit=0;
                        }
                        else
                        {
                            $this->paginate = array('conditions'=>  array('payee_code'=>$id,'eopfile_id'=>$eopfileid));
                            $this->set('eopfileentries', $this->paginate());
                            $edit=0;  
                        }
                    }
                    
                }
            }
            
//                }
                
                $providers  = $this->Eopfileentry->find('all',array('fields'    =>  array('payee_code')));
                foreach ($providers as $provider)
                {
                    $providerarray[]    =   $provider['Eopfileentry']['payee_code'];
                }
                $providerarrays = array_unique($providerarray);
                $providers = '';
                foreach ($providerarrays as $providerarray)
                {
                    $providers[$providerarray] = $providerarray;
                }
                $this->set('providers',$providers);
                $this->layout=  "ajax";
                $this->set('edit',$edit);
                


            
    }
    
    
	public function eopsearch($eopid=null) {
            
                 if($eopid!="img" and $eopid!="")
                $this->Session->write('eop_file_id',$eopid);
                
                $providers  = $this->Eopfileentry->find('all',array('fields'    =>  array('payee_code')));
                foreach ($providers as $provider)
                {
                    $providerarray[]    =   $provider['Eopfileentry']['payee_code'];
                }
                $providerarrays = array_unique($providerarray);
                $providers = '';
                foreach ($providerarrays as $providerarray)
                {
                    $providers[$providerarray] = $providerarray;
                }
                $this->set('providers',$providers);
                
             
        }
        
        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('*');
        }
        
        
        public function parsexlsx()
        {
                App::import('Vendor', 'simplexlsx');
                $fname = $this->Eopfileentry->Eopfile->find('first',array('Eopfile.status' => 0));
                pr($fname);
                exit;
                
                $obj = new simplexlsx(WWW_ROOT.'files/eopfiles/'.$fname);
                
        }

        
        public function addDenialcode($id=null)
        {
            app::import('model','Denialcode');
            $denialcodeobj     =   new Denialcode();
            $this->layout   =   'ajax';
            $denialcodes    =  $denialcodeobj->find('all');
            foreach ($denialcodes as $denialcode)
            {
                $denial_code[$denialcode['Denialcode']['Code']]  =   $denialcode['Denialcode']['Code'];
            }
            $this->set('denial_code',$denial_code);
            $this->set('id',$id);
        }
        
        public function saveComment($id=null,$code=null)
        {
             $activity   =   array('Eopfileentry'=>array('id'=>$id,'denial_code'=>$code));
                if($this->Eopfileentry->save($activity))
                    $this->Session->setFlash("Denial Code has been added");
                else
                    $this->Session->setFlash("Error");
                
            $this->autoRender = false;
        }

                public function neweop() {
        if ($this->request->is('Post')) {
            $name = str_replace(' ', '', trim($this->request->data['Eopfile']['eop']['name']));
            do {
                srand((double) microtime() * 1000000);
                $random_num = rand(0, 1000);
                $name = $random_num . $name;
            }while (file_exists(WWW_ROOT . 'files/eopfiles/' . $name));
            $fh = move_uploaded_file($this->request->data['Eopfile']['eop']['tmp_name'], WWW_ROOT . 'files/eopfiles/' . $name);
            if (!$fh) {
                echo "could not write file successfully \n";
            }
            $eopfile = array('Eopfile' => array('name' => trim($this->request->data['Eopfile']['eop']['name']), 'foldername' => $name,'status'  =>  0));
            $save = $this->Eopfileentry->Eopfile->save($eopfile);
            if ($save) {
                $this->Session->setFlash("The file was successfully uploaded");
            } else {
                $this->Session->setFlash("The file could not be uploaded");
            }
        }
    }
    
    public  function grid(){
        
        $this->autoRender   =   true;
        $this->layout    =   "tablegrid";
    }




    public function getEoplist()
    {
            
            $eopfiles   = $this->Eopfileentry->find('all');
            
            for($i=0;$i<=count($eopfiles); $i++)
           
            {
                $arr['aaData'][]    =   array(
                                    $eopfiles[$i]['Eopfileentry']['eopfile_id'],
                                    $eopfiles[$i]['Eopfileentry']['payment_run'],
                                    $eopfiles[$i]['Eopfileentry']['account_number'],
                                    $eopfiles[$i]['Eopfileentry']['account_description'],
                                    $eopfiles[$i]['Eopfileentry']['payment_number'],
                                    $eopfiles[$i]['Eopfileentry']['payment_external_reference'],
                                    $eopfiles[$i]['Eopfileentry']['payment_receipt_date'],
                                    $eopfiles[$i]['Eopfileentry']['batch_number'],
                                    $eopfiles[$i]['Eopfileentry']['batch_external_reference'],
                                    $eopfiles[$i]['Eopfileentry']['batch_received_date'],
                                    $eopfiles[$i]['Eopfileentry']['due_date'],
                                    $eopfiles[$i]['Eopfileentry']['batch_claimed_amount'],
                                    $eopfiles[$i]['Eopfileentry']['payer_code']
                                );
                if($i==500)
                    break;
            }
            echo json_encode($arr);
            die();
   
     exit;       
    }
        

    
        
    /**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Eopfileentry->id = $id;
		if (!$this->Eopfileentry->exists()) {
			throw new NotFoundException(__('Invalid eopfileentry'));
		}
		$this->set('eopfileentry', $this->Eopfileentry->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Eopfileentry->create();
			if ($this->Eopfileentry->save($this->request->data)) {
				$this->Session->setFlash(__('The eopfileentry has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The eopfileentry could not be saved. Please, try again.'));
			}
		}
		$eopfiles = $this->Eopfileentry->Eopfile->find('list');
		$this->set(compact('eopfiles'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Eopfileentry->id = $id;
		if (!$this->Eopfileentry->exists()) {
			throw new NotFoundException(__('Invalid eopfileentry'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Eopfileentry->save($this->request->data)) {
				$this->Session->setFlash(__('The eopfileentry has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The eopfileentry could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Eopfileentry->read(null, $id);
		}
		$eopfiles = $this->Eopfileentry->Eopfile->find('list');
		$this->set(compact('eopfiles'));
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
		$this->Eopfileentry->id = $id;
		if (!$this->Eopfileentry->exists()) {
			throw new NotFoundException(__('Invalid eopfileentry'));
		}
		if ($this->Eopfileentry->delete()) {
			$this->Session->setFlash(__('Eopfileentry deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Eopfileentry was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        public function memberIdTruncate($memberid=null){
        $this->autoRender  =   FALSE;
        if($memberid){
                if($this->checkGlobalSetting("TRUNCATE_MEMBER_ID")){
                        $frontruncated     =   trim(substr($memberid,10));
                        $integeronly       =   trim(ltrim($frontruncated,'0'));
                        $backtrunctated    =   trim(substr($integeronly, 0,strlen($integeronly)-2));
                        return $backtrunctated;
                }else{
                    return $memberid;
                }
            }
       }

       
       
       public function createRemitanceBatch($fileid=null)
       {
            app::import('model','Eopbatch');
            $Eopbatch           =   new Eopbatch();
            $providers   =   $this->Eopfileentry->query(array('distinct'    =>  'eopfileentries',   'key'   =>  'payee_code', 'query'=>array('eopfile_id' =>  $fileid) ));
            foreach ($providers['values'] as $providerid)
            {
                
                    $Eopbatchdata['Eopbatch']['eopfileid']              =   $fileid;
                    $Eopbatchdata['Eopbatch']['providerlicence']        =   $providerid;
                    $Eopbatchdata['Eopbatch']['status']                 =   0;
                    $Eopbatch->create();
                    $Eopbatch->save($Eopbatchdata);
            }
       }

       public function createRemitance($fileid=null,$country=null)
       {
            app::import('model', 'Activity');
            app::import('model','Claim');
            
            
            $dom                = new DOMDocument('1.0', "UTF-8");
            $dom->formatOutput  = true;
            if($country=='HAAD'){
                $Remitance          = $dom->appendChild(new DOMElement('Remittance.Advice'));
                $header             = $Remitance->appendChild(new DOMElement('Header'));
                $attr1              = $Remitance->setAttributeNode(new DOMAttr('xsi:nonamespaceSchemaLocation', 'http://www.haad.ae/DataDictionary/CommonTypes/RemittanceAdvice.xsd'));
                $attr2              = $Remitance->setAttributeNode(new DOMAttr('xmlns:tns','http://www.haad.ae/DataDictionary/CommonTypes'));
                $attr3              = $Remitance->setAttributeNode(new DOMAttr('xmlns:xsi','http://www.w3.org/2001/XMLSchema-instance'));
            }
            else
            {
                $Remitance          = $dom->appendChild(new DOMElement('Remittance.Advice'));
                $header             = $Remitance->appendChild(new DOMElement('Header'));
                //$attr1              = $Remitance->setAttributeNode(new DOMAttr('xsi:nonamespaceSchemaLocation', 'http://www.haad.ae/DataDictionary/CommonTypes/RemittanceAdvice.xsd'));
                $attr2              = $Remitance->setAttributeNode(new DOMAttr('xmlns:tns','ValidationSchema'));
                $attr3              = $Remitance->setAttributeNode(new DOMAttr('xmlns:xsi','http://www.w3.org/2001/XMLSchema-instance'));
            }
            $ActivityModel      =   new Activity();
            $Claim              =   new Claim();
            
            app::import('model','header');
            $headerobj          =       new Header();
            $providers   =   $this->Eopfileentry->query(array('distinct'    =>  'eopfileentries',   'key'   =>  'payee_code', 'query'=>array('eopfile_id' =>  $fileid) )); 
            foreach ($providers['values'] as $providerid)
            {
                $xmllistingid      =        $Claim->find('first',array('conditions'   =>  array('claim.ProviderID'    =>  $providerid),'fields'   =>  array('xmllisting_id')));
                if(!$xmllistingid){
                    continue;
                }else{
                    
                }
                $headerforxml      =       $headerobj->find('first',array('conditions'=>array('xmllisting_id'=>$xmllistingid['Claim']['xmllisting_id'])));

                if($country=="DHA"){
                   if($headerforxml['Header']['ReceiverID']  !=  "TPA009"){
                       continue;
                   }
                }else{
                      if($headerforxml['Header']['ReceiverID']  ==  "TPA009")
                          continue; 
                }
                
                $eopfileentries     =    $this->Eopfileentry->query(array('distinct'    =>  'eopfileentries',   'key'   =>  'external_invoice_ref', 'query'=>array('payee_code' =>  $providerid) ));
                foreach ($eopfileentries['values'] as $claimids)
                {
                    $claimcountforehader++;    
                    $eopfilevalues      =   $this->Eopfileentry->find('first',array('conditions'  =>  array('external_invoice_ref'=>  $claimids)));
                    $activity_uid       =   0;
                    $claim              =   $Remitance->appendChild(new DOMElement('Claim'));
                    $id                 =   $claim->appendChild(new DOMElement('ID',$eopfilevalues['Eopfileentry']['external_invoice_ref']));
                    $idpayer            =   $claim->appendChild(new DOMElement('IDPayer',$eopfilevalues['Eopfileentry']['batch_number'].'_'.$eopfilevalues['Eopfileentry']['report_number'].'_'.$eopfilevalues['Eopfileentry']['external_invoice_ref']));
                    $provider_id        =   $claim->appendChild(new DOMElement('ProviderID',$eopfilevalues['Eopfileentry']['payee_code']));
                    $DenialCode         =   $claim->appendChild(new DOMElement('DenialCode',isset($eopfilevalues['Eopfileentry']['denial_code']) ? $eopfilevalues['Eopfileentry']['denial_code']:'-'));
                    $paymentreference   =   $claim->appendChild(new DOMElement('PaymentReference',$eopfilevalues['Eopfileentry']['payment_external_reference']));
                    $SettlementDate     =   $claim->appendChild(new DOMElement('SettlementDate',$eopfilevalues['Eopfileentry']['payment_receipt_date']));
                    $Encounter          =   $claim->appendChild(new DOMElement('Encounter'));
                    $FacilityID         =   $Encounter->appendChild(new DOMElement('FacilityID',$eopfilevalues['Eopfileentry']['payee_code']));
                    $claimid            =   $Claim->find('first',array('conditions'   =>  array('claim.xmlclaimID'    =>  $claimids),'fields'   =>  array('Claim.id')));
                    $activities         =   $ActivityModel->find('all',array('conditions'=>array('claim_id'=>$claimid['Claim']['id'])));
                    foreach ($activities as $activity)
                    {
                        $eopresults         =   $this->Eopfileentry->find('first',array('condition'  =>  array('external_invoice_ref'    =>  $activity['Activity']['claim_id'], 'invoice_line_notes'    =>  $activity['Activity']['Activity_id'])));
                        $Activity           =   $claim->appendChild(new DOMElement('Activity'));
                        $Uid                =   $Activity->appendChild(new DOMElement('UID',(++$activity_uid)+''));
                        $id                 =   $Activity->appendChild(new DOMElement('ID',  isset($eopresults['Eopfileentry']['invoice_line_notes'])?$eopresults['Eopfileentry']['invoice_line_notes']:$activity['Activity']['Activity_id']));
                        $start              =   $Activity->appendChild(new DOMElement('Start',$activity['Activity']['start']));
                        $type               =   $Activity->appendChild(new DOMElement('Type',$activity['Activity']['Type']));
                        $code               =   $Activity->appendChild(new DOMElement('Code',$activity['Activity']['Code']));
                        $quantity           =   $Activity->appendChild(new DOMElement('Quantity',$activity['Activity']['Quantity']));
                        $net                =   $Activity->appendChild(new DOMElement('Net',isset($eopresults['Eopfileentry']['insurer_part'])?$eopresults['Eopfileentry']['insurer_part']:$activity['Activity']['Net']));
                        $list               =   $Activity->appendChild(new DOMElement('List',isset($eopresults['Eopfileentry']['claimed_amount'])?$eopresults['Eopfileentry']['claimed_amount']:'-'));
                        $clinitian          =   $Activity->appendChild(new DOMElement('Clinician',$activity['Activity']['Clinician']));
                        $PriorAuthorizationID=  $Activity->appendChild(new DOMElement('PriorAuthorizationID',$activity['Activity']['PriorAuthorizationID']));
                        $Gross              =   $Activity->appendChild(new DOMElement('Gross',isset($eopresults['Eopfileentry']['approved_amount'])?$eopresults['Eopfileentry']['approved_amount']:'-'));
                        $PatientShare       =   $Activity->appendChild(new DOMElement('PatientShare',isset($eopresults['Eopfileentry']['insured_part'])?$eopresults['Eopfileentry']['insured_part']:'-'));
                        $PaymentAmount      =   $Activity->appendChild(new DOMElement('PaymentAmount',isset($eopresults['Eopfileentry']['insurer_part'])?$eopresults['Eopfileentry']['insurer_part']:'-'));
                        $DenialCode         =   $Activity->appendChild(new DOMElement('DenialCode',isset($eopresults['Eopfileentry']['invoice_notes'])?$eopresults['Eopfileentry']['invoice_notes']:'-'));
                    }
                }
                $claimobj     =   new Claim();
                $otherclaims    =   $claimobj->find('all',array('conditions'   =>  array('claim.ProviderID'    =>  $providerid,'comment_id'=>array('$ne'=>null),'remitance_status'=>array('$ne' => 1))));
                foreach ($otherclaims as $otherclaim)
                {
                    $claim_status       = $this->Eopfileentry->find('first',array('conditions'  =>  array('external_invoice_ref'    =>  $otherclaim['Claim']['claim']['xmlclaimID'])));
                    if(!isset($claim_status['Eopfileentry']['eopfile_id']))
                    {
                        $claimcountforehader++;   
                        $activity_uid=0;
                        $claim              =   $Remitance->appendChild(new DOMElement('Claim'));
                        $id                 =   $claim->appendChild(new DOMElement('ID',$otherclaim['Claim']['claim']['xmlclaimID']));
                        $idpayer            =   $claim->appendChild(new DOMElement('IDPayer',''/*$eopfilevalues['Eopfileentry']['payee_code']*/));
                        $provider_id        =   $claim->appendChild(new DOMElement('ProviderID',$providerid/*$eopfilevalues['Eopfileentry']['batch_number'].'_'.$eopfilevalues['Eopfileentry']['report_number'].'_'.$eopfilevalues['Eopfileentry']['external_invoice_ref']*/));
                        $DenialCode         =   $claim->appendChild(new DOMElement('DenialCode',''));
                        $paymentreference   =   $claim->appendChild(new DOMElement('PaymentReference','n/a'/*$eopfilevalues['Eopfileentry']['payment_external_reference']*/));
                        $SettlementDate     =   $claim->appendChild(new DOMElement('SettlementDate',date("Y-m-d H:i:s")/*$eopfilevalues['Eopfileentry']['payment_receipt_date']*/));
                    
                        $Encounter          =   $claim->appendChild(new DOMElement('Encounter'));
                        $FacilityID         =   $Encounter->appendChild(new DOMElement('FacilityID',''/*$eopfilevalues['Eopfileentry']['payee_code']*/));
                        $claimid            =   $Claim->find('first',array('conditions'   =>  array('claim.xmlclaimID'    =>  $eopfilevalues['Eopfileentry']['external_invoice_ref']),'fields'   =>  array('Claim.id')));
                        
                        $activities         =   $ActivityModel->find('all',array('conditions'=>array('claim_id'=>$otherclaim['Claim']['id'])));
                        foreach ($activities as $Activity)
                        {
                            $Activity           =   $claim->appendChild(new DOMElement('Activity'));
                            $Uid                =   $Activity->appendChild(new DOMElement('UID',(++$activity_uid)+''));
                            $id                 =   $Activity->appendChild(new DOMElement('ID',$activity['Activity']['Activity_id']));
                            $start              =   $Activity->appendChild(new DOMElement('Start',$activity['Activity']['start']));
                            $type               =   $Activity->appendChild(new DOMElement('Type',$activity['Activity']['Type']));
                            $code               =   $Activity->appendChild(new DOMElement('Code',$activity['Activity']['Code']));
                            $quantity           =   $Activity->appendChild(new DOMElement('Quantity',$activity['Activity']['Quantity']));
                            $net                =   $Activity->appendChild(new DOMElement('Net',$activity['Activity']['Net']));
                            $list               =   $Activity->appendChild(new DOMElement('List',''/*,$eopresults['Eopfileentry']['claimed_amount']*/));
                            $clinitian          =   $Activity->appendChild(new DOMElement('Clinician',$activity['Activity']['Clinician']));
                            $PriorAuthorizationID=  $Activity->appendChild(new DOMElement('PriorAuthorizationID'));
                            $Gross              =   $Activity->appendChild(new DOMElement('Gross',''/*,$eopresults['Eopfileentry']['approved_amount']*/));
                            $PatientShare       =   $Activity->appendChild(new DOMElement('PatientShare',''/*,$eopresults['Eopfileentry']['insured_part']*/));
                            $PaymentAmount      =   $Activity->appendChild(new DOMElement('PaymentAmount',''/*,$eopresults['Eopfileentry']['insurer_part']*/));
                            $DenialCode         =   $Activity->appendChild(new DOMElement('DenialCode',''/*,$eopresults['Eopfileentry']['invoice_notes']*/));
                        }
//                        $claimobj->$id    =   $otherclaim['Claim']['id'];
//                        $claimobj->save(array('id'  =>  $otherclaim['Claim']['id'],'remitance_status' => 1));
                    }
                    

                }
                
            }
            
            if($headerforxml){
                echo "creating headers \n";
                $senderid           = $header->appendChild(new DOMElement('SenderID',$headerforxml['Header']['ReceiverID']));
                $recieverid         = $header->appendChild(new DOMElement('ReceiverID',$headerforxml['Header']['SenderID']));
                $transactiondate    = $header->appendChild(new DOMElement('TransactionDate',$headerforxml['Header']['TransactionDate']));
                $recordcount        = $header->appendChild(new DOMElement('RecordCount',$claimcountforehader));
                $dispositionflag    = $header->appendChild(new DOMElement('DispositionFlag',$headerforxml['Header']['DispositionFlag']));

            }
            
               $date = trim(date("Ymd"));
                if (!file_exists(WWW_ROOT . 'files/Remitance/'.$date.'/')) {
                    mkdir(WWW_ROOT.'files/Remitance/'.$date); 
                }
                if(!file_exists(WWW_ROOT . 'files/Remitance/'.$date.'/'.$fileid.'/'))
                    mkdir(WWW_ROOT.'files/Remitance/'.$date.'/'.$fileid);
                {
                }
                if(!file_exists(WWW_ROOT . 'files/Remitance/' . $date.'/'.$fileid.'/'.$country.'/'))
                {
                   echo "creating $country \n";
                    mkdir(WWW_ROOT . 'files/Remitance/'.$date.'/'.$fileid.'/'.$country);
                }
                $dom->save(WWW_ROOT.'files/Remitance/'. $date.'/'.$fileid.'/'.$country.'/'.$country.'.xml');
                $zip = new ZipArchive();
                $filename = $country.'.zip';
                 if (!file_exists(WWW_ROOT . 'files/Eopresults/' . $date . '/')) {
                     mkdir(WWW_ROOT . 'files/Eopresults/' . $date . '/');
                 }
                  if (!file_exists(WWW_ROOT . 'files/Eopresults/' . $date . '/'.$fileid.'/')) {
                     mkdir(WWW_ROOT . 'files/Eopresults/' . $date . '/'.$fileid);
                 }
                if ($zip->open(WWW_ROOT.'files/Eopresults/' . $date .'/'.$fileid. '/'.$filename, ZIPARCHIVE::CREATE)!=TRUE) {
                        exit("cannot open <$filename>\n");
                }
                if(!($zip->addFile(WWW_ROOT.'files/Remitance/'. $date.'/'.$fileid.'/'.$country.'/'.$country.'.xml',$country.'.xml')))
                        die("can not add file");
                        
                $zip->close();
                $this->Eopfileentry->Eopfile->id=$fileid;
                $this->Eopfileentry->Eopfile->saveField($country, $date.'/'.$fileid. '/'.$country.'.zip');
                $this->Eopfileentry->Eopfile->saveField('status',3);
             
              
         }
         public function createexcels($fileid=null,$country=null)
         {
                app::import('model', 'Activity');
                app::import('model','Claim');
                $ActivityModel      =   new Activity();
                $Claim              =   new Claim();
                app::import('model','header');
                $headerobj          =       new Header();
                $date = trim(date("Ymd"));
                $filename           =       WWW_ROOT.'files/Remitance/'.$date.'/'.$fileid.'/'.$country.'.csv';
                if(!($file=fopen($filename,"w")))
                {
                    die("Unable to open the specified file..!!!");
                }
                fputcsv($file, array('SenderID','ReceiverID','ClaimID','ClaimIDPayer','ClaimProviderID','ClaimDenialCode','ClaimPaymentReference','ClaimSettlementDate','EncounterFacilityID','ActivityUID','ActivityID','ActivityStart','ActivityType','ActivityCode','ActivityQuantity','ActivityNet','ActivityList','ActivityClinician','ActivityPriorAuthorizationID','ActivityGross','ActivityPatientShare','ActivityPaymentAmount','ActivityDenialCode'));
                $providers   =   $this->Eopfileentry->query(array('distinct'    =>  'eopfileentries',   'key'   =>  'payee_code', 'query'=>array('eopfile_id' =>  $fileid) ));
                print_r($providers);
                foreach ($providers['values'] as $providerid)
                {
                    $xmllistingid      =        $Claim->find('first',array('conditions'   =>  array('claim.ProviderID'    =>  $providerid),'fields'   =>  array('xmllisting_id')));
                    
                    if(!$xmllistingid){
                        continue;
                    }else{
                        
                    }
                    $headerforxml      =       $headerobj->find('first',array('conditions'=>array('xmllisting_id'=>$xmllistingid['Claim']['xmllisting_id'])));
                    if($country=="DHA"){
                        if($headerforxml['Header']['ReceiverID']  !=  "TPA009"){
                            continue;
                        }
                    }else{
                         if($headerforxml['Header']['ReceiverID']  ==  "TPA009")
                            continue; 
                    }
                    $eopfileentries     =    $this->Eopfileentry->query(array('distinct'    =>  'eopfileentries',   'key'   =>  'external_invoice_ref', 'query'=>array('payee_code' =>  $providerid) ));
                    $activitydetails    =   array();
                    foreach ($eopfileentries['values'] as $claimids)
                    {
                        $claimcountforehader++;    
                        $eopfilevalues                      =   $this->Eopfileentry->find('first',array('conditions'  =>  array('external_invoice_ref'=>  $claimids)));
                        $activity_uid                       =   0;
                        $claimdetails                       =   array();
                        $claimdetails['ClaimID']            =   $eopfilevalues['Eopfileentry']['external_invoice_ref'];
                        $claimdetails['IDPayer']            =   $eopfilevalues['Eopfileentry']['batch_number'].'_'.$eopfilevalues['Eopfileentry']['report_number'].'_'.$eopfilevalues['Eopfileentry']['external_invoice_ref'];
                        $claimdetails['ProviderID']         =   $eopfilevalues['Eopfileentry']['payee_code'];
                        $claimdetails['DenialCode']         =   $eopfilevalues['Eopfileentry']['denial_code'];
                        $claimdetails['PaymentReference']   =   $eopfilevalues['Eopfileentry']['payment_external_reference'];
                        $claimdetails['SettlementDate']     =   $eopfilevalues['Eopfileentry']['payment_receipt_date'];
                        $claimdetails['FacilityID']         =   $eopfilevalues['Eopfileentry']['payee_code'];
                        $claimid            =   $Claim->find('first',array('conditions'   =>  array('claim.xmlclaimID'    =>  $claimids),'fields'   =>  array('Claim.id')));
                        $activities         =   $ActivityModel->find('all',array('conditions'=>array('claim_id'=>$claimid['Claim']['id'])));
                        
                        foreach ($activities as $activity)
                        {
                            $eopresults                     =   $this->Eopfileentry->find('first',array('conditions'  =>  array('external_invoice_ref'    =>$claimids, 'invoice_line_notes'    => $activity['Activity']['Activity_id'])));
                            $activity_details               =   array();
                            $activity_details['senderid']   =   isset($eopresults['Eopfileentry']['invoice_ref'])?$eopresults['Eopfileentry']['invoice_ref']:'-';
                            $activity_details['receiverid'] =   $headerforxml['Header']['SenderID'];
                            foreach($claimdetails as $key   =>  $claimdetail)
                            {
                                $activity_details[$key]     =   $claimdetail;
                            }
                           
                            
                            
                            
                            $activity_details['UID']        =   ++$activity_uid;
                            $activity_details['ActivityID'] =   isset($eopresults['Eopfileentry']['invoice_line_notes'])?$eopresults['Eopfileentry']['invoice_line_notes']:$activity['Activity']['Activity_id'];
                            $activity_details['Start']      =   $activity['Activity']['start'];
                            $activity_details['Type']       =   $activity['Activity']['Type'];
                            $activity_details['Code']       =   $activity['Activity']['Code'];
                            $activity_details['Quantity']   =   $activity['Activity']['Quantity'];
                            $activity_details['Net']        =   isset($eopresults['Eopfileentry']['insurer_part'])?$eopresults['Eopfileentry']['insurer_part']:'-';
                            $activity_details['List']       =   isset($eopresults['Eopfileentry']['claimed_amount'])?$eopresults['Eopfileentry']['claimed_amount']:'-';
                            $activity_details['Clinician']  =   $activity['Activity']['Clinician'];
                            $activity_details['Prioratherizationid']  =   $activity['Activity']['PriorAuthorizationID'];
                            $activity_details['Gross']      =   isset($eopresults['Eopfileentry']['approved_amount'])?$eopresults['Eopfileentry']['approved_amount']:'-';
                            $activity_details['PatientShare']  =   isset($eopresults['Eopfileentry']['insured_part'])?$eopresults['Eopfileentry']['insured_part']:'-';
                            $activity_details['PaymentAmount']  =   isset($eopresults['Eopfileentry']['insurer_part'])?$eopresults['Eopfileentry']['insurer_part']:'-';
                            $activity_details['ActivityDenialCode']  =   isset($eopresults['Eopfileentry']['invoice_notes'])?$eopresults['Eopfileentry']['invoice_notes']:'-';
                            $activitydetails                =   $activity_details;
                            
                            fputcsv($file, $activity_details);
                        }
                    }
                    $claimobj     =   new Claim();
                    $otherclaims    =   $claimobj->find('all',array('conditions'   =>  array('claim.ProviderID'    =>  $providerid,'comment_id'=>array('$ne'=>null),'remitance_status'=>array('$ne' => 1))));
                    foreach ($otherclaims as $otherclaim)
                    {
                        $claim_status       = $this->Eopfileentry->find('first',array('conditions'  =>  array('external_invoice_ref'    =>  $otherclaim['Claim']['claim']['xmlclaimID'])));
                        if(!isset($claim_status['Eopfileentry']['eopfile_id']))
                        {
                            $claimcountforehader++;   
                            $activity_uid                       =   0;
                            $claimdetails                       =   array();
                            $claimdetails['ClaimID']            =   $otherclaim['Claim']['claim']['xmlclaim_id'];
                            $claimdetails['IDPayer']            =   '-';//$eopfilevalues['Eopfileentry']['batch_number'].'_'.$eopfilevalues['Eopfileentry']['report_number'].'_'.$eopfilevalues['Eopfileentry']['external_invoice_ref'];
                            $claimdetails['ProviderID']         =   '-';//$eopfilevalues['Eopfileentry']['payee_code'];
                            $claimdetails['DenialCode']         =   '-';//$eopfilevalues['Eopfileentry']['denial_code'];
                            $claimdetails['PaymentReference']   =   'n/a';//$eopfilevalues['Eopfileentry']['payment_external_reference'];
                            $claimdetails['SettlementDate']     =   date("Y-m-d H:i:s");//$eopfilevalues['Eopfileentry']['payment_receipt_date'];
                            $claimdetails['FacilityID']         =   $otherclaim['Claim']['claim']['Encounter']['FacilityID'];//$eopfilevalues['Eopfileentry']['payee_code'];
//                            $claimid            =   $Claim->find('first',array('conditions'   =>  array('claim.xmlclaimID'    =>  $eopfilevalues['Eopfileentry']['external_invoice_ref']),'fields'   =>  array('Claim.id')));
                        
                            $activities         =   $ActivityModel->find('all',array('conditions'=>array('claim_id'=>$otherclaim['Claim']['id'])));
                            foreach ($activities as $Activity)
                            {
                                $activity_details                       =   array();
                                foreach($claimdetails as $key           =>  $claimdetail)
                                {
                                    $activity_details[$key]             =   $claimdetail;
                                }
                                $activity_details['UID']                =   ++$activity_uid;
                                $activity_details['ActivityID']         =   $activity['Activity']['Activity_id'];
                                $activity_details['Start']              =   $activity['Activity']['start'];
                                $activity_details['Type']               =   $activity['Activity']['Type'];
                                $activity_details['Code']               =   $activity['Activity']['Code'];
                                $activity_details['Quantity']           =   $activity['Activity']['Quantity'];
                                $activity_details['Net']                =   $activity['Activity']['Net'];
                                $activity_details['List']               =   '-';//$eopresults['Eopfileentry']['claimed_amount'];
                                $activity_details['Clinician']          =   $activity['Activity']['Clinician'];
                                $activity_details['Prioratherizationid']=   $activity['Activity']['PriorAuthorizationID'];
                                $activity_details['Gross']              =   '-';//$eopresults['Eopfileentry']['approved_amount'];
                                $activity_details['PatientShare']       =   '-';//$eopresults['Eopfileentry']['insured_part'];
                                $activity_details['PaymentAmount']      =   '-';//$eopresults['Eopfileentry']['insurer_part'];
                                $activity_details['ActivityDenialCode'] =   '-';//$eopresults['Eopfileentry']['invoice_notes'];
                            
                                fputcsv($file, $activity_details);
                            }
                            $claimobj->save(array('id'  =>  $otherclaim['Claim']['id'],'remitance_status' => 1));
                        }
                    }
                }
                fclose($file);
                $this->Eopfileentry->Eopfile->id=$fileid;
                $this->Eopfileentry->Eopfile->saveField('Excel'.$country, $date.'/'.$fileid. '/'.$country.'.csv');
         }
}
