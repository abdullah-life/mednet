<?php
App::uses('AppController', 'Controller');
/**
 * ClaimsprocessorBatches Controller
 *
 * @property ClaimsprocessorBatch $ClaimsprocessorBatch
 */
class ClaimsprocessorBatchesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ClaimsprocessorBatch->recursive = 0;
		$this->set('claimsprocessorBatches', $this->paginate());
	}
        
        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('*');
            $this->checkpermission();
        }
        
        public function checkdownloadstatus($batchid){
                $batchdetails           =   $this->ClaimsprocessorBatch->Batch->find('first',array('conditions'=>array('Batch.id'=>$batchid)));
                if($batchdetails['Batch']['status']>=3){
                     $this->autoRender  =   false;
                     $this->ClaimsprocessorBatch->Batch->id =   $batchid;
                     $batchdetails   =   $this->ClaimsprocessorBatch->Batch->read(null,$batchid);
                     if($batchdetails['Batch']['status']==3){
                           $this->ClaimsprocessorBatch->Batch->saveField('status',7);
                     }
                     app::import('model','Batch');
                     $batchobj      =   new Batch();
                     $batch         =   $batchobj->read(null,$batchid);
                     $trimmeddate   =   trim(date("Ymd",$batch['Batch']['created']->sec));
                     if($batch['Batch']['resubmission']==0)
                        echo json_encode(array('firsttime',Router::url('/', true)."/files/batch/". $trimmeddate.'/'.str_replace(' ','',$batch['Batch']['name']).'_'.$batch['Batch']['provider_id'].'.zip'));
                     else
                        echo json_encode(array('firsttime',Router::url('/', true)."/files/batch/". $trimmeddate.'/'.str_replace(' ','',$batch['Batch']['name']).'_'.$batch['Batch']['provider_id'].'_resubmission_files.zip'));
                
                     
                     }
                else{
                     $this->autoRender   =   false;
                     app::import('model','Batch');
                     $batchobj  =   new Batch();
                     $batch  =   $batchobj->read(null,$batchid);
                     $trimmeddate           =         trim(date("Ymd",strtotime($batch['Batch']['created'])));
//                     echo json_encode(array('alreadydownloaded',Router::url('/', true)."/files/batch/". $trimmeddate.'/'.str_replace(' ','',$batch['Batch']['name']).'_'.$batch['Batch']['provider_id'].'.zip'));
                      if($batch['Batch']['resubmission']==0)
                        echo json_encode(array('alreadydownloaded',Router::url('/', true)."/files/batch/". $trimmeddate.'/'.str_replace(' ','',$batch['Batch']['name']).'_'.$batch['Batch']['provider_id'].'.zip'));
                     else
                        echo json_encode(array('alreadydownloaded',Router::url('/', true)."/files/batch/". $trimmeddate.'/'.str_replace(' ','',$batch['Batch']['name']).'_'.$batch['Batch']['provider_id'].'_resubmission_files.zip'));
                
                     
                }
            $this->layout=  "ajax";
            $this->autoRender   =   false;
            
        }
        
        public function markprocessed($status,$batchid,$redirect){
            $this->ClaimsprocessorBatch->id=$batchid;
            $batchdetails                   =   $this->ClaimsprocessorBatch->Batch->find("first",array('conditions' => array('id' => $batchid)));
            $this->ClaimsprocessorBatch->Batch->id= $batchid;
            if($status==1){
                $data   =   $this->ClaimsprocessorBatch->Batch->read(null,$batchid);
                if($this->Session->read('Auth.User.group_id')==17){
                    if($data['Batch']['status']!=3 and  $data['Batch']['status']!=5 and $data['Batch']['status']!=7 ){
                        $this->Session->setFlash("You are not allowed to perform this action");
                        $this->redirect(array('controller'=>'batches','action'=>$redirect));
                    }
                    
                }
                $this->ClaimsprocessorBatch->Batch->id= $batchid;
                $this->ClaimsprocessorBatch->Batch->saveField('status', 6);
                $this->ClaimsprocessorBatch->Batch->saveField('success_by', $this->Session->read('Auth.User.id'));
                
                app::import('model','Log');
                $logobj                         =   new Log();
                $data                           =   array();
                $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                $data['Log']['Object']          =   $batchid;
                $data['Log']['Objectcategory']  =   "batch";
                $data['Log']['Header']          =   "Batch made success";
                $data['Log']['Desc']            =   "The batch ".$batchdetails['Batch']['name']." is marked as processed by : ".$this->Session->read('Auth.User.username');
                $logobj->create();
                $logobj->save($data);
                $this->Session->setFlash("Batch marked as processed"); 
            }
            else{
                $this->ClaimsprocessorBatch->Batch->id  = $batchid;
                $batchesdateails    =   $this->ClaimsprocessorBatch->find('count',array('conditions'=>array('batch_id'=>$batchid)));
                $batchvalues        =   $this->ClaimsprocessorBatch->Batch->find('first',array('conditions' =>  array('id' => $batchid)));
                if($batchvalues['Batch']['status']!=6)
                {
                    $this->ClaimsprocessorBatch->Batch->id= $batchid;
                    $this->ClaimsprocessorBatch->Batch->saveField('status', 6);
                    $this->ClaimsprocessorBatch->Batch->saveField('success_by', $this->Session->read('Auth.User.id'));
                    $this->Session->setFlash("Batch marked as processed");
                    app::import('model','Log');
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   $batchid;
                    $data['Log']['Objectcategory']  =   "batch";
                    $data['Log']['Header']          =   "Batch made success";
                    $data['Log']['Desc']            =   "The batch ".$batchdetails['Batch']['name']." is marked as processed by : ".$this->Session->read('Auth.User.username');
                    $logobj->create();  
                    $logobj->save($data);
                }
                else{
                    if($batchesdateails>0){
                        $this->ClaimsprocessorBatch->Batch->saveField('status', 3);
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $batchid;
                        $data['Log']['Objectcategory']  =   "batch";
                        $data['Log']['Header']          =   "Batch made success";
                        $data['Log']['Desc']            =   "The batch ".$batchdetails['Batch']['name']."is marked as unprocessed by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                    }
                    else{
                        $this->ClaimsprocessorBatch->Batch->saveField('status', 2);
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $batchid;
                        $data['Log']['Objectcategory']  =   "batch";
                        $data['Log']['Header']          =   "Batch made success";
                        $data['Log']['Desc']            =   "The batch ".$batchdetails['Batch']['name']." is marked as unprocessed by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                    }
                    $this->Session->setFlash("Batch marked as unprocessed");
                    $this->ClaimsprocessorBatch->Batch->saveField('success_by',null);
                    $this->Session->setFlash("Batch marked as processed");
                }
            }
           
                
                $this->redirect(array('controller'=>'batches','action'=>$redirect));
           
            
        }
        public function markhold($status,$batchid,$redirect){
            
             $this->ClaimsprocessorBatch->Batch->id=$batchid;
              $batchesdateails    =   $this->ClaimsprocessorBatch->Batch->read();
             if($batchesdateails['Batch']['status']==4 or $batchesdateails['Batch']['status']==8 ){
                        $this->Session->setFlash("This action is not permitted");
                        $this->redirect(array('controller'=>'batches','action'=>$redirect));
                        
             }
             if($this->Session->read('Auth.User.group_id') == 17)
             {
                if($batchesdateails['Batch']['status']!=6)
                {
                    if(($batchesdateails['Batch']['status']==3 OR $batchesdateails['Batch']['status']==7) ){
                        $this->ClaimsprocessorBatch->Batch->id  =   $batchesdateails['Batch']['id'];
                        $this->ClaimsprocessorBatch->Batch->saveField("onhold_by", $this->Session->read('Auth.User.id'));
                        $status         =   5;
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $batchid;
                        $data['Log']['Objectcategory']  =   "batch";
                        $data['Log']['Header']          =   "Batch :- Onhold";
                        $data['Log']['Desc']            =   "The batch ".$batchesdateails['Batch']['name']." is made onhold by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                    }
                    else if($batchesdateails['Batch']['status']==5){
                        $this->ClaimsprocessorBatch->Batch->id  =   $batchesdateails['Batch']['id'];
                        $this->ClaimsprocessorBatch->Batch->saveField("onhold_by", null);
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $batchid;
                        $data['Log']['Objectcategory']  =   "batch";
                        $data['Log']['Header']          =   "Batch :- Removed Onhold";
                        $data['Log']['Desc']            =   "The batch ".$batchesdateails['Batch']['name']." is removed onhold by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                        $status         =   7;
                    }
//                    else 
//                         $status         =   3;  
                }
                else
                {
                     $this->Session->setFlash("You do not have the permission to do this operation");
                     $this->redirect(array('controller'=>'batches','action'=>$redirect));
                }
            }
            else
            {   
                    $batchescount    =   $this->ClaimsprocessorBatch->find('count',array('conditions'=>array('batch_id'=> trim($batchid))));
                    if($batchesdateails['Batch']['status']==5)
                    {
                         if($batchescount>0)
                                $status         =   3;
                            else
                                $status         =   2;
                            
                        $this->ClaimsprocessorBatch->Batch->id  =   $batchesdateails['Batch']['id'];
                        $this->ClaimsprocessorBatch->Batch->saveField("onhold_by", null);
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $batchid;
                        $data['Log']['Objectcategory']  =   "batch";
                        $data['Log']['Header']          =   "Batch :- Removed Onhold";
                        $data['Log']['Desc']            =   "The batch ".$batchesdateails['Batch']['name']." is removed onhold by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                     }
                     else
                     {
                        $status    =   5;
                        $this->ClaimsprocessorBatch->Batch->id  =   $batchesdateails['Batch']['id'];
                        $this->ClaimsprocessorBatch->Batch->saveField("onhold_by", $this->Session->read('Auth.User.id')); 
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $batchid;
                        $data['Log']['Objectcategory']  =   "batch";
                        $data['Log']['Header']          =   "Batch :- added Onhold";
                        $data['Log']['Desc']            =   "The batch ".$batchesdateails['Batch']['name']." is made onhold by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                     }
            }
            if($this->ClaimsprocessorBatch->Batch->saveField('status', $status))
            {
                $this->Session->setFlash("Successfully changed the status ");
                $this->redirect(array('controller'=>'batches','action'=>$redirect));
            }else{
                $this->Session->setFlash("Batch marked as unprocessed");
                $this->redirect(array('controller'=>'batches','action'=>$redirect));
            }
            
        }
        
        
/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ClaimsprocessorBatch->id = $id;
		if (!$this->ClaimsprocessorBatch->exists()) {
			throw new NotFoundException(__('Invalid claimsprocessor batch'));
		}
		$this->set('claimsprocessorBatch', $this->ClaimsprocessorBatch->read(null, $id));
	}

         public function getbatchclaimscount($date=null){
            $date               =   "'".trim(date("Y-m-d"))."'";  
            $claimsbatch       =    $this->ClaimsprocessorBatch->find('all',array(
                    
                 'conditions'=>array('created'=>$this->getDateForSearch(),'user_id' => $this->Session->read('Auth.User.id'))
             ));
           
            $claimscount   =   0;
            foreach($claimsbatch as $batch){
               $batches     =   $this->ClaimsprocessorBatch->Batch->BatchesClaim->find('count',array('conditions'=>array('batch_id'=>$batch['ClaimsprocessorBatch']['batch_id'])));
               $claimscount =   $claimscount    + $batches;
            }
            return  $claimscount;
        }
        
        public function getbatchxmlcount($date=null){
            $date               =   "'".trim(date("Y-m-d"))."'";  
            $claimsbatch       =    $this->ClaimsprocessorBatch->find('list',array(
                 'conditions'=>array($this->getDateForSearch('ClaimsprocessorBatch'))
             ));
             $claimscount   =   0;
            foreach($claimsbatch as $batch){
               $batches     =   $this->ClaimsprocessorBatch->Batch->find('first',array('conditions'=>array('Batch.id'=>$batch)));
               
            }
            return  $claimscount;
       }
        
       public function getbatchcount($date=null){
             $date               =   "'".trim(date("Y-m-d"))."'";
             
             $batchdetails      =       $this->ClaimsprocessorBatch->find('all',array(
                                            'conditions'=>array('created'=> $this->getDateForSearch('ClaimsprocessorBatch'),'user_id' => $this->Session->read('Auth.User.id'))
                                        ));
             app::import('model','Batch');
             $batchobj          =       new Batch();
             $count             =       0;
             foreach ($batchdetails as $batchdetail)
             {
                 $count         +=      $batchobj->find('count',array('conditions'  =>  array('id' => $batchdetail['ClaimsprocessorBatch']['batch_id'],'status' => 3)));
             }
             return $count;
             
        }
        
/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ClaimsprocessorBatch->create();
			if ($this->ClaimsprocessorBatch->save($this->request->data)) {
				$this->Session->setFlash(__('The claimsprocessor batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The claimsprocessor batch could not be saved. Please, try again.'));
			}
		}
		$batches = $this->ClaimsprocessorBatch->Batch->find('list');
		$groups = $this->ClaimsprocessorBatch->Group->find('list');
		$this->set(compact('batches', 'groups'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ClaimsprocessorBatch->id = $id;
		if (!$this->ClaimsprocessorBatch->exists()) {
			throw new NotFoundException(__('Invalid claimsprocessor batch'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ClaimsprocessorBatch->save($this->request->data)) {
				$this->Session->setFlash(__('The claimsprocessor batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The claimsprocessor batch could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->ClaimsprocessorBatch->read(null, $id);
		}
		$batches = $this->ClaimsprocessorBatch->Batch->find('list');
		$groups = $this->ClaimsprocessorBatch->Group->find('list');
		$this->set(compact('batches', 'groups'));
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
		$this->ClaimsprocessorBatch->id = $id;
		if (!$this->ClaimsprocessorBatch->exists()) {
			throw new NotFoundException(__('Invalid claimsprocessor batch'));
		}
		if ($this->ClaimsprocessorBatch->delete()) {
			$this->Session->setFlash(__('Claimsprocessor batch deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Claimsprocessor batch was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
