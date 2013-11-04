<?php
App::uses('AppController', 'Controller');
/**
 * Commonobservationmappingfiles Controller
 *
 * @property Commonobservationmappingfile $Commonobservationmappingfile
 */
class CommonobservationmappingfilesController extends AppController {

    
        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('*');
            $this->checkpermission();
        }
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Commonobservationmappingfile->recursive = 0;
		$this->set('commonobservationmappingfiles', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Commonobservationmappingfile->id = $id;
		if (!$this->Commonobservationmappingfile->exists()) {
			throw new NotFoundException(__('Invalid commonobservationmappingfile'));
		}
		$this->set('commonobservationmappingfile', $this->Commonobservationmappingfile->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Commonobservationmappingfile->create();
			if ($this->Commonobservationmappingfile->save($this->request->data)) {
				$this->Session->setFlash(__('The commonobservationmappingfile has been saved'));
                                app::import('model','Log');
                                $logobj                         =   new Log();
                                $data                           =   array();
                                $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                                $data['Log']['Object']          =   "";
                                $data['Log']['Objectcategory']  =   "observationmappings";
                                $data['Log']['Header']          =   "Uploaded the Common observation mapping file";
                                $data['Log']['Desc']            =   "The Common observation mapping file ".$this->request->data['Commonobservationmappingfile']['pricing']."is uploaded by : ".$this->Session->read('Auth.User.username');
                                $logobj->create();
                                $logobj->save($data);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The commonobservationmappingfile could not be saved. Please, try again.'));
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
		$this->Commonobservationmappingfile->id = $id;
		if (!$this->Commonobservationmappingfile->exists()) {
			throw new NotFoundException(__('Invalid commonobservationmappingfile'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Commonobservationmappingfile->save($this->request->data)) {
				$this->Session->setFlash(__('The commonobservationmappingfile has been saved'));
				
			} else {
				$this->Session->setFlash(__('The commonobservationmappingfile could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Commonobservationmappingfile->read(null, $id);
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
		$this->Commonobservationmappingfile->id = $id;
		if (!$this->Commonobservationmappingfile->exists()) {
			throw new NotFoundException(__('Invalid commonobservationmappingfile'));
		}
                $data   = $this->Commonobservationmappingfile->find('first',array('conditions' => array('id' => $id)));
		if ($this->Commonobservationmappingfile->delete()) {
                        
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $data['Commonobservationmappingfile']['pricing'];
                        $data['Log']['Objectcategory']  =   "observationmappings";
                        $data['Log']['Header']          =   "Deleted the Common observation mapping file";
                        $data['Log']['Desc']            =   "The Common observation mapping file ".$data['Commonobservationmappingfile']['pricing']."has been deleted by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
			$this->Session->setFlash(__('Commonobservationmappingfile deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Commonobservationmappingfile was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
