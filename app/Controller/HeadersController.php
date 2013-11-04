<?php
App::uses('AppController', 'Controller');
/**
 * Headers Controller
 *
 * @property Header $Header
 */
class HeadersController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Header->recursive = 0;
		$this->set('headers', $this->paginate());
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
        public function generateheader($xmllistingid=null){
           $this->autoRender    =   FALSE;
           $this->Header->recursive =   -1;
           $val     =   $this->Header->find('first',array('conditions'=>array('Header.xmllisting_id'=>$xmllistingid)));
           
           $header    =   "<ul> <li><b>Header</b><ul>";
                $header    .=   "<li><b>SenderID &nbsp;:</b>".$val['Header']['SenderID'].'</li>';
                $header  .=   "<li><b>ReceiverID &nbsp;:</b>".$val['Header']['ReceiverID'].'</li>';
                $header    .=   "<li><b>TransactionDate &nbsp;:</b>".$val['Header']['TransactionDate'].'</li>';
                $header    .=   "<li><b>RecordCount &nbsp;:</b>".$val['Header']['RecordCount'].'</li>';
                $header    .=   "<li><b>DispositionFlag &nbsp;:</b>".$val['Header']['DispositionFlag'].'</li></ul>';
          $header   .=  "</li></ul>"  ;
          
          return $header;
          
         
        }
        
	public function view($id = null) {
		$this->Header->id = $id;
		if (!$this->Header->exists()) {
			throw new NotFoundException(__('Invalid header'));
		}
		$this->set('header', $this->Header->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Header->create();
			if ($this->Header->save($this->request->data)) {
				$this->Session->setFlash(__('The header has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The header could not be saved. Please, try again.'));
			}
		}
		$xmllistings = $this->Header->Xmllisting->find('list');
		$this->set(compact('xmllistings'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Header->id = $id;
		if (!$this->Header->exists()) {
			throw new NotFoundException(__('Invalid header'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Header->save($this->request->data)) {
				$this->Session->setFlash(__('The header has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The header could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Header->read(null, $id);
		}
		$xmllistings = $this->Header->Xmllisting->find('list');
		$this->set(compact('xmllistings'));
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
		$this->Header->id = $id;
		if (!$this->Header->exists()) {
			throw new NotFoundException(__('Invalid header'));
		}
		if ($this->Header->delete()) {
			$this->Session->setFlash(__('Header deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Header was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Header->recursive = 0;
		$this->set('headers', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Header->id = $id;
		if (!$this->Header->exists()) {
			throw new NotFoundException(__('Invalid header'));
		}
		$this->set('header', $this->Header->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Header->create();
			if ($this->Header->save($this->request->data)) {
				$this->Session->setFlash(__('The header has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The header could not be saved. Please, try again.'));
			}
		}
		$xmllistings = $this->Header->Xmllisting->find('list');
		$this->set(compact('xmllistings'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Header->id = $id;
		if (!$this->Header->exists()) {
			throw new NotFoundException(__('Invalid header'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Header->save($this->request->data)) {
				$this->Session->setFlash(__('The header has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The header could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Header->read(null, $id);
		}
		$xmllistings = $this->Header->Xmllisting->find('list');
		$this->set(compact('xmllistings'));
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
		$this->Header->id = $id;
		if (!$this->Header->exists()) {
			throw new NotFoundException(__('Invalid header'));
		}
		if ($this->Header->delete()) {
			$this->Session->setFlash(__('Header deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Header was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
