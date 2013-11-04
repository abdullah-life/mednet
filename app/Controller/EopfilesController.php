<?php
App::uses('AppController', 'Controller');
/**
 * Eopfiles Controller
 *
 * @property Eopfile $Eopfile
 */
class EopfilesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		app::import('model','Log');
    		$logobj                         =   new Log();
    		$data                           =   array();
    		$data['Log']['User']            =   $this->Session->read('Auth.User.id');
                $data['Log']['Object']          =   "";
                $data['Log']['Objectcategory']  =   "eop";
    		$data['Log']['Header']          =   "User - Page access";
    		$data['Log']['Desc']            =   "The : ".$this->Session->read('Auth.User.username')." accessed the  dashboard for Finance User";
    		$logobj->create();
    		$logobj->save($data);
            
		$this->Eopfile->recursive = 0;
		$this->set('eopfiles', $this->paginate());
	}
        
        
        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('*');
            $this->checkpermission();
        }
        
        public function changestatus($id=null,$status=null)       
        {
            $this->Eopfile->id=$id;
            $this->Eopfile->saveField('status',(int) $status);
            $details        =   $this->Eopfile->find('first',array('conditions' => array('id' => $id)));
            app::import('model','Log');
            $logobj                         =   new Log();
            $data                           =   array();
            $data['Log']['User']            =   $this->Session->read('Auth.User.id');
            $data['Log']['Object']          =   "";
            $data['Log']['Objectcategory']  =   "eop";
            $data['Log']['Header']          =   "Status of EOP file changed";
            $data['Log']['Desc']            =   "The status of the EOP file ".$details['Eopfile']['name']." changed by ".$this->Session->read('Auth.User.username');
            $logobj->create();
            $logobj->save($data);
            
            //$this->autoRender   =   FALSE;
             $this->redirect(array('action'=>'index'));
            //echo ":asd";
            //exit();
            
            
             
        }
/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Eopfile->id = $id;
		if (!$this->Eopfile->exists()) {
			throw new NotFoundException(__('Invalid eopfile'));
		}
		$this->set('eopfile', $this->Eopfile->read(null, $id));
	}
        
        public function getStatus($fileid = null)
        {
            $status     =   $this->Eopfile->find('all',array('conditions'   =>  array('id'  =>  $fileid),'fields'   =>  array('status')));
            if($status[0]['Eopfile']['status']==1)
            {
                return '<a href="'.Router::url('/',true).'eopfiles/changestatus/'.$fileid.'/2"><img src="'.Router::url('/',true).'app/webroot/img/help.png" class="statuschange"/></a>';
            }
            else if($status[0]['Eopfile']['status']==2)
            {
                return '<a href="'.Router::url('/',true).'eopfiles/changestatus/'.$fileid.'/1"><img src="'.Router::url('/',true).'app/webroot/img/test-fail-icon.png" /></a>';
            }
            else if($status[0]['Eopfile']['status']==3)
            {
                return '<img src="'.Router::url('/',true).'app/webroot/img/down.png" />';
            }
            else
            {
                return '<img src="'.Router::url('/',true).'app/webroot/img/test-pass-icon.png" />';
            }
            
        }
        public function geterrorfile($eopfileid=null){
            $filedet    = $this->Eopfile->find('first',array('conditions' => array('id' => $eopfileid)));
            if(isset($filedet['Eopfile']['error_file'])){
                return '<a href= "'.Router::url('/',true).'app/webroot/files/EOPError/'.$filedet['Eopfile']['error_file'].'">Errors found</a>';
            }
            else{
                return "success";
            }   
        }
        public function getdownloadlink($fileid = null,$option = null)
        {
            if($option == 0)
            {
                $linkData   =   $this->Eopfile->find('first',array('conditions'   =>  array('id'  =>  $fileid),'fields'   =>array('DHA')));
                if(isset($linkData['Eopfile']['DHA']))
                {
                    $link       =   '<a href = "'.Router::url('/',true).'app/webroot/files/Eopresults/'.$linkData['Eopfile']['DHA'].'">Download</a>';
                    return $link;
                }
                else
                {
                    return "Processing";
                }
            }
            if($option==1)
            {
                $linkData   =   $this->Eopfile->find('first',array('conditions'   =>  array('id'  =>  $fileid),'fields'   =>array('HAAD')));
                if(isset($linkData['Eopfile']['HAAD']))
                {
                    $link       = '<a href = "'.Router::url('/',true).'app/webroot/files/Eopresults/'.$linkData['Eopfile']['HAAD'].'">Download</a>';
                    return $link;
                }
                else
                {
                    return "Processing";
                }
            }
            if($option==2)
            {
                $linkData   =   $this->Eopfile->find('first',array('conditions'   =>  array('id'  =>  $fileid),'fields'   =>array('ExcelDHA')));
                if(isset($linkData['Eopfile']['ExcelDHA']))
                {
                    $link       = '<a href = "'.Router::url('/',true).'app/webroot/files/Remitance/'.$linkData['Eopfile']['ExcelDHA'].'">Download Excel</a>';
                    return $link;
                }
                else
                {
                    return "Processing";
                }
            }
            if($option==3)
            {
                $linkData   =   $this->Eopfile->find('first',array('conditions'   =>  array('id'  =>  $fileid),'fields'   =>array('ExcelHAAD')));
                if(isset($linkData['Eopfile']['ExcelHAAD']))
                {
                    $link       = '<a href = "'.Router::url('/',true).'app/webroot/files/Remitance/'.$linkData['Eopfile']['ExcelHAAD'].'">Download Excel</a>';
                    return $link;
                }
                else
                {
                    return "Processing";
                }
            }
        }

        /**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Eopfile->create();
			if ($this->Eopfile->save($this->request->data)) {
				$this->Session->setFlash(__('The eopfile has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The eopfile could not be saved. Please, try again.'));
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
		$this->Eopfile->id = $id;
		if (!$this->Eopfile->exists()) {
			throw new NotFoundException(__('Invalid eopfile'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Eopfile->save($this->request->data)) {
				$this->Session->setFlash(__('The eopfile has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The eopfile could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Eopfile->read(null, $id);
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
		$this->Eopfile->id = $id;
		if (!$this->Eopfile->exists()) {
			throw new NotFoundException(__('Invalid eopfile'));
		}
		if ($this->Eopfile->delete()) {
			$this->Session->setFlash(__('Eopfile deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Eopfile was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
