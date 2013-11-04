<?php
App::uses('AppController', 'Controller');
/**
 * Globalsettings Controller
 *
 * @property Globalsetting $Globalsetting
 */
class GlobalsettingsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Globalsetting->recursive = 0;
		$this->set('globalsettings', $this->paginate());
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
		$this->Globalsetting->id = $id;
		if (!$this->Globalsetting->exists()) {
			throw new NotFoundException(__('Invalid globalsetting'));
		}
		$this->set('globalsetting', $this->Globalsetting->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Globalsetting->create();
			if ($this->Globalsetting->save($this->request->data)) {
				$this->Session->setFlash(__('The globalsetting has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The globalsetting could not be saved. Please, try again.'));
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
		$this->Globalsetting->id = $id;
		if (!$this->Globalsetting->exists()) {
			throw new NotFoundException(__('Invalid globalsetting'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Globalsetting->save($this->request->data)) {
				$this->Session->setFlash(__('The globalsetting has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The globalsetting could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Globalsetting->read(null, $id);
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
		$this->Globalsetting->id = $id;
		if (!$this->Globalsetting->exists()) {
			throw new NotFoundException(__('Invalid globalsetting'));
		}
		if ($this->Globalsetting->delete()) {
			$this->Session->setFlash(__('Globalsetting deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Globalsetting was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
