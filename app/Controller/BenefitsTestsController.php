<?php
App::uses('AppController', 'Controller');
/**
 * BenefitsTests Controller
 *
 * @property BenefitsTest $BenefitsTest
 */
class BenefitsTestsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->BenefitsTest->recursive = 0;
		$this->set('benefitsTests', $this->paginate());
	}
        
        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('*');
        }
        
         public function hello(){
            $data   =   array();
            $benefits       =   $this->BenefitsTest->find('all');
            foreach($benefits as $key=>$val){
                $data['Benefit'][]  =$val['BenefitsTest']; 
            }
           app::import('model','Benefit');
           $benefit=  new Benefit();
           
           $benefit->saveAll($data);
           exit;
                  
        
        
         }
        

        
        
/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->BenefitsTest->id = $id;
		if (!$this->BenefitsTest->exists()) {
			throw new NotFoundException(__('Invalid benefits test'));
		}
		$this->set('benefitsTest', $this->BenefitsTest->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->BenefitsTest->create();
			if ($this->BenefitsTest->save($this->request->data)) {
				$this->Session->setFlash(__('The benefits test has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The benefits test could not be saved. Please, try again.'));
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
		$this->BenefitsTest->id = $id;
		if (!$this->BenefitsTest->exists()) {
			throw new NotFoundException(__('Invalid benefits test'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->BenefitsTest->save($this->request->data)) {
				$this->Session->setFlash(__('The benefits test has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The benefits test could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->BenefitsTest->read(null, $id);
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
		$this->BenefitsTest->id = $id;
		if (!$this->BenefitsTest->exists()) {
			throw new NotFoundException(__('Invalid benefits test'));
		}
		if ($this->BenefitsTest->delete()) {
			$this->Session->setFlash(__('Benefits test deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Benefits test was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
