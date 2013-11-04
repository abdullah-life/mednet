<?php
App::uses('AppController', 'Controller');
/**
 * Providerpricingfiles Controller
 *
 * @property Providerpricingfile $Providerpricingfile
 */
class ProviderpricingfilesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Providerpricingfile->recursive = 0;
		$this->set('providerpricingfiles', $this->paginate());
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
		$this->Providerpricingfile->id = $id;
		if (!$this->Providerpricingfile->exists()) {
			throw new NotFoundException(__('Invalid providerpricingfile'));
		}
		$this->set('providerpricingfile', $this->Providerpricingfile->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Providerpricingfile->create();
			if ($this->Providerpricingfile->save($this->request->data)) {
				$this->Session->setFlash(__('The providerpricingfile has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The providerpricingfile could not be saved. Please, try again.'));
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
		$this->Providerpricingfile->id = $id;
		if (!$this->Providerpricingfile->exists()) {
			throw new NotFoundException(__('Invalid providerpricingfile'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Providerpricingfile->save($this->request->data)) {
				$this->Session->setFlash(__('The providerpricingfile has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The providerpricingfile could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Providerpricingfile->read(null, $id);
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
		$this->Providerpricingfile->id = $id;
		if (!$this->Providerpricingfile->exists()) {
			throw new NotFoundException(__('Invalid providerpricingfile'));
		}
                
		if ($this->Providerpricingfile->delete()) {
                        if($this->Providerpricingfile->Providerpricing->deleteAll(array('providerpricingfile_id'   =>  $id)))
                        {
                            $this->Session->setFlash(__('Providerpricingfile deleted'));
                            $this->redirect(array('action' => 'index'));
                        }
                        else
                        {
                            $this->Session->setFlash(__('Some files was not able to delete'));
                            $this->redirect(array('action' => 'index'));
                        }
		}
		$this->Session->setFlash(__('Providerpricingfile was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
