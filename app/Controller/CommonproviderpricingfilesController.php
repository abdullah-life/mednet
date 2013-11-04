<?php
App::uses('AppController', 'Controller');
/**
 * Commonproviderpricingfiles Controller
 *
 * @property Commonproviderpricingfile $Commonproviderpricingfile
 */
class CommonproviderpricingfilesController extends AppController {

    
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
		$this->Commonproviderpricingfile->recursive = 0;
		$this->set('commonproviderpricingfiles', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Commonproviderpricingfile->id = $id;
		if (!$this->Commonproviderpricingfile->exists()) {
			throw new NotFoundException(__('Invalid commonproviderpricingfile'));
		}
		$this->set('commonproviderpricingfile', $this->Commonproviderpricingfile->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Commonproviderpricingfile->create();
			if ($this->Commonproviderpricingfile->save($this->request->data)) {
                                $logobj                         =   new Log();
                                $data                           =   array();
                                $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                                $data['Log']['Object']          =   "";
                                $data['Log']['Objectcategory']  =   "providerpricings";
                                $data['Log']['Header']          =   "Uploaded the Common provider pricings file";
                                $data['Log']['Desc']            =   "The Common provider pricings file ".$this->request->data['Commonproviderpricingfile']['pricing']." is uploaded by : ".$this->Session->read('Auth.User.username');
                                $logobj->create();
                                $logobj->save($data);
				$this->Session->setFlash(__('The commonproviderpricingfile has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The commonproviderpricingfile could not be saved. Please, try again.'));
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
		$this->Commonproviderpricingfile->id = $id;
		if (!$this->Commonproviderpricingfile->exists()) {
			throw new NotFoundException(__('Invalid commonproviderpricingfile'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Commonproviderpricingfile->save($this->request->data)) {
				$this->Session->setFlash(__('The commonproviderpricingfile has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The commonproviderpricingfile could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Commonproviderpricingfile->read(null, $id);
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
		$this->Commonproviderpricingfile->id = $id;
		if (!$this->Commonproviderpricingfile->exists()) {
			throw new NotFoundException(__('Invalid commonproviderpricingfile'));
		}
                $datas   =   $this->Commonproviderpricingfile->find('first',array('conditions' => array('id' => $id)));
		if ($this->Commonproviderpricingfile->delete()) {
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $datas['Commonproviderpricingfile']['pricing'];
                        $data['Log']['Objectcategory']  =   "providerpricings";
                        $data['Log']['Header']          =   "Deleted the Common provider pricings file";
                        $data['Log']['Desc']            =   "The Common provider pricings file ".$datas['Commonproviderpricingfile']['pricing']." is uploaded by : ".$this->Session->read('Auth.User.id');
                        $logobj->create();
                        $logobj->save($data);
			$this->Session->setFlash(__('Commonproviderpricingfile deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Commonproviderpricingfile was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
