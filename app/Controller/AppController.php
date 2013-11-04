<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */

class AppController extends Controller {

         public $components = array(
                'Session',
                'Auth','RequestHandler'
          );
      public $helpers            =   array('Html', 'Form','Session','Js');
    
     
      
   function beforeFilter() {

         
       
    Security::setHash('md5');
    $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
    $this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'index');
    $this->Auth->loginError = 'Invalid Username or Password.';
    $this->Auth->authError = "You are not authorized to access.";
    $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
    $this->Auth->authorize = 'Actions';
    $this->Auth->actionPath = 'Controllers/';
}   

public function checkpermission(){
    $url_compo  = explode('/', $_SERVER['REQUEST_URI']);
    app::import('model','Permission');
    $permissionobj      =   new Permission();
    $group_id = $this->Session->read('Auth.User.group_id');
    $url_compo[3]=preg_replace('/[_]+/', '', $url_compo[3]);
    if((!$url_compo[3]) AND (!$url_compo[2])){
        return true;
    }
    if($url_compo[3]=="login" OR $group_id=='1' OR $url_compo[3]=="logout")
    {
        return true;
    }
    if($url_compo[3] == "")
    {
        $url_compo[3]="index";
    }
//    app::import('model','Log');
//    $logobj                     =   new Log();
//    $data                       =   array();
//    $data['Log']['User']        =   $this->Session->read('Auth.User.id');
//    $data['Log']['Header']      =   "User - Requests  ";
//    $data['Log']['Desc']        =   "The user ".$this->Session->read('Auth.User.id')."requests the page  : ".$_SERVER['REQUEST_URI'];
//    $logobj->create();
//    $logobj->save($data);
    //return true;
    $permissionvalues   =   $permissionobj->find('all',array('conditions' => array('actions' => strtolower($url_compo[3]),'controller' => ucfirst(strtolower($url_compo[2])))));
    //print_r($permissionvalues);print_r(array('actions' => trim(strtolower($url_compo[3]),'_'),'controller' => ucfirst(strtolower($url_compo[2])),'users' => $this->Session->read('Auth.User.group_id')));+exit;
    if(isset($permissionvalues[0]))
    {
        //die("found");
        foreach ($permissionvalues as $permissionvalue)
        {
            
            if($permissionvalue['Permission']['users'] == $group_id){
                return true;
            }
        }
        $this->Session->setFlash("You don't have permission to access this page.Contanct Admin.");
        $this->redirect(array('controller' => "Users",'action' => "login"));
    }
    return true;
}
public function getDateForSearch($model=null,$date=null){
       
            $cdate    =   date("Y-m-d");
            if($date){
                   
                    return array('$gt' =>  new MongoDate(strtotime($date."")),'$lt'   =>  new MongoDate(strtodate($date))."+1 day");
                
            }else{
                 
                if($this->Session->read('from_date')){
                     
                    $from_date               =   new MongoDate(strtotime($this->Session->read('from_date'.""))); 
                    if($this->Session->read('to_date'))
                        $to_date                =   new MongoDate(strtotime($this->Session->read('to_date'."")."+1 day")); 
                        return  array('$gt' => $from_date, '$lt' => $to_date);
                 }   
                 else{
                      
                    $start   =   new MongoDate(strtotime("200-1-1"));
                    $end     =   new MongoDate(strtotime(date("Y-m-d", strtotime($cdate)) . "+1 day"));
                    return array('$gt' =>  $start,'$lt'   => $end);
                 }
                 
            }
            $this->autoRender   =   FALSE;
        }
      

public function getDateForConsoleSearch($date=null)
      {
         if(!$date)
             $date    =   date("Y-m-d");
             $start   =   new MongoDate(strtotime($date));
             $end     =   new MongoDate(strtotime(date("Y-m-d", strtotime($date)) . "+1 day"));
         
           return  array('$gt' => $start, '$lt' => $end);
            
         exit;
        }
        
 public function oderby(){
     
    
     
 }       
      
}



