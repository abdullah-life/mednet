<?php

App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
        $this->checkpermission();
        
    }
    
  public function removedatesearch(){
      $this->Session->delete('from_date');
      $this->Session->delete('to_date');
      
      $this->autoRender=false;
      $this->layout =   'ajax';
      return true;
      
  }  
  public function initDB() {
    //$group->id = 1;
   // $this->Acl->deny($group, 'controllers');
    echo "all done";
    exit;
  }
public function logout(){
     app::import('model','Log');
     $logobj                        =   new Log();
     $data                          =   array();
     $data['Log']['User']           =   $this->Session->read('Auth.User.id');
     $data['Log']['Object']         =   "";
     $data['Log']['Objectcategory'] =   "users";
     $data['Log']['Header']         =   "User - Logout";
     $data['Log']['Desc']           =   "The ".$this->Session->read('Auth.User.username')." is logged out : ";
     $logobj->create();
     $logobj->save($data);
    if($this->Auth->logout()){
	$this->Session->setFlash("thank you");
        $this->redirect(array('controller'=>'users','action'=>'login'));
    }
}

public function logs(){
	app::import('model','Log');
	$logobj		=	new Log();
	$date		=	$this->getDateForConsoleSearch();
	$logs		=	$logobj->find('all',array('conditions' => array('created' => $date)));
	$this->set('logs',$logs);
}
public function getUser($id=null){
	$userdetails = $this->User->find('first',array('conditions' => array('id' => $id)));
	return $userdetails['User']['username'];
}

public function dashboardReciverunit(){
    app::import('model','Log');
    $logobj                         =   new Log();
    $data                           =   array();
    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
    $data['Log']['Object']          =   "";
    $data['Log']['Objectcategory']  =   "users";
    $data['Log']['Header']          =   "User - Page access";
    $data['Log']['Desc']            =   "The ".$this->Session->read('Auth.User.username')." accessed the  dashboard for Receiver User";
    $logobj->create();
    $logobj->save($data);
    $date               =   "'".trim(date("Y-m-d"))."'"; 
    $batchcount         =   $this->requestAction(array('controller'=>'batches','action'=>'getcount', "$date"));
    //$todaysxmlcount     =   $this->requestAction(array('controller'=>'Xmllistings','action'=>'getcount',"$date"));
    $claimscount        =   $this->requestAction(array('controller'=>'claims','action'=>'getcount',$date));
//    $dhacount           =   $this->requestAction(array('controller'=>'Xmllistings','action'=>'getDHAcount',$date));
//    $haadcount          =   $this->requestAction(array('controller'=>'Xmllistings','action'=>'getHAADcount',$date));
//    $otherfiles         =   $this->requestAction(array('controller'=>'Xmllistings','action'=>'getotherfiles',$date));
    $this->set(compact(array('batchcount','claimscount')));
}
public function dashboard(){
    app::import('model','Log');
    $logobj                     =   new Log();
    $data                       =   array();
    $data['Log']['User']        =   $this->Session->read('Auth.User.id');
    $data['Log']['Header']      =   "User - Page access";
    $data['Log']['Desc']        =   "The user with user-id : ".$this->Session->read('Auth.User.id')." accessed the  dashboard for Receiver Admin";
    $logobj->create();
    $logobj->save($data);
    $date               =   "'".trim(date("Y-m-d"))."'"; 
    $batchcount         =   $this->requestAction(array('controller'=>'batches','action'=>'getcount', "$date"));
    $todaysxmlcount     =   $this->requestAction(array('controller'=>'Xmllistings','action'=>'getcount',"$date"));
    $claimscount        =   $this->requestAction(array('controller'=>'claims','action'=>'getcount',$date));
    $dhacount           =   $this->requestAction(array('controller'=>'Xmllistings','action'=>'getDHAcount',$date));
    $haadcount          =   $this->requestAction(array('controller'=>'Xmllistings','action'=>'getHAADcount',$date));
    $otherfiles         =   $this->requestAction(array('controller'=>'Xmllistings','action'=>'getotherfiles',$date));
    $resubmission       =   $this->requestAction(array('controller'=>'Claims','action'=>'resubmission',$date));
    $this->set(compact(array('claimsresubcount','claimscount','todaysxmlcount','batchcount','dhacount','haadcount','otherfiles','resubmission')));
}

public function dashboardClaimsmanager(){
    app::import('model','Log');
    $logobj                         =   new Log();
    $data                           =   array();
    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
    $data['Log']['Object']          =   "";
    $data['Log']['Objectcategory']  =   "users";
    $data['Log']['Header']          =   "User - Page access";
    $data['Log']['Desc']            =   "The ".$this->Session->read('Auth.User.username')." accessed the  dashboard for Claims Manager";
    $logobj->create();
    $logobj->save($data);
    $batchcount         =   $this->requestAction(array('controller'=>'ClaimsmanagerBatches','action'=>'getbatchcount'));
    $batchclaimscount   =   $this->requestAction(array('controller'=>'ClaimsmanagerBatches','action'=>'getbatchclaimscount'));
    $date               =   "'".trim(date("Y-m-d"))."'"; 
    $batchcount2         =   $this->requestAction(array('controller'=>'batches','action'=>'getcount', "$date"));
    $todaysxmlcount     =   $this->requestAction(array('controller'=>'Xmllistings','action'=>'getcount',"$date"));
    $claimscount        =   $this->requestAction(array('controller'=>'claims','action'=>'getcount',$date));
    $dhacount           =   $this->requestAction(array('controller'=>'Xmllistings','action'=>'getDHAcount',$date));
    $haadcount          =   $this->requestAction(array('controller'=>'Xmllistings','action'=>'getHAADcount',$date));
    $otherfiles         =   $this->requestAction(array('controller'=>'Xmllistings','action'=>'getotherfiles',$date));
    $resubmission       =   $this->requestAction(array('controller'=>'Batches','action'=>'resubmission',$date));
    $this->set(compact(array('batchclaimscount','batchcount2','claimsresubcount','claimscount','todaysxmlcount','onhold','batchcount','dhacount','haadcount','otherfiles','resubmission')));
      
}

 public function dashboardClaimsprocessor(){
    app::import('model','Log');
    $logobj                         =   new Log();
    $data                           =   array();
    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
    $data['Log']['Object']          =   "";
    $data['Log']['Objectcategory']  =   "users";
    $data['Log']['Header']          =   "User - Page access";
    $data['Log']['Desc']            =   "The ".$this->Session->read('Auth.User.username')." accessed the  dashboard for Claims Processor";
    $logobj->create();
    $logobj->save($data);
    $batchcount         =   $this->requestAction(array('controller'=>'ClaimsprocessorBatches','action'=>'getbatchcount'));
    $batchclaimscount   =   $this->requestAction(array('controller'=>'ClaimsprocessorBatches','action'=>'getbatchclaimscount'));
    $date               =   "'".trim(date("Y-m-d"))."'"; 
    $batchcount2         =   $this->requestAction(array('controller'=>'batches','action'=>'getcount', "$date"));
    $onhold             =   $this->requestAction(array('controller' => 'batches','action'   =>  'getonholdbatches'));
    $todaysxmlcount     =   $this->requestAction(array('controller'=>'Xmllistings','action'=>'getcount',"$date"));
    $claimscount        =   $this->requestAction(array('controller'=>'claims','action'=>'getcount',$date));
    $dhacount           =   $this->requestAction(array('controller'=>'Xmllistings','action'=>'getDHAcount',$date));
    $haadcount          =   $this->requestAction(array('controller'=>'Xmllistings','action'=>'getHAADcount',$date));
    $otherfiles         =   $this->requestAction(array('controller'=>'Xmllistings','action'=>'getotherfiles',$date));
    $resubmission       =   $this->requestAction(array('controller'=>'Claims','action'=>'resubmission',$date));
    $this->set(compact(array('batchclaimscount','batchcount2','claimsresubcount','onhold','claimscount','todaysxmlcount','batchcount','dhacount','haadcount','otherfiles','resubmission')));
 }      
 
 public function dashboardmedicalmanager(){
    app::import('model','Log');
    $logobj                         =   new Log();
    $data                           =   array();
    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
    $data['Log']['Object']          =   "";
    $data['Log']['Objectcategory']  =   "users";
    $data['Log']['Header']          =   "User - Page access";
    $data['Log']['Desc']            =   "The ".$this->Session->read('Auth.User.username')." accessed the  dashboard for Medical Manager";
    $logobj->create();
    $logobj->save($data);
    $batchcount         =   $this->requestAction(array('controller'=>'MedicalmanagerBatches','action'=>'getbatchcount'));
    $claimscount   =   $this->requestAction(array('controller'=>'MedicalmanagerBatches','action'=>'getbatchclaimscount'));
    $this->set(compact('batchcount','claimscount'));
   }
   
  public function dashboardmedicalreceiver(){
    app::import('model','Log');
    $logobj                         =   new Log();
    $data                           =   array();
    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
    $data['Log']['Object']          =   "";
    $data['Log']['Objectcategory']  =   "users";
    $data['Log']['Header']          =   "User - Page access";
    $data['Log']['Desc']            =   "The ".$this->Session->read('Auth.User.username')." accessed the  dashboard for Medical Reviewer";
    $logobj->create();
    $logobj->save($data);
    $batchcount         =   $this->requestAction(array('controller'=>'MedicalreceiverBatches','action'=>'getbatchcount'));
    $claimscount        =   $this->requestAction(array('controller'=>'MedicalreceiverBatches','action'=>'getbatchclaimscount'));
    $this->set(compact('batchcount','claimscount'));
  }
  
  
  public function dashboardDataAnalyst(){
      echo 'hiiii';
      break;
  }
  public function dashboardFinance()
  {
       echo 'hiiii';
       break;
  }
 
public function login() {
    
       if(!$this->Session->read('Auth.User.id'))
        {      
         if ($this->request->is('post')) {
             if ($this->Auth->login()) 
                 {
                  
		    app::import('model','Log');
            	    $logobj                         =   new Log();
            	    $data                           =   array();
            	    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   "";
                    $data['Log']['Objectcategory']  =   "users";
            	    $data['Log']['Header']          =   "User - Login";
            	    $data['Log']['Desc']            =   "The ".$this->Session->read('Auth.User.username')." is logged in to the system";
            	    $logobj->create();
            	    $logobj->save($data); 	
                    
                    if($this->Session->read('Auth.User.group_id')==15){
                        $this->redirect(array('controller'=>'users','action'=>'dashboardReciverunit' ));
                    }
                    if($this->Session->read('Auth.User.group_id')==16){
                        $this->redirect(array('controller'=>'users','action'=>'dashboardClaimsmanager' ));
                    }
                    if($this->Session->read('Auth.User.group_id')==17){
                        $this->redirect(array('controller'=>'users','action'=>'dashboardClaimsprocessor' ));
                    }
                    if($this->Session->read('Auth.User.group_id')==18){
                        $this->redirect(array('controller'=>'providerpricings','action'=>'index' ));
                    }
                    if($this->Session->read('Auth.User.group_id')==19){
                        $this->redirect(array('controller'=>'users','action'=>'dashboardmedicalmanager' ));
                    }
                    if($this->Session->read('Auth.User.group_id')==20){
                        $this->redirect(array('controller'=>'users','action'=>'dashboardmedicalreceiver' ));
                    }
                    if($this->Session->read('Auth.User.group_id')==21){
                        $this->redirect(array('controller'=>'eopfiles','action'=>'index' ));
                    }
                    
                    $this->redirect(array('controller'=>'users','action'=>'dashboard' ));
                 } 
                 else 
                    {
                       $this->Session->setFlash('The user was deleted successfully.', 'flash_success');
                   }
            }
        }
        else
        {
           // $this->Session->setFlash('Good-Bye');
            $this->redirect($this->Auth->logout());
        }  
}

 public function index() 
        {
     
             	$this->set('users', $this->paginate());
	}
        
        
        public function checkcron(){
             
             
           
        }











        /**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
                            
                                    
				$this->Session->setFlash(__('The user has been saved'));
                                app::import('model','Log');
                                $logobj                     =   new Log();
                                $data                       =   array();
                                $data['Log']['User']        =   $this->Session->read('Auth.User.id');
                                $data['Log']['Header']      =   "New User Added";
                                $data['Log']['Desc']        =   "A new user ".$this->request->data['User']['name']." is added by : ".$this->Session->read('Auth.User.id');
                                $logobj->create();
                                $logobj->save($data);
				//$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
                                app::import('model','Log');
                                $logobj                     =   new Log();
                                $data                       =   array();
                                $data['Log']['User']        =   $this->Session->read('Auth.User.id');
                                $data['Log']['Header']      =   "User Editted";
                                $data['Log']['Desc']        =   "The user ".$this->request->data['User']['name']." is updated by : ".$this->Session->read('Auth.User.id');
                                $logobj->create();
                                $logobj->save($data);
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
                        app::import('model','Log');
                        $logobj                     =   new Log();
                        $data                       =   array();
                        $data['Log']['User']        =   $this->Session->read('Auth.User.id');
                        $data['Log']['Header']      =   "New User Deleted";
                        $data['Log']['Desc']        =   "The user ".$this->request->data['User']['name']." is deleted by : ".$this->Session->read('Auth.User.id');
                        $logobj->create();
                        $logobj->save($data);
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

/**
 * admin_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        public function setpermission()
        {
            
            $method =   array(
                            "Activities" => array(
                                0 => "add",
                                1 => "addnewcomments",
                                2 => "adminadd",
                                3 => "adminedit",
                                4 => "adminindex",
                                5 => "adminview",
                                6 => "edit",
                                7 => "getactivitiespricing",
                                8 => "getactivitycomments",
                                9 => "getclaimactivitiesforremittance",
                                10 => "geteopactivities",
                                11 => "geteopclaims",
                                12 => "index",
                                13 => "view",
                                14 => "viewobservation"
                            ),
                            "BatchComments" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Batches" => array(
                                0 => "add",
                                1 => "adminadd",
                                2 => "adminedit",
                                3 => "adminindex",
                                4 => "adminview",
                                5 => "assignbacktoclaimsprocessor",
                                6 => "assigntoclaimsmanager",
                                7 => "assigntoclaimsprocessor",
                                8 => "assigntomedicalreceiver",
                                9 => "batchname",
                                10 => "edit",
                                11 => "getpiechart",
                                12 => "index",
                                13 => "listbatchesforclaimsmanager",
                                14 => "listbatchesforclaimsprocessor",
                                15 => "listbatchesformedicalmanager",
                                16 => "listbatchesformedicalreceiver",
                                17 => "view"
                            ),
                            "BatchesClaims" => array(
                                0 => "add",
                                1 => "adminadd",
                                2 => "adminedit",
                                3 => "adminindex",
                                4 => "adminview",
                                5 => "edit",
                                6 => "index",
                                7 => "viewclaims",
                                8 => "view"
                            ),
                            "Benefits" => array(
                                0 => "add",
                                1 => "adminindex",
                                2 => "edit",
                                3 => "adminadd",
                                4 => "adminview",
                                5 => "index",
                                6 => "adminedit",
                                7 => "benefitaddajax",
                                8 => "view"
                            ),
                            "Claims" => array(
                                0 => "add",
                                1 => "adminview",
                                2 => "index",
                                3 => "adminadd",
                                4 => "edit",
                                5 => "listmarkedclaims",
                                6 => "adminedit",
                                7 => "generateclaims",
                                8 => "resubmissionindex",
                                9 => "adminindex",
                                10 => "getclaimtree",
                                11 => "view"
                            ),
                            "ClaimsmanagerBatches" => array(
                                0 => "add",
                                1 => "adminindex",
                                2 => "getactivitiespricing",
                                3 => "adminadd",
                                4 => "adminview",
                                5 => "index",
                                6 => "adminedit",
                                7 => "edit",
                                8 => "view"
                            ),
                            "ClaimsprocessorBatches" => array(
                                0 => "add",
                                1 => "adminedit",
                                2 => "adminview",
                                3 => "index",
                                4 => "adminadd",
                                5 => "adminindex",
                                6 => "edit",
                                7 => "view"
                            ),
                            "Denialcodes" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "addsinglecode",
                                4 => "getfalurecode",
                                5 => "view"
                            ),
                            "Denialtables" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Dhaobservationmappings" => array(
                                0 => "add",
                                1 => "addsingle",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "Dhapricings" => array(
                                0 => "add",
                                1 => "addsingle",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "Diagnosis" => array(
                                0 => "add",
                                1 => "adminedit",
                                2 => "edit",
                                3 => "index",
                                4 => "adminview",
                                5 => "adminindex",
                                6 => "view",
                                7 => "adminadd"
                            ),
                            "Eopfileentries" => array(
                                0 => "add",
                                1 => "createremitance",
                                2 => "grid",
                                3 => "adddenialcode",
                                4 => "edit",
                                5 => "neweop",
                                6 => "ajaxupdate",
                                7 => "eopsearch",
                                8 => "view"
                            ),
                            "Eopfiles" => array(
                                0 => "add",
                                1 => "changestatus",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "Haadobservationmappings" => array(
                                0 => "add",
                                1 => "addsingle",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "Haadpricings" => array(
                                0 => "add",
                                1 => "addsingle",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "MedicalmanagerBatches" => array(
                                0 => "add",
                                1 => "getbatchclaimscount",
                                2 => "index",
                                3 => "edit",
                                4 => "getbatchcount",
                                5 => "view"
                            ),
                            "MedicalreceiverBatches" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Missingproviders" => array(
                                0 => "details"
                            ),
                            "Newfiles" => array(
                                0 => "add",
                                1 => "adminedit",
                                2 => "adminview",
                                3 => "index",
                                4 => "adminadd",
                                5 => "adminindex",
                                6 => "edit",
                                7 => "view"
                            ),
                            "Observationmappingfiles" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Observationmappings" => array(
                                0 => "add",
                                1 => "addsingle",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "Providerdetails" => array(
                                0 => "add",
                                1 => "index",
                                2 => "networkedit",
                                3 => "networkview",
                                4 => "view",
                                5 => "edit",
                                6 => "networkadd",
                                7 => "networkindex",
                                8 => "uploadprovider"
                            ),
                            "Providerpricingfiles" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Providerpricings" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "sheduledcsv",
                                4 => "singleadd",
                                5 => "view"
                            ),
                            "Remittanceclaimcomments" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Users" => array(
                                0 => "add",
                                1 => "adminadd",
                                2 => "adminedit",
                                3 => "adminindex",
                                4 => "adminview",
                                5 => "dashboardclaimsmanager",
                                6 => "dashboardclaimsprocessor",
                                7 => "dashboard",
                                8 => "dashboarddataanalyst",
                                9 => "dashboardfinance",
                                10 => "dashboardmedicalmanager",
                                11 => "dashboardmedicalreceiver",
                                12 => "dashboardreciverunit",
                                13 => "edit",
                                14 => "index",
                                15 => "login1",
                                16 => "login",
                                17 => "logout",
                                18 => "register",
                                19 => "view",
                                20 => "setpermission",
                                21 => "notfound"
                            )
                        );
            foreach($method as $key => $val)
            {
                $options[$key] = $key;
            }
            if($this->request->is("post")){
                if(isset($this->request->data['Permission']['controller']) AND ($this->request->data['Permission']['actions']) AND ($this->request->data['Permission']['users'])){
                    app::import('model','Permission');
                    $permissionobj  =   new Permission();
                    $this->request->data['Permission']['actions']= trim($this->request->data['Permission']['actions'], '_');
                    $permissionobj->create();
                    if($permissionobj->save($this->request->data))
                        $this->Session->setFlash ("Permission saved");
                }
                else{
                    $this->Session->setFlash("Please choose a method");
                }
            }
            else{
                $this->Session->write('controller','activity');
                foreach($method['activity'] as $val){
                    $methods[$val] = $val;
                }
            }
            app::import('model','Group');
            $groupobj   =   new Group();
            $groups     =   $groupobj->find('list',array('fields' => array('name')));
            $this->set('options',$options);
            $this->set('methods', $methods);
            $this->set('users',$groups);
        }
        public function notfound(){
            
        }
        public function getmethods($controller=null){
            $this->layout='ajax';
            $this->autoRender=false;
            $method =   array(
                            "Activities" => array(
                                0 => "add",
                                1 => "addnewcomments",
                                2 => "adminadd",
                                3 => "adminedit",
                                4 => "adminindex",
                                5 => "adminview",
                                6 => "edit",
                                7 => "getactivitiespricing",
                                8 => "getactivitycomments",
                                9 => "getclaimactivitiesforremittance",
                                10 => "geteopactivities",
                                11 => "geteopclaims",
                                12 => "index",
                                13 => "view",
                                14 => "viewobservation"
                            ),
                            "BatchComments" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Batches" => array(
                                0 => "add",
                                1 => "adminadd",
                                2 => "adminedit",
                                3 => "adminindex",
                                4 => "adminview",
                                5 => "assignbacktoclaimsprocessor",
                                6 => "assigntoclaimsmanager",
                                7 => "assigntoclaimsprocessor",
                                8 => "assigntomedicalreceiver",
                                9 => "batchname",
                                10 => "edit",
                                11 => "getpiechart",
                                12 => "index",
                                13 => "listbatchesforclaimsmanager",
                                14 => "listbatchesforclaimsprocessor",
                                15 => "listbatchesformedicalmanager",
                                16 => "listbatchesformedicalreceiver",
                                17 => "view"
                            ),
                            "BatchesClaims" => array(
                                0 => "add",
                                1 => "adminadd",
                                2 => "adminedit",
                                3 => "adminindex",
                                4 => "adminview",
                                5 => "edit",
                                6 => "index",
                                7 => "viewclaims",
                                8 => "view"
                            ),
                            "Benefits" => array(
                                0 => "add",
                                1 => "adminindex",
                                2 => "edit",
                                3 => "adminadd",
                                4 => "adminview",
                                5 => "index",
                                6 => "adminedit",
                                7 => "benefitaddajax",
                                8 => "view"
                            ),
                            "Claims" => array(
                                0 => "add",
                                1 => "adminview",
                                2 => "index",
                                3 => "adminadd",
                                4 => "edit",
                                5 => "listmarkedclaims",
                                6 => "adminedit",
                                7 => "generateclaims",
                                8 => "resubmissionindex",
                                9 => "adminindex",
                                10 => "getclaimtree",
                                11 => "view"
                            ),
                            "ClaimsmanagerBatches" => array(
                                0 => "add",
                                1 => "adminindex",
                                2 => "getactivitiespricing",
                                3 => "adminadd",
                                4 => "adminview",
                                5 => "index",
                                6 => "adminedit",
                                7 => "edit",
                                8 => "view"
                            ),
                            "ClaimsprocessorBatches" => array(
                                0 => "add",
                                1 => "adminedit",
                                2 => "adminview",
                                3 => "index",
                                4 => "adminadd",
                                5 => "adminindex",
                                6 => "edit",
                                7 => "view"
                            ),
                            "Denialcodes" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "addsinglecode",
                                4 => "getfalurecode",
                                5 => "view"
                            ),
                            "Denialtables" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Dhaobservationmappings" => array(
                                0 => "add",
                                1 => "addsingle",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "Dhapricings" => array(
                                0 => "add",
                                1 => "addsingle",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "Diagnosis" => array(
                                0 => "add",
                                1 => "adminedit",
                                2 => "edit",
                                3 => "index",
                                4 => "adminview",
                                5 => "adminindex",
                                6 => "view",
                                7 => "adminadd"
                            ),
                            "Eopfileentries" => array(
                                0 => "add",
                                1 => "createremitance",
                                2 => "grid",
                                3 => "adddenialcode",
                                4 => "edit",
                                5 => "neweop",
                                6 => "ajaxupdate",
                                7 => "eopsearch",
                                8 => "view"
                            ),
                            "Eopfiles" => array(
                                0 => "add",
                                1 => "changestatus",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "Haadobservationmappings" => array(
                                0 => "add",
                                1 => "addsingle",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "Haadpricings" => array(
                                0 => "add",
                                1 => "addsingle",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "MedicalmanagerBatches" => array(
                                0 => "add",
                                1 => "getbatchclaimscount",
                                2 => "index",
                                3 => "edit",
                                4 => "getbatchcount",
                                5 => "view"
                            ),
                            "MedicalreceiverBatches" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Missingproviders" => array(
                                0 => "details"
                            ),
                            "Newfiles" => array(
                                0 => "add",
                                1 => "adminedit",
                                2 => "adminview",
                                3 => "index",
                                4 => "adminadd",
                                5 => "adminindex",
                                6 => "edit",
                                7 => "view"
                            ),
                            "Observationmappingfiles" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Observationmappings" => array(
                                0 => "add",
                                1 => "addsingle",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "Providerdetails" => array(
                                0 => "add",
                                1 => "index",
                                2 => "networkedit",
                                3 => "networkview",
                                4 => "view",
                                5 => "edit",
                                6 => "networkadd",
                                7 => "networkindex",
                                8 => "uploadprovider"
                            ),
                            "Providerpricingfiles" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Providerpricings" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "sheduledcsv",
                                4 => "singleadd",
                                5 => "view"
                            ),
                            "Remittanceclaimcomments" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Users" => array(
                                0 => "add",
                                1 => "adminadd",
                                2 => "adminedit",
                                3 => "adminindex",
                                4 => "adminview",
                                5 => "dashboardclaimsmanager",
                                6 => "dashboardclaimsprocessor",
                                7 => "dashboard",
                                8 => "dashboarddataanalyst",
                                9 => "dashboardfinance",
                                10 => "dashboardmedicalmanager",
                                11 => "dashboardmedicalreceiver",
                                12 => "dashboardreciverunit",
                                13 => "edit",
                                14 => "index",
                                15 => "login1",
                                16 => "login",
                                17 => "logout",
                                18 => "register",
                                19 => "view",
                                20 => "setpermission",
                                21 => "notfound"
                            )
                        );
            echo '<label for="PermissionActions">Actions</label>';
            echo '<select id="PermissionActions" class="methods" name="data[Permission][actions]>';
            
            echo '<option value="">Select the method</option>';
           foreach($method[$controller] as $value)
           {
               echo '<option value="'.$value.'">'.$value.'</option>';
           }
           echo "</select>";
        }
        public function addadminpermissions(){
            $method =   array(
                            "Activities" => array(
                                0 => "add",
                                1 => "addnewcomments",
                                2 => "adminadd",
                                3 => "adminedit",
                                4 => "adminindex",
                                5 => "adminview",
                                6 => "edit",
                                7 => "getactivitiespricing",
                                8 => "getactivitycomments",
                                9 => "getclaimactivitiesforremittance",
                                10 => "geteopactivities",
                                11 => "geteopclaims",
                                12 => "index",
                                13 => "view",
                                14 => "viewobservation"
                            ),
                            "BatchComments" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Batches" => array(
                                0 => "add",
                                1 => "adminadd",
                                2 => "adminedit",
                                3 => "adminindex",
                                4 => "adminview",
                                5 => "assignbacktoclaimsprocessor",
                                6 => "assigntoclaimsmanager",
                                7 => "assigntoclaimsprocessor",
                                8 => "assigntomedicalreceiver",
                                9 => "batchname",
                                10 => "edit",
                                11 => "getpiechart",
                                12 => "index",
                                13 => "listbatchesforclaimsmanager",
                                14 => "listbatchesforclaimsprocessor",
                                15 => "listbatchesformedicalmanager",
                                16 => "listbatchesformedicalreceiver",
                                17 => "view"
                            ),
                            "BatchesClaims" => array(
                                0 => "add",
                                1 => "adminadd",
                                2 => "adminedit",
                                3 => "adminindex",
                                4 => "adminview",
                                5 => "edit",
                                6 => "index",
                                7 => "viewclaims",
                                8 => "view"
                            ),
                            "Benefits" => array(
                                0 => "add",
                                1 => "adminindex",
                                2 => "edit",
                                3 => "adminadd",
                                4 => "adminview",
                                5 => "index",
                                6 => "adminedit",
                                7 => "benefitaddajax",
                                8 => "view"
                            ),
                            "Claims" => array(
                                0 => "add",
                                1 => "adminview",
                                2 => "index",
                                3 => "adminadd",
                                4 => "edit",
                                5 => "listmarkedclaims",
                                6 => "adminedit",
                                7 => "generateclaims",
                                8 => "resubmissionindex",
                                9 => "adminindex",
                                10 => "getclaimtree",
                                11 => "view"
                            ),
                            "ClaimsmanagerBatches" => array(
                                0 => "add",
                                1 => "adminindex",
                                2 => "getactivitiespricing",
                                3 => "adminadd",
                                4 => "adminview",
                                5 => "index",
                                6 => "adminedit",
                                7 => "edit",
                                8 => "view"
                            ),
                            "ClaimsprocessorBatches" => array(
                                0 => "add",
                                1 => "adminedit",
                                2 => "adminview",
                                3 => "index",
                                4 => "adminadd",
                                5 => "adminindex",
                                6 => "edit",
                                7 => "view"
                            ),
                            "Denialcodes" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "addsinglecode",
                                4 => "getfalurecode",
                                5 => "view"
                            ),
                            "Denialtables" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Dhaobservationmappings" => array(
                                0 => "add",
                                1 => "addsingle",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "Dhapricings" => array(
                                0 => "add",
                                1 => "addsingle",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "Diagnosis" => array(
                                0 => "add",
                                1 => "adminedit",
                                2 => "edit",
                                3 => "index",
                                4 => "adminview",
                                5 => "adminindex",
                                6 => "view",
                                7 => "adminadd"
                            ),
                            "Eopfileentries" => array(
                                0 => "add",
                                1 => "createremitance",
                                2 => "grid",
                                3 => "adddenialcode",
                                4 => "edit",
                                5 => "neweop",
                                6 => "ajaxupdate",
                                7 => "eopsearch",
                                8 => "view"
                            ),
                            "Eopfiles" => array(
                                0 => "add",
                                1 => "changestatus",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "Haadobservationmappings" => array(
                                0 => "add",
                                1 => "addsingle",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "Haadpricings" => array(
                                0 => "add",
                                1 => "addsingle",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "MedicalmanagerBatches" => array(
                                0 => "add",
                                1 => "getbatchclaimscount",
                                2 => "index",
                                3 => "edit",
                                4 => "getbatchcount",
                                5 => "view"
                            ),
                            "MedicalreceiverBatches" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Missingproviders" => array(
                                0 => "details"
                            ),
                            "Newfiles" => array(
                                0 => "add",
                                1 => "adminedit",
                                2 => "adminview",
                                3 => "index",
                                4 => "adminadd",
                                5 => "adminindex",
                                6 => "edit",
                                7 => "view"
                            ),
                            "Observationmappingfiles" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Observationmappings" => array(
                                0 => "add",
                                1 => "addsingle",
                                2 => "edit",
                                3 => "index",
                                4 => "view"
                            ),
                            "Providerdetails" => array(
                                0 => "add",
                                1 => "index",
                                2 => "networkedit",
                                3 => "networkview",
                                4 => "view",
                                5 => "edit",
                                6 => "networkadd",
                                7 => "networkindex",
                                8 => "uploadprovider"
                            ),
                            "Providerpricingfiles" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Providerpricings" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "sheduledcsv",
                                4 => "singleadd",
                                5 => "view"
                            ),
                            "Remittanceclaimcomments" => array(
                                0 => "add",
                                1 => "edit",
                                2 => "index",
                                3 => "view"
                            ),
                            "Users" => array(
                                0 => "add",
                                1 => "adminadd",
                                2 => "adminedit",
                                3 => "adminindex",
                                4 => "adminview",
                                5 => "dashboardclaimsmanager",
                                6 => "dashboardclaimsprocessor",
                                7 => "dashboard",
                                8 => "dashboarddataanalyst",
                                9 => "dashboardfinance",
                                10 => "dashboardmedicalmanager",
                                11 => "dashboardmedicalreceiver",
                                12 => "dashboardreciverunit",
                                13 => "edit",
                                14 => "index",
                                15 => "login1",
                                16 => "login",
                                17 => "logout",
                                18 => "register",
                                19 => "view",
                                20 => "setpermission",
                                21 => "notfound"
                            )
                        );
                        foreach ($method as $key => $val){
                            foreach ($val  as $fn)
                            {
                                app::import('model','Permission');
                                $permissionobj  =   new Permission();
                                $data   =   array();
                                $data['Permission']['controller']= $key;
                                $data['Permission']['actions']= $fn;
                                $data['Permission']['users']= '1';
                                $prev   =   $permissionobj->find('count',array('conditions' => $data));
                                if($prev>0)
                                {
                                    echo "Already exist";
                                }
                                else{
                                    $permissionobj->create();
                                    if($permissionobj->save($data))
                                        echo "Permission saved";
                                }
                            }
                        }
        }
}
