<?php
App::uses('AppController', 'Controller');
/**
 * Authorizations Controller
 *
 * @property Authorization $Authorization
 */
class AuthorizationsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Authorization->recursive = 0;
		$this->set('authorizations', $this->paginate());
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
		$this->Authorization->id = $id;
		if (!$this->Authorization->exists()) {
			throw new NotFoundException(__('Invalid authorization'));
		}
		$this->set('authorization', $this->Authorization->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Authorization->create();
			if ($this->Authorization->save($this->request->data)) {
				$this->Session->setFlash(__('The authorization has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The authorization could not be saved. Please, try again.'));
			}
		}
		$listings = $this->Authorization->Listing->find('list');
		$claims = $this->Authorization->Claim->find('list');
		$this->set(compact('listings', 'claims'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Authorization->id = $id;
		if (!$this->Authorization->exists()) {
			throw new NotFoundException(__('Invalid authorization'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Authorization->save($this->request->data)) {
				$this->Session->setFlash(__('The authorization has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The authorization could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Authorization->read(null, $id);
		}
		$listings = $this->Authorization->Listing->find('list');
		$claims = $this->Authorization->Claim->find('list');
		$this->set(compact('listings', 'claims'));
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
		$this->Authorization->id = $id;
		if (!$this->Authorization->exists()) {
			throw new NotFoundException(__('Invalid authorization'));
		}
		if ($this->Authorization->delete()) {
			$this->Session->setFlash(__('Authorization deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Authorization was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Authorization->recursive = 0;
		$this->set('authorizations', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Authorization->id = $id;
		if (!$this->Authorization->exists()) {
			throw new NotFoundException(__('Invalid authorization'));
		}
		$this->set('authorization', $this->Authorization->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Authorization->create();
			if ($this->Authorization->save($this->request->data)) {
				$this->Session->setFlash(__('The authorization has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The authorization could not be saved. Please, try again.'));
			}
		}
		$listings = $this->Authorization->Listing->find('list');
		$claims = $this->Authorization->Claim->find('list');
		$this->set(compact('listings', 'claims'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Authorization->id = $id;
		if (!$this->Authorization->exists()) {
			throw new NotFoundException(__('Invalid authorization'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Authorization->save($this->request->data)) {
				$this->Session->setFlash(__('The authorization has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The authorization could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Authorization->read(null, $id);
		}
		$listings = $this->Authorization->Listing->find('list');
		$claims = $this->Authorization->Claim->find('list');
		$this->set(compact('listings', 'claims'));
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
		$this->Authorization->id = $id;
		if (!$this->Authorization->exists()) {
			throw new NotFoundException(__('Invalid authorization'));
		}
		if ($this->Authorization->delete()) {
			$this->Session->setFlash(__('Authorization deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Authorization was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
