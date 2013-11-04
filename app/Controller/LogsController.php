<?php
	class LogsController extends AppController{
	public function beforeFilter() {
        	parent::beforeFilter();
        	$this->Auth->allow('*');
        	$this->checkpermission();
    	}
	public function index(){
		if($this->request->is('post')){
			$this->Session->write('Log_user',$this->request->data['logs']['user']);
		}
		if($this->Session->read('Log_user')){
			$conditions = array('conditions' => array('User' => $this->Session->read('Log_user')));
			$this->paginate=$conditions;
		}
		$this->set('logs', $this->paginate());
		app::import('model','User');
		$userobj	=	new User();
		$uservals	=	$userobj->find('list',array('fields' => array('id','username')));
		$this->set('users',$uservals);		
	}
	public function getUser($id=null){
		app::import('model','User');
		$userobj	=	new User();
		$userdet	=	$userobj->find('first',array('conditions' => array('id' => $id)));
		return $userdet["User"]["username"];
	}
}
?>
