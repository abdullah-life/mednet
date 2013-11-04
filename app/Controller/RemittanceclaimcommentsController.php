<?php
App::uses('AppController', 'Controller');
/**
 * Remittanceclaimcomments Controller
 *
 * @property Remittanceclaimcomment $Remittanceclaimcomment
 */
class RemittanceclaimcommentsController extends AppController {


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
		$this->Remittanceclaimcomment->recursive = 0;
		$this->set('remittanceclaimcomments', $this->paginate());
                $this->checkpermission();
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Remittanceclaimcomment->id = $id;
		if (!$this->Remittanceclaimcomment->exists()) {
			throw new NotFoundException(__('Invalid remittanceclaimcomment'));
		}
		$this->set('remittanceclaimcomment', $this->Remittanceclaimcomment->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Remittanceclaimcomment->create();
			if ($this->Remittanceclaimcomment->save($this->request->data)) {
				$this->Session->setFlash(__('The remittanceclaimcomment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The remittanceclaimcomment could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Remittanceclaimcomment->id = $id;
		if (!$this->Remittanceclaimcomment->exists()) {
			throw new NotFoundException(__('Invalid remittanceclaimcomment'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Remittanceclaimcomment->save($this->request->data)) {
				$this->Session->setFlash(__('The remittanceclaimcomment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The remittanceclaimcomment could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Remittanceclaimcomment->read(null, $id);
		}
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
		$this->Remittanceclaimcomment->id = $id;
		if (!$this->Remittanceclaimcomment->exists()) {
			throw new NotFoundException(__('Invalid remittanceclaimcomment'));
		}
		if ($this->Remittanceclaimcomment->delete()) {
			$this->Session->setFlash(__('Remittanceclaimcomment deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Remittanceclaimcomment was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
