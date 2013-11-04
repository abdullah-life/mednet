<?php
App::uses('AppController', 'Controller');
/**
 * Haadobservationmappings Controller
 *
 * @property Haadobservationmapping $Haadobservationmapping
 */
class HaadobservationmappingsController extends AppController {
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
            }
            $this->Haadobservationmapping->recursive = 0;
            $this->set('haadobservationmappings', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Haadobservationmapping->id = $id;
		if (!$this->Haadobservationmapping->exists()) {
			throw new NotFoundException(__('Invalid haadobservationmapping'));
		}
		$this->set('haadobservationmapping', $this->Haadobservationmapping->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			if (!file_exists(WWW_ROOT . 'files/haadobservationmappings/')) {
                            mkdir(WWW_ROOT.'files/haadobservationmappings'); 
                        }
                        $filename   =  $values['Haadobservationmapping']['Mapping']['name']; 
                        while(file_exists(WWW_ROOT.'files/haadobservationmappings/'.$filename))
                        {
                            $filename   = rand(10, 1000).$this->request->data['Haadobservationmapping']['Mapping']['name'];
                        }
                        move_uploaded_file($this->request->data['Haadobservationmapping']['Mapping']['tmp_name'], WWW_ROOT.'files/haadobservationmappings/'.$filename);
			app::import('model',  'Commonobservationmappingfile');
                        $observationmappingfileobj     =   new Commonobservationmappingfile();
                        $observationmappingfilearray['Commonobservationmappingfile']['start_date']     = $this->request->data['Haadobservationmapping']['start_date'];
                        $observationmappingfilearray['Commonobservationmappingfile']['pricing']        = $this->request->data['Haadobservationmapping']['Mapping']['name'];
                        $observationmappingfilearray['Commonobservationmappingfile']['url']            = $filename;
                        $observationmappingfilearray['Commonobservationmappingfile']['dha_status']     = 0;
                        $observationmappingfilearray['Commonobservationmappingfile']['haad_status']    = 1;
                        $observationmappingfilearray['Commonobservationmappingfile']['status']         = 0;
                        $observationmappingfileobj->create();
                        $observationmappingfileobj->save($observationmappingfilearray);
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   "";
                        $data['Log']['Objectcategory']  =   "observationmappings";
                        $data['Log']['Header']          =   "Uploaded Haad Observation mappings file";
                        $data['Log']['Desc']            =   "The Haad Observation mappings file ".$observationmappingfilearray['Commonobservationmappingfile']['pricing']." is uploaded by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                        $this->Session->setFlash("The file has been uploaded. Please wait for the file to be processed"); 
		}
	}
        public function insertrecords($recorddata)
        {
            App::import('Vendor', 'excel_reader2');
            $data = new Spreadsheet_Excel_Reader(WWW_ROOT.'files/haadobservationmappings/'.$recorddata['Commonobservationmappingfile']['url'], true);
            $exeldata = $data->sheets['0']['cells'];
            foreach ($exeldata as $key  =>  $row)
            {
                $dhapricingarray['Haadobservationmapping']['providerpricingfile_id']     =   $recorddata['Commonobservationmappingfile']['id'];
                $dhapricingarray['Haadobservationmapping']['start_date']                 =   $recorddata['Commonobservationmappingfile']['start_date'];
                $dhapricingarray['Haadobservationmapping']['activity_type']              =   (string) $row[1];
                $dhapricingarray['Haadobservationmapping']['activity_code']              =   (string) $row[2];
                $dhapricingarray['Haadobservationmapping']['observation_code']           =   (string) $row[3];
                $dhapricingarray['Haadobservationmapping']['gross_price']                =   $row[4];
                $dhapricingarray['Haadobservationmapping']['description']                =   $row[5];
                $dhapricingarray['Dhaobservationmapping']['status']                      =   0;
                $this->Haadobservationmapping->create();
                $this->Haadobservationmapping->save($dhapricingarray);
            }
        }
        public function addsingle()
        {
           if($this->request->is('post'))
           {
               $this->request->data['Haadobservationmapping']['activity_type']  =   (string) $this->request->data['Haadobservationmapping']['activity_type'];
               $this->request->data['Haadobservationmapping']['activity_code']  =   (string) $this->request->data['Haadobservationmapping']['activity_code'];
               $this->request->data['Haadobservationmapping']['observation_code']  =   (string) $this->request->data['Haadobservationmapping']['observation_code'];
               $this->request->data['Haadobservationmapping']['gross_price']  =   (int) $this->request->data['Haadobservationmapping']['gross_price'];
               $this->request->data['Haadobservationmapping']['status']  =   0;
               $this->Haadobservationmapping->create();
               if($this->Haadobservationmapping->save($this->request->data)){
                    $this->Session->setFlash ("Observation  mappings added");
                    app::import('model','Log');
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   "";
                    $data['Log']['Objectcategory']  =   "observationmappings";
                    $data['Log']['Header']          =   "Added new Haad Observation mappings record";
                    $data['Log']['Desc']            =   "The Haad Observation mappings record with price ".$this->request->data['Haadobservationmapping']['gross_price']." is added for the activity type ".$this->request->data['Haadobservationmapping']['activity_type']." and activity code ".$this->request->data['Haadobservationmapping']['activity_code']." with the observation code ".$this->request->data['Haadobservationmapping']['observation_code']." is added by : ".$this->Session->read('Auth.User.username');
                    $logobj->create();
                    $logobj->save($data);
               }
               else
                   $this->Session->setFlash ("Failed to add the Observation mappings");
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
		$this->Haadobservationmapping->id = $id;
		if (!$this->Haadobservationmapping->exists()) {
			throw new NotFoundException(__('Invalid haadobservationmapping'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Haadobservationmapping->save($this->request->data)) {
				$this->Session->setFlash(__('The haadobservationmapping has been saved'));
                                $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The haadobservationmapping could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Haadobservationmapping->read(null, $id);
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
		$this->Haadobservationmapping->id = $id;
		if (!$this->Haadobservationmapping->exists()) {
			throw new NotFoundException(__('Invalid haadobservationmapping'));
		}
                $data   =   $this->Haadobservationmapping->find('all',array('conditions' => array('id' => $id)));
		if ($this->Haadobservationmapping->delete()) {
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   "";
                        $data['Log']['Objectcategory']  =   "observationmappings";
                        $data['Log']['Header']          =   "Haad Observation mappings deleted";
                        $data['Log']['Desc']            =   "The Haad Observation mappings record ".$data['Haadobservationmapping']['observation_code']." is deleted by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
			$this->Session->setFlash(__('Haadobservationmapping deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Haadobservationmapping was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
