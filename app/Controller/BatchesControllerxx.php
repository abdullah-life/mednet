<?php
App::uses('AppController', 'Controller');
/**
 * Batches Controller
 *
 * @property Batch $Batch
 */
class BatchesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Batch->recursive = 0;
		$this->set('batches', $this->paginate());
	}
        
        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('*');
        }

          public function getcount($date=null)
        {
              $date               =   "'".trim(date("Y-m-d"))."'";  
            $claims    = $this->Batch->find('count',array('conditions'=>array(
                                                             "(DATE(Batch.created) = $date))"
                                                   )));
           
                return $claims;
           
        }
        
        
        
/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Batch->id = $id;
		if (!$this->Batch->exists()) {
			throw new NotFoundException(__('Invalid batch'));
		}
		$this->set('batch', $this->Batch->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Batch->create();
			if ($this->Batch->save($this->request->data)) {
				$this->Session->setFlash(__('The batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The batch could not be saved. Please, try again.'));
			}
		}
		$providers = $this->Batch->Provider->find('list');
		$claims = $this->Batch->Claim->find('list');
		$this->set(compact('providers', 'claims'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Batch->id = $id;
		if (!$this->Batch->exists()) {
			throw new NotFoundException(__('Invalid batch'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Batch->save($this->request->data)) {
				$this->Session->setFlash(__('The batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The batch could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Batch->read(null, $id);
		}
		$providers = $this->Batch->Provider->find('list');
		$claims = $this->Batch->Claim->find('list');
		$this->set(compact('providers', 'claims'));
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
		$this->Batch->id = $id;
		if (!$this->Batch->exists()) {
			throw new NotFoundException(__('Invalid batch'));
		}
		if ($this->Batch->delete()) {
			$this->Session->setFlash(__('Batch deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Batch was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Batch->recursive = 0;
		$this->set('batches', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Batch->id = $id;
		if (!$this->Batch->exists()) {
			throw new NotFoundException(__('Invalid batch'));
		}
		$this->set('batch', $this->Batch->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Batch->create();
			if ($this->Batch->save($this->request->data)) {
				$this->Session->setFlash(__('The batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The batch could not be saved. Please, try again.'));
			}
		}
		$providers = $this->Batch->Provider->find('list');
		$claims = $this->Batch->Claim->find('list');
		$this->set(compact('providers', 'claims'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Batch->id = $id;
		if (!$this->Batch->exists()) {
			throw new NotFoundException(__('Invalid batch'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Batch->save($this->request->data)) {
				$this->Session->setFlash(__('The batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The batch could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Batch->read(null, $id);
		}
		$providers = $this->Batch->Provider->find('list');
		$claims = $this->Batch->Claim->find('list');
		$this->set(compact('providers', 'claims'));
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
		$this->Batch->id = $id;
		if (!$this->Batch->exists()) {
			throw new NotFoundException(__('Invalid batch'));
		}
		if ($this->Batch->delete()) {
			$this->Session->setFlash(__('Batch deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Batch was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
