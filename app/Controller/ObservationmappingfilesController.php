<?php
App::uses('AppController', 'Controller');
/**
 * Observationmappingfiles Controller
 *
 * @property Observationmappingfile $Observationmappingfile
 */
class ObservationmappingfilesController extends AppController {

    
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
		$this->Observationmappingfile->recursive = 0;
		$this->set('observationmappingfiles', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Observationmappingfile->id = $id;
		if (!$this->Observationmappingfile->exists()) {
			throw new NotFoundException(__('Invalid observationmappingfile'));
		}
		$this->set('observationmappingfile', $this->Observationmappingfile->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($values) {
            
                if($values['Mapping']['error']>0)
                {
                    return false;
                }
                else
                {
                     if (!file_exists(WWW_ROOT . 'files/Observationmappings/')) {
                        mkdir(WWW_ROOT.'files/Observationmappings'); 
                    }
                    $filename   =  $values['Mapping']['name']; 
                    while(file_exists(WWW_ROOT.'files/Observationmappings/'.$filename))
                    {
                        $filename   = rand(10, 1000).$values['Mapping']['name'];
                    }
                    move_uploaded_file($values['Mapping']['tmp_name'], WWW_ROOT.'files/Observationmappings/'.$filename);
                }
                $data = array();
                $data['Observationmappingfile']['file'] =  $filename;
                $data['Observationmappingfile']['mednet_code'] = $values['provider'];
                $data['Observationmappingfile']['status'] = 0;
                $data['Observationmappingfile']['start_date'] = $values['start_date'];
                $this->Observationmappingfile->create();
                if($this->Observationmappingfile->save($data))
                {
                    app::import('model','Providerdetail');
                    $providerdetailobj              =   new Providerdetail();
                    $providervalues                 =   $providerdetailobj->find('first',array('conditions' => array('licence' => $values['provider'])));
                    app::import('model','Log');
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   $providervalues['Providerdetail']['id'];
                    $data['Log']['Objectcategory']  =   "observationmappings";
                    $data['Log']['Header']          =   "Observationmappings file added";
                    $data['Log']['Desc']            =   "The Observationmappings file  ".$values['Mapping']['name']."is uploaded by : ".$this->Session->read('Auth.User.username');
                    $logobj->create();
                    $logobj->save($data);
                    return true;
                }
                else
                {
                    return false;
                }
                $this->autoRender = FALSE;
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Observationmappingfile->id = $id;
		if (!$this->Observationmappingfile->exists()) {
			throw new NotFoundException(__('Invalid observationmappingfile'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Observationmappingfile->save($this->request->data)) {
				$this->Session->setFlash(__('The observationmappingfile has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The observationmappingfile could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Observationmappingfile->read(null, $id);
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
		$this->Observationmappingfile->id = $id;
		if (!$this->Observationmappingfile->exists()) {
			throw new NotFoundException(__('Invalid observationmappingfile'));
		}
		if ($this->Observationmappingfile->delete()) {
			$this->Session->setFlash(__('Observationmappingfile deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Observationmappingfile was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
