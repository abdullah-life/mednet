<?php
App::uses('AppController', 'Controller');
/**
 * Diagnosis Controller
 *
 * @property Diagnosi $Diagnosi
 */
class DiagnosisController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index($claimid=null) {
            
		$this->Diagnosi->recursive = 0;
                if($claimid){
                    $this->paginate = array(
                        'conditions' => array('Diagnosi.claim_id' => $claimid)
                    );
                    
                }
		$this->set('diagnosis', $this->paginate());
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
		$this->Diagnosi->id = $id;
		if (!$this->Diagnosi->exists()) {
			throw new NotFoundException(__('Invalid diagnosi'));
		}
		$this->set('diagnosi', $this->Diagnosi->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Diagnosi->create();
			if ($this->Diagnosi->save($this->request->data)) {
				$this->Session->setFlash(__('The diagnosi has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The diagnosi could not be saved. Please, try again.'));
			}
		}
		$xmllistings = $this->Diagnosi->Xmllisting->find('list');
		$claims = $this->Diagnosi->Claim->find('list');
		$this->set(compact('xmllistings', 'claims'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Diagnosi->id = $id;
		if (!$this->Diagnosi->exists()) {
			throw new NotFoundException(__('Invalid diagnosi'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Diagnosi->save($this->request->data)) {
				$this->Session->setFlash(__('The diagnosi has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The diagnosi could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Diagnosi->read(null, $id);
		}
		$xmllistings = $this->Diagnosi->Xmllisting->find('list');
		$claims = $this->Diagnosi->Claim->find('list');
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
		$this->Diagnosi->id = $id;
		if (!$this->Diagnosi->exists()) {
			throw new NotFoundException(__('Invalid diagnosi'));
		}
		if ($this->Diagnosi->delete()) {
			$this->Session->setFlash(__('Diagnosi deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Diagnosi was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Diagnosi->recursive = 0;
		$this->set('diagnosis', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Diagnosi->id = $id;
		if (!$this->Diagnosi->exists()) {
			throw new NotFoundException(__('Invalid diagnosi'));
		}
		$this->set('diagnosi', $this->Diagnosi->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Diagnosi->create();
			if ($this->Diagnosi->save($this->request->data)) {
				$this->Session->setFlash(__('The diagnosi has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The diagnosi could not be saved. Please, try again.'));
			}
		}
		$xmllistings = $this->Diagnosi->Xmllisting->find('list');
		$claims = $this->Diagnosi->Claim->find('list');
		$this->set(compact('xmllistings', 'claims'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Diagnosi->id = $id;
		if (!$this->Diagnosi->exists()) {
			throw new NotFoundException(__('Invalid diagnosi'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Diagnosi->save($this->request->data)) {
				$this->Session->setFlash(__('The diagnosi has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The diagnosi could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Diagnosi->read(null, $id);
		}
		$xmllistings = $this->Diagnosi->Xmllisting->find('list');
		$claims = $this->Diagnosi->Claim->find('list');
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
		$this->Diagnosi->id = $id;
		if (!$this->Diagnosi->exists()) {
			throw new NotFoundException(__('Invalid diagnosi'));
		}
		if ($this->Diagnosi->delete()) {
			$this->Session->setFlash(__('Diagnosi deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Diagnosi was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
