<?php
App::uses('AppController', 'Controller');
/**
 * Dhaobservationmappings Controller
 *
 * @property Dhaobservationmapping $Dhaobservationmapping
 */
class DhaobservationmappingsController extends AppController {
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
		if($this->request->is('post'))
                {
                    if($this->request->data['ObservationMapping']['activity_type']!='')
                    {
                        $conditions['activity_type']=$this->request->data['ObservationMapping']['activity_type'];
                    }
                    if($this->request->data['ObservationMapping']['activity_code']!='')
                    {
                        $conditions['activity_code']=$this->request->data['ObservationMapping']['activity_code'];
                    }
                    if($this->request->data['ObservationMapping']['observation_code']!='')
                    {
                        $conditions['observation_code']=$this->request->data['ObservationMapping']['observation_code'];
                    }
                }
                if(isset($conditions))
                {
                    $this->paginate =   array('conditions'=>$conditions);
                }
                $activitycodearray          =    $this->Dhaobservationmapping->query(array('distinct'    =>  'dhaobservationmappings',   'key'   =>  'activity_code' ));
                $activitytypearray          =    $this->Dhaobservationmapping->query(array('distinct'    =>  'dhaobservationmappings',   'key'   =>  'activity_type' ));
                $observationcodearray       =    $this->Dhaobservationmapping->query(array('distinct'    =>  'dhaobservationmappings',   'key'   =>  'observation_code' ));
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
                $this->set('activitycodes',$activitycodes);
                $this->set('activitytypes',$activitytypes);
                $this->set('observationcodes',$observationcodes);
                $this->Dhaobservationmapping->recursive = 0;
		$this->set('dhaobservationmappings', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Dhaobservationmapping->id = $id;
		if (!$this->Dhaobservationmapping->exists()) {
			throw new NotFoundException(__('Invalid dhaobservationmapping'));
		}
		$this->set('dhaobservationmapping', $this->Dhaobservationmapping->read(null, $id));
	}
        public function insertrecords($recorddata)
        {
            App::import('Vendor', 'excel_reader2');
            $data = new Spreadsheet_Excel_Reader(WWW_ROOT.'files/dhaobservationmappings/'.$recorddata['Commonobservationmappingfile']['url'], true);
            $exeldata = $data->sheets['0']['cells'];
            foreach ($exeldata as $key  =>  $row)
            {
                $dhapricingarray['Dhaobservationmapping']['providerpricingfile_id']     =   $recorddata['Commonobservationmappingfile']['id'];
                $dhapricingarray['Dhaobservationmapping']['start_date']                 =   $recorddata['Commonobservationmappingfile']['start_date'];
                $dhapricingarray['Dhaobservationmapping']['activity_type']              =   (string) $row[1];
                $dhapricingarray['Dhaobservationmapping']['activity_code']              =   (string) $row[2];
                $dhapricingarray['Dhaobservationmapping']['observation_code']           =   (string) $row[3];
                $dhapricingarray['Dhaobservationmapping']['gross_price']                =   (int) $row[4];
                $dhapricingarray['Dhaobservationmapping']['description']                =   $row[5];
                $dhapricingarray['Dhaobservationmapping']['status']                     =   0;
                $this->Dhaobservationmapping->create();
                $this->Dhaobservationmapping->save($dhapricingarray);
            }
        }
/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
                        if (!file_exists(WWW_ROOT . 'files/dhaobservationmappings/')) {
                            mkdir(WWW_ROOT.'files/dhaobservationmappings'); 
                        }
                        $filename   =  $values['Dhaobservationmapping']['Mapping']['name']; 
                        while(file_exists(WWW_ROOT.'files/dhaobservationmappings/'.$filename))
                        {
                            $filename   = rand(10, 1000).$this->request->data['Dhaobservationmapping']['Mapping']['name'];
                        }
                        move_uploaded_file($this->request->data['Dhaobservationmapping']['Mapping']['tmp_name'], WWW_ROOT.'files/dhaobservationmappings/'.$filename);
			app::import('model',  'Commonobservationmappingfile');
                        $observationmappingfileobj     =   new Commonobservationmappingfile();
                        $observationmappingfilearray['Commonobservationmappingfile']['start_date']     = $this->request->data['Dhaobservationmapping']['start_date'];
                        $observationmappingfilearray['Commonobservationmappingfile']['pricing']        = $this->request->data['Dhaobservationmapping']['Mapping']['name'];
                        $observationmappingfilearray['Commonobservationmappingfile']['url']            = $filename;
                        $observationmappingfilearray['Commonobservationmappingfile']['dha_status']     = 1;
                        $observationmappingfilearray['Commonobservationmappingfile']['haad_status']    = 0;
                        $observationmappingfilearray['Commonobservationmappingfile']['status']         = 0;
                        $observationmappingfileobj->create();
                        $observationmappingfileobj->save($observationmappingfilearray);
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   "";
                        $data['Log']['Objectcategory']  =   "observationmappings";
                        $data['Log']['Header']          =   "Dha Observationmappings file";
                        $data['Log']['Desc']            =   "The Dha Observationmappings file  ".$this->request->data['Dhaobservationmapping']['Mapping']['name']." is added by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                        $this->Session->setFlash("The file has been uploaded. Please wait for the file to be processed");  
		}
	}
	public function addsingle() {
		if ($this->request->is('post')) {
                    $this->request->data['Dhaobservationmapping']['status'] =   0;
                    $this->request->data['Dhaobservationmapping']['activity_type']      =   (string) $this->request->data['Dhaobservationmapping']['activity_type'];
                    $this->request->data['Dhaobservationmapping']['activity_code']      =   (string) $this->request->data['Dhaobservationmapping']['activity_code'];
                    $this->request->data['Dhaobservationmapping']['observation_code']   =   (string) $this->request->data['Dhaobservationmapping']['observation_code'];
                    $this->request->data['Dhaobservationmapping']['gross_price']        =   (int) $this->request->data['Dhaobservationmapping']['gross_price'];
                    $this->Dhaobservationmapping->create();
                    if($this->Dhaobservationmapping->save($this->request->data)){
                        $this->Session->setFlash ("Observation mapping saved");
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   "";
                        $data['Log']['Objectcategory']  =   "observationmappings";
                        $data['Log']['Header']          =   "Dha Observationmappings code";
                        $data['Log']['Desc']            =   "The Dha Observationmappings code  ".$this->request->data['Dhaobservationmapping']['observation_code']." is added by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                    }
                    else
                        $this->Session->setFlash ("Failed to save the Observation Mapping");
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Dhaobservationmapping->id = $id;
		if (!$this->Dhaobservationmapping->exists()) {
			throw new NotFoundException(__('Invalid dhaobservationmapping'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Dhaobservationmapping->save($this->request->data)) {
				$this->Session->setFlash(__('The dhaobservationmapping has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dhaobservationmapping could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Dhaobservationmapping->read(null, $id);
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
		$this->Dhaobservationmapping->id = $id;
		if (!$this->Dhaobservationmapping->exists()) {
			throw new NotFoundException(__('Invalid dhaobservationmapping'));
		}
                $datas       =   $this->Dhaobservationmapping->find('first',array('conditions' => array('id' => $id)));
		if ($this->Dhaobservationmapping->delete()) {
			$this->Session->setFlash(__('Dhaobservationmapping deleted'));
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $id;
                        $data['Log']['Objectcategory']  =   "observationmappings";
                        $data['Log']['Header']          =   "Dha Observationmappings code deleted";
                        $data['Log']['Desc']            =   "The Dha Observationmappings code  ".$datas['Dhaobservationmapping']['observation_code']." is deleted by : ".$this->Session->read('Auth.User.id');
                        $logobj->create();
                        $logobj->save($data);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Dhaobservationmapping was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
