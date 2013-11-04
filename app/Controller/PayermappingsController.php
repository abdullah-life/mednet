<?php
App::uses('AppController', 'Controller');
/**
 * Payermappings Controller
 *
 * @property Payermapping $Payermapping
 */
class PayermappingsController extends AppController {


/**
 * index method
 *
 * @return void
 */
        public function addpayermapping() {
        if ($this->request->is('post')) {
            if (!$this->request->data['Payermapping']['mappings'])
                throw new NotFoundException('excel file not found');
            extract($this->data['Payermapping']['mappings']);
            $data = new Spreadsheet_Excel_Reader($tmp_name, true);
            $exeldata = $data->sheets['0']['cells'];
            $mappings = array();
            $count = 0;
            foreach ($exeldata as $key => $val) {
                if ($key == 1)
                    continue;
                if ($val['2']) {
                    $count++;
                    $pricingdetails[$count] = array('providerdetail_id' => $this->data['Providerpricing']['providerdetail_id'],
                        'acitvity' => $val['1'],
                        'code' => $val['2'],
                        'servicedescription' => isset($val['3']) ? $val['3'] : '',
                        'gross' => isset($val['4']) ? $val['4'] : 0,
                        'discount' => $val['5'],
                        'discountprice' => $val['6'],
                        'start_date' => $this->data['Providerpricing']['start_date'],
                    );
                }
            }
            if ($this->Providerpricing->saveAll($pricingdetails)) {
                $this->Session->setFlash('Pricing added');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The providerpricing could not be saved. Please, try again with a file that is less than 2MB size.'));
            }
        }
    }
    
        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('*');
            $this->checkpermission();
        }
    
	public function index() {
		$this->Payermapping->recursive = 0;
		$this->set('payermappings', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Payermapping->id = $id;
		if (!$this->Payermapping->exists()) {
			throw new NotFoundException(__('Invalid payermapping'));
		}
		$this->set('payermapping', $this->Payermapping->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Payermapping->create();
			if ($this->Payermapping->save($this->request->data)) {
				$this->Session->setFlash(__('The payermapping has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The payermapping could not be saved. Please, try again.'));
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
		$this->Payermapping->id = $id;
		if (!$this->Payermapping->exists()) {
			throw new NotFoundException(__('Invalid payermapping'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Payermapping->save($this->request->data)) {
				$this->Session->setFlash(__('The payermapping has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The payermapping could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Payermapping->read(null, $id);
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
		$this->Payermapping->id = $id;
		if (!$this->Payermapping->exists()) {
			throw new NotFoundException(__('Invalid payermapping'));
		}
		if ($this->Payermapping->delete()) {
			$this->Session->setFlash(__('Payermapping deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Payermapping was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
