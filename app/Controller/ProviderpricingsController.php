<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'PHPExcel.Classes.PHPExcel.php');
require_once APP . 'Vendor' . DS."PHPExcel".DS."Classes".DS."PHPExcel.php";
require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/Cell/AdvancedValueBinder.php';
require_once APP . 'Vendor' . DS."PHPExcel".DS.'Classes/PHPExcel/IOFactory.php';
App::uses('AppController', 'Controller');
App::import('Vendor', 'excel_reader2');
/**
 * Providerpricings Controller
 *
 * @property Providerpricing $Providerpricing
 */
class ProviderpricingsController extends AppController {


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
                $data['Log']['Objectcategory']  =   "providerpricings";
    		$data['Log']['Header']          =   "User - Page access";
    		$data['Log']['Desc']            =   "The ".$this->Session->read('Auth.User.username')." accessed the  dashboard for Network User";
    		$logobj->create();
    		$logobj->save($data);
                MongoCursor::$timeout=-1;
                app::import('model','Providerdetail');
                $providerobj    =   new Providerdetail();
                if($this->request->is('post')){
                    if($this->request->data['Providerpricing']['providerdetail_id_by_txtfld'] !='')
                    {
                       
                        $id_providerdetail  = $providerobj->find('first',array('conditions' =>  array('code'    =>  $this->request->data['Providerpricing']['providerdetail_id_by_txtfld']),'fields'    =>  array('id')));
                        $this->Session->write('providerdetail_id', $id_providerdetail['Providerdetail']['id']);
                    }
                    else
                    {
                        $this->Session->write('providerdetail_id', $this->request->data['Providerpricing']['providerdetail_id']);
                    }
                    
                    if($this->request->data['Providerpricing']['activityid']!='')
                    {
                        
                        $this->Session->write('acitivitycode',trim($this->request->data['Providerpricing']['activityid']));
                    }
                    else
                    {
                        $this->Session->write('acitivitycode',null);
                    }
                    if($this->request->data['Providerpricing']['dates'])
                        $this->Session->write ('dateforsearch',$this->request->data['Providerpricing']['dates']);
                    else
                        $this->Session->write ('dateforsearch', null);
                    
                }  
                if($this->Session->read('providerdetail_id'))
                {
                    if($this->Session->read('acitivitycode')){
                        if($this->Session->read('dateforsearch')){
                            $dates  = explode('-', $this->Session->read('dateforsearch'));
                            $conditions =   array(
                                                'providerdetail_id' => $this->Session->read('providerdetail_id'),
                                                'code'   => $this->Session->read('acitivitycode'),
                                                'start_date.day'    =>  $dates[0],
                                                'start_date.month'    =>  $dates[1],
                                                'start_date.year'    =>  $dates[2],
                                            );
                        }
                        else
                        {
                            $conditions =   array(
                                                'providerdetail_id' => $this->Session->read('providerdetail_id'),
                                                'code'   => $this->Session->read('acitivitycode')
                                            );
                        }
                    }
                    else{
                        
                        $conditions =   array(
                                                'providerdetail_id' => $this->Session->read('providerdetail_id')    
                                            );
                    }
                }
                else{
                    if($this->Session->read('acitivitycode'))
                    {
                        if($this->Session->read('dateforsearch'))
                        {
                            $dates  = explode('-', $this->Session->read('dateforsearch'));
                            $conditions =   array(
                                                'code'   => $this->Session->read('acitivitycode'),
                                                'start_date.day'    =>  $dates[0],
                                                'start_date.month'    =>  $dates[1],
                                                'start_date.year'    =>  $dates[2],
                                            );
                        }
                        else
                        {
                            $conditions =   array(
                                                'code'   => $this->Session->read('acitivitycode')
                                            );
                        }
                    }
                    else
                    {
                        if($this->Session->read('dateforsearch')){
                            $dates  = explode('-', $this->Session->read('dateforsearch'));
                            $conditions =   array(
                                                'start_date.day'    =>  $dates[0],
                                                'start_date.month'    =>  $dates[1],
                                                'start_date.year'    =>  $dates[2]
                                            );
                        }
                        else{
                            $conditions =   null;
                        }
                    }
                }
                $this->paginate =   array(
                                        'conditions' => $conditions
                                    );
//           	if($this->Session->read('providerdetail_id')){
//                   
//                    if($this->Session->read('acitivitycode'))
//                    {
//                       
//                        $this->paginate = array(
//                            'conditions' => array('providerdetail_id' => $this->Session->read('providerdetail_id'),'code'   => $this->Session->read('acitivitycode'))
//                        );
//                       
//                    }
//                    else
//                    {
//                        $this->paginate = array(
//                            'conditions' => array('providerdetail_id' => $this->Session->read('providerdetail_id'))
//                        );
//                    }
//                }
//                else
//                {
//                    
//                   if($this->Session->read('acitivitycode'))
//                    {
//                        $this->paginate = array(
//                            'conditions' => array('code'   => $this->Session->read('acitivitycode'))
//                        );
//                    }
//
//                }
                
                $this->set('providerpricings', $this->paginate());

                $providerpricingdetails   =    $this->Providerpricing->query(array('distinct'    =>  'providerpricings',   'key'   =>  'providerdetail_id' ));
                foreach ($providerpricingdetails['values'] as $providerpricingdetail)
                {
                    $providerdetailids[]    =   $providerpricingdetail;
                }
                
                foreach($providerdetailids as $providerdetailid)
                {
                    $details[]      =   $providerobj->find('all',array('conditions'   =>  array('id'  =>  $providerdetailid)));
                }
                foreach ($details as $detail)
                {
                    $list[$detail[0]['Providerdetail']['id']]  = $detail[0]['Providerdetail']['code'].'_'.$detail[0]['Providerdetail']['display_name'];  
                }
                $this->set(compact('list'));
                if($this->Session->read('providerdetail_id'))
                    $query  =   array('providerdetail_id'   =>  $this->Session->read('providerdetail_id'));
                $dates  = $this->Providerpricing->query(array('distinct'    =>  'providerpricings',   'key'   =>  'start_date' ));
                foreach ($dates['values'] as $date)
                {
                    $datedata[$date['day'].'-'.$date['month'].'-'.$date['year']]    =   $date['day'].'-'.$date['month'].'-'.$date['year'];
                }
                $this->set('datedata',$datedata);
                app::import('model','Missingprovider');
                $unknownproviderobj         =   new Missingprovider();
                $unknownprovidercount       =   $unknownproviderobj->find('count',array('conditions' => array('status' => 0)));
                $this->set('unknownprovidercount',$unknownprovidercount);
                
                
        }
        public function sheduledcsv()
        {
            app::import('model','Providerpricingscsvdata');
            app::import('model','Providerdetail');
            $providerpricingcsvdataobj  = new Providerpricingscsvdata();
            $providerdetailobj          =   new Providerdetail();
            $providercsvshedule         =   $providerpricingcsvdataobj->find('all');
            foreach ($providercsvshedule as $shedule)
            {
                if($shedule['Providerpricingscsvdata']['status']!=3)
                {
                    $providercode           =   $providerdetailobj->find('first',array('conditions' =>  array('id'  =>  $shedule['Providerpricingscsvdata']['providerdetail_id'])));
                    $shedule['Providerpricingscsvdata']['provider_code']    =   $providercode['Providerdetail']['code'];
                    $sheduledata[]  =   $shedule;
                }
                else{
                    $sheduledata[]  =   $shedule;
                }
            }
            $this->set('sheduledata',$sheduledata);
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
        
        public function createtxt(){
                app::import('model','Providerpricingscsvdata');
                $csvdataobj     =   new Providerpricingscsvdata();
                if(!$this->Session->read('providerdetail_id'))
                {
                    $this->Session->setFlash("Please choose a provider");
                    $this->redirect(array('action' => 'index'));
                }
                $dataarray      = array();
                $dataarray['Providerpricingscsvdata']['providerdetail_id']      =   $this->Session->read('providerdetail_id');
                $dataarray['Providerpricingscsvdata']['acitivitycode']          =   $this->Session->read('acitivitycode');
                $dataarray['Providerpricingscsvdata']['dateforsearch']          =   $this->Session->read('dateforsearch');
                $dataarray['Providerpricingscsvdata']['type']                   =   0;
                $dataarray['Providerpricingscsvdata']['status']                 =   0;
                $csvdataobj->create();
                if($csvdataobj->save($dataarray))
                {
                    app::import('model','Log');
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   $dataarray['Providerpricingscsvdata']['providerdetail_id'];
                    $data['Log']['Objectcategory']  =   "providerpricings";
                    $data['Log']['Header']          =   "Request to create Excel - Provider pricings";
                    $data['Log']['Desc']            =   $this->Session->read('Auth.User.username')." requested to create an excel sheet containing the provider pricing for the provider ".$this->Session->read('providerdetail_id');
                    $logobj->create();
                    $logobj->save($data);
                    $this->Session->setFlash("The request has been sheduled for processing");
                }
                else
                {
                    $this->Session->setFlash("Unable to process the request");
                }
                $this->redirect(array('action' => 'index'));
                $this->autoRender=false;
                $this->layout="ajax";
        }
        
        public function deleteshedule($id=null)
        {
            app::import('model','Providerpricingscsvdata');
            $providerpricingcsvobj      =   new Providerpricingscsvdata();
            if($id)
            {
                $providerdetailsdata    =   $providerpricingcsvobj->find('first',array('conditions' => array('id' => $id)));
                        
                if($providerpricingcsvobj->delete($id)){
                    app::import('model','Log');
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   $providerdetailsdata['Providerpricingscsvdata']['providerdetail_id'];
                    $data['Log']['Objectcategory']  =   "providerpricings";
                    $data['Log']['Header']          =   "Reuest removed - Provider pricing";
                    $data['Log']['Desc']            =   $this->Session->read('Auth.User.username')." has removed the request to create the excel for provider pricing ";
                    $logobj->create();
                    $logobj->save($data);
                    $this->Session->setFlash ("The record has been deleted");
                }
                else
                    $this->Session->setFlash ("Unable to delete the record");
                $this->redirect(array('action' => 'sheduledcsv'));
            }
        }
        public function singleadd()
        {
            if($this->request->is('post'))
            {
                $this->request->data['Providerpricing']['activity'] =   (string) $this->request->data['Providerpricing']['activity'];
                $this->request->data['Providerpricing']['code']     =   (string) $this->request->data['Providerpricing']['code'];
                $this->request->data['Providerpricing']['gross']    =   (string) $this->request->data['Providerpricing']['gross'];
                $providervalues                                     =   $this->Providerpricing->Providerdetail->find('first',array('conditions' => array('id' => $this->request->data['Providerpricing']['providerdetail_id'])));
                $this->Providerpricing->create();   
                if($this->Providerpricing->save($this->request->data))
                {
                    app::import('model','Log');
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   $this->request->data['Providerpricing']['providerdetail_id'];
                    $data['Log']['Objectcategory']  =   "providerpricings";
                    $data['Log']['Header']          =   "Provider pricings added";
                    $data['Log']['Desc']            =   "The Provider pricing for the provider ".$providervalues['Providerdetail']['licence']." for the activity type ".$this->request->data['Providerpricing']['activity']." is added by : ".$this->Session->read('Auth.User.username');
                    $logobj->create();
                    $logobj->save($data);
                    $this->Session->setFlash("Pricing saved succesfully");
                }
                else {
                    $this->Session->setFlash("Failed to add pricing");
                }
            }
            $providerdetails = $this->Providerpricing->Providerdetail->find('list',array('fields'=>array('id','code')));
            $this->set(compact('providerdetails'));
        }
        
        
	public function view($id = null) {
		$this->Providerpricing->id = $id;
		if (!$this->Providerpricing->exists()) {
			throw new NotFoundException(__('Invalid providerpricing'));
		}
		$this->set('providerpricing', $this->Providerpricing->read(null, $id));
	}
        public function populatehaadpricing(){
           $providerpricings    =    $this->Providerpricing->find('all',array('conditions'=>array('providerdetail_id'=>'51a5f7d51da29a561100018a'	,
	 "activity"=> 5)));
           app::import('model','Haadpricing');
           $haadpricingobj  =   new Haadpricing();
           foreach($providerpricings as $key=>$val){
              $haadpricingobj->create();
               $haadpricingobj->save(array('Haadpricing'=>array('start_date'=>array('month'=>'01','day'=>'01','year'=>'2013'),'activity'=>'5','code'=>$val['Providerpricing']['code'],'gross'=>(string)$val['Providerpricing']['gross'],'discount'=>'','discountprice'=>'')));
              
           }
           
            
        }

/**
 * add method
 *
 * @return void
 */
	public function add() {
            
		if ($this->request->is('post')) {
                        if(!$this->request->data['Providerpricing']['pricing'])
                           throw  new NotFoundException('excel file not found');
                          extract($this->data['Providerpricing']['pricing']);
                          $actualname   =   $name;
                         do{
                            srand ((double) microtime() * 1000000); 
                            $random_num = rand(0, 1000);
                            $name =  $random_num.$name;
                          }while(file_exists(WWW_ROOT.'files/providerpricing/'.$name));
                          if(move_uploaded_file($tmp_name, WWW_ROOT.'files/providerpricing/'.$name))
                          {
                            if($this->Providerpricing->Providerpricingfile->save(array('Providerpricingfile'=>array('providerdetail_id'=>$this->request->data['Providerpricing']['providerdetail_id'],'start_date'=>$this->data['Providerpricing']['start_date'],'name'=>$actualname,'url'=>$name,'status'=>0))))
                            {
                                app::import('model','Log');
                                $logobj                         =   new Log();
                                $data                           =   array();
                                $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                                $data['Log']['Object']          =   $this->request->data['Providerpricing']['providerdetail_id'];
                                $data['Log']['Objectcategory']  =   "providerpricings";
                                $data['Log']['Header']          =   "Provider pricings file uploaded";
                                $data['Log']['Desc']            =   "The Provider pricings file ".$actualname."is uploaded by : ".$this->Session->read('Auth.User.username');
                                $logobj->create();
                                $logobj->save($data);
                                $this->Session->setFlash ('Pricing added, Please wait for a minute for the file to get processed');
                                $this->redirect(array( 'controller'=>'providerpricingfiles','action' => 'index'));
                            }else{
                                $this->Session->setFlash ('Error uploading the file');
                                 $this->redirect(array('controller'=>'providerpricingfiles','action' => 'index'));
                            }
                          }
               }
		$providerdetails = $this->Providerpricing->Providerdetail->find('list',array('fields'=>array('id','code')));
		$this->set(compact('providerdetails'));
	}
        
        
        public function providerpricingcron() {
         app::import('model','Benefit');
            app::import('model','Providerdetail');
            $benefitobj     =   new Benefit();
            $providerdetailobj  =   new Providerdetail();
            $this->autoRender  =   false;
            date_default_timezone_set('Europe/London');
                        define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
                        $objPHPExcel = new PHPExcel();

                         // Set document properties
                        echo date('H:i:s') , " xls details" , EOL;
                        $objPHPExcel->getProperties()->setCreator("Hari Krishna S")
                                ->setLastModifiedBy("Hari Krishna S")
                                ->setTitle("PHP Excel Providerpricingsreport")
                                ->setSubject("PHP Excel Providerpricingsreport")
                                ->setDescription("Providerpricingsreport")
                                ->setKeywords("Providerpricingsreport")
                                ->setCategory("Providerpricingsreport");

                        //Innetialize the headings for columns
                        $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A1', 'PROVIDER CODE')
                                ->setCellValue('B1', 'PROCEDURE TYPE')
                                ->setCellValue('C1', 'PROCEDURE CODE')
                                ->setCellValue('D1', 'BENEFIT MAPPING STATUS')
                                ->setCellValue('E1', 'DESCRIPTION STATUS');
                        $objPHPExcel->getActiveSheet()->getStyle("A1:E1")->getFont()->setBold(true);
        $excelfils = $this->Providerpricing->Providerpricingfile->find('first', array('conditions' => array('status' => new MongoInt64(0))));



        $filepath = WWW_ROOT . 'files/providerpricing/' . $excelfils['Providerpricingfile']['url'];
        $providerdata       =   $providerdetailobj->find('first',array('conditions' => array('id' => $excelfils['Providerpricingfile']['providerdetail_id'])));
        if (file_exists($filepath)) {
             if($this->Providerpricing->Providerpricingfile->save(array('Providerpricingfile'=>array('id'=>$excelfils['Providerpricingfile']['id'],'status'=>1))))
                    {
                            echo "updated";
                    }
            $data = new Spreadsheet_Excel_Reader($filepath, true);
            $exeldata = $data->sheets['0']['cells'];
            $pricingdetails = array();
            $count = 0;
            $i=1;
            foreach ($exeldata as $key => $val) {
                if ($key == 1)
                    continue;
                if ($val['2']) {
                    $count++;
                    $pricingdetails[$count] = array('providerdetail_id' =>$excelfils['Providerpricingfile']['providerdetail_id'],
                        'providerpricingfile_id' => $excelfils['Providerpricingfile']['id'],
                        'start_date'=>$excelfils['Providerpricingfile']['start_date'],
                        'activity' => (string)$val['1'],
                        'code' => $val['2']."",
                        'gross' => isset($val['3']) ? $val['3'] : 0,
                        'discount' => $val['5'],
                        'discountprice' => $val['6'],
                    );
                }

                $benefitdata    =   $benefitobj->find('first',array('conditions' => array('TYPE' => (string)$val['1'],'CODE' => (string)$val['2'])));
                if(isset($benefitdata['Benefit']))
                {
                    if(!isset($benefitdata['Benefit']['LOCAL_DESCRIPTION_1']))
                    {
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i+1, $providerdata['Providerdetail']['code']);
                        $objRichText = new PHPExcel_RichText();
                        $objRichText->createText((string)$val['1']);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i+1, $objRichText);
                        $objRichText = new PHPExcel_RichText();
                        $objRichText->createText((string)$val['2']);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i+1, $objRichText);
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i+1, 'Benefit records present');
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i+1, 'Benefit description not found');
                        $i++;
                    }
                }
                else{
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i+1, $providerdata['Providerdetail']['code']);
                    $objRichText = new PHPExcel_RichText();
                    $objRichText->createText((string)$val['1']);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i+1, $objRichText);
                    $objRichText = new PHPExcel_RichText();
                    $objRichText->createText((string)$val['2']);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i+1, $objRichText);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i+1, 'Benefit records not found');
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i+1, 'Benefit description not found');
                    $i++;
                }
            }


            if ($this->Providerpricing->saveAll($pricingdetails)) {
                    if(!file_exists(WWW_ROOT.'files/Pricingreport/'))
                    {
                        mkdir(WWW_ROOT.'files/Pricingreport');
                    }
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                    $date = trim(date("Ymd"));
                    $reportfilename = explode('.',$excelfils['Providerpricingfile']['url']);
                    $objWriter->save(WWW_ROOT.'files/Pricingreport/'.$reportfilename[0].'_report.xls');
                    $this->Providerpricing->Providerpricingfile->save(array('Providerpricingfile'=>array('id'=>$excelfils['Providerpricingfile']['id'],'report'=>$reportfilename[0].'_report.xls')));
                }
            }
        }
        public function insertformultiupleproviders(){
            
           
            App::import('Vendor', 'simplexlsx');
            app::import('model',  'Providerdetail');
            $providerdetailsobj    =   new Providerdetail();
            $providerlist     =    new SimpleXLSX(WWW_ROOT . 'files/providerpricing/Pharmacy List-AUH.xlsx');
            
               foreach( $providerlist->rows() as $key=>$val){
                  
                   if($key==0)
                       continue;
                   $Providerdet     =   $providerdetailsobj->find('first',array('conditions'    =>  array('code'    =>  $val[1])));
                   if(isset($Providerdet['Providerdetail']['id']))
                   {
//                        if(trim($val['0'])!="")
//                            $providerpricing     =    new SimpleXLSX(WWW_ROOT . 'files/providerpricing/Pharmacy_Price_List-AUH.xlsx');
//                        foreach( $providerpricing->rows() as $pricinkey=>$pricingval){
//                            if($pricinkey==0)
//                                continue;
//                            $pricingdetails['Providerpricing']['providerdetail_id']     =   $Providerdet['Providerdetail']['id'];
//                            $pricingdetails['Providerpricing']['start_date']            =   array(
//                                                                                                'month' => '01',
//                                                                                                'day'   => '01',
//                                                                                                'year'  => '2013'
//                                                                                            );
//                            $pricingdetails['Providerpricing']['activity']              =   $pricingval[0];
//                            $pricingdetails['Providerpricing']['code']                  =   (string) $pricingval[1];
//                            $pricingdetails['Providerpricing']['gross']                 =   $pricingval[2];
//                            $pricingdetails['Providerpricing']['discount']              =   $pricingval[3];
//                            $pricingdetails['Providerpricing']['discountprice']         =   $pricingval[4];
//                            $this->Providerpricing->create();
//                            $status     =   $this->Providerpricing->save($pricingdetails);
//                            if($status)
//                            {
//                                echo "inserted";
//                            }
//                            else
//                            {
//                                echo 'Failed';
//                            }
//                        }
                    }
                    else
                    {
                        echo $val[1]." \n";
                        echo 'Provider Not found';
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
		$this->Providerpricing->id = $id;
		if (!$this->Providerpricing->exists()) {
			throw new NotFoundException(__('Invalid providerpricing'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Providerpricing->save($this->request->data)) {
                            app::import('model','Log');
                            $logobj                         =   new Log();
                            $data                           =   array();
                            $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                            $data['Log']['Object']          =   $this->request->data['Providerpricing']['providerdetail_id'];
                            $data['Log']['Objectcategory']  =   "providerpricings";
                            $data['Log']['Header']          =   "Provider pricings updated";
                            $data['Log']['Desc']            =   "The provider pricings for the activity type ".$this->request->data['Providerpricingscsvdata']['activity']." is updated by : ".$this->Session->read('Auth.User.username');
                            $logobj->create();
                            $logobj->save($data);
                            $this->Session->setFlash(__('The providerpricing has been saved'));
                            $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The providerpricing could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Providerpricing->read(null, $id);
		}
		$providerdetails = $this->Providerpricing->Providerdetail->find('list',array('fields'=>array('id','provider_code')));
		$this->set(compact('providerdetails'));
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
		$this->Providerpricing->id = $id;
		if (!$this->Providerpricing->exists()) {
			throw new NotFoundException(__('Invalid providerpricing'));
		}
                $providerpricingsdata                   =   $this->Providerpricing->find('first',array('conditions' => array('id' => $id)));
		if ($this->Providerpricing->delete()) {
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $providerpricingsdata['Providerpricing']['providerdetail_id'];
                        $data['Log']['Objectcategory']  =   "providerpricings";
                        $data['Log']['Header']          =   "Provider pricings deleted";
                        $data['Log']['Desc']            =   "The provider pricings ".$providerpricingsdata." is deleted by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
			$this->Session->setFlash(__('Providerpricing deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Providerpricing was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
