<?php   
App::uses('AppController', 'Controller');
App::import('Vendor', 'PHPExcel.Classes.PHPExcel.php');
require_once APP . 'Vendor' . DS."PHPExcel".DS."Classes".DS."PHPExcel.php";
require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/Cell/AdvancedValueBinder.php';
require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/IOFactory.php';
App::uses('AppController', 'Controller');
App::import('Vendor', 'excel_reader2');
/**
 * Providerdetails Controller
 *
 * @property Providerdetail $Providerdetail
 */
class ProviderdetailsController extends AppController {

    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
        $this->checkpermission();
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
                $code       =   $this->request->data['code'];
                $licence    =   $this->request->data['licence'];
                if($code)
                {
                    $conditions['code']   =   $code;
                }
                if($licence)
                    $conditions['licence']    =   $licence;
                if(isset($conditions))
                {
                    $this->paginate = array(
                        'conditions' => $conditions,
                        'activate' => array('provider_code' => 'asc'),

                   );
                }
                else
                {
                    $this->paginate = array(
                        'order' => array('active' => 'desc'),
                   );
                }
                

                $this->set('providerdetails', $this->paginate());
	}
        public function dissableall(){
            if($this->Providerdetail->updateAll(array('active'=>0),array('active'=>1)))
                echo "asd";
            else echo "ajj";
            exit;
            
        }
        
        public function listactivedubaiproviders(){
            $this->autoRender=null;
            $this->layout=null;
            $activeproviders        =   $this->Providerdetail->find('all',array('conditions' => array('active' => 1,'city' => 'DUBAI')));
            date_default_timezone_set('Europe/London');

            define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
            $objPHPExcel = new PHPExcel();
        if(!file_exists(WWW_ROOT.'files/Activeproviders/')){
                            mkdir(WWW_ROOT.'files/Activeproviders');
                        }
        		// Set document properties
            echo date('H:i:s') , " xls details" , EOL;
            $objPHPExcel->getProperties()->setCreator("Hari Krishna S")
               		->setLastModifiedBy("Hari Krishna S")
               		->setTitle("PHPExcel Active Providers")
               		->setSubject("PHPExcel Active Providers")
               		->setDescription("Active Providers")
               		->setKeywords("Active Providers")
               		->setCategory("Active Providers");

			$objPHPExcel->setActiveSheetIndex(0)
                		->setCellValue('A1', 'Provider Code')
                		->setCellValue('B1', 'Provider Name')
                		->setCellValue('C1', 'Provider Licence')
                		->setCellValue('E1', 'facility_name');
                        $i=2;
                        foreach ($activeproviders as $activeprovider){
                            $objRichText = new PHPExcel_RichText();
                            $objRichText->createText($activeprovider['Providerdetail']['code']);
                            $objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValue($objRichText);
                            $objRichText = new PHPExcel_RichText();
                            $objRichText->createText($activeprovider['Providerdetail']['display_name']);
                            $objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValue($objRichText);
                            $objRichText = new PHPExcel_RichText();
                            $objRichText->createText($activeprovider['Providerdetail']['licence']);
                            $objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValue($objRichText);
                            $objRichText = new PHPExcel_RichText();
                            $objRichText->createText($activeprovider['Providerdetail']['facility_name']);
                            $objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValue($objRichText);
                            $i++;
                        }
                        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                        
                        $objWriter->save(WWW_ROOT.'files/Activeproviders/ActiveDHAProviders.xls');
                        
        }

        public function network_index() {
		$this->Providerdetail->recursive = 0;
		$this->set('providerdetails', $this->paginate());
	}
        
        
        public function activatefromexcel()
        {
            App::import('Vendor', 'excel_reader2');  
            $data = new Spreadsheet_Excel_Reader(WWW_ROOT.'files/providers/8-6-2013.xls', true);
            $exeldata = $data->sheets['0']['cells'];
           $count   =   0;
            foreach ($exeldata as $key  =>  $row)
            {
                
                if($count==0){
                     $count++;
                    continue;
                }
              
              $providerdetails     =   $this->Providerdetail->find('first',array('conditions' => array('licence' => $row[4])));
               
               if(!$providerdetails['Providerdetail']['id']){
                  if($this->Providerdetail->save(array('Providerdetail'=>array('city'=>'DUBAI','code'=>$row[1],'display_name'=>$row[2],'facility_name'=>$row[3],'licence'=>$row[4],'active' =>1)))){
                      continue;
                  }else{
                      die("error");
                  }
                   
               }
             
               if($this->Providerdetail->save(array('Providerdetail'=>array('id'=>$providerdetails['Providerdetail']['id'],'active' =>1)))){
                   echo"Status updated for ".$row[4]." \n";
                  }
               else
               {
                    echo"Status updated for ".$row[4]." \n";;
                   die("error");
                  echo "Failed to update the status";
               }
            }
        }
        public function deactivateproviders()
        {
            $providers  = $this->Providerdetail->find('all',array('conditions' => array('city' => 'DUBAI')));
            foreach($providers as $provider)
            {
                print_r($provider);
                $this->Providerdetail->id   =   $provider['Providerdetail']['id'];
                if($this->Providerdetail->saveField('active', 0))
                        echo "Updated";
                else
                        die("Failed to update");
            }
        }
        public function activateprovidersfromexcel()
        {
            App::import('Vendor', 'simplexlsx');
            //$exceldata      =   new SimpleXLSX(WWW_ROOT.'files/activate/PrimeGroup.xlsx');
            $simple     =    new SimpleXLSX(WWW_ROOT.'files/activate/PrimeGroup.xlsx');
            list($cols) = $simple->dimension();
            foreach( $simple->rows() as $k => $r){
                if($k==0)
                    continue;
                $providerid = $this->Providerdetail->find('first',array('conditions'    =>  array('licence' => $r[2])));
                if(isset($providerid['Providerdetail']['id']))
                {
                    $this->Providerdetail->id   =   $providerid['Providerdetail']['id'];
                    if($this->Providerdetail->saveField('active', 1))
                            echo "Updated";
                    else
                        $failed[]   =   $r[2];
                }
            }
            print_r($failed);
        }
     
        public function getproidername($providedetails=null){
            
            $providename    =    $this->Providerdetail->find('first',array('conditions'=>array('Providerdetail.licence'=>$providedetails)));
            return $providename['Providerdetail']['display_name'];
            exit;
            $this->autoRender=FALSE;
            
        }
        
        public function getMednetcode($id=null)
        {
            if(isset($id))
            {
                $details    =   $this->Providerdetail->read(null,$id);
                return $details['Providerdetail']['code'];
            }
            else
            {
                return '-';
            }
        }

                public function getProviderdetailsById($providedetails=null){
            $providename    =    $this->Providerdetail->find('first',array('conditions'=>array('Providerdetail.id'=>$providedetails)));
            return $providename['Providerdetail']['display_name'];
            exit;
            $this->autoRender=FALSE;
        }
        public function network_getproidermednetcode($providedetails=null){
            
            $providename    =    $this->Providerdetail->find('first',array('conditions'=>array('Providerdetail.licence'=>$providedetails)));
            return $providename['Providerdetail']['provider_code'];
            exit;
            $this->autoRender=FALSE;
            
        }
        public function markacive($providerid){
            
            $provider   =   $this->Providerdetail->read(null,$providerid);
            $this->Providerdetail->id   =   $providerid;
            if($provider['Providerdetail']['active']==0)
            {
                if($this->Providerdetail->save(array('Providerdetail'=>array('id'=>$providerid, 'active'=>1)))){
                app::import('model','Log');
                $logobj                         =   new Log();
                $data                           =   array();
                $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                $data['Log']['Object']          =   $providerid;
                $data['Log']['Objectcategory']  =   "providers";
                $data['Log']['Header']          =   "Provider activated";
                $data['Log']['Desc']            =   "The Provider : ".$provider['Providerdetail']['licence']."is activated by : ".$this->Session->read('Auth.User.username');
                $logobj->create();
                $logobj->save($data);
                  $this->Session->setFlash(__('The providerdetail has been updated.'));
                  $this->redirect(array('controller'=>'Providerdetails','action'=>'index'));
               }else{
                   if($this->Providerdetail->save(array('Providerdetail'=>array('id'=>$providerid, 'active'=>0)))){
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $providerid;
                        $data['Log']['Objectcategory']  =   "providers";
                        $data['Log']['Header']          =   "Provider deactivated";
                        $data['Log']['Desc']            =   "The Provider : ".$provider['Providerdetail']['licence']."is deactivated by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                        $this->Session->setFlash(__('The providerdetail has been updated.'));
                        $this->redirect(array('controller'=>'Providerdetails','action'=>'index'));
                   }
               }
               
 }
            else{
                   if($this->Providerdetail->save(array('Providerdetail'=>array('id'=>$providerid, 'active'=>0)))){
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $providerid;
                        $data['Log']['Objectcategory']  =   "providers";
                        $data['Log']['Header']          =   "Provider deactivated";
                        $data['Log']['Desc']            =   "The Provider : ".$provider['Providerdetail']['licence']."is deactivated by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                        $this->Session->setFlash(__('The providerdetail has been updated.'));
                        $this->redirect(array('controller'=>'Providerdetails','action'=>'index'));
                   }
               }
       }
        public function getproidermednetcode($providedetails=null){
            
            $providename    =    $this->Providerdetail->find('first',array('conditions'=>array('Providerdetail.licence'=>$providedetails)));
            return $providename['Providerdetail']['code'];
            exit;
            $this->autoRender=FALSE;
            
        }
        public function getproidercode($providedetails=null){
             $providename    =    $this->Providerdetail->find('first',array('conditions'=>array('Providerdetail.licence'=>$providedetails)));
            return $providename['Providerdetail']['provider_code'];
            exit;
            $this->autoRender=FALSE;
            
            
        }
        public function network_getproidercode($providedetails=null){
             $providename    =    $this->Providerdetail->find('first',array('conditions'=>array('Providerdetail.licence'=>$providedetails)));
            return $providename['Providerdetail']['provider_code'];
            exit;
            $this->autoRender=FALSE;
            
            
        }
        
        public function getdetails($provider_id){
            return $this->Providerdetail->find('first',array('conditions'=>array('licence'=>$provider_id)));
            $this->autoRender   =   false;
        }
        public function network_getdetails($provider_id){
            return $this->Providerdetail->find('first',array('conditions'=>array('licence'=>$provider_id)));
            $this->autoRender   =   false;
        }
        
        
        /**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Providerdetail->id = $id;
		if (!$this->Providerdetail->exists()) {
                        throw new NotFoundException(__('Invalid providerdetail'));
		}
		$this->set('providerdetail', $this->Providerdetail->read(null, $id));
	}
	public function network_view($id = null) {
		$this->Providerdetail->id = $id;
		if (!$this->Providerdetail->exists()) {
			throw new NotFoundException(__('Invalid providerdetail'));
		}
		$this->set('providerdetail', $this->Providerdetail->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Providerdetail->create();
			if ($this->Providerdetail->save($this->request->data)) {
				$this->Session->setFlash(__('The providerdetail has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The providerdetail could not be saved. Please, try again.'));
			}
		}
	}
	public function network_add() {
		if ($this->request->is('post')) {
			$this->Providerdetail->create();
			if ($this->Providerdetail->save($this->request->data)) {
				$this->Session->setFlash(__('The providerdetail has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The providerdetail could not be saved. Please, try again.'));
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
		$this->Providerdetail->id   = $id;
                $providervalues             = $this->Providerdetail->find('first',array('conditions' => array('id' => $id)));
		if (!$this->Providerdetail->exists()) {
			throw new NotFoundException(__('Invalid providerdetail'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Providerdetail->save($this->request->data)) {
                                app::import('model','Log');
                                $logobj                         =   new Log();
                                $data                           =   array();
                                $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                                $data['Log']['Object']          =   $id;
                                $data['Log']['Objectcategory']  =   "providers";
                                $data['Log']['Header']          =   "Provider details updated";
                                $data['Log']['Desc']            =   "The details of the provider ".$providervalues['Providerdetail']['licence']." is updated by : ".$this->Session->read('Auth.User.username');
                                $logobj->create();
                                $logobj->save($data);
				$this->Session->setFlash(__('The providerdetail has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The providerdetail could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Providerdetail->read(null, $id);
		}
	}
	public function network_edit($id = null) {
		$this->Providerdetail->id = $id;
		if (!$this->Providerdetail->exists()) {
			throw new NotFoundException(__('Invalid providerdetail'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Providerdetail->save($this->request->data)) {
				$this->Session->setFlash(__('The providerdetail has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The providerdetail could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Providerdetail->read(null, $id);
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
		$this->Providerdetail->id = $id;
                $providervalues             = $this->Providerdetail->find('first',array('conditions' => array('id' => $id)));
		if (!$this->Providerdetail->exists()) {
			throw new NotFoundException(__('Invalid providerdetail'));
		}
		if ($this->Providerdetail->delete()) {
			$this->Session->setFlash(__('Providerdetail deleted'));
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $id;
                        $data['Log']['Objectcategory']  =   "providers";
                        $data['Log']['Header']          =   "Provider details updated";
                        $data['Log']['Desc']            =   "The details of the provider ".$providervalues['Providerdetail']['licence']." is updated by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Providerdetail was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	public function network_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Providerdetail->id = $id;
		if (!$this->Providerdetail->exists()) {
			throw new NotFoundException(__('Invalid providerdetail'));
		}
		if ($this->Providerdetail->delete()) {
			$this->Session->setFlash(__('Providerdetail deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Providerdetail was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        function providerdetailscsv() 
        {
            $row = 1;

        
        $data = new Spreadsheet_Excel_Reader(WWW_ROOT.'files/providerdetails/providerdetails.xls', true);
        $exeldata = $data->sheets['0']['cells'];
        $Providerdetail = array();


        foreach ($exeldata as $key => $val) {
            $provider[$key] = array('provider_code' => $val['1'], 'display_name' => $val['2'], 'provider_status' => $val['3'], 'facility_name' => $val['4'], 'licence' => $val['5'],'city' => $val['6'],'region' => $val['7']);
        }
       
        
        if ($this->Providerdetail->saveAll($provider)) {
            die('saved');
        } else {
            die("could not save the mCodes");
        }
                
        }
            
      
        public function insertproviders($file=null){
            
            
            
            if (file_exists(trim($file))) {
                app::import('Vendor','simplexlsx');
                $simple     =    new SimpleXLSX($file);
                
                list($cols) = $simple->dimension();
                $i  = 0;
                
                foreach( $simple->rows() as $k => $r){
                    if($i==0)
                    {
                        $i++;
                        continue;
                    }
                    $count  =   $this->Providerdetail->find('count',array('conditions'  =>  (array('code'   =>  $r[0],'licence'   => $r[3]))));
                    if($count>0)
                    {
                        echo "The provider already exists..!!";
                        continue;
                    }
                    $data['Providerdetail']['code']=$r[0];
                    $data['Providerdetail']['city']=$r[4];
                    $data['Providerdetail']['display_name']= $r[1];
                    $data['Providerdetail']['facility_name']= $r[2];
                    $data['Providerdetail']['licence']= $r[3];
                    $data['Providerdetail']['active']=0;
                    $this->Providerdetail->create();
                    if($this->Providerdetail->save($data))
                        echo "inserted";
                    else
                        echo "error"; 
                }
            }
            else
                die("failed to read file");
            
        }
        
        public function uploadProvider()
        {
                app::import('model','Provider');
                $provider = new Provider();
               if ($this->request->is('post')) {
                        if(!$this->request->data['Providerpricing']['details'])
                            throw  new NotFoundException('excel file not found');
                          extract($this->data['Providerpricing']['details']);
                          $actualname   =   $name;
                         do{
                            srand ((double) microtime() * 1000000); 
                            $random_num = rand(0, 1000);
                            $name =  $random_num.$name;
                          }while(file_exists(WWW_ROOT.'files/Provider/'.$name));
                          if(move_uploaded_file($tmp_name, WWW_ROOT.'files/Provider/'.$name))
                          {
                            if($provider->save(array('file_name'=>$name,'directory_name'=>WWW_ROOT.'files/Provider/','status'=>0)))
                            {
                                app::import('model','Log');
                                $logobj                         =   new Log();
                                $data                           =   array();
                                $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                                $data['Log']['Object']          =   "";
                                $data['Log']['Objectcategory']  =   "providers";
                                $data['Log']['Header']          =   "Provider details file added";
                                $data['Log']['Desc']            =   "The Provider details file  ".$actualname."is uploaded by : ".$this->Session->read('Auth.User.username');
                                $logobj->create();
                                $logobj->save($data);
                                $this->Session->setFlash ('Provider details added, Please wait for a minute for the file to get processed');
                                 
                            }else{
                                $this->Session->setFlash ('Error uploading the file');
                                 
                            }
                          }
               }
		//$providerdetails = $this->Providerpricing->Providerdetail->find('list',array('fields'=>array('id','provider_code')));
		//$this->set(compact('providerdetails'));
        }
}
