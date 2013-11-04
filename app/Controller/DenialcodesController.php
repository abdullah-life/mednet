<?php
App::uses('AppController', 'Controller');
/**
 * Denialcodes Controller
 *
 * @property Denialcode $Denialcode
 */
class DenialcodesController extends AppController {

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
    
	public function index() {
                if($this->request->is('post')){
                    $conditions = array();
                    $data       = $this->request->data;
                    if($data['Denialcodes']['Denialcode']){
                        $this->Session->write('Code',$data['Denialcodes']['Denialcode']);
                    }
                    else{
                        $this->Session->write('Code',null);
                    }
                    if($data['Denialcodes']['DenialType']){
                        $this->Session->write('Type',$data['Denialcodes']['DenialType']);
                    }
                    else{
                        $this->Session->write('Type',null);
                    }
                    if($data['Denialcodes']['EffectiveDate']){
                        $this->Session->write('Effective',$data['Denialcodes']['EffectiveDate']);
                    }
                    else{
                        $this->Session->write('Effective',null);
                    }
                    if($data['Denialcodes']['ExpiryDate']){
                        $this->Session->write('Expired',$data['Denialcodes']['ExpiryDate']);
                    }
                    else{
                        $this->Session->write('Expired',null);
                    }
                    if($data['Denialcodes']['ProviderLocation']){
                        $this->Session->write('location',$data['Denialcodes']['ProviderLocation']);
                    }
                    else{
                        $this->Session->write('location',null);
                    }
                    
                }
                else{
                    $conditions =   array();
                }
                if($this->Session->read('Code'))
                    $conditions['Code']     =   $this->Session->read('Code');
                if($this->Session->read('Type'))
                    $conditions['Type']     =   $this->Session->read('Type');
                if($this->Session->read('Effective'))
                    $conditions['Effective']     =   $this->Session->read('Effective');
                if($this->Session->read('Expired'))
                    $conditions['Expired']     =   $this->Session->read('Expired');
                if($this->Session->read('location'))
                {
                    if($this->Session->read('location')=='2'){
                        $conditions['location']     =   '0'; 
                    }else{
                        $conditions['location']     =   '1';
                    }
                }
                $denialcodesarray    = $this->Denialcode->query(array('distinct'    =>  'denialcodes',   'key'   =>  'Code', 'query'=>array() ));
                foreach ($denialcodesarray['values'] as $denial)
                {
                    $denial_codes[$denial]   =   $denial;
                }
                $denialcodesarray    = $this->Denialcode->query(array('distinct'    =>  'denialcodes',   'key'   =>  'Type', 'query'=>array() ));
                foreach ($denialcodesarray['values'] as $denial)
                {
                    $denialtypes[$denial]   =   $denial;
                }
                $denialcodesarray    = $this->Denialcode->query(array('distinct'    =>  'denialcodes',   'key'   =>  'Effective', 'query'=>array() ));
                foreach ($denialcodesarray['values'] as $denial)
                {
                    $effectivedates[$denial]   =   $denial;
                }
                $denialcodesarray    = $this->Denialcode->query(array('distinct'    =>  'denialcodes',   'key'   =>  'Expired', 'query'=>array() ));
                foreach ($denialcodesarray['values'] as $denial)
                {
                    $expirydate[$denial]   =   $denial;
                }
                $denialcodesarray    = $this->Denialcode->query(array('distinct'    =>  'denialcodes',   'key'   =>  'location', 'query'=>array() ));
                foreach ($denialcodesarray['values'] as $denial)
                {
                    if((string) $denial == 1)
                    {
                        $locations[1] = 'DHA';
                    }else{
                        $locations[2] = 'HAAD';
                    }
                }
                $this->paginate =   array(
                                        'conditions' => $conditions
                                    );
                $this->set(compact('denial_codes','denialtypes','effectivedates','expirydate','locations'));
		$this->Denialcode->recursive = 0;
		$this->set('denialcodes', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Denialcode->id = $id;
		if (!$this->Denialcode->exists()) {
			throw new NotFoundException(__('Invalid denialcode'));
		}
		$this->set('denialcode', $this->Denialcode->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
                    if (!file_exists(WWW_ROOT . 'files/DenialCodes/')) {
                        mkdir(WWW_ROOT.'files/DenialCodes'); 
                    }
                    app::import('model','Denialtable');
                    $denialtableobj         =   new Denialtable();
                    $name                   =   trim($this->request->data['DenialCode']['Codes']['name']);
                    $denialtblfilename      =   $denialtableobj->find('first',array('conditions'  =>  array('filename'    =>  $name)));
                    while($denialtblfilename!=null)
                    {
                        $name               =   rand(0, 1000).$name;
                        $denialtblfilename  =   $denialtableobj->find('first',array('conditions'  =>  array('filename'    =>  $name)));
                    }
                    move_uploaded_file($this->request->data['DenialCode']['Codes']['tmp_name'],WWW_ROOT.'/files/DenialCodes/'.$name);
                    $newDenialTable =   array();
                    $newDenialTable['Denialtable']['filename']      =   $name;
		    $newDenialTable['Denialtable']['location']	    =	$this->request->data['DenialCode']['country']; 
                    $newDenialTable['Denialtable']['status']        =   0;
                    $denialtableobj->create();
                    $denialtableobj->saveAll($newDenialTable);
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   "";
                    $data['Log']['Objectcategory']  =   "denialcodes";
                    $data['Log']['Header']          =   "Uploaded the Denialcodes file";
                    $data['Log']['Desc']            =   "The Denialcodes file ".$this->request->data['Commonproviderpricingfile']['pricing']." is uploaded by : ".$this->Session->read('Auth.User.username');
                    $logobj->create();
                    $logobj->save($data);
                    $this->Session->setFlash("The file uploaded successfully. Please wait for the file to be processed");
		}
	}
        
        public function getfalurecode($activityid){
            app::import('model','Activity');
            app::import('model','claim');
            app::import('model','Header');
            $activityobj    =   new Activity();
            $claimobj       =   new Claim();
            $headerobj      =   new header();
            $activity       =   $activityobj->find('first',array('conditions'=>array('id'=>$activityid)));
            $header         =   $headerobj->find('first',array('conditions'=>array('xmllisting_id'=>$activity['Activity']['xmllisting_id'])));
            app::import('model','Denialcode');
            $Remittanceclaimcommentobj  =   new Denialcode(); 
            $header    =   $headerobj->find('first',array('condition'=>array("SenderID"=>  $batchid)));
                   
            $start = new MongoDate(strtotime("2010-01-15 00:00:00)"));
            if(strtoupper($header['Header']['ReceiverID'])=="TPA009"){
               $remittancecommentsarray    =   $Remittanceclaimcommentobj->find('list',array('fields'=>array('Code','Description','Effective','Expired'),'conditions'=>array(
                                                                                                                                                             '$and'=>array(
                                                                                                                                                                    array('location'=>'1'), 
                                                                                                                                                                    array('Effective'=>array('$lte'=>new MongoDate(strtotime($activity['Activity']['start']) ))),
                                                                                                                                                                    array('$or'=>array(array('Expired'=>array('$gte'=>new MongoDate(strtotime($activity['Activity']['start']) ))),array('Expired'=>""))),
                                                                                                                                                                 ))
                                                                                                                                                      ));
               $this->set('remittancecommentsarray',$remittancecommentsarray);
            }else{
               $remittancecommentsarray    =   $Remittanceclaimcommentobj->find('list',array('fields'=>array('Code','Description','Effective','Expired'),'conditions'=>array(
                                                                                                                                                             '$and'=>array(
                                                                                                                                                                    array('location'=>'0'), 
                                                                                                                                                                    array('Effective'=>array('$lte'=>new MongoDate(strtotime($activity['Activity']['start']) ))),
                                                                                                                                                                    array('$or'=>array(array('Expired'=>array('$gte'=>new MongoDate(strtotime($activity['Activity']['start']) ))),array('Expired'=>""))),
                                                                                                                                                                 ))
                                                                                                                                                      ));

              $this->set('remittancecommentsarray',$remittancecommentsarray);
            }
            
           
            
            $this->set('denial_code',$activity['Activity']['denailcode']);
            $this->set('activityid',$activityid);
        }
        
        public function updateactivitydenail(){
            $this->autoRender = false;
            
            if (($_POST['activity'] != 'null') and ($_POST['denialcode'] != 'null')) {
                app::import('model', 'Activity');
                $activityobj = new Activity();
                if ($activityobj->save(array('Activity' => array('id' => $_POST['activity'], 'denailcode' => $_POST['denialcode'])))) {
                    echo "Denial Code Added";
                    app::import('model','Activity');
                    $activityobj        = new Activity();  
                    app::import('model','Claim');
                    $claimobj   =   new Claim();
                    $activity_det       =   $activityobj->find('first',array('conditions' => array('id' => $_POST['activity'])));
                    $claim_det  =   $claimobj->find('first',array('conditions' => array('id' => $activity_det['Activity']['claim_id'])));
                    app::import('model','Log');
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   $_POST['activity'];
                    $data['Log']['Objectcategory']  =   "activity";
                    $data['Log']['Header']          =   "Denailcode update for Activity";
                    $data['Log']['Desc']            =   "The denialcode ".$_POST['denialcode']."is added to the activity ".$activity_det['Activity']['Activity_id']." of the claim ".$claim_det['Claim']['claim']['xmlclaimID']." by : ".$this->Session->read('Auth.User.username');
                    $logobj->create();
                    $logobj->save($data);
                } else {
                    echo "Failed to add Denial Code";
                }
            }
            else{
                echo 'Please choose a denial code to add';
            }
        }
        
        public function addsinglecode(){
            if($this->request->is('post')){
                $data   =   $this->request->data;
                $this->Denialcode->create();
                $datatosave['Denialcode']['Code']                   =    $this->request->data['DenialCode']['Code'];
                $datatosave['Denialcode']['Description']            =    $this->request->data['DenialCode']['Description'];
                $datatosave['Denialcode']['Examples/Descriptions']  =    $this->request->data['DenialCode']['Exampledscr'];
                $datatosave['Denialcode']['Status']                 =    $this->request->data['DenialCode']['Status'];
                $datatosave['Denialcode']['Type']                   =    $this->request->data['DenialCode']['Type'];
                $datatosave['Denialcode']['location']               =    $this->request->data['DenialCode']['Location'];
                $datatosave['Denialcode']['Effective']              =     new MongoDate(strtotime($this->request->data['DenialCode']['Effective']['year']."-".$this->request->data['DenialCode']['Effective']['month']."-".$this->request->data['DenialCode']['Effective']['day']));
                $datatosave['Denialcode']['Expired']                =     new MongoDate(strtotime($this->request->data['DenialCode']['Expiry']['year'].'-'.$data['DenialCode']['Expiry']['month'].'-'.$data['DenialCode']['Expiry']['day']));
                
                if($this->Denialcode->save($datatosave)){
                    $this->Session->setFlash ("Denial code added");
                    app::import('model','Log');
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   "";
                    $data['Log']['Objectcategory']  =   "denialcode";
                    $data['Log']['Header']          =   "Denailcode added to the activity";
                    $data['Log']['Desc']            =   "The denialcode ".$this->request->data['DenialCode']['Code']." is added to database by : ".$this->Session->read('Auth.User.username');
                    $logobj->create();
                    $logobj->save($data);
                }
                else
                    $this->Session->setFlash ("Failed to add the denial code");
            }
            $locations  =   array(0 => 'HAAD',1 => 'DHA');
            $this->set('locations',$locations);
        }
        
        public function removeactivitydenial(){
            $this->autoRender = false;
            app::import('model','Activity');
            $activityobj    =   new Activity();
            if($_POST['activity'] != 'null'){
                if ($activityobj->save(array('Activity' => array('id' => $_POST['activity'], 'denailcode' => null)))) {
                    app::import('model','Activity');
                    app::import('model','Claim');
                    $activityobj        =   new Activity();
                    $claimobj           =   new Claim();
                    $activitydet        =   $activityobj->find('first',array('conditions' => array('id' => $_POST['activity'])));
                    $claimdet           =   $claimobj->find('first',array('conditions' => array('id' => $activitydet['Activity']['claim_id'])));
                    app::import('model','Log');
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   $_POST['activity'];
                    $data['Log']['Objectcategory']  =   "activity";
                    $data['Log']['Header']          =   "Denailcode deleted for Activity";
                    $data['Log']['Desc']            =   "The denialcode ".$_POST['denialcode']."is deleted for the activity ".$activitydet['Activity']['Activity_id']." for the claim ".$claimdet['Claim']['claim']['xmlclaimID']." by : ".$this->Session->read('Auth.User.username');
                    $logobj->create();
                    $logobj->save($data);
                    echo "Denial Code is removed";
                } else {
                    echo "Failed to remove Denial Code";
                }
            }
        }
        
        public function getdatetime($timevalue)
        {
            $d = floor($timevalue); 
            $t = $timevalue - $d;
            $date   =    ($d > 0) ? ( $d - 25569 ) * 86400 + $t * 86400 : $t * 86400;
            return  new MongoDate($date);
            
        }
        
        public function adddenialCodes($denialtbldata=null)
        {
           $filename   =   $denialtbldata['Denialtable']['filename'];
           if(file_exists(WWW_ROOT.'/files/DenialCodes/'.$filename))
           {
               app::import('Vendor','simplexlsx');
               app::import('model','Denialtable');
               $denialtableobj  =   new Denialtable();
               $simple     =    new SimpleXLSX(WWW_ROOT.'/files/DenialCodes/'.$filename);
               list($cols) = $simple->dimension();
               foreach( $simple->rows() as $k => $r){
                   if($k==0)
                       continue;
                   $i=0;
                   $data['Denialcode']['fileid']=$denialtbldata['Denialtable']['id'];
                   $data['Denialcode']['Code']=$r[$i++];
                   $data['Denialcode']['Description']=$r[$i++];
                   $data['Denialcode']['Examples/Descriptions']=$r[$i++];
                   $data['Denialcode']['Status']=$r[$i++];
                   $data['Denialcode']['Type']=$r[$i++];
		   $data['Denialcode']['location']	=	$denialtbldata['Denialtable']['location'];
                   $data['Denialcode']['Effective']=$r[$i++];
                   $data['Denialcode']['Expired']=$r[$i++];
		   if(!isset( $data['Denialcode']['Code']))
			continue;
		   if($data['Denialcode']['Effective']!=null){
		   	$data['Denialcode']['Effective']	=	$this->getdatetime($data['Denialcode']['Effective'] );
		   }
		   if($data['Denialcode']['Expired']!=null)
		   {
			$data['Denialcode']['Expired']        =       $this->getdatetime($data['Denialcode']['Expired'] );

		   }
		   
                   $this->Denialcode->create();
                    if($this->Denialcode->save($data)){


                    }
                   else
                       echo "Unable to insert the data"."\n";
                }
                $denialtableobj->save(array('id'  =>  $denialtbldata['Denialtable']['id'],'status' => 1));
                exit;
           }
           else
           {
               echo "Unable to open the file";
           }
            
        }

        /**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Denialcode->id = $id;
		if (!$this->Denialcode->exists()) {
			throw new NotFoundException(__('Invalid denialcode'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Denialcode->save($this->request->data)) {
				$this->Session->setFlash(__('The denialcode has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The denialcode could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Denialcode->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Denialcode->id = $id;
		if (!$this->Denialcode->exists()) {
			throw new NotFoundException(__('Invalid denialcode'));
		}
                $data       =   $this->Denialcode->find('first',array('conditions' => array('id' => $id)));
		if ($this->Denialcode->delete()) {
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   "";
                        $data['Log']['Objectcategory']  =   "denialcode";
                        $data['Log']['Header']          =   "Denailcode deleted from Database";
                        $data['Log']['Desc']            =   "The denialcode ".$data['Denialcode']['Code']."is deleted from the database by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
			$this->Session->setFlash(__('Denialcode deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Denialcode was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
