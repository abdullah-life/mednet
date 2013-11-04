<?php
App::uses('AppController', 'Controller');
/**
 * Mcodes Controller
 *
 * @property Mcode $Mcode
 */
class McodesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Mcode->recursive = 0;
		$this->set('mcodes', $this->paginate());
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
		$this->Mcode->id = $id;
		if (!$this->Mcode->exists()) {
			throw new NotFoundException(__('Invalid mcode'));
		}
		$this->set('mcode', $this->Mcode->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Mcode->create();
                        
                        pr($this->request->data);
                        exit;
			if ($this->Mcode->save($this->request->data)) {
				$this->Session->setFlash(__('The mcode has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The mcode could not be saved. Please, try again.'));
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
		$this->Mcode->id = $id;
		if (!$this->Mcode->exists()) {
			throw new NotFoundException(__('Invalid mcode'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Mcode->save($this->request->data)) {
				$this->Session->setFlash(__('The mcode has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The mcode could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Mcode->read(null, $id);
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
		$this->Mcode->id = $id;
		if (!$this->Mcode->exists()) {
			throw new NotFoundException(__('Invalid mcode'));
		}
		if ($this->Mcode->delete()) {
			$this->Session->setFlash(__('Mcode deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Mcode was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Mcode->recursive = 0;
		$this->set('mcodes', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Mcode->id = $id;
		if (!$this->Mcode->exists()) {
			throw new NotFoundException(__('Invalid mcode'));
		}
		$this->set('mcode', $this->Mcode->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Mcode->create();
			if ($this->Mcode->save($this->request->data)) {
				$this->Session->setFlash(__('The mcode has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The mcode could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Mcode->id = $id;
		if (!$this->Mcode->exists()) {
			throw new NotFoundException(__('Invalid mcode'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Mcode->save($this->request->data)) {
				$this->Session->setFlash(__('The mcode has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The mcode could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Mcode->read(null, $id);
		}
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
		$this->Mcode->id = $id;
		if (!$this->Mcode->exists()) {
			throw new NotFoundException(__('Invalid mcode'));
		}
		if ($this->Mcode->delete()) {
			$this->Session->setFlash(__('Mcode deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Mcode was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        public function addmcodes(){
            app::import('Vendor','simplexlsx');
            $simple     =    new SimpleXLSX(WWW_ROOT . 'files/mcodes/Maternitycodes.xlsx');
            list($cols) = $simple->dimension();
            $i=2;
            foreach( $simple->rows() as $k => $r){
                if($k==0)
                    continue;
                $data['Mcode']['codenumber']        =   $r[0];
                $data['Mcode']['description_1']     =   $r[1];
                $data['Mcode']['description_2']     =   $r[2];
                $data['Mcode']['benefit']           =   $r[3];
                $this->Mcode->create();
                if($this->Mcode->save($data)){
                    echo "Data saved\n";
                }
                
            }
        }
}
