<?php
App::uses('AppController', 'Controller');
/**
 * BatchesClaims Controller
 *
 * @property BatchesClaim $BatchesClaim
 */
class BatchesClaimsController extends AppController {

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
	public function index() {
		$this->BatchesClaim->recursive = 0;
                
		$this->set('batchesClaims', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
        public function viewclaims($batchid=null){
            if($batchid){
                if($batchid){
                $this->paginate = array(
                        'conditions' => array('batch_id'=>$batchid)
                    );
               
                 $this->set('batchesClaims', $this->paginate());
             }
              
               
            }else{
                throw new NotFoundException('batch not found');
            }
            
            
        }




        public function view($id = null) {
		$this->BatchesClaim->id = $id;
		if (!$this->BatchesClaim->exists()) {
			throw new NotFoundException(__('Invalid batches claim'));
		}
		$this->set('batchesClaim', $this->BatchesClaim->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->BatchesClaim->create();
			if ($this->BatchesClaim->save($this->request->data)) {
				$this->Session->setFlash(__('The batches claim has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The batches claim could not be saved. Please, try again.'));
			}
		}
		$batches = $this->BatchesClaim->Batch->find('list');
		$xmllistings = $this->BatchesClaim->Xmllisting->find('list');
		$this->set(compact('batches', 'xmllistings'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->BatchesClaim->id = $id;
		if (!$this->BatchesClaim->exists()) {
			throw new NotFoundException(__('Invalid batches claim'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->BatchesClaim->save($this->request->data)) {
				$this->Session->setFlash(__('The batches claim has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The batches claim could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->BatchesClaim->read(null, $id);
		}
		$batches = $this->BatchesClaim->Batch->find('list');
		$xmllistings = $this->BatchesClaim->Xmllisting->find('list');
		$this->set(compact('batches', 'xmllistings'));
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
		$this->BatchesClaim->id = $id;
		if (!$this->BatchesClaim->exists()) {
			throw new NotFoundException(__('Invalid batches claim'));
		}
		if ($this->BatchesClaim->delete()) {
			$this->Session->setFlash(__('Batches claim deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Batches claim was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->BatchesClaim->recursive = 0;
		$this->set('batchesClaims', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->BatchesClaim->id = $id;
		if (!$this->BatchesClaim->exists()) {
			throw new NotFoundException(__('Invalid batches claim'));
		}
		$this->set('batchesClaim', $this->BatchesClaim->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->BatchesClaim->create();
			if ($this->BatchesClaim->save($this->request->data)) {
				$this->Session->setFlash(__('The batches claim has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The batches claim could not be saved. Please, try again.'));
			}
		}
		$batches = $this->BatchesClaim->Batch->find('list');
		$xmllistings = $this->BatchesClaim->Xmllisting->find('list');
		$this->set(compact('batches', 'xmllistings'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->BatchesClaim->id = $id;
		if (!$this->BatchesClaim->exists()) {
			throw new NotFoundException(__('Invalid batches claim'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->BatchesClaim->save($this->request->data)) {
				$this->Session->setFlash(__('The batches claim has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The batches claim could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->BatchesClaim->read(null, $id);
		}
		$batches = $this->BatchesClaim->Batch->find('list');
		$xmllistings = $this->BatchesClaim->Xmllisting->find('list');
		$this->set(compact('batches', 'xmllistings'));
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
		$this->BatchesClaim->id = $id;
		if (!$this->BatchesClaim->exists()) {
			throw new NotFoundException(__('Invalid batches claim'));
		}
		if ($this->BatchesClaim->delete()) {
			$this->Session->setFlash(__('Batches claim deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Batches claim was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
