<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'excel_reader2'); 
/**
 * ObservationMappings Controller
 *
 * @property ObservationMapping $ObservationMapping
 */
class ObservationMappingsController extends AppController {

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
    
	public function index() {
		app::import('model','Log');
    		$logobj                         =   new Log();
   		$data                           =   array();
    		$data['Log']['User']            =   $this->Session->read('Auth.User.id');
                $data['Log']['Object']          =   "";
                $data['Log']['Objectcategory']  =   "observationmappings";
    		$data['Log']['Header']          =   "User - Page access";
    		$data['Log']['Desc']            =   "The : ".$this->Session->read('Auth.User.username')." accessed the  index page for Observation Mappings";
    		$logobj->create();
    		$logobj->save($data);           
                if($this->request->is('post'))
                {$this->Session->write('provider_code',null);
                    if(isset($this->request->data['ObservationMapping']['provider_code']))
                        $this->Session->write('provider_code',$this->request->data['ObservationMapping']['provider_code']);
                    else
                        $this->Session->write('provider_code',null);
                    if(isset($this->request->data['ObservationMapping']['activity_type']))
                        $this->Session->write('activity_type',$this->request->data['ObservationMapping']['activity_type']);
                    else
                        $this->Session->write('activity_type',null);
                    if(isset($this->request->data['ObservationMapping']['activity_code']))
                        $this->Session->write('activity_code',$this->request->data['ObservationMapping']['activity_code']);
                    else
                        $this->Session->write('activity_code',null);
                    if(isset($this->request->data['ObservationMapping']['observation_code']))
                        $this->Session->write('observation_code',$this->request->data['ObservationMapping']['observation_code']);
                    else
                        $this->Session->write ('observation_code',null);
                    if(isset($this->request->data['ObservationMapping']['dateforsearch']))
                        $this->Session->write('dateforsearch',$this->request->data['ObservationMapping']['dateforsearch']);
                    else
                        $this->Session->write ('dateforsearch',null);
                }
                unset($conditions);
                if($this->Session->read('provider_code'))
                    $conditions['providerdetail_id']=$this->Session->read('provider_code');
                if($this->Session->read('activity_type'))
                    $conditions['activity_type']=$this->request->data['ObservationMapping']['activity_type'];
                if($this->Session->read('activity_code'))
                    $conditions['activity_code']=$this->request->data['ObservationMapping']['activity_code'];
                if($this->Session->read('observation_code'))
                    $conditions['observation_code']=$this->request->data['ObservationMapping']['observation_code'];
                if($this->Session->read('dateforsearch'))
                {
                    $datevalues = explode('-',$this->Session->read('dateforsearch'));
                    $conditions['start_date.day']       =   $datevalues[0];
                    $conditions['start_date.month']     =   $datevalues[1];
                    $conditions['start_date.year']      =   $datevalues[2];
                }
                if(isset($conditions))
                {
                    $this->paginate =   array('conditions'=>$conditions);
                }
                else
                {
                    $this->paginate();
                }
		$this->ObservationMapping->recursive = 0;
		$this->set('observationMappings', $this->paginate());
                $activitycodearray   =    $this->ObservationMapping->query(array('distinct'    =>  'Observation_mappings',   'key'   =>  'activity_code' ));
                $activitytypearray   =    $this->ObservationMapping->query(array('distinct'    =>  'Observation_mappings',   'key'   =>  'activity_type' ));
                $observationcodearray   =    $this->ObservationMapping->query(array('distinct'    =>  'Observation_mappings',   'key'   =>  'observation_code' ));
                foreach ($activitycodearray['values'] as $activitycode)
                {
                    $activitycodes[$activitycode]   =   $activitycode;
                }
                foreach ($activitytypearray['values'] as $activitycode)
                {
                    $activitytypes[$activitycode]   =   $activitycode;
                }
                foreach ($observationcodearray['values'] as $activitycode)
                {
                    $observationcodes[$activitycode]   =   $activitycode;
                }
                app::import('model','Providerdetail');
                $provderdetailobj   =   new Providerdetail();
                //$provider[0]        =   'Search without provider';
                $provider           =   $provderdetailobj->find('list',array('fields'=>array('id','code')));
                //$provider[0]        =   'Search without provider';
                $this->set('provider',$provider);
                $this->set('activitycodes',$activitycodes);
                $this->set('activitytypes',$activitytypes);
                $this->set('observationcodes',$observationcodes);
                if($this->Session->read('provider_code'))
                    $query  =   array('providerdetail_id'   => $this->Session->read('provider_code'));
                $dates      =   $this->ObservationMapping->query(array('distinct'    =>  'providerpricings',   'key'   =>  'start_date', 'query'=>$query ));
                foreach($dates['values']   as $date)
                {
                    $datearray[$date[day].'-'.$date['month'].'-'.$date['year']] =   $date[day].'-'.$date['month'].'-'.$date['year'];
                }
                $this->set('datearray',$datearray);
	}
        public function createexcel()
        {
            
            app::import('model','Providerpricingscsvdata');
            $providerpricingcsvdataobj  =   new Providerpricingscsvdata();
            $detailsarray               =   array();
            $detailsarray['Providerpricingscsvdata']['providerdetail_id']       =   $this->Session->read('provider_code');
            $detailsarray['Providerpricingscsvdata']['activity_type']           =   $this->Session->read('activity_type');
            $detailsarray['Providerpricingscsvdata']['activity_code']           =   $this->Session->read('activity_code');
            $detailsarray['Providerpricingscsvdata']['observation_code']        =   $this->Session->read('observation_code');
            $detailsarray['Providerpricingscsvdata']['dateforsearch']           =   $this->Session->read('dateforsearch');
            $detailsarray['Providerpricingscsvdata']['status']                  =   0;
            $detailsarray['Providerpricingscsvdata']['type']                    =   1;
            $providerpricingcsvdataobj->create();
            if(!$this->Session->read('provider_code'))
            {
                $this->Session->setFlash("Please choose a provider from the dropdown");
                $this->redirect(array('action' => 'index'));
            }
            if($providerpricingcsvdataobj->save($detailsarray))
            {
                $this->Session->setFlash("The request has been sheduled for processing");
                app::import('model','Log');
                $logobj                         =   new Log();
                $data                           =   array();
                $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                $data['Log']['Object']          =   "";
                $data['Log']['Objectcategory']  =   "observationmappings";
                $data['Log']['Header']          =   "Observationmappings - Request to create Excel";
                $data['Log']['Desc']            =   "The ObservationMappings excel file is generated by : ".$this->Session->read('Auth.User.username');
                $logobj->create();
                $logobj->save($data);
            }
            else
            {
                $this->Session->setFlash("Unable to process the request");
            }
            $this->redirect(array('action' => 'index'));
            $this->autoRender=false;
            $this->layout="ajax";
            
            
//            app::import('model','Providerdetail');
//            app::import('model','Benefit');
//            $providerdetailobj  =   new Providerdetail();
//            $benefitobj         =   new Benefit();
//            if($this->Session->read('provider_code'))
//            {
//                
//                if($this->Session->read('dateforsearch'))
//                {
//                    $datesearch = explode('-', $this->Session->read('dateforsearch'));
//                    $conditions =   array(
//                                        'providerdetail_id'     =>  $this->Session->read('provider_code'),
//                                        'start_date.day'        =>  $datesearch[0],
//                                        'start_date.month'      =>  $datesearch[1],
//                                        'start_date.year'       =>  $datesearch[2]
//                                    );
//                }
//                else
//                {
//                    $conditions =   array('providerdetail_id'     =>  $this->Session->read('provider_code'));
//                }
//                $filename           =       tempnam(sys_get_temp_dir(), "csv");
//                if(!($file=fopen($filename,"w")))
//                {
//                    die("Unable to open the specified file..!!!");
//                }
//                $observationsarray  =   $this->ObservationMapping->find('all',array('conditions'    =>  $conditions));
//                fputcsv($file, array('Provider Code','Provider Name','Peocedure Type','Procedure Code','Observation Code','Procedure Description','Price'));
//                foreach ($observationsarray as $key => $observation)
//                {
//                    $providerdetails    =   $providerdetailobj->find('first',array('conditions' =>  array('id' =>   $observation['ObservationMapping']['providerdetail_id']),'fields'   =>  array('code','display_name')));
//                    $datastoprint       =   array($providerdetails['Providerdetail']['code'],$providerdetails['Providerdetail']['display_name'],$observation['ObservationMapping']['activity_type'],$observation['ObservationMapping']['activity_code'],$observation['ObservationMapping']['observation_code'],$observation['ObservationMapping']['description'],$observation['ObservationMapping']['gross_price']);
//                    fputcsv($file,$datastoprint);
//                }
//            }
//            else
//            {
//                $this->Session->setFlash("Please choose a provider");
//                $this->redirect(array('action' => 'index'));
//            }
//            fclose($file);
//            header('Content-Encoding: UTF-8');
//            header("Content-Type: application/csv;charset=utf-8");
//            header("Content-Disposition: attachment;Filename=".$providerdetails['Providerdetail']['code']."_pricings.csv");
//            readfile($filename);
//            unlink($filename);
//            $this->autoRender=false;
//            $this->layout="ajax";
        }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ObservationMapping->id = $id;
		if (!$this->ObservationMapping->exists()) {
			throw new NotFoundException(__('Invalid observation mapping'));
		}
		$this->set('observationMapping', $this->ObservationMapping->read(null, $id));
	}

       public function addsingle()
        {
            if($this->request->is('post'))
            {
                $observationarray   = array();
                app::import('model','Providerdetail');
                $providerdetailobj                                              =   new Providerdetail();
                $providerdetails_id     =   $providerdetailobj->find('first',array('conditions' =>  array('code'   => $this->request->data['ObservationMapping']['provider'])));
                
                $observationarray['ObservationMapping']['providerdetail_id']    =   $providerdetails_id['Providerdetail']['id'];
                $observationarray['ObservationMapping']['activity_type']        = $this->request->data['ObservationMapping']['activity_type'];
                $observationarray['ObservationMapping']['activity_code']        = $this->request->data['ObservationMapping']['activity_code'];
                $observationarray['ObservationMapping']['observation_code']     = $this->request->data['ObservationMapping']['observation_code'];
                $observationarray['ObservationMapping']['gross_price']          = $this->request->data['ObservationMapping']['gross_price'];
                $observationarray['ObservationMapping']['description']          = $this->request->data['ObservationMapping']['description'];
                $observationarray['ObservationMapping']['start_date']           = $this->request->data['ObservationMapping']['start_date'];
                $observationarray['ObservationMapping']['status']               = 0;
                $this->ObservationMapping->create();
                if($this->ObservationMapping->save($observationarray))
                {
                    $this->Session->setFlash("The Observation mapping added succesfully");
                }
                else
                {
                    $this->Session->setFlash("Failed to add the observation mappings");
                }
            }
            app::import('model','Providerdetail');
            $providerDetails    =   new Providerdetail();
            $providers = $providerDetails->find('all',array('fields'    =>  array('code',  'display_name')));
                
            foreach ($providers as $provider)
            {
                $providerlist[$provider['Providerdetail']['code']] =   $provider['Providerdetail']['code'];
            }
                
                
            $providerlist = array_unique($providerlist);
                
            $this->set('providerlist',$providerlist);
        }
        
/**
 * add method
 *
 * @return void
 */
	public function add() {
            
            
                if(isset($this->request->data['ObservationMapping']['provider']))
                {
                    //echo $this->request->data['ObservationMapping']['provider'];
                    $this->Session->write('provider',$this->request->data['ObservationMapping']['provider']);
                }
                app::import('model','Providerdetail');
                $providerdetailobj              =   new Providerdetail();
                $providervalues                 =   $providerdetailobj->find('first',array('conditions' => array('id' => $this->request->data['ObservationMapping']['provider'])));
		if ($this->request->is('post')) {
                    app::import('controller','Observationmappingfiles');
                    $observationmappingfileobj  =   new ObservationmappingfilesController();
                    if($observationmappingfileobj->add($this->request->data['ObservationMapping']))
                    {
			app::import('model','Log');
    			$logobj                         =   new Log();
    			$data                           =   array();
    			$data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $this->request->data['ObservationMapping']['provider'];
                        $data['Log']['Objectcategory']  =   "observationmappings";
    			$data['Log']['Header']          =   "User - Page access";
    			$data['Log']['Desc']            =   "The  ".$this->Session->read('Auth.User.username')." added the observation code for the provider ".$providervalues['Providerdetail']['licence'];
    			$logobj->create();
    			$logobj->save($data);
                        $this->Session->setFlash("The Observation Mappings File is added.");
                    }
                    else
                    {
                        $this->Session->setFlash("Error in uploading the Obsercation Mapping file.");
                    }
                    
                }
                app::import('model','Providerdetail');
                $providerDetails    =   new Providerdetail();
                $providers = $providerDetails->find('all',array('fields'    =>  array('code',  'display_name')));
                
                foreach ($providers as $provider)
                {
                    $providerlist[$provider['Providerdetail']['code']] =   $provider['Providerdetail']['code'];
                }
                
                
                $providerlist = array_unique($providerlist);
                
                $this->set('providerlist',$providerlist);
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ObservationMapping->id = $id;
		if (!$this->ObservationMapping->exists()) {
			throw new NotFoundException(__('Invalid observation mapping'));
		}
                $observationvalues          =   $this->ObservationMapping->find('first',array('id' => $id));
                app::import('model','Providerdetal');
                $providerdetailobj          =   new Providerdetail();
                $providervalues             =   $providerdetailobj->find('first',array('conditions' => array('id' => $observationvalues['ObservationMapping']['providerdetail_id'])));
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ObservationMapping->save($this->request->data)) {
				app::import('model','Log');
    				$logobj                             =   new Log();
    				$data                               =   array();
    				$data['Log']['User']                =   $this->Session->read('Auth.User.id');
                                $data['Log']['Object']              =   $this->request->data['ObservationMapping']['providerdetail_id'];
                                $data['Log']['Objectcategory']      =   "observationmappings";
    				$data['Log']['Header']              =   "User - Page access";
    				$data['Log']['Desc']                =   "The  ".$this->Session->read('Auth.User.username')." edited the observation mappings record for the provider ".$providervalues['Providerdetail']['licence'];
    				$logobj->create();
    				$logobj->save($data);
				$this->Session->setFlash(__('The observation mapping has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The observation mapping could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->ObservationMapping->read(null, $id);
		}
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
		$this->ObservationMapping->id = $id;
		if (!$this->ObservationMapping->exists()) {
			throw new NotFoundException(__('Invalid observation mapping'));
		}
                app::import('model','Providerdetail');
                $providerdetailobj          =   new Providerdetail();
                $providervalues             =   $providerdetailobj->find('first',array('conditions' => array('id' => $id)));
                if ($this->ObservationMapping->delete()) {
			$mappings	=	$this->ObservationMapping->find('first',array('conditions' => array('id' => $id)));
			app::import('model','Log');
    			$logobj                         =   new Log();
    		        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $$providervalues['ObservationMapping']['providerdetail_id'];
                        $data['Log']['Objectcategory']  =   "observationmappings";
    			$data['Log']['Header']          =   "User - Page access";
    			$data['Log']['Desc']            =   "The ".$this->Session->read('Auth.User.username')." deleted the observation mappings ".$mappings;
    			$logobj->create();
    			$logobj->save($data);
			$this->Session->setFlash(__('Observation mapping deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Observation mapping was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        
        public function saveFields($file = null)
        {
            $filepath = WWW_ROOT.'files/Observationmappings/'.$file['Observationmappingfile']['file'];
            $data = new Spreadsheet_Excel_Reader($filepath, true);
            $exeldata = $data->sheets['0']['cells'];
            $mappingdetails = array();
            app::import('model','Providerdetail');
            $providerdetailobj  = new Providerdetail();
            $providerdetails    =   $providerdetailobj->find('first',  array('conditions'=>array('code'=>$file['Observationmappingfile']['mednet_code'])));
            $providerdetails;
            
            $count = 0;
            foreach ($exeldata as $key => $val) {
                if(!$val[1])
                    continue;
                $observationMapping = array();
                $observationMapping['ObservationMapping']['providerdetail_id'] = $providerdetails['Providerdetail']['id'];
                $observationMapping['ObservationMapping']['activity_type'] = (string)$val[1];
                $observationMapping['ObservationMapping']['activity_code'] = (string)$val[2];
                $observationMapping['ObservationMapping']['observation_code'] =(string) $val[3];
                $observationMapping['ObservationMapping']['gross_price'] = $val[4];
                $observationMapping['ObservationMapping']['description'] = $val[5];
                $observationMapping['ObservationMapping']['start_date'] = $file['Observationmappingfile']['start_date'];
                $observationMapping['ObservationMapping']['status'] = 0;
		$records	=	$this->ObservationMapping->find("all",array("conditions" => array("providerdetail_id" => $providerdetails['Providerdetail']['id'],"activity_type" => (string)$val[1],"activity_code" => (string)$val[2],'observation_code' => (string) $val[3])));
		if(count($records)>0)
		{
			echo "Records already present";
			continue;
		}
		echo "Inserting records";
                $this->ObservationMapping->create();
                if($this->ObservationMapping->save($observationMapping))
                {
                   print_r($observationMapping);
                }
            }
        }
}
