<?php
App::uses('AppController', 'Controller');
/**
 * Observations Controller
 *
 * @property Observation $Observation
 */
class ObservationsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index($claimid=null) {
		$this->Observation->recursive = 0;
                 if($claimid){
                    $this->paginate = array(
                        'conditions' => array('Observation.claim_id' => $claimid)
                    );
                    
                }
		$this->set('observations', $this->paginate());
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
		$this->Observation->id = $id;
		if (!$this->Observation->exists()) {
			throw new NotFoundException(__('Invalid observation'));
		}
		$this->set('observation', $this->Observation->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Observation->create();
			if ($this->Observation->save($this->request->data)) {
				$this->Session->setFlash(__('The observation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The observation could not be saved. Please, try again.'));
			}
		}
		$xmllistings = $this->Observation->Xmllisting->find('list');
		$claims = $this->Observation->Claim->find('list');
		$this->set(compact('xmllistings', 'claims'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Observation->id = $id;
		if (!$this->Observation->exists()) {
			throw new NotFoundException(__('Invalid observation'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Observation->save($this->request->data)) {
				$this->Session->setFlash(__('The observation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The observation could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Observation->read(null, $id);
		}
		$xmllistings = $this->Observation->Xmllisting->find('list');
		$claims = $this->Observation->Claim->find('list');
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
		$this->Observation->id = $id;
		if (!$this->Observation->exists()) {
			throw new NotFoundException(__('Invalid observation'));
		}
		if ($this->Observation->delete()) {
			$this->Session->setFlash(__('Observation deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Observation was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Observation->recursive = 0;
		$this->set('observations', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Observation->id = $id;
		if (!$this->Observation->exists()) {
			throw new NotFoundException(__('Invalid observation'));
		}
		$this->set('observation', $this->Observation->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Observation->create();
			if ($this->Observation->save($this->request->data)) {
				$this->Session->setFlash(__('The observation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The observation could not be saved. Please, try again.'));
			}
		}
		$xmllistings = $this->Observation->Xmllisting->find('list');
		$claims = $this->Observation->Claim->find('list');
		$this->set(compact('xmllistings', 'claims'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Observation->id = $id;
		if (!$this->Observation->exists()) {
			throw new NotFoundException(__('Invalid observation'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Observation->save($this->request->data)) {
				$this->Session->setFlash(__('The observation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The observation could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Observation->read(null, $id);
		}
		$xmllistings = $this->Observation->Xmllisting->find('list');
		$claims = $this->Observation->Claim->find('list');
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
		$this->Observation->id = $id;
		if (!$this->Observation->exists()) {
			throw new NotFoundException(__('Invalid observation'));
		}
		if ($this->Observation->delete()) {
			$this->Session->setFlash(__('Observation deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Observation was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
