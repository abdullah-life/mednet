<?php
App::uses('AppController', 'Controller');
/**
 * Icd10toicd9cmmappings Controller
 *
 * @property Icd10toicd9cmmapping $Icd10toicd9cmmapping
 */
class Icd10toicd9cmmappingsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Icd10toicd9cmmapping->recursive = 0;
		$this->set('icd10toicd9cmmappings', $this->paginate());
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
		$this->Icd10toicd9cmmapping->id = $id;
		if (!$this->Icd10toicd9cmmapping->exists()) {
			throw new NotFoundException(__('Invalid icd10toicd9cmmapping'));
		}
		$this->set('icd10toicd9cmmapping', $this->Icd10toicd9cmmapping->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Icd10toicd9cmmapping->create();
			if ($this->Icd10toicd9cmmapping->save($this->request->data)) {
				$this->Session->setFlash(__('The icd10toicd9cmmapping has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The icd10toicd9cmmapping could not be saved. Please, try again.'));
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
		$this->Icd10toicd9cmmapping->id = $id;
		if (!$this->Icd10toicd9cmmapping->exists()) {
			throw new NotFoundException(__('Invalid icd10toicd9cmmapping'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Icd10toicd9cmmapping->save($this->request->data)) {
				$this->Session->setFlash(__('The icd10toicd9cmmapping has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The icd10toicd9cmmapping could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Icd10toicd9cmmapping->read(null, $id);
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
		$this->Icd10toicd9cmmapping->id = $id;
		if (!$this->Icd10toicd9cmmapping->exists()) {
			throw new NotFoundException(__('Invalid icd10toicd9cmmapping'));
		}
		if ($this->Icd10toicd9cmmapping->delete()) {
			$this->Session->setFlash(__('Icd10toicd9cmmapping deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Icd10toicd9cmmapping was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        
        public function addNewFile()
        {
            if($this->request->isPost())
            {   
                        pr($this->request->data['Icd10toicd9cmmapping']);
                        //move_uploaded_file($this->request->data['Icd10toicd9cmmapping']['file']['tmp_name'],"/var/www/NewProject/Upload/" . $this->request->data['Icd10toicd9cmmapping']['file']['name']);
                       // $file=  fopen('"'.$this->request->data['Icd10toicd9cmmapping']['file']['tmp_name'].'/'.$this->request->data['Icd10toicd9cmmapping']['file']['name'].'"', 'r') or exit("Unable to open file!"); 
                        $filecontent = file_get_contents($this->request->data['Icd10toicd9cmmapping']['file']['tmp_name']);
                        $words = preg_split('/[\s]+/', $filecontent, -1, PREG_SPLIT_NO_EMPTY);
                       
                        for($i=0;$i<=count($words); $i+=3)
                        {
                            $insertdata['Icd10toicd9cmmapping']['icd_10']=$words[$i];
                            $insertdata['Icd10toicd9cmmapping']['icd9_cm']=$words[$i+1];
                            $insertdata['Icd10toicd9cmmapping']['status_code']=$words[$i+2];
                            $insertdata['Icd10toicd9cmmapping']['status']='1';
                            $this->Icd10toicd9cmmapping->create();
                            $this->Icd10toicd9cmmapping->save($insertdata);                           
                        }
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   "";
                        $data['Log']['Objectcategory']  =   "ICD10-ICD9";
                        $data['Log']['Header']          =   "ICD10 to ICD9 mappings";
                        $data['Log']['Desc']            =   "New ICD codes are added by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                }      
        }
        
}
