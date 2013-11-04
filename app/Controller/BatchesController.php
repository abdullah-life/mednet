<?php
App::uses('AppController', 'Controller');
/**
 * Batches Controller
 *
 * @property Batch $Batch
 */
class BatchesController extends AppController {


/**
 * index method
 *
 * @return void
 */
        public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
        $this->checkpermission();
    }
        
        
        public function getpiechart(){
            $data    =   $this->Batch->find('all',array('conditions'=>array('created'=>$this->getDateForSearch())));
            foreach($data as $key=>$batch){
                if($batch['Batch']['status']==0)
                    $notnameed++ ;    
                if($batch['Batch']['status']==3)
                {
                    $claimsprocessor++ ;
                }
                if($batch['Batch']['status']==2)
                {
                    $claimsmanager++ ;
                }
                
                if($batch['Batch']['status']==4)
                    $medicalmanage++ ;    
                if($batch['Batch']['status']==8)
                    $medicalreceiver++ ;    
                if($batch['Batch']['status']==5)
                    $onhold++ ;    
                if($batch['Batch']['status']==6)
                    $success++ ;    
                if($batch['Batch']['status']==7)
                    $downloaded++ ;    
                if($batch['Batch']['status']==10)
                    $backmedicalmanager++ ;
            }
            
            

            if($this->Session->read('Auth.User.group_id')==17)
            {
                app::import('model','ClaimsprocessorBatch');
                $claimsProcessorBatch = new ClaimsprocessorBatch();
                $cbatchids   =   $claimsProcessorBatch->find('all',array('fields'    =>  array('batch_id'),'conditions'  =>  array('user_id' => $this->Session->read('Auth.User.id'))));
                foreach ($cbatchids as $cbatchid)
                {
                    $batchids[] =   $cbatchid['ClaimsprocessorBatch']['batch_id'];
                }
                $claimsprocessor=0;
                foreach ($batchids as $batchid)
                {
                    $claimsprocessor+=  $this->Batch->find('count',array('conditions'    =>  array('status'   =>  new MongoInt32(3),'id' => $batchid)));
                }
            }
            if($this->Session->read('Auth.User.group_id')==20)
            {
                app::import('model','MedicalreceiverBatch');
                $medicalreceiverBatch = new MedicalreceiverBatch();
                $cbatchids   =   $medicalreceiverBatch->find('all',array('fields'    =>  array('batch_id'),'conditions'  =>  array('user_id' => $this->Session->read('Auth.User.id'))));
                
                foreach ($cbatchids as $cbatchid)
                {
                    $batchids[] =   $cbatchid['MedicalreceiverBatch']['batch_id'];
                }
                $medicalreceiver=0;
                foreach ($batchids as $batchid)
                {
                    $medicalreceiver+=  $this->Batch->find('count',array('conditions'    =>  array('status'   =>  new MongoInt32(8),'id' => $batchid)));
                }
            }
            $this->set(compact('notnameed','claimsmanager','claimsprocessor','medicalmanage','medicalreceiver','onhold','downloaded','backmedicalmanager','success'));
            $this->layout   =   'ajax';
        }  
        public function removeentriesbydate($date){
             $cdate    =   '2013-05-26';
            
            if($cdate){
                app::import('model','Batch');
               
                $batchobj   =   new Batch();
                $count  =   $batchobj->find('count', array('conditions'=>array('$gt' =>  new MongoDate(),'$lt'   =>  new MongoDate(strtotime($cdate))."+1 day")));
                
                        
                
                
                
                
            }
            
            
        }
        
        
        public function getDateForSearchhere($date=null){
            
            if($date){
                 return "(DATE(Batch.created) = DATE($date))";
            }else{
                 $date               =   "'".trim(date("Y-m-d"))."'";  
                 return $this->getDateForSearch('Batch');
            }
            $this->autoRender   =   FALSE;
        }
        public function list_batches_for_claimsmanager($claimtype=null){
            app::import('model','Log');
            $logobj                         =   new Log();
            $data                           =   array();
            $data['Log']['User']            =   $this->Session->read('Auth.User.id');
            $data['Log']['Object']          =   "";
            $data['Log']['Objectcategory']  =   "";
            $data['Log']['Header']      =   "User - Page access";
            $data['Log']['Desc']        =   "The ".$this->Session->read('Auth.User.username')." accessed the  page for listing batches for Claims Manager";
            $logobj->create();
            $logobj->save($data);
              $this->set('item',$claimtype);
            $this->Session->write('provider_code',trim($this->request->data['Search']['provider_code']));
            $this->Session->write('License',trim($this->request->data['Search']['License']));
            $this->Session->write('Name',trim($this->request->data['Search']['Name']));
            if($this->Session->read('provider_code')){
                $providerLicense   =   $this->getproviderlisense($this->Session->read('provider_code'));
                if($providerLicense){
                       $this->Session->write('License',trim($providerLicense));
                }
            }
            if(isset($claimtype)){
               
               
               if($claimtype==3){
                   if($this->Session->read('resubmission')=='yes'){
                       $batches    =   $this->Batch->find('all',array('fields'=>array('batch_id'),  'conditions'=>array('resubmission' => 1,'status'=>array('$in'=> array(3,7)))));
                   }
                   else
                    $batches    =   $this->Batch->find('all',array('fields'=>array('batch_id'),  'conditions'=>array('resubmission' => 1,'status'=>array('$in'=> array(3,7)))));
                    //$batches    =   $this->Batch->find('all',array('fields'=>array('batch_id'),  'conditions'=>array('created'=>$this->getDateForSearch(),'status'=>array('$in'=> array(3,7)))));
               }else{
                   if($this->Session->read('resubmission')=='yes'){
                     $batches    =   $this->Batch->find('all',array('fields'=>array('batch_id'),  'conditions'=>array('status'=>new MongoInt64($claimtype))));  
                   }else{
                    $batches    =   $this->Batch->find('all',array('fields'=>array('batch_id'),  'conditions'=>array('status'=>new MongoInt64($claimtype))));
                   }
                    //$batches    =   $this->Batch->find('all',array('fields'=>array('batch_id'),  'conditions'=>array('created'=>$this->getDateForSearch(),'status'=>new MongoInt64($claimtype))));
               }
               foreach ($batches as $batch)
               $batchid[]     =   trim($batch['Batch']['id']);
           }
           else{
               app::import('model','ClaimsmanagerBatch');
               $ClaimsmanagerBatch  =   new ClaimsmanagerBatch();
               if($this->Session->read('resubmission' == 'yes')){
                    $allbatchids = $this->Batch->find('all',array('conditions' => array('resubmission' => 1)));
                    foreach ($allbatchids  as $bid)
                    {
                        $batches[]    =   $ClaimsmanagerBatch->find('all',array('fields'=>array('batch_id'),'conditions'=>array('batch_id'=>$bid['Batch']['id'],'created'=>$this->getDateForSearch())));    
                    }
               }
               else{
                    $batches    =   $ClaimsmanagerBatch->find('all',array('fields'=>array('batch_id'),'conditions'=>array('created'=>$this->getDateForSearch())));    
               }
               foreach ($batches as $batch)
               $batchid[]     =   trim($batch['ClaimsmanagerBatch']['batch_id']);
            }
          
           $inquery =   implode(',', $batchid);
           if($inquery)
           {
               $licence     = $this->Session->read('License');
               $name        = $this->Session->read('Name');
               if($licence)
               {
                   if($this->Session->read('resubmission') == 'yes')
                   {
                      $this->paginate = array(
                        'conditions'=>array('id'=>array('$in'=> $batchid),'provider_id' => $licence,'resubmission' => 1),
                        'order' => array('modified' => 'desc'),
                    ); 
                   }
                   else{
                    $this->paginate = array(
                        'conditions'=>array('id'=>array('$in'=> $batchid),'provider_id' => $licence),
                        'order' => array('modified' => 'desc'),
                    );
                   }
               }
               if($name)
               {
                   if($this->Session->read('resubmission') == 'yes'){
                       $this->paginate = array(
                        'conditions'=>array('id'=>array('$in'=> $batchid),'name' => $name,'resubmission' => 1),
                        'order' => array('modified' => 'desc'),
                    );
                   }
                   else{
                    $this->paginate = array(
                        'conditions'=>array('id'=>array('$in'=> $batchid),'name' => $name),
                        'order' => array('modified' => 'desc'),
                    );
                   }
               }
               if(!(($name)||($licence)))
               {
                   if($this->Session->read('resubmission') == 'yes'){
                       $this->paginate = array(
                        'conditions'=>array('id'=>array('$in'=> $batchid),'resubmission' => 1),
                        'order' => array('modified' => 'desc'),
                    );
                   }
                   else
                   {
                    $this->paginate = array(
                        'conditions'=>array('id'=>array('$in'=> $batchid)),
                        'order' => array('modified' => 'desc'),
                    );
                   }
               }
          
           $this->Batch->recursive = 1;
            $this->set('batches', $this->paginate());
            }else{
             $this->set('batches',"error");
           }
           
        }
        
            public function listbatchesformedicalmanager($claimtype=null){
                app::import('model','Log');
                $logobj                     =   new Log();
                $data                       =   array();
                $data['Log']['User']        =   $this->Session->read('Auth.User.id');
                $data['Log']['Object']          =   "";
                $data['Log']['Objectcategory']  =   "";
                $data['Log']['Header']      =   "User - Page access";
                $data['Log']['Desc']        =   "The ".$this->Session->read('Auth.User.username')." accessed the  page for listing batches for Medical Manager";
                $logobj->create();
                $logobj->save($data);
            
            $this->set('item',$claimtype);
            $this->Session->write('provider_code',trim($this->request->data['Search']['provider_code']));
            $this->Session->write('License',trim($this->request->data['Search']['License']));
            $this->Session->write('Name',trim($this->request->data['Search']['Name']));
            if($this->Session->read('provider_code')){
                $providerLicense   =   $this->getproviderlisense($this->Session->read('provider_code'));
                if($providerLicense){
                    $this->Session->write('License',trim($providerLicense));
                }
            }
           if(isset($claimtype)){

               $batches    =   $this->Batch->find('all',array('fields'=>array('batch_id'),  'conditions'=>array('status'=>new MongoInt64($claimtype))));
               //$batches    =   $this->Batch->find('all',array('fields'=>array('batch_id'),  'conditions'=>array('created'=>$this->getDateForSearch(),'status'=>new MongoInt64($claimtype))));

               foreach ($batches as $batch)
               $batchid[]     =   trim($batch['Batch']['id']);
           }
           else{
               app::import('model','MedicalmanagerBatch');
               $MedicalmanagerBatch  =   new MedicalmanagerBatch();
               $batches    =   $MedicalmanagerBatch->find('all',array('fields'=>array('batch_id'),'conditions'=>array('created'=>$this->getDateForSearch())));    
               //$batches    =   $MedicalmanagerBatch->find('all',array('fields'=>array('batch_id'),'conditions'=>array('created'=>$this->getDateForSearch(),'created'=>$this->getDateForSearch())));    
               foreach ($batches as $batch)
               $batchid[]     =   trim($batch['MedicalmanagerBatch']['batch_id']);
            }
          
            
           $inquery =   implode(',', $batchid);
           
           if($batchid)
           {
               $licence     = $this->Session->read('License');
               $name        = $this->Session->read('Name');
               if($licence)
               {
                   $this->paginate = array(
                     'conditions'=>array('id'=>array('$in'=> $batchid),'provider_id' => $licence),
                     'order' => array('modified' => 'desc'),
                   ); 
               }
               if($name)
               {
                   $this->paginate = array(
                     'conditions'=>array('id'=>array('$in'=> $batchid),'name' => $name),
                     'order' => array('modified' => 'desc'),
                   ); 
               }
               if(!(($licence)||($name)))
               {
                   $this->paginate = array(
                     'conditions'=>array('id'=>array('$in'=> $batchid)),
                     'order' => array('modified' => 'desc'),
                    ); 
               }
           
          
           $this->Batch->recursive = 1;
            $this->set('batches', $this->paginate());
            }else{
             $this->set('batches',"error");
            
            }
                        
        }
        
            public function getAssignerName($batchid=null,$option=null)
            {
                app::import('model',  'User');
                $userobj    =   new User();
                if(isset($batchid))
                {
                    switch($option){
                        case 1:
                            $batchstatus    =   $this->Batch->find('first',array('conditions'   =>  array('id' => $batchid)));
                            if(($batchstatus['Batch']['success_by']==null) && ($batchstatus['Batch']['onhold_by']==null))
                            {
                                app::import('model','ClaimsmanagerBatch');
                                $claimsmanagerbacthobj  =   new ClaimsmanagerBatch();
                                $batchdetails           =   $claimsmanagerbacthobj->find('first',array('conditions' =>  array('batch_id'    =>  $batchid),'fields'  => array('Assigned_by')));
                                $userdetails            =   $userobj->find('first',array('conditions'   =>  array('id'  =>  $batchdetails['ClaimsmanagerBatch']['Assigned_by'])));
                                return $userdetails['User']['username'];
                            }
                            else
                            {
                                if($batchstatus['Batch']['success_by']){
                                    $conditions     = array('id' => $batchstatus['Batch']['success_by']);
                                }
                                else{
                                    
                                    $conditions     = array('id' => $batchstatus['Batch']['onhold_by']);
                                }
                                $userdetails            =   $userobj->find('first',array('conditions'   =>  $conditions));
                                return $userdetails['User']['username'];
                                
                            }
                        break;
                        case 2:
                            $batchstatus    =   $this->Batch->find('first',array('conditions'   =>  array('id' => $batchid)));
                            if(($batchstatus['Batch']['success_by']==null) && ($batchstatus['Batch']['onhold_by']==null))
                            {
                                app::import('model','ClaimsprocessorBatch');
                                $claimsmanagerbacthobj  =   new ClaimsprocessorBatch();
                                $batchdetails           =   $claimsmanagerbacthobj->find('first',array('conditions' =>  array('batch_id'    =>  $batchid),'fields'  => array('Assigned_by')));
                                $userdetails            =   $userobj->find('first',array('conditions'   =>  array('id'  =>  $batchdetails['ClaimsprocessorBatch']['Assigned_by'])));
                                return $userdetails['User']['username'];
                            }
                            else
                            {
                                if($batchstatus['Batch']['success_by']){
                                    $conditions     = array('id' => $batchstatus['Batch']['success_by']);
                                }
                                else{
                                    $conditions     = array('id' => $batchstatus['Batch']['onhold_by']);
                                }
                                $userdetails            =   $userobj->find('first',array('conditions'   =>  $conditions));
                                return $userdetails['User']['username'];
                            }
                        break;
                        case 3: 
                            app::import('model','MedicalmanagerBatch');
                            $claimsmanagerbacthobj  =   new MedicalmanagerBatch();
                            $batchdetails           =   $claimsmanagerbacthobj->find('first',array('conditions' =>  array('batch_id'    =>  $batchid),'fields'  => array('Assigned_by')));
                            $userdetails            =   $userobj->find('first',array('conditions'   =>  array('id'  =>  $batchdetails['MedicalmanagerBatch']['Assigned_by'])));
                            return $userdetails['User']['username'];
                        break;
                        case 4: 
                            app::import('model','MedicalreceiverBatch');
                            $claimsmanagerbacthobj  =   new MedicalreceiverBatch();
                            $batchdetails           =   $claimsmanagerbacthobj->find('first',array('conditions' =>  array('batch_id'    =>  $batchid),'fields'  => array('Assigned_by')));
                            $userdetails            =   $userobj->find('first',array('conditions'   =>  array('id'  =>  $batchdetails['MedicalreceiverBatch']['Assigned_by'])));
                            return $userdetails['User']['username'];
                        break;
                            
                    }
                    
                }
            }

        public function listbatchesformedicalreceiver($claimtype=null){
            app::import('model','Log');
            $logobj                     =   new Log();
            $data                       =   array();
            $data['Log']['User']        =   $this->Session->read('Auth.User.id');
            $data['Log']['Object']          =   "";
            $data['Log']['Objectcategory']  =   "";
            $data['Log']['Header']      =   "User - Page access";
            $data['Log']['Desc']        =   "The user with user-id : ".$this->Session->read('Auth.User.id')." accessed the  page for listing batches for Medical Reviewer";
            $logobj->create();
            $logobj->save($data);
            $this->set('item',$claimtype);
            $this->Session->write('provider_code',trim($this->request->data['Search']['provider_code']));
            $this->Session->write('License',trim($this->request->data['Search']['License']));
            $this->Session->write('Name',trim($this->request->data['Search']['Name']));
            if($this->Session->read('provider_code')){
                $providerLicense   =   $this->getproviderlisense($this->Session->read('provider_code'));
                if($providerLicense){
                    $this->Session->write('License',trim($providerLicense));
                }
            }
            if(isset($claimtype)){
               app::import('model','MedicalreceiverBatch');
               $MedicalreceiverBatch  =   new MedicalreceiverBatch();
               $mbatchids   = $MedicalreceiverBatch->find('all',array('fields'  =>  array('batch_id'),'conditions'  =>  array('user_id'  => $this->Session->read('Auth.User.id'))));
               //$mbatchids   = $MedicalreceiverBatch->find('all',array('fields'  =>  array('batch_id'),'conditions'  =>  array('created'=>$this->getDateForSearch(),'user_id'  => $this->Session->read('Auth.User.id'))));
               
               foreach ($mbatchids as $mbatchid)
               {
                   $batchids[]    = $this->Batch->find('all',array('fields'   =>  array('id'),'conditions'    =>  array('status' => new MongoInt32(8),'id' =>  $mbatchid['MedicalreceiverBatch']['batch_id'])));
                   //$batchids[]    = $this->Batch->find('all',array('fields'   =>  array('id'),'conditions'    =>  array('created'=>$this->getDateForSearch(),'status' => new MongoInt32(8),'id' =>  $mbatchid['MedicalreceiverBatch']['batch_id'])));
               }
               foreach ($batchids as $Batchid)
               {
                   $batchid[] = $Batchid[0]['Batch']['id'];
               }
               
//           $batches    =   $this->Batch->find('all',array('fields'=>array('batch_id'),  'conditions'=>array('status'=>new MongoInt64($claimtype))));
//               foreach ($batches as $batch)
//               $batchid[]     =   trim($batch['Batch']['id']);
           }
           else{
               app::import('model','MedicalreceiverBatch');
               $MedicalreceiverBatch  =   new MedicalreceiverBatch();
               $batches    =   $MedicalreceiverBatch->find('all',array('fields'=>array('batch_id'),'conditions'=>array('created'=>$this->getDateForSearch(),'user_id'  => $this->Session->read('Auth.User.id'))));    
               //$batches    =   $MedicalreceiverBatch->find('all',array('fields'=>array('batch_id'),'conditions'=>array('created'=>$this->getDateForSearch(),'created'=>$this->getDateForSearch(),'user_id'  => $this->Session->read('Auth.User.id'))));    
               foreach ($batches as $batch)
               $batchid[]     =   trim($batch['MedicalreceiverBatch']['batch_id']);
            }
          
            
           $inquery =   implode(',', $batchid);
           
           if($batchid)
           {
               $licence     = $this->Session->read('License');
               $name        = $this->Session->read('Name');
               if($licence)
               {
                   $this->paginate = array(
                     'conditions'=>array('id'=>array('$in'=> $batchid),'provider_id' => $licence),
                       'order' => array('modified' => 'desc'),
               
                    ); 
               }
               if($name)
               {
                   $this->paginate = array(
                     'conditions'=>array('id'=>array('$in'=> $batchid),'name' => $name),
                       'order' => array('modified' => 'desc'),
               
                    ); 
               }
               else
               {
                   $this->paginate = array(
                     'conditions'=>array('id'=>array('$in'=> $batchid)),
                       'order' => array('modified' => 'desc'),
               
                    ); 
               }
           
          
           $this->Batch->recursive = 1;
            $this->set('batches', $this->paginate());
            }else{
             $this->set('batches',"error");
            
            }
            
        }
        
        public function list_batches_for_dataanalyst($claimtype=null){
     
        }

        public function list_batches_for_claimsprocessor($claimtype=null){
            app::import('model','Log');
            $logobj                     =   new Log();
            $data                       =   array();
            $data['Log']['User']        =   $this->Session->read('Auth.User.id');
            $data['Log']['Object']          =   "";
            $data['Log']['Objectcategory']  =   "";
            $data['Log']['Header']      =   "User - Page access";
            $data['Log']['Desc']        =   "The user with user-id : ".$this->Session->read('Auth.User.id')." accessed the  page for listing batches for Claims Processor";
            $logobj->create();
            $logobj->save($data);
          $this->set('item',$claimtype);
          $this->Session->write('provider_code',trim($this->request->data['Search']['provider_code']));
          $this->Session->write('License',trim($this->request->data['Search']['License']));
          $this->Session->write('Name',trim($this->request->data['Search']['Name']));
          if($this->Session->read('provider_code')){
            $providerLicense   =   $this->getproviderlisense($this->Session->read('provider_code'));
            if($providerLicense){
                $this->Session->write('License',trim($providerLicense));
            }
          }
          app::import('model','ClaimsprocessorBatch');
              $ClaimsprocessorBatch  =   new ClaimsprocessorBatch();
          if(isset($claimtype)){
              
              $batchids =   $ClaimsprocessorBatch->find('all',array('fields'    =>  array('batch_id'),'conditions'    =>array('created'=>$this->getDateForSearch(),'user_id' =>  $this->Session->read("Auth.User.id"))));
              
              foreach ($batchids as $row)
              {
                  $batches[]    =   $this->Batch->find('all',array('fields'=>array('id'),  'conditions'=>array('status'=>new MongoInt64($claimtype),'id'    =>  $row['ClaimsprocessorBatch']['batch_id'])));
                  //$batches[]    =   $this->Batch->find('all',array('fields'=>array('id'),  'conditions'=>array('created'=>$this->getDateForSearch(),'status'=>new MongoInt64($claimtype),'id'    =>  $row['ClaimsprocessorBatch']['batch_id'])));
              }
              foreach ($batches as $batch)
              {
                  if(isset($batch[0]['Batch']['id']))
                  {
                      $batchid[]    =   $batch[0]['Batch']['id'];
                  }
              }
           }
           else{
              
               $batches    =   $ClaimsprocessorBatch->find('all',array('fields'=>array('batch_id'),'conditions'=>array('created'=>$this->getDateForSearch(),'user_id' =>  $this->Session->read("Auth.User.id"))));  
               //$batches    =   $ClaimsprocessorBatch->find('all',array('fields'=>array('batch_id'),'conditions'=>array('created'=>$this->getDateForSearch(),'created'=>$this->getDateForSearch(),'user_id' =>  $this->Session->read("Auth.User.id"))));  
               foreach ($batches as $batch)
               $batchid[]     =   trim($batch['ClaimsprocessorBatch']['batch_id']);
            }
           $claimprocessorbatches   =   $ClaimsprocessorBatch->find('all',array('fields'    =>  array('batch_id'),'conditions' => array('user_id' => $this->Session->read('Auth.User.id'))));
           foreach($claimprocessorbatches as $downloadbatchid)
           {    
                $downloadedbatch   = $this->Batch->find('all',array('fields'=>array('batch_id'),  'conditions'=>array('status'=>new MongoInt64(7),'id' => $downloadbatchid['ClaimsprocessorBatch']['batch_id'])));
                if(count($downloadedbatch)>0)
                {
                    $downloaded[]   =   $downloadedbatch;
                }
           }
           
            //$downloaded   = $this->Batch->find('all',array('fields'=>array('batch_id'),  'conditions'=>array('created'=>$this->getDateForSearch(),'status'=>new MongoInt64(7))));
           foreach($downloaded[0] as $download)
           {
               $downloadedbatches[]=$download;
           }
           $this->set('downloaded',$downloadedbatches);
            
            
           if($batchid) 
           {
               $licence     = $this->Session->read('License');
               $name        = $this->Session->read('Name');
               if($licence)
               {
                   $this->paginate = array(
                     'conditions'=>array('id'=>array('$in'=> $batchid),'provider_id' => $licence),
                       'order' => array('modified' => 'desc'),
                    ); 
               }
               if($name)
               {
                   $this->paginate = array(
                     'conditions'=>array('id'=>array('$in'=> $batchid),'name' => $name),
                       'order' => array('modified' => 'desc'),
                    ); 
               }
               if(!(($licence)||($name)))
               {
                    $this->paginate = array(
                        'conditions'=>array('id'=>array('$in'=> $batchid)),
                        'order' => array('modified' => 'desc'),
                    );
                }
                $this->Batch->recursive = 1;
                $this->set('batches', $this->paginate());
            }else{
             $this->set('batches',"error");
           }
          
          
          
        }

        
        
        public function getstatus($batchid=null){
            $this->Batch->id    =   $batchid;
            if($this->Batch->exists()){
                $batchdetails   =   $this->Batch->read(null,$batchid);
                switch($batchdetails['Batch']['status']){
                    case '0':
                         $status =   "Notnamed";
                    break;
                    case '1':
                         $status =   "named";
                    break;
                    case '2':
                         $status =   "withClaimsManager";
                    break;
                    case '3':
                         $status =   "withClaimsProcessor";
                    break;
                    case '4':
                         $status =   "withMedicalManager";
                    break;
                    case '5':
                         $status =   "onhold";
                    break;
                    case '6':
                         $status =   "complete";
                    break;
                    case '7':
                         $status =   "downloaded";
                    break;
                    case '8':
                         $status =   "withmedicalreceiver";
                    break;
                    case '10':
                         $status =   "assignedbacktoclaimsmanager";
                    break;
                }
            }
            return $status;
            $this->autoRender   =   FALSE;
        }
        
        public function getclaimstatus($id){
            
            
            $processed     =    $this->Batch->find('first',array('fields'=>array('status'),
                                    'conditions'=>array('Batch.id' => $id)
                            ));
            $this->autoRender=FALSE;
            return  intval($processed['Batch']['status']);
        }

        public function claimProcessorStatus($id){

            app::import('model','ClaimsprocessorBatch');
            $processed     =    $this->Batch->find('first',array('fields'=>array('status'),
                                    'conditions'=>array('id' => $id)
                            ));
            $this->autoRender=FALSE;
            return  intval($processed['Batch']['status']);
        }
        public function getonholdbatches(){
            $count  =   0;
            if($this->Session->read('Auth.User.id')!=""){
                $count  =   $this->Batch->find('count',array('conditions'    =>  array('onhold_by' => $this->Session->read('Auth.User.id'),'status' => 5)));
                return $count;
            }else{
                return 0;
            }
        }

        public function claimProcessorHoldStatus($id){

            app::import('model','ClaimsprocessorBatch');
            $ClaimsprocessorBatchobj  =   new ClaimsprocessorBatch();
            $processed     = $ClaimsprocessorBatchobj->find('first',array('fields'=>array('onhold'),
                                    'conditions'=>array('batch_id' => $id)
                            ));
            $this->autoRender=FALSE;
            return  intval($processed['ClaimsprocessorBatch']['onhold']);
        }
        
        public function getclaimcountforbatch($batchid){
            app::import('model','BatchesClaim');
            $BatchesClaimobj    =    new BatchesClaim();
            return $BatchesClaimobj->find('count',array('conditions'=>array('BatchesClaim.batch_id'=>$batchid)));
            $this->autoRender=FALSE;
            $this->layout   =   'ajax';
            
        }
        
        
        public function Assign_to_claims_processor($batchid=null,$status=null){
            $this->Batch->id    =   $batchid;
            app::import('model','ClaimsprocessorBatch');
            $ClaimsprocessorBatchobj  =   new ClaimsprocessorBatch();
            if(isset($batchid))
            {
                    $var = $ClaimsprocessorBatchobj->find('all',array('conditions'=>array('ClaimsprocessorBatch.batch_id'=>$batchid),'fields'=>array('ClaimsprocessorBatch.user_id')));
                    $this->set('selected',$var[0]['ClaimsprocessorBatch']['user_id']);
            }
            if ($this->request->is('post') || $this->request->is('put')) {
                if($ClaimsprocessorBatchobj->find('count',array('conditions' => array('batch_id' => $batchid)))>0)
                {
                    $ClaimsprocessorBatchobj->id=  $this->request->data['Batch']['id'];
                    if($ClaimsprocessorBatchobj->updateAll(array('user_id' => $this->request->data['Batch']['User_id']),array('ClaimsprocessorBatch.batch_id' => $this->request->data['Batch']['id'])))
                    {
                        $batchdetails   =   $this->Batch->find('first',array('conditions' => array('id' => $batchid)));
                        if($batchdetails['Batch']['status']==10){
                            $this->Batch->id    =   $batchid;
                            $this->Batch->save(array('Batch' => array('status' => 3,'id' => $batchid)));
                        }
                        $this->Session->setFlash("The Claims processor has been changed");
                        app::import('model','User');
                        app::import('model','Log');
                        $userobj                        =   new User();
                        $userdetails                    =   $userobj->find('first',array('conditions' => array('id' => $this->request->data['Batch']['User_id'])));
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $batchid;
                        $data['Log']['Objectcategory']  =   "batch";
                        $data['Log']['Header']          =   "Assigning the batch";
                        $data['Log']['Desc']            =   "The batch ".$batchdetails['Batch']['name']." is assigned to : ".$userdetails['User']['username']." by ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                        $this->redirect(array('action'=>'list_batches_for_claimsmanager'));
                        
                    }
                }
                if($this->request->data['Batch']['User_id']=="")
                    {
                        $this->Session->setFlash("Please choose a claim processor");
                        $this->redirect(array('action'=>'assign_to_claims_processor',$batchid));
                    }
                    $claimsmanagerdetails  =    array();
                    if($this->request->data['Batch']['ClaimsprocessorBatchid']!=""){
                        $claimsmanagerdetails['ClaimsprocessorBatch']['id']     =   $this->request->data['Batch']['ClaimsprocessorBatchid'];
                    }
                  
                    
                    $claimsmanagerdetails['ClaimsprocessorBatch']['batch_id']   =   $this->request->data['Batch']['id'];
                    $claimsmanagerdetails['ClaimsprocessorBatch']['group_id']   =   $this->request->data['Batch']['Assign_to'];
                    $claimsmanagerdetails['ClaimsprocessorBatch']['user_id']    =   $this->request->data['Batch']['User_id'];
                    $claimsmanagerdetails['ClaimsprocessorBatch']['Assigned_by']=   $this->Session->read('Auth.User.id');
                    if($ClaimsprocessorBatchobj->save($claimsmanagerdetails))
                    {
                        $batchdetails   =   $this->Batch->find('first',array('conditions' => array('id' => $batchid)));
                        app::import('model','User');
                        $userobj        =   new User();
                        $userdetails    =   $userobj->find('first',array('conditions' => array('id' => $this->request->data['Batch']['User_id'])));
                        $this->Batch->saveField('status', 3);  
                        $this->Session->setFlash("Batch has been assigned to claims manager");
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $batchid;
                        $data['Log']['Objectcategory']  =   "batch";
                        $data['Log']['Header']          =   "Assigning the batch";
                        $data['Log']['Desc']            =   "The batch ".$batchdetails['Batch']['name']." is assigned to : ".$userdetails['User']['username']." by ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                      $this->redirect(array('action'=>'list_batches_for_claimsmanager'));
                    }else{
                        die("could not save");
                    }
                    
                }
            if($this->Batch->exists()){
                 if($status ==  2)
                 {
                     $this->Session->setFlash("Choose a different claims processor from the dropdown");
                 }
                $assineddetails     =   $ClaimsprocessorBatchobj->find('first',array('conditions'=>array('batch_id'=>$batchid)));
                $batchdetails   =   $this->Batch->read(null,$batchid);
                if(!trim($batchdetails['Batch']['name'])){
                    $this->Session->setFlash("Before assigning to claims manager, you have to assign a batch name");
                    $this->redirect(array('action'=>'edit',$batchid));
                }
                app::import('model','User'); 
                $userobj         =      new User();
                $claimsmanager   =   $userobj->find('list',array('fields'=>array('id','username'),'conditions'=>array('group_id'=>'16')));
                app::import('model','User');
                $userobj            =   new User();
                $claimsProcessors   =   $userobj->find('list',array('fields'=>array('id','username'),'conditions'=>array('group_id'=>'17')));
                
                $this->set(compact('claimsmanager','batchdetails','assineddetails','claimsProcessors','status'));
            }else{
                throw new NotFoundException('Batch id not present!');
            }
        }
        

        public function assignBackToClaimsManager($id=null,$url=null)
        {
             $userid            = $this->Session->read('Auth.User.id');
             $this->Batch->id   = trim($id);
                if($this->Batch->exists())
                {
                        app::import('model','MedicalreceiverBatch');
                        $MedicalreceiverBatchobj  =   new MedicalreceiverBatch();
                        app::import('model','ClaimsmanagerBatch');
                        $claimsmanagerbatchobj    =   new ClaimsmanagerBatch();
                        $this->Batch->id   =   $id;
                        $this->Batch->save(array('Batch'=>array('id'=>$id,'status'=>10)));
                        $this->Session->setFlash("assigned");
                        $batchdetails      =    $claimsmanagerbatchobj->find('first',array('conditions'     =>  array('batch_id'    =>  $id)));
                        $claimsmanagerbatchobj->save(array('id'  =>  $batchdetails['ClaimsmanagerBatch']['id'],'Assigned_by' => $userid));
                        app::import('model','Log');
                        $batchvalues                    =   $this->Batch->find('first',array('conditions' => array('id' => $id)));
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $id;
                        $data['Log']['Objectcategory']  =   "batch";
                        $data['Log']['Header']          =   "Assigning the batch";
                        $data['Log']['Desc']            =   "The batch ".$batchvalues['Batch']['name']." is assigned to : claims manager by ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                        
                        if(isset($url))
                        {
                            $this->redirect(array('controller'=>'batches','action'=>$url));
                        }
                        $this->redirect(array('controller'=>'batches','action'=>'listbatchesformedicalreceiver'));
                    
                }else{
                        $this->Session->setFlash("Failed to assign the task to Claims Processor");
                }   

        }
        
        public function Assign_to_medical_receiver($batchid=null){
           $this->Batch->id    =   $batchid;
            app::import('model','MedicalreceiverBatch');
            $MedicalreceiverBatchobj  =   new MedicalreceiverBatch();
            if ($this->request->is('post') || $this->request->is('put')) {
                
                    if($this->request->data['Batch']['User_id']=="")
                    {
                        $this->Session->setFlash("Please choose a medical receiver");
                        $this->redirect(array('action'=>'assign_to_medical_receiver',$batchid));
                    }
                    $MedicalreceiverBatchdetails  =    array();
                    $batchdetails   =   $MedicalreceiverBatchobj->find('count',array('conditions'   =>  array('batch_id' => $batchid)));
                    if($batchdetails > 0)
                    {
                       if($MedicalreceiverBatchobj->updateAll(array('user_id' => $this->request->data['Batch']['User_id']),array('MedicalreceiverBatch.batch_id' => $this->request->data['Batch']['id'])))
                        {
                            $this->Batch->saveField('status', 8);
                            $batchvalues                    =   $this->Batch->find('first',array('conditions' => array('id' => $batchid)));
                            $this->Session->setFlash("The medical reviewer has been changed");
                            $logobj                         =   new Log();
                            app::import('model','User');
                            $userobj                        =   new User();
                            $userdata                       =   $userobj->find('first',array('conditions' => array('id' => $this->request->data['Batch']['User_id'])));
                            $data                           =   array();
                            $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                            $data['Log']['Object']          =   $batchid;
                            $data['Log']['Objectcategory']  =   "batch";
                            $data['Log']['Header']          =   "Assigning the batch";
                            $data['Log']['Desc']            =   "The batch ".$batchvalues['Batch']['name']." is assigned to ".$userdata['User']['username']."  by ".$this->Session->read('Auth.User.username');
                            $logobj->create();
                            $logobj->save($data);
                            $this->redirect(array('action'=>'listbatchesformedicalmanager'));
                        } 
                    }
                    
                    if($this->request->data['Batch']['MedicalreceiverBatch']!=""){
                        $MedicalreceiverBatchdetails['MedicalreceiverBatch']['id']          =   $this->request->data['Batch']['id'];
                    }
                    $MedicalreceiverBatchdetails['MedicalreceiverBatch']['batch_id']        =   $this->request->data['Batch']['id'];
                    $MedicalreceiverBatchdetails['MedicalreceiverBatch']['group_id']        =   $this->request->data['Batch']['Assign_to'];
                    $MedicalreceiverBatchdetails['MedicalreceiverBatch']['user_id']         =   $this->request->data['Batch']['User_id'];
                    $MedicalreceiverBatchdetails['MedicalreceiverBatch']['Assigned_by']     =   $this->Session->read('Auth.User.id');
                    if($MedicalreceiverBatchobj->save($MedicalreceiverBatchdetails))
                    {
                        $this->Batch->saveField('status', 8); 
                        $logobj                         =   new Log();
                        $batchdetails                   =   $this->Batch->find('first',array('conditions' => array('id' => $batchid)));
                        app::import('model','User');
                        $userobj                        =   new User();
                        $userdata                       =   $userobj->find('first',array('conditions' => array('id' => $this->request->data['Batch']['User_id'])));
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $batchid;
                        $data['Log']['Objectcategory']  =   "batch";
                        $data['Log']['Header']          =   "Assigning the batch";
                        $data['Log']['Desc']            =   "The batch ".$batchdetails['Batch']['name']." is assigned to ".$userdata['User']['username']."  by ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                      $this->Session->setFlash("Batch has been assigned to Medical receiver");
                      $this->redirect(array('action'=>'listbatchesformedicalmanager'));
                    }else{
                        die("could not save");
                    }
                }
            if($this->Batch->exists()){
                 
                $assineddetails     =   $MedicalreceiverBatchobj->find('first',array('conditions'=>array('batch_id'=>$batchid)));
                $batchdetails   =   $this->Batch->read(null,$batchid);
                if(!trim($batchdetails['Batch']['name'])){
                    $this->Session->setFlash("Before assigning to Medical receiver, you have to assign a batch name!!");
                    $this->redirect(array('action'=>'edit',$batchid));
                }
                app::import('model','User');
                $userobj         =      new User();
                $mediacalmanager   =   $userobj->find('list',array('fields'=>array('id','username'),'conditions'=>array('group_id'=>'19')));
                app::import('model','User');
                $userobj            =   new User();
                $medicalreceiver   =   $userobj->find('list',array('fields'=>array('id','username'),'conditions'=>array('group_id'=>'20')));
                $this->set(compact('mediacalmanager','batchdetails','assineddetails','medicalreceiver'));
            }else{
                throw new NotFoundException('Batch id not present!');
            }
            
           
           
       } 
        
        public function Assign_to_claims_manager($batchid=null){
            $userid             =   $this->Session->read('Auth.User.id');
            $this->Batch->id    =   $batchid;
            app::import('model','ClaimsmanagerBatch');
            $ClaimsmanagerBatchobj  =   new ClaimsmanagerBatch();
            if ($this->request->is('post') || $this->request->is('put')) {
                    $claimsmanagerdetails  =    array();
                    if($this->request->data['Batch']['ClaimsmanagerBatchid']!=""){
                        $claimsmanagerdetails['ClaimsmanagerBatch']['id']     =   $this->request->data['Batch']['ClaimsmanagerBatchid'];
                    }
                    $claimsmanagerdetails['ClaimsmanagerBatch']['batch_id']     =   $this->request->data['Batch']['id'];
                    $claimsmanagerdetails['ClaimsmanagerBatch']['group_id']     =   $this->request->data['Batch']['Assign_to'];
                    $claimsmanagerdetails['ClaimsmanagerBatch']['Assigned_by']  =   $userid;
                    if($ClaimsmanagerBatchobj->save($claimsmanagerdetails))
                    {
                        $this->Batch->saveField('status', 2);
                        $this->Session->setFlash("Batch has been assigned to claims manager");
                        app::import('model','Log');
                        $batchdetails                   =   $this->Batch->find('first',array('conditions' => array('id' => $batchid)));
                        app::import('model','User');
                        $userobj                        =   new User();
                        $userdetails                    =   $userobj->find('first',array('conditions' => array('id' => $this->request->data['Batch']['Assign_to'])));
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $batchid;
                        $data['Log']['Objectcategory']  =   "batch";
                        $data['Log']['Header']          =   "Assigning the batch";
                        $data['Log']['Desc']            =   "The batch ".$batchdetails['Batch']['name']." is assigned to ".$userdetails['User']['username']."  by ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                        $this->redirect(array('action'=>'index'));
                    }else{
                        die("could not save");
                    }
                }
            if($this->Batch->exists()){
                $assineddetails     =   $ClaimsmanagerBatchobj->find('first',array('conditions'=>array('batch_id'=>$batchid)));
                $batchdetails       =   $this->Batch->read(null,$batchid);
                
                if(!isset($batchdetails['Batch']['name'])){
                    $this->Session->setFlash("Before assigning to claims manager, you have to assign a batch name");
                    $this->redirect(array('action'=>'batchname',$batchid));
                    exit;
                    
                }
               
                app::import('model','User');
                $userobj         =      new User();
                $claimsmanager   =      $userobj->find('list',array('fields'=>array('id','username'),'conditions'=>array('group_id'=>16)));
                $this->set(compact('claimsmanager','batchdetails','assineddetails'));
            }else{
                throw new NotFoundException('Batch id not present!');
            }
            
        }
        
        public function getbatchstatus($batchid=null,$status=null)
        {
            if(($status==2)||($status==10))
            {
                
                app::import('model','ClaimsmanagerBatch');
                $claimsmanagerbatchobj      =   new ClaimsmanagerBatch();
                $userid                     =   $claimsmanagerbatchobj->find('first',array('conditions' =>  array('batch_id'    =>  $batchid)));
                app::import('model','User');
                $userobj                    =   new User();
                $userdetails                =   $userobj->find('first',array('conditions'   =>  array('group_id'    =>  $userid['ClaimsmanagerBatch']['group_id']."")));
                return $userdetails['User']['username'];
                
            }
            if(($status==3)||($status==7))
            {
                app::import('model','ClaimsprocessorBatch');
                $claimsprocessorbatchobj      =   new ClaimsprocessorBatch();
                $userid                     =   $claimsprocessorbatchobj->find('first',array('conditions' =>  array('batch_id'    =>  $batchid)));
                app::import('model','User');
                $userobj                    =   new User();
                $userdetails                =   $userobj->find('first',array('conditions'   =>  array('id'    =>  $userid['ClaimsprocessorBatch']['user_id']."")));
                return $userdetails['User']['username']; 
            }
            if($status==4)
            {
                app::import('model','MedicalmanagerBatch');
                $medicalmanagerbatchobj      =   new MedicalmanagerBatch();
                $userid                     =   $medicalmanagerbatchobj->find('first',array('conditions' =>  array('batch_id'    =>  $batchid)));
                app::import('model','User');
                $userobj                    =   new User();
                $userdetails                =   $userobj->find('first',array('conditions'   =>  array('group_id'    =>  $userid['MedicalmanagerBatch']['group_id']."")));
                return $userdetails['User']['username'];
            }
            if($status==5)
            {
                return "OnHold";
            }
            if($status==6)
            {
                return "Success";
            }
            if($status==8)
            {
                app::import('model','MedicalreceiverBatch');
                $medicalreceiverbatchobj      =   new MedicalreceiverBatch();
                $userid                     =   $medicalreceiverbatchobj->find('first',array('conditions' =>  array('batch_id'    =>  $batchid)));
                app::import('model','User');
                $userobj                    =   new User();
                $userdetails                =   $userobj->find('first',array('conditions'   =>  array('id'    =>  $userid['MedicalreceiverBatch']['user_id']."")));
                return $userdetails['User']['username']; 
            }
        }


        public function getStatusvalue($batchstatus=null,$image=null,$controller=null,$method=null,$choice=null,$batchid=null)
        {
            
            app::import('HtmlHelper');
            
            //$html   =   new HtmlHelper();
            
            $this->autoRender=false;
            if(isset($batchstatus))
            {
                $group=$this->Session->read('Auth.User.group_id');
                switch ($group)
                {
                    case 15:
                        if(($batchstatus == 0)||($batchstatus==1))
                        {
                           // echo $html->link($html->image('assign.png',array('title'=>'view xmldetails')), array('controller'=>'Batches','action' => 'Assign_to_claims_manager', $batch['Batch']['id']),array('escape'=>FALSE));
                            $link   =    '<a href="'.Router::url('/', true).$controller.'/'.$method.'"><img src="'.Router::url('/',true).'img/'.$image.'"></a>';
                            return $link;                
                            }
                        else
                        {
                            return $this->getbatchstatus($choice,$batchstatus);
                        }
                    break;
                    case 16:
                        if($batchstatus == 2 or $batchstatus == 10)
                        {
                            $link   =    '<a href="'.Router::url('/', true).$controller.'/'.$method.'"><img src="'.Router::url('/',true).'img/'.$image.'" ></a>';
                            return $link; 
                        }
                        else if($batchstatus == 5)
                        {
                            return "On Hold";
                        }
                        else
                        {   
                            if($controller  ==  'Batches'){
                                return $this->getbatchstatus($choice,$batchstatus).'<br><br><a href="'.Router::url('/', true).$controller.'/'.$method.'"><img src="'.Router::url('/',true).'img/'.$image.'" ></a>';
                            }
                            else
                            {
                                return $this->getbatchstatus($choice,$batchstatus);
                            }
                        }
                    case 17:

                        if(($batchstatus == 3) OR ($batchstatus==7) )
                        {
                            $link   =    '<a href="'.Router::url('/', true).$controller.'/'.$method.'"><img src="'.Router::url('/',true).'img/'.$image.'"></a>';
                            return $link;
                        }
                        else 
                        {
                            return $this->getbatchstatus($choice,$batchstatus);
                        }
                    break;
                    case 19:
                        if($batchstatus == 4)
                        {
                            if($choice==1) 
                                    $link   =    '<a href="'.Router::url('/', true).$controller.'/'.$method.'"><img src="'.Router::url('/',true).'img/'.$image.'"></a>';
                            else
                                    $link   =    '<a href="'.Router::url('/', true).$controller.'/'.$method.'"><img src="'.Router::url('/',true).'img/'.$image.'"></a>';
                            return $link;
                        }
                        
                        else 
                        {
                            if($choice==1)
                                return $this->getbatchstatus($batchid,$batchstatus);
                            else
                                return $this->getbatchstatus($batchid,$batchstatus).'<br><br><a href="'.Router::url('/', true).$controller.'/'.$method.'"><img src="'.Router::url('/',true).'img/'.$image.'"></a>';
                        }
                    case 20:
                        if($batchstatus == 8)
                        {
                            $link   =    '<a href="'.Router::url('/', true).$controller.'/'.$method.'"><img src="'.Router::url('/',true).'img/'.$image.'"></a>';
                            return $link;
                        }
                        else 
                        {
                           return $this->getbatchstatus($choice,$batchstatus);
                        }
                    break;
                   }
            }
            else
            {
               return "Invalid operation";
            }
        }
        public function getproviderlisense($lisense){
            app::import('Model',  'Providerdetail');
            $providerdetailObj  =   new Providerdetail();
            $provider           =   $providerdetailObj->find('first',array('conditions'=>array('code'=>$lisense)));
            return $provider['Providerdetail']['licence'];            
        }
        
        public function resubmissionbatches(){
            app::import('model','Log');
            $logobj                         =   new Log();
            $data                           =   array();
            $data['Log']['User']            =   $this->Session->read('Auth.User.id');
            $data['Log']['Object']          =   "";
            $data['Log']['Objectcategory']  =   "";
            $data['Log']['Header']          =   "User - Page access";
            $data['Log']['Desc']            =   $this->Session->read('Auth.User.username')." accessed the  page for listing resubmissionbatches";
            $logobj->save($data);
            $this->Session->write('resubmission','yes');
            $this->redirect(array('action' => 'list_batches_for_claimsmanager'));
        }
        public function list_allbatches_for_claimsmanager(){
            $this->Session->write('resubmission','no');
            $this->redirect(array('action' => 'list_batches_for_claimsmanager'));
        }
	public function index($claimtype=null) {
            app::import('model','Log');
            $logobj                         =   new Log();
            $data                           =   array();
            $data['Log']['User']            =   $this->Session->read('Auth.User.id');
            $data['Log']['Object']          =   "";
            $data['Log']['Objectcategory']  =   "";
            $data['Log']['Header']          =   "User - Page access";
            $data['Log']['Desc']            =   $this->Session->read('Auth.User.username')." accessed the index page for batches";
            $logobj->create();
            $logobj->save($data);
            $this->set('item',$claimtype);
            
            $this->Session->write('provider_code',trim($this->request->data['Search']['provider_code']));
            $this->Session->write('License',trim($this->request->data['Search']['License']));
            $this->Session->write('Name',trim($this->request->data['Search']['Name']));
            if($this->Session->read('provider_code')){
                $providerLicense   =   $this->getproviderlisense($this->Session->read('provider_code'));
                if($providerLicense){
                       $this->Session->write('License',trim($providerLicense));
                }
            }
            if(!isset($claimtype)){
                
                    $pagination     =   
                    $this->paginate = array(
                      'order' => array('modified' => 'desc'),                  
                      'conditions'=>array('created'=>$this->getDateForSearch())
                    ); 
                if($this->Session->read('License')){
                   
                    $this->paginate = array(
                      'order' => array('modified' => 'desc'),                  
                      'conditions'=>array('provider_id'=>$this->Session->read('License'), 'created'=>$this->getDateForSearch())
                    ); 
                }
                if($this->Session->read('Name')){
                    
                    $this->paginate = array(
                      'order' => array('modified' => 'desc'),                  
                      'conditions'=>array('name'=>$this->Session->read('Name'), 'created'=>$this->getDateForSearch())
                    ); 
                }
            }else if($claimtype==2){
                
                    $this->paginate = array(  'order' => array('modified' => 'desc'),'conditions' =>array('status'=>array('$gte' =>  new MongoInt64($claimtype))));
                if($this->Session->read('License')){
                   
                   $this->paginate = array(
                      'order' => array('modified' => 'desc'),                  
                      'conditions'=>array('provider_id'=>$this->Session->read('License'), 'created'=>$this->getDateForSearch(),'status'=>array('$gte' =>  new MongoInt64($claimtype)))
                    ); 
                }
                if($this->Session->read('Name')){
                    
                   $this->paginate = array(
                      'order' => array('modified' => 'desc'),                  
                      'conditions'=>array('name'=>$this->Session->read('Name'), 'created'=>$this->getDateForSearch(),'status'=>array('$gte' =>  new MongoInt64($claimtype)))
                    ); 
                }
                
            }
            else
            {
                
                 $this->paginate = array(
                       'order' => array('modified' => 'desc'),   
                     'conditions'=>array('status'=>new MongoInt64($claimtype))
                    );
                 if($this->Session->read('License')){
                     
                   $this->paginate = array(
                      'order' => array('modified' => 'desc'),                  
                      'conditions'=>array('provider_id'=>$this->Session->read('License'), 'status'=>new MongoInt64($claimtype),'created'=>$this->getDateForSearch())
                     );
                }
                 if($this->Session->read('Name')){
                     
                        $this->paginate = array(
                           'order' => array('modified' => 'desc'),                  
                           'conditions'=>array('name'=>$this->Session->read('Name'), 'status'=>new MongoInt64($claimtype),'created'=>$this->getDateForSearch())
                         ); 
                }
            }   
            
                $this->Batch->recursive = 1;
		$this->set('batches', $this->paginate());
                
	}

        public function getcount($date=null)
        { 

            $claims    = $this->Batch->find('count',array('conditions'=>array('created'=>$this->getDateForSearch('Batch'))));
           
            return $claims;
           
        }
        public function resubmission()
        {
            $count      =   $this->Batch->find('count',array('conditions' => array ('resubmission' => 1,'created'=>$this->getDateForSearch('Batch'))));
            return $count;
        }
        public function deletebatch(){
            $params = array(
			'conditions' => array('created' => $this->getDateForConsoleSearch()),
                
			
                    );
            
              $savedxml = $this->Batch->find('all',$params);
              foreach($savedxml as $key=>$val){
                  
                  if($savedxml = $this->Batch->delete($val['Batch']['id']))
                          echo "de";
                  exit;
                  
                  
              }
              
               
            
            $this->autoRender=FALSE;
        }




        /**

 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Batch->id = $id;
		if (!$this->Batch->exists()) {
			throw new NotFoundException(__('Invalid batch'));
		}
		$this->set('batch', $this->Batch->read(null, $id));
	}

        public function checkactiveprovider($providerid){
            
            App::import('model', 'Providerdetail');
            $Providerdetailobj  =   new Providerdetail();
            $provider           =   $Providerdetailobj->find('count',array('conditions'=>array('licence'=>$providerid,'active'=>1)));
            
            if($provider>0)
                return true;
            else
                return false;
        }
        
        public function createnewbatches($email=null){
        
        echo "Starting function to createbatch \n";
        $this->autoRender = false;
        app::import('model', 'xmllisting');
        $xmlobj = new Xmllisting();
        $xmlobj->Recursive = -1;
        $xmlobj->Claim->recursive = 0;
        $params = array(
                        'conditions' => array('created' =>$this->getDateForConsoleSearch(),'claim.markedresubmission'=>0),'fields'=>array('Claim.claim.ProviderID','Claim.xmllisting_id')
	            );
	if(isset($email))
	{
		$params['conditions']['xmllisting_id'] = $email;
	}
        $providerarray  =   array();
        
        $claimcount = $xmlobj->Claim->find('all',$params); 
        if($claimcount==0){
            return true;
        }
        $claims = $xmlobj->Claim->find('all',$params);  
        $providerxmllistingid   =   array();
        $count                  =   0;
        foreach ($claims as $key => $val){
             if($this->checkactiveprovider($val['Claim']['claim']['ProviderID']))
             {
                 echo "Active provider";
                 $checkarray    =   array('xmllisting_id' => $val['Claim']['xmllisting_id'],'provider_id' => $val['Claim']['claim']['ProviderID']);
                 if(!in_array($checkarray, $providerarray)){
                     $providerarray[] =   array('xmllisting_id' => $val['Claim']['xmllisting_id'],'provider_id' => $val['Claim']['claim']['ProviderID']);
                 }
                 $providerClaimid[$val['Claim']['xmllisting_id']][]  =   $val['Claim']['id'];
                 if(!array_key_exists($val['Claim']['xmllisting_id'], $providerxmllistingid))
                        $providerxmllistingid[$val['Claim']['xmllisting_id']] =array();
                 if(!in_array($val['Claim']['xmllisting_id'],$providerxmllistingid[$val['Claim']['xmllisting_id']])){
                        "collected ".$val['Claim']['xmllisting_id']." \n";
                        if(!in_array($val['Claim']['xmllisting_id'], $providerxmllistingid[$val['Claim']['xmllisting_id']][$val['Claim']['claim']['ProviderID']])){
                            $providerxmllistingid[$val['Claim']['xmllisting_id']][$val['Claim']['claim']['ProviderID']][]=$val['Claim']['xmllisting_id'];
                        }
                    }
             }
        }
        foreach ($providerarray as $key => $value) {
            $batch['batch'][] = array('provider_id' =>$value['provider_id'],"resubmission_status" => 0,'status'=>0,'xmllisting_id' => $value['xmllisting_id']);
        } 
        
        echo "number of batches found today ." . count($batch['batch']);
        foreach ($batch['batch'] as $val) {
//            $batchid    ;
            $this->Batch->create();
            
            if ($this->Batch->save($val)) {
               $batchid = $this->Batch->getLastInsertID();
                $hasmanyclaims = array();
                foreach ($providerClaimid[$val['xmllisting_id']] as $claimdetails) {
                    $hasmanyclaims[] = array(
                        'batch_id' => $batchid,
                        'claim_id' => $claimdetails,
                    );
                }
            }
            
            app::import('model', 'BatchesClaim');
            $batchclaims = new BatchesClaim();
            if ($batchclaims->saveAll($hasmanyclaims))
                echo "all batches created \n";
        }
        $params = array('conditions' => array('created' =>$this->getDateForConsoleSearch()));
        $batchestoday = $this->Batch->find('all', $params);
        $batchlisting = array();
        $trimmeddate = trim(date("Ymd"));
        if (!is_dir(WWW_ROOT . "files/batch/" . $trimmeddate)) {
            mkdir(WWW_ROOT . "files/batch/" . $trimmeddate,0755);
        }
        chmod(WWW_ROOT . "files/batch/",0755);
        $date = trim(date("Ymd"));
        
        foreach ($providerxmllistingid as $xmllistingid){
            foreach($xmllistingid as $bname => $xmllist){
                $zip_name = "batch_id_" . $bname . "_files_".$xmllist[0].".zip";
                $file_dir   =   $xmllist[0];
            }
            $zipobject              =   new ZipArchive();
            $zipobjectfolder        =   $zipobject->open(WWW_ROOT . "files/batch/" . $trimmeddate . '/' . $zip_name, ZipArchive::OVERWRITE);
            $handle = opendir(WWW_ROOT."files/splited/".$trimmeddate."/".$file_dir);
            
            while (false !== ($entry = readdir($handle))) {
                    echo $entry."\n";
                    if(($entry == '.')OR ($entry == '..'))
                    {
                        echo "Directory files";
                    }
                    else{
                        $zipobject->addFile(WWW_ROOT."files/splited/".$trimmeddate."/".$file_dir."/".$entry,$zip_name."/".$entry);
                    }
            }
            app::import('model','Xmllisting');
            $xmllistingobj      =   new Xmllisting();
            $masterfile         =   $xmllistingobj->find('first',array('conditions' => array('id' => $file_dir)));
            if(isset($masterfile['Xmllisting']['xml_url']))
                $zipobject->addFile(WWW_ROOT."files/xmlunprocessed/".$trimmeddate."/".$masterfile['Xmllisting']['xml_url'],$zip_name."/".$masterfile['Xmllisting']['xml_url']);
            else
               $zipobject->addFile(WWW_ROOT."files/Emailxmls/".$masterfile['Xmllisting']['url'],$zip_name."/".$masterfile['Xmllisting']['url']); 
        }
        chmod(WWW_ROOT.'files/batch/'.$date,0777);
       
    }  
    
    
   //resubmission
    
    public function createnewresubmissionbatches($email=null){
        
        echo "Starting function to createbatch \n";
        $this->autoRender = false;
        app::import('model', 'xmllisting');
        $xmlobj = new Xmllisting();
        $xmlobj->Recursive = -1;
        $xmlobj->Claim->recursive = 0;
        $params = array(
                        'conditions' => array('created' =>$this->getDateForConsoleSearch(),'claim.markedresubmission'=>1),'fields'=>array('Claim.claim.ProviderID','Claim.xmllisting_id')
	            );
	if(isset($email))
	{
		$params['conditions']['xmllisting_id'] = $email;
	}
        $providerarray  =   array();
        
        $claimscount = $xmlobj->Claim->find('count',$params); 
        if($claimscount==0)
            return true;
        $claims = $xmlobj->Claim->find('all',$params); 
        
        
        $providerxmllistingid   =   array();
        $count                  =   0;
        foreach ($claims as $key => $val){
             if($this->checkactiveprovider($val['Claim']['claim']['ProviderID']))
             {
                 echo "Active provider";
                 $checkarray    =   array('xmllisting_id' => $val['Claim']['xmllisting_id'],'provider_id' => $val['Claim']['claim']['ProviderID']);
                 if(!in_array($checkarray, $providerarray)){
                     $providerarray[] =   array('xmllisting_id' => $val['Claim']['xmllisting_id'],'provider_id' => $val['Claim']['claim']['ProviderID']);
                 }
                 $providerClaimid[$val['Claim']['xmllisting_id']][]  =   $val['Claim']['id'];
                 if(!array_key_exists($val['Claim']['xmllisting_id'], $providerxmllistingid))
                        $providerxmllistingid[$val['Claim']['xmllisting_id']] =array();
                 if(!in_array($val['Claim']['xmllisting_id'],$providerxmllistingid[$val['Claim']['xmllisting_id']])){
                        "collected ".$val['Claim']['xmllisting_id']." \n";
                        if(!in_array($val['Claim']['xmllisting_id'], $providerxmllistingid[$val['Claim']['xmllisting_id']][$val['Claim']['claim']['ProviderID']])){
                            $providerxmllistingid[$val['Claim']['xmllisting_id']][$val['Claim']['claim']['ProviderID']][]=$val['Claim']['xmllisting_id'];
                        }
                    }
             }
        }
        
        foreach ($providerarray as $key => $value) {
            $batch['batch'][] = array('provider_id' =>$value['provider_id'],"resubmission_status" => 0,'status'=>0,'xmllisting_id' => $value['xmllisting_id']);
        } 
        
        echo "number of batches found today ." . count($batch['batch']);
        foreach ($batch['batch'] as $val) {
            $batchid    ;
            $this->Batch->create();
            if ($this->Batch->save($val)) {
               $batchid = $this->Batch->getLastInsertID();
                $hasmanyclaims = array();
                foreach ($providerClaimid[$val['xmllisting_id']] as $claimdetails) {
                    $hasmanyclaims[] = array(
                        'batch_id' => $batchid,
                        'claim_id' => $claimdetails,
                    );
                }
            }
            
            app::import('model', 'BatchesClaim');
            $batchclaims = new BatchesClaim();
            if ($batchclaims->saveAll($hasmanyclaims))
                echo "all batches created \n";
        }
        $params = array('conditions' => array('created' =>$this->getDateForConsoleSearch()));
        $batchestoday = $this->Batch->find('all', $params);
        $batchlisting = array();
        $trimmeddate = trim(date("Ymd"));
        if (!is_dir(WWW_ROOT . "files/batch/" . $trimmeddate)) {
            mkdir(WWW_ROOT . "files/batch/" . $trimmeddate,0755);
        }
        chmod(WWW_ROOT . "files/batch/",0755);
        $date = trim(date("Ymd"));
        
        
        print_r($providerxmllistingid);
        foreach ($providerxmllistingid as $xmllistingid){
            foreach($xmllistingid as $bname => $xmllist){
                $zip_name = "batch_id_" . $bname . "_resubmission_files_".$xmllist[0].".zip";
                $file_dir   =   $xmllist[0];
            }
            $zipobject              =   new ZipArchive();
            $zipobjectfolder        =   $zipobject->open(WWW_ROOT . "files/batch/" . $trimmeddate . '/' . $zip_name, ZipArchive::OVERWRITE);
            $handle = opendir(WWW_ROOT."files/splited/".$trimmeddate."/".$file_dir);
            
            while (false !== ($entry = readdir($handle))) {
                    echo $entry."\n";
                    if(($entry == '.')OR ($entry == '..'))
                    {
                        echo "Directory files";
                    }
                    else{
                        $zipobject->addFile(WWW_ROOT."files/splited/".$trimmeddate."/".$file_dir."/".$entry,$zip_name."/".$entry);
                    }
            }
            app::import('model','Xmllisting');
            $xmllistingobj      =   new Xmllisting();
            $masterfile         =   $xmllistingobj->find('first',array('conditions' => array('id' => $file_dir)));
            if(isset($masterfile['Xmllisting']['xml_url']))
                $zipobject->addFile(WWW_ROOT."files/xmlunprocessed/".$trimmeddate."/".$masterfile['Xmllisting']['xml_url'],$zip_name."/".$masterfile['Xmllisting']['xml_url']);
            else
               $zipobject->addFile(WWW_ROOT."files/Emailxmls/".$masterfile['Xmllisting']['url'],$zip_name."/".$masterfile['Xmllisting']['url']); 
        }
        chmod(WWW_ROOT.'files/batch/'.$date,0777);
    }  
    
    
  
    
  
 public function createXMlInpatient($claimsArray, $headervalues, $batch,$typename,$xmlistings){
     
     

     foreach ($claimsArray as $benefit => $claims) {
            $benefitname = $benefit;
            $dom = new DOMDocument('1.0', "UTF-8");
            $dom->formatOutput = true;
            $xmllistingsclaims = $dom->appendChild(new DOMElement('Claim.Submission'));
            $attr1 = $xmllistingsclaims->setAttributeNode(new DOMAttr('xsi:noNamespaceSchemaLocation', 'http://www.haad.ae/DataDictionary/CommonTypes/DataDictionary.xsd'));
            $attr2 = $xmllistingsclaims->setAttributeNode(new DOMAttr('xmlns:tns', 'http://www.haad.ae/DataDictionary/CommonTypes'));
            $attr3 = $xmllistingsclaims->setAttributeNode(new DOMAttr('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance'));
            $header = $xmllistingsclaims->appendChild(new DOMElement('Header'));
            $senderid = $header->appendChild(new DOMElement('SenderID', $headervalues['SenderID']));
            $recieverid = $header->appendChild(new DOMElement('ReceiverID', 'C004'));
            $DispositionFlag = $header->appendChild(new DOMElement('DispositionFlag', $headervalues['DispositionFlag']));
            $TransactionDate = $header->appendChild(new DOMElement('TransactionDate', $headervalues['TransactionDate']));
            $RecordCount = $header->appendChild(new DOMElement('RecordCount', count($claims)));
            foreach ($claims as $claimid => $singleClaim) {
                app::import('model','Providerdetail');
                $providerdetailsobj    =   new Providerdetail();
                $providername          =   $singleClaim['ProviderID'];
                $claim              = $xmllistingsclaims->appendChild(new DOMElement('Claim'));
                $ID                 = $claim->appendChild(new DOMElement('ID', $singleClaim['ID']));
                $IDPayer            = $claim->appendChild(new DOMElement('IDPayer', $singleClaim['IDPayer']));
                $MemberID           = $claim->appendChild(new DOMElement('MemberID', $singleClaim['MemberID']));
                $PayerID            = $claim->appendChild(new DOMElement('PayerID', $singleClaim['PayerID']));
                $ProviderID         = $claim->appendChild(new DOMElement('ProviderID', $singleClaim['ProviderID']));
                $EmiratesIDNumber   = $claim->appendChild(new DOMElement('EmiratesIDNumber', $singleClaim['EmiratesIDNumber']));
                $Gross              = $claim->appendChild(new DOMElement('Gross', $singleClaim['Gross']));
                $PatientShare       = $claim->appendChild(new DOMElement('PatientShare', $singleClaim['PatientShare']));
                $Net                = $claim->appendChild(new DOMElement('Net',$singleClaim['Net']));
                $Encounter          = $claim->appendChild(new DOMElement('Encounter'));
                if(isset($singleClaim['Encounter']['FacilityID']))
                $FacilityID         = $Encounter->appendChild(new DOMElement('FacilityID',$singleClaim['Encounter']['FacilityID']));
                if(isset($singleClaim['Encounter']['Type']))
                $Type               = $Encounter->appendChild(new DOMElement('Type', $singleClaim['Encounter']['Type']));
                if(isset($singleClaim['Encounter']['PatientID']))
                $PatientID          = $Encounter->appendChild(new DOMElement('PatientID', $singleClaim['Encounter']['PatientID']));
                if(isset($singleClaim['Encounter']['Start']))
                $Start              = $Encounter->appendChild(new DOMElement('Start', $singleClaim['Encounter']['Start']));
                if(isset($singleClaim['Encounter']['End']))
                $End                = $Encounter->appendChild(new DOMElement('End', $singleClaim['Encounter']['End']));
                if(isset($singleClaim['Encounter']['StartType']))
                $StartType          = $Encounter->appendChild(new DOMElement('StartType', $singleClaim['Encounter']['StartType']));
                if(isset($singleClaim['Encounter']['EndType']))
                $EndType            = $Encounter->appendChild(new DOMElement('EndType', $singleClaim['Encounter']['EndType']));
                if(isset($singleClaim['Contract']))
                $Contract           = $claim->appendChild(new DOMElement('Contract'));
                if(isset($singleClaim['Contract']['PackageName']))
                $PackageName        = $Contract->appendChild(new DOMElement('PackageName', $singleClaim['Contract']['PackageName']));
                if(isset($singleClaim['Resubmission']))
                { 
                    $resubmission       = $claim->appendChild(new DOMElement('Resubmission'));
                    if(isset($singleClaim['Resubmission']['Type']))
                    $resubmissiontype   = $resubmission->appendChild(new DOMElement('Type', $singleClaim['Resubmission']['Type']));
                    if(isset($singleClaim['Resubmission']['Comment']))
                    $resubmissionComment= $resubmission->appendChild(new DOMElement('Comment', $singleClaim['Resubmission']['Comment']));
                }
                if(isset($singleClaim['Diagnosis'])){
                    if (isset($singleClaim['Diagnosis'][0])) {
                        foreach ($singleClaim['Diagnosis'] as $key => $diag) {
                            $Diagnosi = $claim->appendChild(new DOMElement('Diagnosis'));
                             if(isset($diag['Type']))
                            $Type = $Diagnosi->appendChild(new DOMElement('Type', $diag['Type']));
                             if(isset($diag['Code']))
                            $code = $Diagnosi->appendChild(new DOMElement('Code', $diag['Code']));
                        }
                    } else {
                        $Diagnosi   = $claim->appendChild(new DOMElement('Diagnosis'));
                        if(isset($singleClaim['Diagnosis']['Type']))
                        $Type       = $Diagnosi->appendChild(new DOMElement('Type', $singleClaim['Diagnosis']['Type']));
                        if(isset($singleClaim['Diagnosis']['Code']))
                        $code       = $Diagnosi->appendChild(new DOMElement('Code', $singleClaim['Diagnosis']['Code']));
                    }
                 }
                $activitydetails    = $singleClaim['Activity'];
                $activitymodifiedarray  =   array();
                if(!isset($singleClaim['Activity'][0])){
                    $activitymodifiedarray[]  =   $singleClaim['Activity'];
                }else{
                     $activitymodifiedarray   =   $singleClaim['Activity'];
                }
                foreach ($activitymodifiedarray as $singleactivity) {
                    $activitydomobj = $claim->appendChild(new DOMElement('Activity'));
                    $activity_id    = $activitydomobj->appendChild(new DOMElement('ID', $singleactivity['ID']));
                    $Start          = $activitydomobj->appendChild(new DOMElement('Start', $singleactivity['Start']));
                    $end            = $activitydomobj->appendChild(new DOMElement('End', $singleactivity['End']));
                    $Code           = $activitydomobj->appendChild(new DOMElement('Code', $singleactivity['Code']));
                    $type           = $activitydomobj->appendChild(new DOMElement('Type', $singleactivity['Type']));
                    $Quantity       = $activitydomobj->appendChild(new DOMElement('Quantity', $singleactivity['Quantity']));
                    $Net = $activitydomobj->appendChild(new DOMElement('Net', $singleactivity['Net']));
                    $Clinician = $activitydomobj->appendChild(new DOMElement('Clinician', $singleactivity['Clinician']));
                    $PriorAuthorizationID = $activitydomobj->appendChild(new DOMElement('PriorAuthorizationID', $singleactivity['PriorAuthorizationID']));
                    if(isset($singleactivity['Observation'])){
                        $allobservation =array();
                         if(isset($singleactivity['Observation'][0]))
                           $allobservation  =     $singleactivity['Observation'];
                         else
                           $allobservation[0]  =     $singleactivity['Observation'];  
                           foreach($allobservation as $singleobservation){
                            $Observation = $activitydomobj->appendChild(new DOMElement('Observation'));
                            $Type        = $Observation->appendChild(new DOMElement('Type', $singleobservation['Type']));
                            $Code        = $Observation->appendChild(new DOMElement('Code', $singleobservation['Code']));
                            $Value       = $Observation->appendChild(new DOMElement('Value', preg_replace("/&#?[a-z0-9]+;/i","",$singleobservation['Value'])));
                            $ValueType   = $Observation->appendChild(new DOMElement('ValueType', $singleobservation['ValueType']));
                         } 
                    }
                }
            }
     
            $date = trim(date("Ymd"));
            if (!file_exists(WWW_ROOT . 'files/tmpbatch/' . $date . '/')) {
                echo "creating folder with name " . WWW_ROOT . 'files/tmpbatch/' . $date . " \n";
                mkdir(WWW_ROOT . 'files/tmpbatch/' . $date,0777);
            }
            if (!file_exists(WWW_ROOT . 'files/tmpbatch/' . $date . '/' . $batch)) {
                echo "creating folder with name " . WWW_ROOT . 'files/tmpbatch/' . $date . '/' . $batch . " \n";
                mkdir(WWW_ROOT . 'files/tmpbatch/' . $date . '/' . $batch,0777);
            }
            $dom->save(WWW_ROOT.'files/tmpbatch/'.$date.'/'.$batch."/".date("Y-m-d")."_".$batch."_".$typename."_" . $benefitname . "_benefit.xml");
            app::import('model','Xmllisting');
            $xmllistingsobj = new Xmllisting();
            foreach($xmlistings as $xmllistingid){
                 $xmldetails = $xmllistingsobj->read(null,$xmllistingid);
                 if(file_exists(WWW_ROOT . 'files/xmlunprocessed/' . $date . '/'. $xmldetails['Xmllisting']['xml_url'])){
                     echo "coppiing..".$xmldetails['Xmllisting']['xml_url']." \n \n"; 
                     if(strtolower(end(explode('.', $xmldetails['Xmllisting']['name'])))=="xml")
                         copy(WWW_ROOT .'files/xmlunprocessed/'.$date.'/'.$xmldetails['Xmllisting']['xml_url'], WWW_ROOT . 'files/tmpbatch/' .$date.'/'.$batch."/" . $xmldetails['Xmllisting']['name']);
                    else{
                       copy(WWW_ROOT .'files/xmlunprocessed/'.$date.'/'.$xmldetails['Xmllisting']['xml_url'], WWW_ROOT . 'files/tmpbatch/' .$date.'/'.$batch."/" . end(explode('/',$xmldetails['Xmllisting']['xml_url'])));
                    }
                   }
                   else{
                       echo "coppiing..".$xmldetails['Xmllisting']['url']." \n \n"; 
                     if(strtolower(end(explode('.', $xmldetails['Xmllisting']['name'])))=="xml")
                         copy(WWW_ROOT .'files/xmlunprocessed/'.$date.'/'.$xmldetails['Xmllisting']['url'], WWW_ROOT . 'files/tmpbatch/' .$date.'/'.$batch."/" . $xmldetails['Xmllisting']['name']);
                    else{
                       copy(WWW_ROOT .'files/xmlunprocessed/'.$date.'/'.$xmldetails['Xmllisting']['url'], WWW_ROOT . 'files/tmpbatch/' .$date.'/'.$batch."/" . end(explode('/',$xmldetails['Xmllisting']['url'])));
                    }
                   }
            }
        }
    }      
  
 public function createXMlBenefits($claimsArray, $headervalues, $batch,$typename,$xmlistings){
     foreach ($claimsArray as $benefit => $claims) {
            $benefitname = $benefit;
            $dom = new DOMDocument('1.0', "UTF-8");
            $dom->formatOutput = true;
            $xmllistingsclaims = $dom->appendChild(new DOMElement('Claim.Submission'));
            $attr1 = $xmllistingsclaims->setAttributeNode(new DOMAttr('xsi:noNamespaceSchemaLocation', 'http://www.haad.ae/DataDictionary/CommonTypes/DataDictionary.xsd'));
            $attr2 = $xmllistingsclaims->setAttributeNode(new DOMAttr('xmlns:tns', 'http://www.haad.ae/DataDictionary/CommonTypes'));
            $attr3 = $xmllistingsclaims->setAttributeNode(new DOMAttr('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance'));
            $header = $xmllistingsclaims->appendChild(new DOMElement('Header'));
            $senderid = $header->appendChild(new DOMElement('SenderID', $headervalues['SenderID']));
            $recieverid = $header->appendChild(new DOMElement('ReceiverID', 'C004'));
            $DispositionFlag = $header->appendChild(new DOMElement('DispositionFlag', $headervalues['DispositionFlag']));
            $TransactionDate = $header->appendChild(new DOMElement('TransactionDate', $headervalues['TransactionDate']));
            $RecordCount = $header->appendChild(new DOMElement('RecordCount', count($claims)));
            foreach ($claims as $claimid => $singleClaim) {
                app::import('model','Providerdetail');
                $providerdetailsobj    =   new Providerdetail();
                $providername          =   $singleClaim['ProviderID'];
                $claim              = $xmllistingsclaims->appendChild(new DOMElement('Claim'));
                $ID                 = $claim->appendChild(new DOMElement('ID', $singleClaim['ID']));
                $IDPayer            = $claim->appendChild(new DOMElement('IDPayer', $singleClaim['IDPayer']));
                $MemberID           = $claim->appendChild(new DOMElement('MemberID', $singleClaim['MemberID']));
                $PayerID            = $claim->appendChild(new DOMElement('PayerID', $singleClaim['PayerID']));
                $ProviderID         = $claim->appendChild(new DOMElement('ProviderID', $singleClaim['ProviderID']));
                $EmiratesIDNumber   = $claim->appendChild(new DOMElement('EmiratesIDNumber', $singleClaim['EmiratesIDNumber']));
                $Gross              = $claim->appendChild(new DOMElement('Gross', $singleClaim['Gross']));
                $PatientShare       = $claim->appendChild(new DOMElement('PatientShare', $singleClaim['PatientShare']));
                $Net                = $claim->appendChild(new DOMElement('Net',$singleClaim['Net']));
                $Encounter          = $claim->appendChild(new DOMElement('Encounter'));
                if(isset($singleClaim['Encounter']['FacilityID']))
                $FacilityID         = $Encounter->appendChild(new DOMElement('FacilityID',$singleClaim['Encounter']['FacilityID']));
                if(isset($singleClaim['Encounter']['Type']))
                $Type               = $Encounter->appendChild(new DOMElement('Type', $singleClaim['Encounter']['Type']));
                if(isset($singleClaim['Encounter']['PatientID']))
                $PatientID          = $Encounter->appendChild(new DOMElement('PatientID', $singleClaim['Encounter']['PatientID']));
                if(isset($singleClaim['Encounter']['Start']))
                $Start              = $Encounter->appendChild(new DOMElement('Start', $singleClaim['Encounter']['Start']));
                if(isset($singleClaim['Encounter']['End']))
                $End                = $Encounter->appendChild(new DOMElement('End', $singleClaim['Encounter']['End']));
                if(isset($singleClaim['Encounter']['StartType']))
                $StartType          = $Encounter->appendChild(new DOMElement('StartType', $singleClaim['Encounter']['StartType']));
                if(isset($singleClaim['Encounter']['EndType']))
                $EndType            = $Encounter->appendChild(new DOMElement('EndType', $singleClaim['Encounter']['EndType']));
                if(isset($singleClaim['Contract']))
                $Contract           = $claim->appendChild(new DOMElement('Contract'));
                if(isset($singleClaim['Contract']['PackageName']))
                $PackageName        = $Contract->appendChild(new DOMElement('PackageName', $singleClaim['Contract']['PackageName']));
                if(isset($singleClaim['Resubmission']))
                { 
                    $resubmission       = $claim->appendChild(new DOMElement('Resubmission'));
                    if(isset($singleClaim['Resubmission']['Type']))
                    $resubmissiontype   = $resubmission->appendChild(new DOMElement('Type', $singleClaim['Resubmission']['Type']));
                    if(isset($singleClaim['Resubmission']['Comment']))
                    $resubmissionComment= $resubmission->appendChild(new DOMElement('Comment', $singleClaim['Resubmission']['Comment']));
                }
                if(isset($singleClaim['Diagnosis'])){
                    if (isset($singleClaim['Diagnosis'][0])) {
                        foreach ($singleClaim['Diagnosis'] as $key => $diag) {
                            $Diagnosi = $claim->appendChild(new DOMElement('Diagnosis'));
                             if(isset($diag['Type']))
                            $Type = $Diagnosi->appendChild(new DOMElement('Type', $diag['Type']));
                             if(isset($diag['Code']))
                            $code = $Diagnosi->appendChild(new DOMElement('Code', $diag['Code']));
                        }
                    } else {
                        $Diagnosi   = $claim->appendChild(new DOMElement('Diagnosis'));
                        if(isset($singleClaim['Diagnosis']['Type']))
                        $Type       = $Diagnosi->appendChild(new DOMElement('Type', $singleClaim['Diagnosis']['Type']));
                        if(isset($singleClaim['Diagnosis']['Code']))
                        $code       = $Diagnosi->appendChild(new DOMElement('Code', $singleClaim['Diagnosis']['Code']));
                    }
                 }
                $activitydetails    = $singleClaim['Activity'];
                $activitymodifiedarray  =   array();
                if(!isset($singleClaim['Activity'][0])){
                    $activitymodifiedarray[]  =   $singleClaim['Activity'];
                }else{
                     $activitymodifiedarray   =   $singleClaim['Activity'];
                }
                foreach ($activitymodifiedarray as $singleactivity) {
                    $activitydomobj = $claim->appendChild(new DOMElement('Activity'));
                    $activity_id    = $activitydomobj->appendChild(new DOMElement('ID', $singleactivity['ID']));
                    $Start          = $activitydomobj->appendChild(new DOMElement('Start', $singleactivity['Start']));
                    $end            = $activitydomobj->appendChild(new DOMElement('End', $singleactivity['End']));
                    $Code           = $activitydomobj->appendChild(new DOMElement('Code', $singleactivity['Code']));
                    $type           = $activitydomobj->appendChild(new DOMElement('Type', $singleactivity['Type']));
                    $Quantity       = $activitydomobj->appendChild(new DOMElement('Quantity', $singleactivity['Quantity']));
                    $Net = $activitydomobj->appendChild(new DOMElement('Net', $singleactivity['Net']));
                    $Clinician = $activitydomobj->appendChild(new DOMElement('Clinician', $singleactivity['Clinician']));
                    $PriorAuthorizationID = $activitydomobj->appendChild(new DOMElement('PriorAuthorizationID', $singleactivity['PriorAuthorizationID']));
                    if(isset($singleactivity['Observation'])){
                        $allobservation =array();
                         if(isset($singleactivity['Observation'][0]))
                           $allobservation  =     $singleactivity['Observation'];
                         else
                           $allobservation[0]  =     $singleactivity['Observation'];  
                           foreach($allobservation as $singleobservation){
                            $Observation = $activitydomobj->appendChild(new DOMElement('Observation'));
                            $Type        = $Observation->appendChild(new DOMElement('Type', $singleobservation['Type']));
                            $Code        = $Observation->appendChild(new DOMElement('Code', $singleobservation['Code']));
                            $Value       = $Observation->appendChild(new DOMElement('Value', $singleobservation['Value']));
                            $ValueType   = $Observation->appendChild(new DOMElement('ValueType', $singleobservation['ValueType']));
                         } 
                    }
                }
            }
     
            $date = trim(date("Ymd"));
            if (!file_exists(WWW_ROOT . 'files/tmpbatch/' . $date . '/')) {
                echo "creating folder with name " . WWW_ROOT . 'files/tmpbatch/' . $date . " \n";
                mkdir(WWW_ROOT . 'files/tmpbatch/' . $date,0777);
            }
            if (!file_exists(WWW_ROOT . 'files/tmpbatch/' . $date . '/' . $batch)) {
                echo "creating folder with name " . WWW_ROOT . 'files/tmpbatch/' . $date . '/' . $batch . " \n";
                mkdir(WWW_ROOT . 'files/tmpbatch/' . $date . '/' . $batch,0777);
            }
            $dom->save(WWW_ROOT.'files/tmpbatch/'.$date.'/'.$batch."/".date("Y-m-d")."_".$batch."_".$typename."_" . $benefitname . "_benefit.xml");
            app::import('model','Xmllisting');
            $xmllistingsobj = new Xmllisting();
            echo $batch. " \n";
            
            foreach($xmlistings as $xmllistingid){
                 $xmldetails = $xmllistingsobj->read(null,$xmllistingid);
                 if(file_exists(WWW_ROOT . 'files/xmlunprocessed/' . $date . '/'. $xmldetails['Xmllisting']['xml_url'])){
                     echo "coppiing..".$xmldetails['Xmllisting']['xml_url']." \n \n"; 
                     $urltofile = explode('.', $xmldetails['Xmllisting']['name']);
                     $endurl    = end($urltofile);
                     if(strtolower($endurl)=="xml")
                         copy(WWW_ROOT .'files/xmlunprocessed/'.$date.'/'.$xmldetails['Xmllisting']['xml_url'], WWW_ROOT . 'files/tmpbatch/' .$date.'/'.$batch."/" . $xmldetails['Xmllisting']['name']);
                    else{
                       copy(WWW_ROOT .'files/xmlunprocessed/'.$date.'/'.$xmldetails['Xmllisting']['xml_url'], WWW_ROOT . 'files/tmpbatch/' .$date.'/'.$batch."/" . end(explode('/',$xmldetails['Xmllisting']['xml_url'])));
                    }
                   }else{
                        echo "coppiing..".$xmldetails['Xmllisting']['url']." \n \n"; 
                        $urltofile = explode('.', $xmldetails['Xmllisting']['name']);
                        $endurl    = end($urltofile);
                        if(strtolower($endurl)=="xml")
                            copy(WWW_ROOT .'files/Emailxmls/'.$xmldetails['Xmllisting']['url'], WWW_ROOT . 'files/tmpbatch/' .$date.'/'.$batch."/" . $xmldetails['Xmllisting']['name']);
                        else{
                            copy(WWW_ROOT .'files/xmlunprocessed/'.$date.'/'.$xmldetails['Xmllisting']['url'], WWW_ROOT . 'files/tmpbatch/' .$date.'/'.$batch."/" . end(explode('/',$xmldetails['Xmllisting']['url'])));
                        }
                   }
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
			$this->Batch->create();
			if ($this->Batch->save($this->request->data)) {
				$this->Session->setFlash(__('The batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The batch could not be saved. Please, try again.'));
			}
		}
                
		$xmllistings = $this->Batch->Xmllisting->find('list',array());
		$this->set(compact('providers', 'xmllistings'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Batch->id = $id;
		if (!$this->Batch->exists()) {
			throw new NotFoundException(__('Invalid batch'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    
                    
                        if ($this->Batch->save($this->request->data)) {
				$this->Session->setFlash(__('The batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The batch could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Batch->read(null, $id);
		}
		
		$xmllistings = $this->Batch->find('list');
		$this->set(compact( 'xmllistings'));
	}
	public function batchname($id = null) {
                
                app::import('Model','ClaimsmanagerBatch');
                $ClaimsmanagerBatchobj = new ClaimsmanagerBatch();
		$this->Batch->id = $id;
                 $batchdetails             =         $this->Batch->read(null,$id);
                
		if (!$this->Batch->exists()) {
			throw new NotFoundException(__('Invalid batch'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                      
                        $this->request->data['Batch']['status'] =   1;
                        $this->request->data['Batch']['name']   =   trim($this->request->data['Batch']['name']);
                        if($this->Batch->find('all',array('conditions'=>array('name'=>$this->request->data['Batch']['name'])))){
                             $this->Session->setFlash("Batch name already assigned");
                                $this->redirect(array('action'=>'batchname',$id));
                         }
                        if ($this->Batch->save($this->request->data)) {
                                $batchdetails                   =   $this->Batch->find('first',array('conditions' => array('id' => $id)));
                                app::import('model','Log');
                                $logobj                         =   new Log();
                                $data                           =   array();
                                $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                                $data['Log']['Object']          =   $id;
                                $data['Log']['Objectcategory']  =   "batch";
                                $data['Log']['Header']          =   "Batch Naming";
                                $data['Log']['Desc']            =   $this->Session->read('Auth.User.username')." named the batch with id ".$id." for the provider ".$batchdetails['Batch']['provider_id']." as ".$this->request->data['Batch']['name'];
                                $logobj->create();
                                $logobj->save($data);

                                if($this->request->data['Batch']['ClaimsmanagerBatchid']!=""){
                                    $claimsmanagerdetails['ClaimsmanagerBatch']['id']           =   $this->request->data['Batch']['ClaimsmanagerBatchid'];
                                }
                                $claimsmanagerdetails['ClaimsmanagerBatch']['batch_id']         =   $id;
                                
                                $claimsmanagerdetails['ClaimsmanagerBatch']['group_id']         =   16;
                                
                                $claimsmanagerdetails['ClaimsmanagerBatch']['Assigned_by']      =   $this->Session->read('Auth.User.id');
                                
                                if($ClaimsmanagerBatchobj->save($claimsmanagerdetails))
                                {
                                    $batchdetails             =         $this->Batch->read(null,$id);
                                    $trimmeddate              =         date('Ymd', $batchdetails['Batch']['created']->sec);
                                    chmod(WWW_ROOT.'files/batch/'.$trimmeddate,0777);
                                    if(isset($batchdetails['Batch']['resubmission_status'])){
                                        if($batchdetails['Batch']['resubmission_status'] == 0){
                                            $file_name = 'batch_id_'.$batchdetails['Batch']['provider_id'].'_files_'.$batchdetails['Batch']['xmllisting_id'].".zip";
                                        }
                                        else{
                                            $file_name = 'batch_id_'.$batchdetails['Batch']['provider_id'].'_resubmission_files_'.$batchdetails['Batch']['xmllisting_id'].".zip";
                                        }
                                    }
                                    else{
                                        $file_name  =   'batch_id_'.$batchdetails['Batch']['provider_id'].'_files.zip';
                                        if(!file_exists(WWW_ROOT."files/batch/".$trimmeddate."/".$file_name)){
                                            $file_name  =   'batch_id_'.$batchdetails['Batch']['provider_id'].'_resubmission_files.zip';
                                        }
                                    }
                                    $fileHand = fopen(WWW_ROOT.'files/batch/'.$trimmeddate.'/batch_id_'.$batchdetails['Batch']['provider_id'].'_files.zip', 'r');
                                    fclose($fileHand);
                                    chmod(WWW_ROOT.'files/batch/'.$trimmeddate.'/batch_id_'.$batchdetails['Batch']['provider_id'].'_files.zip',0777);
                                    $newarchievepointer     = fopen(WWW_ROOT.'files/batch/'.$trimmeddate.'/'.str_replace(" ",'',$this->request->data['Batch']['name'])."_".$batchdetails['Batch']['provider_id'].'.zip', "w");
                                    fclose($newarchievepointer);
                                    if($batchdetails['Batch']['resubmission']==0){
                                        
                                        
                                        if(file_exists(WWW_ROOT.'files/batch/'.$trimmeddate.'/'.$file_name)){
                                          copy(WWW_ROOT.'files/batch/'.$trimmeddate.'/'.$file_name, WWW_ROOT.'files/batch/'.$trimmeddate.'/'.str_replace(" ",'',$this->request->data['Batch']['name'])."_".$batchdetails['Batch']['provider_id'].'.zip');
                                        }else{
                                            die("file not founmd");
                                        }
                                    }else{
                                          if(file_exists(WWW_ROOT.'files/batch/'.$trimmeddate.'/'.$file_name)){
                                            copy(WWW_ROOT.'files/batch/'.$trimmeddate.'/'.$file_name, WWW_ROOT.'files/batch/'.$trimmeddate.'/'.str_replace(" ",'',$this->request->data['Batch']['name'])."_".$batchdetails['Batch']['provider_id'].'_resubmission_files.zip');
                                            }else{
                                            die("file not founmd");
                                            
                                        }
                                    }
                                    $this->Batch->saveField('status', 2);
                                    app::import('model','Log');
                                    $logobj                         =   new Log();
                                    $data                           =   array();
                                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                                    $data['Log']['Object']          =   $id;
                                    $data['Log']['Objectcategory']  =   "batch";
                                    $data['Log']['Header']          =   "Batch assigned to Claims Manager";
                                    $data['Log']['Desc']            =   "The batch with number ".$this->request->data['Batch']['name']." is assigned to Claims Manager  by ".$this->Session->read('Auth.User.username');
                                    $logobj->create();
                                    $logobj->save($data);
                                  $this->Session->setFlash("Batch has been assigned to claims manager");
                                  $this->redirect(array('action'=>'index'));
                                  
                                  
                                }
			} else {
				$this->Session->setFlash(__('The batch could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Batch->read(null, $id);
		}
		
		$xmllistings = $this->Batch->find('list');
		$this->set(compact( 'xmllistings'));
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
		$this->Batch->id = $id;
		if (!$this->Batch->exists()) {
			throw new NotFoundException(__('Invalid batch'));
		}
		if ($this->Batch->delete()) {
			$this->Session->setFlash(__('Batch deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Batch was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Batch->recursive = 0;
		$this->set('batches', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Batch->id = $id;
		if (!$this->Batch->exists()) {
			throw new NotFoundException(__('Invalid batch'));
		}
		$this->set('batch', $this->Batch->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Batch->create();
			if ($this->Batch->save($this->request->data)) {
				$this->Session->setFlash(__('The batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The batch could not be saved. Please, try again.'));
			}
		}
		$providers = $this->Batch->Provider->find('list');
		$xmllistings = $this->Batch->Xmllisting->find('list');
		$this->set(compact('providers', 'xmllistings'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Batch->id = $id;
		if (!$this->Batch->exists()) {
			throw new NotFoundException(__('Invalid batch'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Batch->save($this->request->data)) {
				$this->Session->setFlash(__('The batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The batch could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Batch->read(null, $id);
		}
		$providers = $this->Batch->Provider->find('list');
		$xmllistings = $this->Batch->Xmllisting->find('list');
		$this->set(compact('providers', 'xmllistings'));
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
		$this->Batch->id = $id;
		if (!$this->Batch->exists()) {
			throw new NotFoundException(__('Invalid batch'));
		}
		if ($this->Batch->delete()) {
			$this->Session->setFlash(__('Batch deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Batch was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
