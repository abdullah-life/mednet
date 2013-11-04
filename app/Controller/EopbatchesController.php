<?php
App::uses('AppController', 'Controller');
/**
 * Eopbatches Controller
 *
 * @property Eopbatch $Eopbatch
 */
class EopbatchesController extends AppController {

/**
 * index method
 *
 * @return void
 */
    public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('*');
            $this->checkpermission();
        }
	public function index($eopfileid=null) {
		$this->Eopbatch->recursive = 0;
                if(isset($eopfileid)){
                    $this->paginate     =   array('conditions'=>array('eopfileid'=>$eopfileid));
                }else{
                    $this->paginate     =   array('conditions'=>array('created'=>$this->getDateForSearch('Eopbatch')));
                }
		$this->set('eopbatches', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Eopbatch->id = $id;
		if (!$this->Eopbatch->exists()) {
			throw new NotFoundException(__('Invalid eopbatch'));
		}
		$this->set('eopbatch', $this->Eopbatch->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Eopbatch->create();
			if ($this->Eopbatch->save($this->request->data)) {
				$this->Session->setFlash(__('The eopbatch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The eopbatch could not be saved. Please, try again.'));
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
		$this->Eopbatch->id = $id;
		if (!$this->Eopbatch->exists()) {
			throw new NotFoundException(__('Invalid eopbatch'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Eopbatch->save($this->request->data)) {
				$this->Session->setFlash(__('The eopbatch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The eopbatch could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Eopbatch->read(null, $id);
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
		$this->Eopbatch->id = $id;
		if (!$this->Eopbatch->exists()) {
			throw new NotFoundException(__('Invalid eopbatch'));
		}
		if ($this->Eopbatch->delete()) {
			$this->Session->setFlash(__('Eopbatch deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Eopbatch was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
