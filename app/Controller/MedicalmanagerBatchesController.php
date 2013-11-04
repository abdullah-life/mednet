<?php
App::uses('AppController', 'Controller');
/**
 * MedicalmanagerBatches Controller
 *
 * @property MedicalmanagerBatch $MedicalmanagerBatch
 */
class MedicalmanagerBatchesController extends AppController {


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
    
        public function getbatchcount(){
            $date               =   "'".trim(date("Y-m-d"))."'"; 
             $batchdetails      = $this->MedicalmanagerBatch->find('all',array(
                 'conditions'=>array('created'=> $this->getDateForSearch())
             ));
             app::import('model','Batch');
             $batchobj          =       new Batch();
             $count             =       0;
             foreach ($batchdetails as $batchdetail)
             {
                 $count         +=      $batchobj->find('count',array('conditions'  =>  array('id' => $batchdetail['ClaimsprocessorBatch']['batch_id'],'status' => 4)));
             }
             return $count;
        }
    
        public function getbatchclaimscount(){
            $claimsbatch       =    $this->MedicalmanagerBatch->find('all',array(
                 'conditions'=>array('created'=>$this->getDateForSearch())
             ));
            $claimscount   =   0;
            foreach($claimsbatch as $batch){
               $batches     =   $this->MedicalmanagerBatch->Batch->BatchesClaim->find('count',array('conditions'=>array('batch_id'=>$batch['MedicalmanagerBatch']['batch_id'])));
                $claimscount =   $claimscount    + $batches;
            }
            return  $claimscount;
            
            
        }
        
	public function index() {
		$this->MedicalmanagerBatch->recursive = 0;
		$this->set('medicalmanagerBatches', $this->paginate());
	}
        
        public function assignbatch($batchid=null){
           $this->MedicalmanagerBatch->Batch->id;
           $batchvalues                        =   $this->MedicalmanagerBatch->Batch->find('first',array('conditions' => array('id' => $batchid)));
           if($this->MedicalmanagerBatch->find('count',array('conditions'=>array('batch_id'=>$batchid)))==0){
           if($this->MedicalmanagerBatch->save(array('MedicalmanagerBatch'=>array('batch_id'=>$batchid,'group_id' => 19,'Assigned_by' => $this->Session->read('Auth.User.id'))))){
               
               $this->MedicalmanagerBatch->Batch->id=  $batchid; 
               if($this->MedicalmanagerBatch->Batch->saveField('status', 4)){
                    app::import('model','Log');
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   $batchvalues['Batch']['id'];
                    $data['Log']['Objectcategory']  =   "batch";
                    $data['Log']['Header']          =   "Batch assignment to Medical manager";
                    $data['Log']['Desc']            =   "The Batch ".$batchvalues['Batch']['name']." is assigned to Medical manager by : ".$this->Session->read('Auth.User.username');
                    $logobj->create();
                    $logobj->save($data);
                    $this->Session->setFlash("Assigned to Medical Manager");
               }
               else
                    $this->Session->setFlash("Assigned to Medical Manager-err");
              }
              $this->autoRender =   false;
           }else{
               $batchdetails    =   $this->MedicalmanagerBatch->find('first',array('conditions' =>  array('batch_id'    =>  $id)));
               $this->MedicalmanagerBatch->updateAll(
                    array('Assigned_by' => $this->Session->read('Auth.User.id')),
                    array('MedicalmanagerBatch.id' => $batchdetails['MedicalmanagerBatch']['id'])
                );
                app::import('model','Log');
                $logobj                     =   new Log();
                $data                       =   array();
                $data['Log']['User']        =   $this->Session->read('Auth.User.id');
                $data['Log']['Object']          =   $batchvalues['Batch']['id'];
                $data['Log']['Objectcategory']  =   "batch";
                $data['Log']['Header']      =   "Batch assignment to Medical manager";
                $data['Log']['Desc']        =   "The Batch ".
                $data['Log']['Object']          =   $batchvalues['Batch']['name']." is assigned to Medical manager by : ".$this->Session->read('Auth.User.username');
                $logobj->create();
                $logobj->save($data);
                $this->MedicalmanagerBatch->Batch->id=  $batchid; 
                if($this->MedicalmanagerBatch->Batch->saveField('status', 4))  
                    $this->Session->setFlash("Assigned to Medical Manager");
//               $this->Session->setFlash("Batch is already assigned to Medical Manager");
           }
          $this->redirect(array('controller'=>'batches','action'=>'list_batches_for_claimsprocessor')); 
        }
        
        
        public function assignfromclaimsManager($batchid=null)
        {
             $this->MedicalmanagerBatch->Batch->id;
           $batchvalues     =   $this->MedicalmanagerBatch->Batch->find('first',array('conditions' => array('id' => $batchid)));
           if($this->MedicalmanagerBatch->find('count',array('conditions'=>array('batch_id'=>$batchid)))==0){
           if($this->MedicalmanagerBatch->save(array('MedicalmanagerBatch'=>array('batch_id'=>$batchid,'group_id'=> 19,'Assigned_by' => $this->Session->read('Auth.User.id'))))){
               $this->MedicalmanagerBatch->Batch->id=  $batchid; 
               if($this->MedicalmanagerBatch->Batch->saveField('status', 4))
               {
                    $this->Session->setFlash("Assigned to Medical Manager");
                    app::import('model','Log');
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   $batchvalues['Batch']['id'];
                    $data['Log']['Objectcategory']  =   "batch";
                    $data['Log']['Header']          =   "Batch assignment to Medical manager";
                    $data['Log']['Desc']            =   "The Batch ".$batchvalues['Batch']['name']." is assigned to Medical manager by : ".$this->Session->read('Auth.User.username');
                    $logobj->create();
                    $logobj->save($data);
               }
               else
                    $this->Session->setFlash("Assigned to Medical Manager-err");
              }
              $this->autoRender =   false;
           }else{
                $this->MedicalmanagerBatch->Batch->id=  $batchid; 
                if($this->MedicalmanagerBatch->Batch->saveField('status', 4)){  
                    $this->Session->setFlash("Assigned to Medical Manager");
                    app::import('model','Log');
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   $batchvalues['Batch']['id'];
                    $data['Log']['Objectcategory']  =   "batch";
                    $data['Log']['Header']          =   "Batch assignment to Medical manager";
                    $data['Log']['Desc']            =   "The Batch ".$batchvalues['Batch']['name']." is assigned to Medical manager by : ".$this->Session->read('Auth.User.username');
                    $logobj->create();
                    $logobj->save($data);
                }
//               $this->Session->setFlash("Batch is already assigned to Medical Manager");
           }
          $this->redirect(array('controller'=>'batches','action'=>'list_batches_for_claimsmanager')); 
        }

        
        /**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->MedicalmanagerBatch->id = $id;
		if (!$this->MedicalmanagerBatch->exists()) {
			throw new NotFoundException(__('Invalid medicalmanager batch'));
		}
		$this->set('medicalmanagerBatch', $this->MedicalmanagerBatch->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MedicalmanagerBatch->create();
			if ($this->MedicalmanagerBatch->save($this->request->data)) {
				$this->Session->setFlash(__('The medicalmanager batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The medicalmanager batch could not be saved. Please, try again.'));
			}
		}
		$batches = $this->MedicalmanagerBatch->Batch->find('list');
		$groups = $this->MedicalmanagerBatch->Group->find('list');
		$this->set(compact('batches', 'groups'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->MedicalmanagerBatch->id = $id;
		if (!$this->MedicalmanagerBatch->exists()) {
			throw new NotFoundException(__('Invalid medicalmanager batch'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->MedicalmanagerBatch->save($this->request->data)) {
				$this->Session->setFlash(__('The medicalmanager batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The medicalmanager batch could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->MedicalmanagerBatch->read(null, $id);
		}
		$batches = $this->MedicalmanagerBatch->Batch->find('list');
		$groups = $this->MedicalmanagerBatch->Group->find('list');
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
		$this->MedicalmanagerBatch->id = $id;
		if (!$this->MedicalmanagerBatch->exists()) {
			throw new NotFoundException(__('Invalid medicalmanager batch'));
		}
		if ($this->MedicalmanagerBatch->delete()) {
			$this->Session->setFlash(__('Medicalmanager batch deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Medicalmanager batch was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
