<?php
App::uses('AppController', 'Controller');
/**
 * Resubmissions Controller
 *
 * @property Resubmission $Resubmission
 */
class ResubmissionsController extends AppController {


/**
 * index method
 *
 * @return void
 */
    
	public function index() {
		$this->Resubmission->recursive = 0;
		$this->set('resubmissions', $this->paginate());
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
		$this->Resubmission->id = $id;
		if (!$this->Resubmission->exists()) {
			throw new NotFoundException(__('Invalid resubmission'));
		}
		$this->set('resubmission', $this->Resubmission->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Resubmission->create();
			if ($this->Resubmission->save($this->request->data)) {
				$this->Session->setFlash(__('The resubmission has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The resubmission could not be saved. Please, try again.'));
			}
		}
		$claims = $this->Resubmission->Claim->find('list');
		$this->set(compact('claims'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Resubmission->id = $id;
		if (!$this->Resubmission->exists()) {
			throw new NotFoundException(__('Invalid resubmission'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Resubmission->save($this->request->data)) {
				$this->Session->setFlash(__('The resubmission has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The resubmission could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Resubmission->read(null, $id);
		}
		$claims = $this->Resubmission->Claim->find('list');
		$this->set(compact('claims'));
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
		$this->Resubmission->id = $id;
		if (!$this->Resubmission->exists()) {
			throw new NotFoundException(__('Invalid resubmission'));
		}
		if ($this->Resubmission->delete()) {
			$this->Session->setFlash(__('Resubmission deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Resubmission was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Resubmission->recursive = 0;
		$this->set('resubmissions', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Resubmission->id = $id;
		if (!$this->Resubmission->exists()) {
			throw new NotFoundException(__('Invalid resubmission'));
		}
		$this->set('resubmission', $this->Resubmission->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Resubmission->create();
			if ($this->Resubmission->save($this->request->data)) {
				$this->Session->setFlash(__('The resubmission has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The resubmission could not be saved. Please, try again.'));
			}
		}
		$claims = $this->Resubmission->Claim->find('list');
		$this->set(compact('claims'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Resubmission->id = $id;
		if (!$this->Resubmission->exists()) {
			throw new NotFoundException(__('Invalid resubmission'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Resubmission->save($this->request->data)) {
				$this->Session->setFlash(__('The resubmission has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The resubmission could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Resubmission->read(null, $id);
		}
		$claims = $this->Resubmission->Claim->find('list');
		$this->set(compact('claims'));
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
		$this->Resubmission->id = $id;
		if (!$this->Resubmission->exists()) {
			throw new NotFoundException(__('Invalid resubmission'));
		}
		if ($this->Resubmission->delete()) {
			$this->Session->setFlash(__('Resubmission deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Resubmission was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
