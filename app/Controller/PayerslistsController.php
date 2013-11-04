<?php
App::uses('AppController', 'Controller');
/**
 * Payerslists Controller
 *
 * @property Payerslist $Payerslist
 */
class PayerslistsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Payerslist->recursive = 0;
		$this->set('payerslists', $this->paginate());
	}
public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
        $this->checkpermission();
    }
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Payerslist->id = $id;
		if (!$this->Payerslist->exists()) {
			throw new NotFoundException(__('Invalid payerslist'));
		}
		$this->set('payerslist', $this->Payerslist->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Payerslist->create();
			if ($this->Payerslist->save($this->request->data)) {
				$this->Session->setFlash(__('The payerslist has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The payerslist could not be saved. Please, try again.'));
			}
		}
	}
        public function uploadData()
        {
            app::import('Vendor','simplexlsx');
            $simple     =    new SimpleXLSX(WWW_ROOT . 'files/Payerslist/payers_list_from_network.xlsx');
            list($cols) = $simple->dimension();
            foreach( $simple->rows() as $k => $r){
                if($k==0)                        continue;
                $i=0;
                $data['Payerslist']['insurance_company']= $r[0];
                $data['Payerslist']['eclaimlinkid']= $r[1];
                $data['Payerslist']['haad']= $r[2];
                $data['Payerslist']['status']= 0;
                $this->Payerslist->create();
                if($data['Payerslist']['insurance_company']=='')
                    continue;
                    
                if($this->Payerslist->save($data))
                {
                    echo "Inserted\n";
                }
                else
                {
                    echo "Failed to insert\n";
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
		$this->Payerslist->id = $id;
		if (!$this->Payerslist->exists()) {
			throw new NotFoundException(__('Invalid payerslist'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Payerslist->save($this->request->data)) {
				$this->Session->setFlash(__('The payerslist has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The payerslist could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Payerslist->read(null, $id);
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
		$this->Payerslist->id = $id;
		if (!$this->Payerslist->exists()) {
			throw new NotFoundException(__('Invalid payerslist'));
		}
		if ($this->Payerslist->delete()) {
			$this->Session->setFlash(__('Payerslist deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Payerslist was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
