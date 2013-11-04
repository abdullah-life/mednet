<?php
App::uses('AppController', 'Controller');
/**
 * Simpletypes Controller
 *
 * @property Simpletype $Simpletype
 */
class SimpletypesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Simpletype->recursive = 0;
		$this->set('simpletypes', $this->paginate());
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
		$this->Simpletype->id = $id;
		if (!$this->Simpletype->exists()) {
			throw new NotFoundException(__('Invalid simpletype'));
		}
		$this->set('simpletype', $this->Simpletype->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Simpletype->create();
			if ($this->Simpletype->save($this->request->data)) {
				$this->Session->setFlash(__('The simpletype has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The simpletype could not be saved. Please, try again.'));
			}
		}
		$xmllistings = $this->Simpletype->Xmllisting->find('list');
		$claims = $this->Simpletype->Claim->find('list');
		$this->set(compact('xmllistings', 'claims'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Simpletype->id = $id;
		if (!$this->Simpletype->exists()) {
			throw new NotFoundException(__('Invalid simpletype'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Simpletype->save($this->request->data)) {
				$this->Session->setFlash(__('The simpletype has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The simpletype could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Simpletype->read(null, $id);
		}
		$xmllistings = $this->Simpletype->Xmllisting->find('list');
		$claims = $this->Simpletype->Claim->find('list');
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
		$this->Simpletype->id = $id;
		if (!$this->Simpletype->exists()) {
			throw new NotFoundException(__('Invalid simpletype'));
		}
		if ($this->Simpletype->delete()) {
			$this->Session->setFlash(__('Simpletype deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Simpletype was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Simpletype->recursive = 0;
		$this->set('simpletypes', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Simpletype->id = $id;
		if (!$this->Simpletype->exists()) {
			throw new NotFoundException(__('Invalid simpletype'));
		}
		$this->set('simpletype', $this->Simpletype->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Simpletype->create();
			if ($this->Simpletype->save($this->request->data)) {
				$this->Session->setFlash(__('The simpletype has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The simpletype could not be saved. Please, try again.'));
			}
		}
		$xmllistings = $this->Simpletype->Xmllisting->find('list');
		$claims = $this->Simpletype->Claim->find('list');
		$this->set(compact('xmllistings', 'claims'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Simpletype->id = $id;
		if (!$this->Simpletype->exists()) {
			throw new NotFoundException(__('Invalid simpletype'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Simpletype->save($this->request->data)) {
				$this->Session->setFlash(__('The simpletype has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The simpletype could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Simpletype->read(null, $id);
		}
		$xmllistings = $this->Simpletype->Xmllisting->find('list');
		$claims = $this->Simpletype->Claim->find('list');
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
		$this->Simpletype->id = $id;
		if (!$this->Simpletype->exists()) {
			throw new NotFoundException(__('Invalid simpletype'));
		}
		if ($this->Simpletype->delete()) {
			$this->Session->setFlash(__('Simpletype deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Simpletype was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
