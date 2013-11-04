<?php
App::uses('AppController', 'Controller');
/**
 * ClaimsmanagerBatches Controller
 *
 * @property ClaimsmanagerBatch $ClaimsmanagerBatch
 */
class ClaimsmanagerBatchesController extends AppController {


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
		$this->ClaimsmanagerBatch->recursive = 0;
		$this->set('claimsmanagerBatches', $this->paginate());
	}
        
        public function getbatchcount($date=null){
           
            
             $batchdetails      =       $this->ClaimsmanagerBatch->find('all',array(
                                            'conditions'=>array('created'=> $this->getDateForSearch('ClaimsmanagerBatch'))
                                        ));

             app::import('model','Batch'); 
             $batchobj          =       new Batch();
             $count             =       0;
             foreach ($batchdetails as $batchdetail)
             {
                 $count         +=      $batchobj->find('count',array('conditions'  =>  array('id'  =>  $batchdetail['ClaimsmanagerBatch']['batch_id'],'status' =>  2))); 
             }
             return $count;
        }
        public function getbatchclaimscount($date=null){
            $date               =   "'".trim(date("Y-m-d"))."'";  
            $claimsbatch       =    $this->ClaimsmanagerBatch->find('all',array(
                 'conditions'=>array('created'=>$this->getDateForSearch('ClaimsmanagerBatch'))
             ));
            $claimscount   =   0;
       
            foreach($claimsbatch as $batch){
               $batches     =   $this->ClaimsmanagerBatch->Batch->BatchesClaim->find('count',array('conditions'=>array('batch_id'=>$batch['ClaimsmanagerBatch']['batch_id'])));
              
               $claimscount =   $claimscount    + $batches;
            }
            return  $claimscount;
           

        }
        public function getbatchxmlcount($date=null){
            $claimsbatch       =    $this->ClaimsmanagerBatch->find('list',array(
                 'conditions'=>array($this->getDateForSearch('ClaimsmanagerBatch'))
             ));
             $claimscount   =   0;
            foreach($claimsbatch as $batch){
               $batches     =   $this->ClaimsmanagerBatch->Batch->find('first',array('conditions'=>array('Batch.id'=>$batch)));
               
            }
            return  $claimscount;
       }
        
        
/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ClaimsmanagerBatch->id = $id;
		if (!$this->ClaimsmanagerBatch->exists()) {
			throw new NotFoundException(__('Invalid claimsmanager batch'));
		}
		$this->set('claimsmanagerBatch', $this->ClaimsmanagerBatch->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ClaimsmanagerBatch->create();
			if ($this->ClaimsmanagerBatch->save($this->request->data)) {
				$this->Session->setFlash(__('The claimsmanager batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The claimsmanager batch could not be saved. Please, try again.'));
			}
		}
		$batches = $this->ClaimsmanagerBatch->Batch->find('list');
		$users = $this->ClaimsmanagerBatch->User->find('list');
		$this->set(compact('batches', 'users'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ClaimsmanagerBatch->id = $id;
		if (!$this->ClaimsmanagerBatch->exists()) {
			throw new NotFoundException(__('Invalid claimsmanager batch'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ClaimsmanagerBatch->save($this->request->data)) {
				$this->Session->setFlash(__('The claimsmanager batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The claimsmanager batch could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->ClaimsmanagerBatch->read(null, $id);
		}
		$batches = $this->ClaimsmanagerBatch->Batch->find('list');
		$users = $this->ClaimsmanagerBatch->User->find('list');
		$this->set(compact('batches', 'users'));
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
		$this->ClaimsmanagerBatch->id = $id;
		if (!$this->ClaimsmanagerBatch->exists()) {
			throw new NotFoundException(__('Invalid claimsmanager batch'));
		}
		if ($this->ClaimsmanagerBatch->delete()) {
			$this->Session->setFlash(__('Claimsmanager batch deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Claimsmanager batch was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
