<?php

App::uses('AppController', 'Controller');
App::import('Vendor', 'excel_reader2');

/**
 * Benefits Controller
 *
 * @property Benefit $Benefit
 */
class BenefitsController extends AppController {

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
     public function benefitupdate(){
       $this->Benefit->updateAll(array("CRITERION_NBR"=>"Greenrain"),array( "CRITERION_NBR"=>"greenrain"));
       exit;
       
   }
        
   public function getduplicatebenefits(){
       
       $data       =   new Spreadsheet_Excel_Reader(WWW_ROOT.'files/providerdetails/phbenefits.xls', true);
        $exeldata   =   $data->sheets['0']['cells'];
        $benefit=   array();
        if($filename = tempnam(sys_get_temp_dir(), "csv")){
             
                    ob_clean();
                   if($file = fopen($filename,"w")){
                           fputcsv($file, array('type','code','Description'));
                   }
            
            
        }
        
        foreach($exeldata as $key=>$val){
        if($key==1){
            continue;
        }
        
          if($this->Benefit->find('count',array('conditions'=>array('TYPE'=>(string)$val[1],'CODE'=>$val[2])))==0){
              fputcsv($file, array($val['1'],$val['2'],$val['3']));
             
          }else{
             
          }
         
        }
        
       fclose($file);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment;Filename=benefitnotpresent.xls");
        header("charset: UTF-8");
        echo readfile($filename);
        unlink($filename);
        exit;
       
   }
   
        
    public function checkavailablityforProviderpricing($code,$activity){
        $count  =   $this->Benefit->find('count',array('conditions'=>array('type'=>$activity,'code'=>$code)));
        if($count>0)
            return 'linked';
        else
            return 'not_linked';
       }
   public function network_descriptionforProviderpricing($code,$activity){
       
         $benefit  =   $this->Benefit->find('first',array('conditions'=>array('type'=>$activity,'code'=>$code)));
         if(!$benefit)
             return array('Benefit'=>array('Benefit'=> "no benefit"));
         return $benefit;
   }    
   public function descriptionforProviderpricing($code,$activity){

       
       
       
        
       $params = array('conditions' => array('CODE'=>trim($code),'TYPE'=>trim($activity)));
       $benefit            =   $this->Benefit->find('first',$params);
       
      // print_r($benefit);
       
       if(!$benefit)
             return array('Benefit'=>array('BENEFIT'=> "-",'LOCAL_DESCRIPTION_1'=>'-','LOCAL_DESCRIPTION'=>'-'));
        else{ 
            return  $benefit;
        }
   }    
       
    public function index() {
        if($this->request->is('post')){
                    $this->Session->write('BENEFIT', $this->request->data['Benefits']['BENEFIT']);
        }
        $this->Benefit->recursive = 0;
        if($this->Session->read('BENEFIT')){
                    
                    $this->paginate = array(
                        'conditions' => array('BENEFIT' => $this->Session->read('BENEFIT'))
                    );
                }

        $this->set('benefits', $this->paginate());
        $list      = $this->Benefit->query(array('distinct'   => 'benefits', 'key'  => 'BENEFIT'));
        foreach($list['values'] as $key)
        {
            $nlist[$key]    =   $key;
        }
       
        $this->set(compact('nlist'));
        
//        $this->Benefit->recursive = 0;
//        $this->set('benefits', $this->paginate());
    }
    
    
    
    
    public function createtxt(){
                
                $this->Providerpricing->recursive = 0;
                 if($this->Session->read('BENEFIT')){
                     $this->Benefit->recursive  =   -1;   
                    $benefits    =    $this->Benefit->find('all',array(
                        'conditions' => array('Benefit.BENEFIT' => $this->Session->read('BENEFIT'))
                        ));
                        
                        ob_clean();
                        if($filename = tempnam(sys_get_temp_dir(), "csv"))
                        {
                            
                            $file = fopen($filename,"w");
                            fputcsv($file, array('CRITERION_NBR','LOCAL_DESCRIPTION','BENEFIT','TYPE','CODE','LOCAL_DESCRIPTION_1','id'));
                            foreach ($benefits as $row)
                            {
                                fputcsv($file, $row['Benefit']);
                            }
                            fclose($file);
                            header("Content-Type: application/csv");
                            header("Content-Disposition: attachment;Filename=Benefits.csv");
                            header("charset: UTF-8");
                            echo readfile($filename);
                            unlink($filename);
                            exit;
                        
                        }
                        else {
                            echo 'Error';
                        }
                   } else{
                            
                     $this->Session->setFlash("Please choose a provider");
                    $this->redirect(array('action' => 'index'));
                     
                 }
        }
    public function outputCSV($data) {
            $outstream = fopen('/var/www/mednet/app/tmp/file.csv', 'w');

            
            fwrite($outstream,$headers);

            function __outputCSV(&$vals, $key, $filehandler) {
                    fputcsv($filehandler, $vals); // add parameters if you want
            }
            array_walk($data, "__outputCSV", $outstream);
            fclose($outstream);
 }


    

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Benefit->id = $id;
        if (!$this->Benefit->exists()) {
            throw new NotFoundException(__('Invalid benefit'));
        }
        $this->set('benefit', $this->Benefit->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Benefit->create();
            if ($this->Benefit->save($this->request->data)) {
                $this->Session->setFlash(__('The benefit has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The benefit could not be saved. Please, try again.'));
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
        $this->Benefit->id = $id;
        if (!$this->Benefit->exists()) {
            throw new NotFoundException(__('Invalid benefit'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Benefit->save($this->request->data)) {
                $this->Session->setFlash(__('The benefit has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The benefit could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Benefit->read(null, $id);
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
        $this->Benefit->id = $id;
        if (!$this->Benefit->exists()) {
            throw new NotFoundException(__('Invalid benefit'));
        }
        if ($this->Benefit->delete()) {
            $this->Session->setFlash(__('Benefit deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Benefit was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Benefit->recursive = 0;
        $this->set('benefits', $this->paginate());
    }

    /**
     * admin_view method
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Benefit->id = $id;
        if (!$this->Benefit->exists()) {
            throw new NotFoundException(__('Invalid benefit'));
        }
        $this->set('benefit', $this->Benefit->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Benefit->create();
            if ($this->Benefit->save($this->request->data)) {
                $this->Session->setFlash(__('The benefit has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The benefit could not be saved. Please, try again.'));
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
        $this->Benefit->id = $id;
        if (!$this->Benefit->exists()) {
            throw new NotFoundException(__('Invalid benefit'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Benefit->save($this->request->data)) {
                $this->Session->setFlash(__('The benefit has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The benefit could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Benefit->read(null, $id);
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
        $this->Benefit->id = $id;
        if (!$this->Benefit->exists()) {
            throw new NotFoundException(__('Invalid benefit'));
        }
        if ($this->Benefit->delete()) {
            $this->Session->setFlash(__('Benefit deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Benefit was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
