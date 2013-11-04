<?php
App::uses('AppController', 'Controller');
/**
 * Activities Controller
 *
 * @property Activity $Activity
 */
class ActivitiesController extends AppController {

    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
        $this->checkpermission();
    }

/**
 * index method
 *
 * @return void
 */
        
        public $components = array('RequestHandler');
        public $helpers = array('Js');
        
        public function getEopActivities($eopfileid,$providerid=null){
           
            app::import('model','Eopfile');
            $eopfiles       =   new Eopfile();
            $eopfiledata    =   $eopfiles->find('first',array('conditions'=>array('id'=>$eopfileid)));
            app::import('model','Eopfileentry');
            $Eopfileentry   =   new Eopfileentry();
            $eopproviders   =   $Eopfileentry->query(array('distinct'    =>  'eopfileentries',   'key'   =>  'payee_code', 'query'=>array('eopfile_id' =>  $eopfileid) ));
            foreach($eopproviders['values'] as $eopprovider){
                $providerlist[$eopprovider]=$eopprovider;
            }
            $this->set('eopfileid',$eopfileid);
            $this->set('providerlists',$providerlist);
        }
        
       public function getEopclaims($providerid,$eopfileid){
             
             app::import('model','Eopfileentry');
             $eopfileentry      =   new Eopfileentry();
             $eopproviders   =   $eopfileentry->query(array('distinct'    =>  'eopfileentries',   'key'   =>  'external_invoice_ref', 'query'=>array('payee_code' =>  $providerid,'eopfile_id' =>  $eopfileid) ));
             if($eopproviders){
                 foreach($eopproviders['values'] as $claim ){
                    $claimarray[$claim] =   $claim;
                 }
             }else{
                 echo "No claims found";
             }
             $this->set("claimarray",$claimarray);
       } 
    
       public function getclaimactivitiesforremittance($claimid){
           $claimid=trim($claimid);
           if($this->Session->read('claim_id')!=null)
            {
                $this->Session->write('claim_id', $claimid);
                $claimid = $this->Session->read('claim_id');
            }
           
            app::import('model','BatchesClaim');
            $BatchesClaimobj    =   new BatchesClaim();
            $claimdetails   =   $this->Activity->Claim->find('first',array('fields'=>array('id'), 'conditions'=>array('Claim.claim.xmlclaimID'=>$claimid)));
            if($claimdetails)
                $claimsarray[]    =  new MongoRegex('"^'.trim($claimdetails['Claim']['id']).'/i"'); 
            else
                $claimsarray[]    =  new MongoRegex('"^'.trim("no claims found").'/i"'); 
            $this->paginate = array(
            'conditions' => array('claim_id' => array('$in' => $claimsarray)),
             'order' => array('marked' => 'desc','id'=>'desc'),
           );
            app::import('model','Remittanceclaimcomment');
            $Remittanceclaimcommentobj  =    new Remittanceclaimcomment();
            $this->set('remittancecommentsarray',$remittancecommentsarray);
            $this->set('activities', $this->paginate());
            $this->set('sclaim',  $this->Session->read('claim_id'));
       }
       
        public function getActivitiesPricing($batchid=null,$claimid=null,$session_write=null){
            
            $claimid=trim($claimid);
            if($session_write == 'true')
            {
                $this->Session->write('claim_id',null);
                $this->Session->write('batch_id',null);
            }else{
                if($this->Session->read('claim_id')!=null)
                {
                    $this->Session->write('claim_id', $claimid);
                    $this->Session->write('batch_id', $batchid);
                    $claimid = $this->Session->read('claim_id');
                    $batchid = $this->Session->read('batch_id');
                }
            }
            app::import('model','Batch');
            $batchesobj         =   new Batch();  
            app::import('model','BatchesClaim');
            $BatchesClaimobj    =   new BatchesClaim();
             app::import('model','header');
             $headerobj         =   new Header();
            $claimsarraydp      =   $BatchesClaimobj->find('list',array('fields'=>array('id','claim_id'), 'conditions'=>array('batch_id'=>trim($batchid))));
            $claimslisting       =   array();      

            $markedclaims = $this->Activity->find('list',array('fields'=>array('claim_id'),'conditions'=>array('marked'=>1)));

            
            $markedclaims = array_unique($markedclaims);
            foreach ($markedclaims as $markedclaim)
            {
                $results = $this->Activity->Claim->find('all',array('conditions'    =>  array('id'  =>  $markedclaim),'fields' =>  array('Claim.claim.xmlclaimID')));
                $mclaims[]   =  $results[0]['Claim']['claim']['xmlclaimID'];
            }

            $claimsmarked = $this->Activity->Claim->find('list',array('fields' => array('Claim.claim.xmlclaimID'),'conditions' => array('comment_id'=>array('$ne'=>null))));
            
            foreach($claimsarraydp as $claimdpid){
                $claimslist         =   $this->Activity->Claim->read(null,$claimdpid);

                $claimids[]         =   $claimslist['Claim']['id'];
                $claimslisting[$claimslist['Claim']['claim']['xmlclaimID']]  =  $claimslist['Claim']['claim']['xmlclaimID']; 
            }
            
          
            if(!$claimid && isset($batchid)){
               
                $claimsdetails[]    =   $BatchesClaimobj->find('first',array('conditions' => array('batch_id' => $batchid),'fields'  =>  array('claim_id')));
                $claimsarray[]      =   $claimsdetails[0]['BatchesClaim']['claim_id'];
                $this->set('claimidformessi',$claimsdetails[0]['BatchesClaim']['claim_id']);
                $claimidforcomment  =   $claimsdetails[0]['BatchesClaim']['claim_id'];
                
              
            }else{
                $batchdetails       =   $batchesobj->find('first',array('conditions' => array('id' => $batchid)));
                $claimdetails       =   $this->Activity->Claim->find('first',array('fields'=>array('id'), 'conditions'=>array('Claim.claim.xmlclaimID'=>$claimid,'Claim.claim.ProviderID' => $batchdetails['Batch']['provider_id'])));
                $claimsarray[]      =   trim($claimdetails['Claim']['id']); 
                $claimidforcomment  =   $claimdetails['Claim']['id'];
                $this->set('claimidformessi',$claimid);
               
            }
          
            $claims_marked_array    =   $this->Activity->Claim->find('all',array('conditions'   =>  array('comment_id'  =>  array('$ne' => null))));
            foreach ($claims_marked_array as $claimsformarked)
            {
                $claimsmarked[]  =   $claimsformarked['Claim']['claim']['xmlclaimID'];
            }
            
            $this->paginate = array(
            'conditions' => array('claim_id' => array('$in' => $claimsarray)),
             'order' => array('marked' => 'desc','created'=>'desc'),
                'limit' => 20
           );
          
            app::import('model','Denialcode');
            $Remittanceclaimcommentobj  =   new Denialcode(); 
            
            $claimcommentarray          =   $this->Activity->Claim->read(null,$claimidforcomment);
            $firstactivity              =   $this->Activity->find('first',array('conditions' => array('claim_id' => $claimidforcomment)));
           
            $this->set('presentclaim',$claimcommentarray);
             //=====================code addded to get the provider is from abudabi or not=================/
                 app::import('model','Denialcode');
                 $batchdetails  =   $batchesobj->find('first',array('condition'=>array('batch.id'=>$batchid)));
                 if($batchdetails['Batch']['provider_id']){
                     $Remittanceclaimcommentobj  =   new Denialcode(); 
                     $header    =   $headerobj->find('first',array('condition'=>array("SenderID"=>  $batchid)));
                     if(strtoupper($header['Header']['ReceiverID'])=="TPA009"){
                        $remittancecommentsarray    =   $Remittanceclaimcommentobj->find('list',array('fields'=>array('id','Code','Description'),'conditions'=>array(
                                                                                                                                                             '$and'=>array(
                                                                                                                                                                    array('location'=>'1'), 
                                                                                                                                                                    array('Effective'=>array('$lte'=>new MongoDate(strtotime($firstactivity['Activity']['start']) ))),
                                                                                                                                                                    array('$or'=>array(array('Expired'=>array('$gte'=>new MongoDate(strtotime($firstactivity['Activity']['start']) ))),array('Expired'=>""))),
                                                                                                                                                                 ))
                                                                                                                                                      ));
                        $this->set('remittancecommentsarray',$remittancecommentsarray);
                    }else{
                        $remittancecommentsarray    =   $Remittanceclaimcommentobj->find('list',array('fields'=>array('id','Code','Description'),'conditions'=>array(
                                                                                                                                                             '$and'=>array(
                                                                                                                                                                    array('location'=>'0'), 
                                                                                                                                                                    array('Effective'=>array('$lte'=>new MongoDate(strtotime($firstactivity['Activity']['start']) ))),
                                                                                                                                                                    array('$or'=>array(array('Expired'=>array('$gte'=>new MongoDate(strtotime($firstactivity['Activity']['start']) ))),array('Expired'=>""))),
                                                                                                                                                                 ))
                                                                                                                                                      ));
                        $this->set('remittancecommentsarray',$remittancecommentsarray);
                    }
                 }
            //=====================end here==========================//
            $this->set('presentclaim',$claimcommentarray);
            $this->set('remittancecommentsarray',$remittancecommentsarray);
            
            $this->set('activities', $this->paginate());
            
            $this->set('claimslisting',$claimslisting);  
           
            $this->set('sclaim',  $this->Session->read('claim_id'));
           
            
            $this->set(compact( 'mclaims','claimsarray','benefitarray','batchid','claimid','claimsmarked'));
            app::import('model','Log');
            $logobj                         =   new Log();
            $data                           =   array();
            $data['Log']['User']            =   $this->Session->read('Auth.User.id');
            $data['Log']['Object']          =   $batchid;
            $data['Log']['Objectcategory']  =   "claim";
            $data['Log']['Header']          =   "User - Page access";
            $data['Log']['Desc']            =   "The : ".$this->Session->read('Auth.User.username')." accessed the  activity pricings page for the claim ".$sclaim;
            $logobj->create();
            $logobj->save($data);
        }
        
        public function index($claimid=null) {
		$this->Activity->recursive = 0;
                if($claimid){
                    $this->paginate = array(
                        'conditions' => array('Activity.claim_id' => $claimid)
                    );
                    
                }
		$this->set('activities', $this->paginate());
	}
        
        public function viewObservation($activityId =   null,$claimid = null)
        {
           
            $observations   =   $this->Activity->find('first',array('conditions'  =>  array('id'  =>  $activityId)));
            $this->set('Observations',$observations);
            $this->set('ClaimID',$claimid);
            $this->layout  =    "ajax";
            
        }
        

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Activity->id = $id;
		if (!$this->Activity->exists()) {
			throw new NotFoundException(__('Invalid activity'));
		}
		$this->set('activity', $this->Activity->read(null, $id));
	}
        
        function getactivityComments($activityid=null){
            if($activityid)
            $this->set('activity',$this->Activity->read(null,$activityid));
            else
            $this->set('activity','error');
            
        }
        
        
        function addnewComments($activityid,$comment){
            
            $activity       =   $this->Activity->read(null,$this->request->data['id']);
            $newcomments    =   $activity['Activity']['comments'];
            $newcomments[]  =   array('user_id'=>$this->Session->read('Auth.User.id'),'user_name'=>$this->Session->read('Auth.User.username'),'user_comment'=> $this->request->data['comments']);
            $this->set('data',array('user_id'=>$this->Session->read('Auth.User.id'),'user_name'=>$this->Session->read('Auth.User.username'),'user_comment'=> $this->request->data['comments']));
            $activity   =   array('Activity'=>array('id'=>trim($this->request->data['id']),'comments'=>$newcomments));
            
            $this->Activity->save($activity);
            $activityvals   =   $this->Activity->find('first',array('conditions' => array('id' => $this->request->data['id'])));
            app::import('model','Claim');
            $claimobj       =   new Claim();
            $claimsval      =   $claimobj->find('first',array('conditions' => array('id' => $activityvals['Activity']['claim_id'])));
            app::import('model','Log');
            $logobj                         =   new Log();
            $data                           =   array();
            $data['Log']['User']            =   $this->Session->read('Auth.User.id');
            $data['Log']['Object']          =   $this->request->data['id'];
            $data['Log']['Objectcategory']  =   "activity";
            $data['Log']['Header']          =   "Activity Comments";
            $data['Log']['Desc']            =   'The comment "'.$this->request->data['comments'].'" is added to the activity with activity id "'.$activityvals['Activity']['Activity_id'].'" for the claim "'.$claimsval['Claim']['claim']['xmlclaimID'].'" by '.$this->Session->read('Auth.User.username');
            $logobj->create();
            $logobj->save($data);   
                
           
            $this->layout=  'ajax';
            
        }
/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Activity->create();
			if ($this->Activity->save($this->request->data)) {
				$this->Session->setFlash(__('The activity has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The activity could not be saved. Please, try again.'));
			}
		}
		$xmllistings = $this->Activity->Xmllisting->find('list');
		$claims = $this->Activity->Claim->find('list');
		$this->set(compact('xmllistings', 'claims'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Activity->id = $id;
		if (!$this->Activity->exists()) {
			throw new NotFoundException(__('Invalid activity'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Activity->save($this->request->data)) {
				$this->Session->setFlash(__('The activity has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The activity could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Activity->read(null, $id);
		}
		$xmllistings = $this->Activity->Xmllisting->find('list');
		$claims = $this->Activity->Claim->find('list');
		$this->set(compact('xmllistings', 'claims'));
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
		$this->Activity->id = $id;
		if (!$this->Activity->exists()) {
			throw new NotFoundException(__('Invalid activity'));
		}
		if ($this->Activity->delete()) {
			$this->Session->setFlash(__('Activity deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Activity was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Activity->recursive = 0;
		$this->set('activities', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Activity->id = $id;
		if (!$this->Activity->exists()) {
			throw new NotFoundException(__('Invalid activity'));
		}
		$this->set('activity', $this->Activity->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Activity->create();
			if ($this->Activity->save($this->request->data)) {
				$this->Session->setFlash(__('The activity has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The activity could not be saved. Please, try again.'));
			}
		}
		$xmllistings = $this->Activity->Xmllisting->find('list');
		$claims = $this->Activity->Claim->find('list');
		$this->set(compact('xmllistings', 'claims'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Activity->id = $id;
		if (!$this->Activity->exists()) {
			throw new NotFoundException(__('Invalid activity'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Activity->save($this->request->data)) {
				$this->Session->setFlash(__('The activity has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The activity could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Activity->read(null, $id);
		}
		$xmllistings = $this->Activity->Xmllisting->find('list');
		$claims = $this->Activity->Claim->find('list');
		$this->set(compact('xmllistings', 'claims'));
	}
        
        public function addComment($activityid=null,$comment=null)
        {
            $comments = array(
                'user' => $this->Auth->user('username'),
                'comment'   =>  'This is a sample comment'
            );
            echo 'ObjectId("'.$activityid.'")';
            if($this->Activity->updateA(array('_id' => new MongoId($activityid)),array('$set' => array('comment'  => $comments)),array("upsert" => true)))
            {
                echo "Inserted";
            }
            else
            {
                echo 'Not';
            }
            exit;
            $comments = $this->Activity->find('all',array('fields'=>array('Activity.comments'),'conditions' => array('Activity.id'=> array($activityid))));
            print_r($comments);
            exit;
            
        }


        public function getLink($activityid=null,$activitycomment=null)
        {
            if(isset($activityid))
            {
                if($activitycomment!=0)
                {
                     $link   ='<img value="'.$activityid.'" id="'.$activityid.'" class="comments  listingcomments" src='.Router::url('/',true).'img/comment2.png>';
                     return $link;
                }
                $link   ='<img value="'.$activityid.'" id="'.$activityid.'" class="comments  listingcomments" src='.Router::url('/',true).'img/comment.png>';
                return $link;
            }
            else
            {
                echo "N/A";
            }
        }
        public function getMarkLink($activityid=null)
        {
            if(isset($activityid))
            {
                $link   ='<img value="'.$activityid.'" class="comment" src='.Router::url('/',true).'img/marked.png>';
                return $link;
            }
            else
            {
                echo "N/A";
            }
        }

        public function markactivity($activityid){
            $activity       =    $this->Activity->read(null,$activityid);
            if(isset($activity['Activity']['marked'])){
                if($activity['Activity']['marked']==0){
                    $this->Activity->id =   $activityid;
                    $activity_det       =   $this->Activity->find('first',array('id' => $activityid));
                    app::import('model','Claim');
                    $claimboj           =   new Claim();
                    $claimdata          =   $claimboj->find('first',array('conditions' => array('id' => $activity_det['Activity']['claim_id'])));
                    if($this->Activity->save(array('Activity'=>array('id'=>$activity['Activity']['id'],'marked'=>1)))){
                            $activity_det       =   $this->Activity->find('first',array('id' => $activityid));
                            app::import('model','Claim');
                            $claimboj           =   new Claim();
                            $claimdata          =   $claimboj->find('first',array('conditions' => array('id' => $activity_det['Activity']['claim_id'])));
                            echo "marked";
                            app::import('model','Log');
                            $logobj                         =   new Log();
                            $data                           =   array();
                            $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                            $data['Log']['Object']          =   $activityid;
                            $data['Log']['Objectcategory']  =   "activity";
                            $data['Log']['Header']          =   "Marking the Activity";
                            $data['Log']['Desc']            =   "The Activity ".$activity['Activity']['Activity_id']." of the claim ".$claimdata['Claim']['claim']['xmlclaimID']." is marked by : ".$this->Session->read('Auth.User.username');
                            $logobj->create();
                            $logobj->save($data); 
                    }
                }else{
                    if($this->Activity->save(array('Activity'=>array('id'=>$activity['Activity']['id'],'marked'=>0)))){
                            echo "unmarked";
                            app::import('model','Log');
                            $logobj                         =   new Log();
                            $data                           =   array();
                            $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                            $data['Log']['Object']          =   $activityid;
                            $data['Log']['Objectcategory']  =   "activity";
                            $data['Log']['Header']          =   "Unmarking the Activity";
                            $data['Log']['Desc']            =   "The Activity ".$activity['Activity']['Activity_id']." of the claim ".$claimdata['Claim']['claim']['xmlclaimID']." is unmarked by : ".$this->Session->read('Auth.User.username');
                            $logobj->create();
                            $logobj->save($data);
                    }
                    else
                            echo "error";
                }
            }else{
                if($this->Activity->save(array('Activity'=>array('id'=>$activity['Activity']['id'],'marked'=>1))))
                            echo "marked here";
            }
            $this->autoRender   =   false;
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
		$this->Activity->id = $id;
		if (!$this->Activity->exists()) {
			throw new NotFoundException(__('Invalid activity'));
		}
		if ($this->Activity->delete()) {
			$this->Session->setFlash(__('Activity deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Activity was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
 /**
 * Find discount,gross,discound_price etc
 *
 * @param int activity_id,int $activity_type, string $activity_code
 * @return array
 */
        
        public function getPricing($activity_id=null,$activity_type=null,$activity_code=null)
        {
            $claimid=$this->Activity->find('all',array('conditions'=> array('Activity.id'=>$activity_id)));
            $providerdetails           =   app::import('model','providerdetail');
            $ProviderDetailobj    =   new Providerdetail();
            $result = $ProviderDetailobj->Providerpricing->find('all',array('conditions'=> array('Providerdetail.licence'=>$claimid['0']['Claim']['ProviderID'],'Providerpricing.code'=>$activity_code,'Providerpricing.type'=>$activity_type,)));
            return $result;
        }
        
        
        
       
}
