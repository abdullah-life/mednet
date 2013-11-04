<?php
App::uses('AppController', 'Controller');
/**
 * Denialtables Controller
 *
 * @property Denialtable $Denialtable
 */
class DenialtablesController extends AppController {

    
    
    
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
		$this->Denialtable->recursive = 0;
		$this->set('denialtables', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Denialtable->id = $id;
		if (!$this->Denialtable->exists()) {
			throw new NotFoundException(__('Invalid denialtable'));
		}
		$this->set('denialtable', $this->Denialtable->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Denialtable->create();
			if ($this->Denialtable->save($this->request->data)) {
				$this->Session->setFlash(__('The denialtable has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The denialtable could not be saved. Please, try again.'));
			}
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
		$this->Denialtable->id = $id;
		if (!$this->Denialtable->exists()) {
			throw new NotFoundException(__('Invalid denialtable'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Denialtable->save($this->request->data)) {
				$this->Session->setFlash(__('The denialtable has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The denialtable could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Denialtable->read(null, $id);
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
		$this->Denialtable->id = $id;
		if (!$this->Denialtable->exists()) {
			throw new NotFoundException(__('Invalid denialtable'));
		}
		if ($this->Denialtable->delete()) {
			$this->Session->setFlash(__('Denialtable deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Denialtable was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
