<?php
App::uses('AppController', 'Controller');
/**
 * MedicalreceiverBatches Controller
 *
 * @property MedicalreceiverBatch $MedicalreceiverBatch
 */
class MedicalreceiverBatchesController extends AppController {


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
             $batchdetails      = $this->MedicalreceiverBatch->find('count',array(
                 'conditions'=>array('created'=> $this->getDateForSearch(),'user_id'    =>  $this->Session->read('Auth.User.id'))
             ));
             app::import('model','Batch');
             $batchobj          =       new Batch();
             $count             =       0;
             foreach ($batchdetails as $batchdetail)
             {
                 $count         +=      $batchobj->find('count',array('conditions'  =>  array('id' => $batchdetail['ClaimsprocessorBatch']['batch_id'],'status' => 8)));
             }
             return $count;
        }
        public function getbatchclaimscount(){
             $claimsbatch       =    $this->MedicalreceiverBatch->find('all',array(
                 'conditions'=>array('created'=>$this->getDateForSearch('MedicalreceiverBatch'),'user_id'    =>  $this->Session->read('Auth.User.id'))
             ));
            $claimscount   =   0;
            foreach($claimsbatch as $batch){
               $batches     =   $this->MedicalreceiverBatch->Batch->BatchesClaim->find('count',array('conditions'=>array('batch_id'=>$batch['MedicalreceiverBatch']['batch_id'])));
               $claimscount =   $claimscount    +$batches;
            }
            return  $claimscount;
        }
    
	public function index() {
		$this->MedicalreceiverBatch->recursive = 0;
		$this->set('medicalreceiverBatches', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->MedicalreceiverBatch->id = $id;
		if (!$this->MedicalreceiverBatch->exists()) {
			throw new NotFoundException(__('Invalid medicalreceiver batch'));
		}
		$this->set('medicalreceiverBatch', $this->MedicalreceiverBatch->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MedicalreceiverBatch->create();
			if ($this->MedicalreceiverBatch->save($this->request->data)) {
				$this->Session->setFlash(__('The medicalreceiver batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The medicalreceiver batch could not be saved. Please, try again.'));
			}
		}
		$batches = $this->MedicalreceiverBatch->Batch->find('list');
		$groups = $this->MedicalreceiverBatch->Group->find('list');
		$users = $this->MedicalreceiverBatch->User->find('list');
		$this->set(compact('batches', 'groups', 'users'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->MedicalreceiverBatch->id = $id;
		if (!$this->MedicalreceiverBatch->exists()) {
			throw new NotFoundException(__('Invalid medicalreceiver batch'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->MedicalreceiverBatch->save($this->request->data)) {
				$this->Session->setFlash(__('The medicalreceiver batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The medicalreceiver batch could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->MedicalreceiverBatch->read(null, $id);
		}
		$batches = $this->MedicalreceiverBatch->Batch->find('list');
		$groups = $this->MedicalreceiverBatch->Group->find('list');
		$users = $this->MedicalreceiverBatch->User->find('list');
		$this->set(compact('batches', 'groups', 'users'));
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
		$this->MedicalreceiverBatch->id = $id;
		if (!$this->MedicalreceiverBatch->exists()) {
			throw new NotFoundException(__('Invalid medicalreceiver batch'));
		}
		if ($this->MedicalreceiverBatch->delete()) {
			$this->Session->setFlash(__('Medicalreceiver batch deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Medicalreceiver batch was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
