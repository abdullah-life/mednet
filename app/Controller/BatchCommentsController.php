<?php
App::uses('AppController', 'Controller');
/**
 * BatchComments Controller
 *
 * @property BatchComment $BatchComment
 */
class BatchCommentsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->BatchComment->recursive = 0;
		$this->set('batchComments', $this->paginate());
	}
        
        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('*');
            $this->checkpermission();
        }

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->BatchComment->id = $id;
		if (!$this->BatchComment->exists()) {
			throw new NotFoundException(__('Invalid batch comment'));
		}
		$this->set('batchComment', $this->BatchComment->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->BatchComment->create();
			if ($this->BatchComment->save($this->request->data)) {
				$this->Session->setFlash(__('The batch comment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The batch comment could not be saved. Please, try again.'));
			}
		}
		$batches = $this->BatchComment->Batch->find('list');
		$users = $this->BatchComment->User->find('list');
		$groups = $this->BatchComment->Group->find('list');
		$this->set(compact('batches', 'users', 'groups'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->BatchComment->id = $id;
		if (!$this->BatchComment->exists()) {
			throw new NotFoundException(__('Invalid batch comment'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->BatchComment->save($this->request->data)) {
				$this->Session->setFlash(__('The batch comment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The batch comment could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->BatchComment->read(null, $id);
		}
		$batches = $this->BatchComment->Batch->find('list');
		$users = $this->BatchComment->User->find('list');
		$groups = $this->BatchComment->Group->find('list');
		$this->set(compact('batches', 'users', 'groups'));
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
		$this->BatchComment->id = $id;
		if (!$this->BatchComment->exists()) {
			throw new NotFoundException(__('Invalid batch comment'));
		}
		if ($this->BatchComment->delete()) {
			$this->Session->setFlash(__('Batch comment deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Batch comment was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
