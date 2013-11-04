<?php
App::uses('AppController', 'Controller');
/**
 * Contracts Controller
 *
 * @property Contract $Contract
 */
class ContractsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Contract->recursive = 0;
		$this->set('contracts', $this->paginate());
	}
        
        
        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('*');
        }

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Contract->id = $id;
		if (!$this->Contract->exists()) {
			throw new NotFoundException(__('Invalid contract'));
		}
		$this->set('contract', $this->Contract->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Contract->create();
			if ($this->Contract->save($this->request->data)) {
				$this->Session->setFlash(__('The contract has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contract could not be saved. Please, try again.'));
			}
		}
		$xmllistings = $this->Contract->Xmllisting->find('list');
		$claims = $this->Contract->Claim->find('list');
		$this->set(compact('xmllistings', 'claims'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Contract->id = $id;
		if (!$this->Contract->exists()) {
			throw new NotFoundException(__('Invalid contract'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Contract->save($this->request->data)) {
				$this->Session->setFlash(__('The contract has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contract could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Contract->read(null, $id);
		}
		$xmllistings = $this->Contract->Xmllisting->find('list');
		$claims = $this->Contract->Claim->find('list');
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
		$this->Contract->id = $id;
		if (!$this->Contract->exists()) {
			throw new NotFoundException(__('Invalid contract'));
		}
		if ($this->Contract->delete()) {
			$this->Session->setFlash(__('Contract deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Contract was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Contract->recursive = 0;
		$this->set('contracts', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Contract->id = $id;
		if (!$this->Contract->exists()) {
			throw new NotFoundException(__('Invalid contract'));
		}
		$this->set('contract', $this->Contract->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Contract->create();
			if ($this->Contract->save($this->request->data)) {
				$this->Session->setFlash(__('The contract has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contract could not be saved. Please, try again.'));
			}
		}
		$xmllistings = $this->Contract->Xmllisting->find('list');
		$claims = $this->Contract->Claim->find('list');
		$this->set(compact('xmllistings', 'claims'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Contract->id = $id;
		if (!$this->Contract->exists()) {
			throw new NotFoundException(__('Invalid contract'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Contract->save($this->request->data)) {
				$this->Session->setFlash(__('The contract has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contract could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Contract->read(null, $id);
		}
		$xmllistings = $this->Contract->Xmllisting->find('list');
		$claims = $this->Contract->Claim->find('list');
		$this->set(compact('xmllistings', 'claims'));
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
		$this->Contract->id = $id;
		if (!$this->Contract->exists()) {
			throw new NotFoundException(__('Invalid contract'));
		}
		if ($this->Contract->delete()) {
			$this->Session->setFlash(__('Contract deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Contract was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
