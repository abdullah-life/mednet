<?php
App::uses('AppController', 'Controller');
/**
 * Dhapricings Controller
 *
 * @property Dhapricing $Dhapricing
 */
class DhapricingsController extends AppController {
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
                    $this->paginate = array(
                            'conditions' => array('code'   => trim(($this->request->data['Providerpricing']['activityid'])))
                        );
                }
		$this->Dhapricing->recursive = 0;
		$this->set('dhapricings', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Dhapricing->id = $id;
		if (!$this->Dhapricing->exists()) {
			throw new NotFoundException(__('Invalid dhapricing'));
		}
		$this->set('dhapricing', $this->Dhapricing->read(null, $id));
	}
        
        
        public function addsingle() {
                if($this->request->is('post'))
                {
                    $dhapricingarray['Dhapricing']['start_date']    =   $this->request->data['Dhapricing']['start_date'];
                    $dhapricingarray['Dhapricing']['activity']    =   (string) $this->request->data['Dhapricing']['activity_type'];
                    $dhapricingarray['Dhapricing']['code']    =   (string) $this->request->data['Dhapricing']['code'];
                    $dhapricingarray['Dhapricing']['gross']    =   (int) $this->request->data['Dhapricing']['gross'];
                    $dhapricingarray['Dhapricing']['discount']    =   $this->request->data['Dhapricing']['discount'];
                    $dhapricingarray['Dhapricing']['discountprice']    =   $this->request->data['Dhapricing']['discountprice'];
                    $this->Dhapricing->create();
                    if($this->Dhapricing->save($dhapricingarray))
                    {
                        $this->Session->setFlash("DHA pricing added");
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   "";
                        $data['Log']['Objectcategory']  =   "providerpricings";
                        $data['Log']['Header']          =   "Dha pricings is added";
                        $data['Log']['Desc']            =   "The Dha pricings ".$this->request->data['Dhapricing']['gross']." for activity type = ".$dhapricingarray['Dhapricing']['activity']." and activity code = ".$this->request->data['Dhapricing']['code']." is added by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                    }
                    else
                    {
                        $this->Session->setFlash("Flailed to add DHA pricing");
                    }
                }
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
                app::import('model',  'Providerdetail');
                $providerdetailobj  =   new Providerdetail();
		if ($this->request->is('post')) {
                        if (!file_exists(WWW_ROOT . 'files/dhapricing/')) {
                            mkdir(WWW_ROOT.'files/dhapricing'); 
                        }
                        $filename   =  $values['Dhapricing']['pricing']['name']; 
                        while(file_exists(WWW_ROOT.'files/dhapricing/'.$filename))
                        {
                            $filename   = rand(10, 1000).$this->request->data['Dhapricing']['pricing']['name'];
                        }
                        move_uploaded_file($this->request->data['Dhapricing']['pricing']['tmp_name'], WWW_ROOT.'files/dhapricing/'.$filename);
			app::import('model',  'Commonproviderpricingfile');
                        $providerpricingfileobj     =   new Commonproviderpricingfile();
                        $providerpricingfilearray['Commonproviderpricingfile']['start_date']   = $this->request->data['Dhapricing']['start_date'];
                        $providerpricingfilearray['Commonproviderpricingfile']['pricing']   = $this->request->data['Dhapricing']['pricing']['name'];
                        $providerpricingfilearray['Commonproviderpricingfile']['url']   = $filename;
                        $providerpricingfilearray['Commonproviderpricingfile']['dha_status']   = 1;
                        $providerpricingfilearray['Commonproviderpricingfile']['haad_status']   = 0;
                        $providerpricingfilearray['Commonproviderpricingfile']['status']   = 0;
                        $providerpricingfileobj->create();
                        if($providerpricingfileobj->save($providerpricingfilearray))
                        {
                            app::import('model','Log');
                            $logobj                         =   new Log();
                            $data                           =   array();
                            $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                            $data['Log']['Object']          =   "";
                            $data['Log']['Objectcategory']  =   "providerpricings";
                            $data['Log']['Header']          =   "Dha pricings file added";
                            $data['Log']['Desc']            =   "The Dha pricings file  ".$this->request->data['Dhapricing']['pricing']['name']." is added by : ".$this->Session->read('Auth.User.username');
                            $logobj->create();
                            $logobj->save($data);
                            $this->Session->setFlash("The file has been uploaded. Please wait for the file to be processed");
                        }
                        else{
                            die("Error");
                        }
                        
		}
	}
        public function insertrecords($recorddata)
        {
            App::import('Vendor', 'excel_reader2');
            $data = new Spreadsheet_Excel_Reader(WWW_ROOT.'files/dhapricing/'.$recorddata['Commonproviderpricingfile']['url'], true);
            $exeldata = $data->sheets['0']['cells'];
            foreach ($exeldata as $key  =>  $row)
            {
                $dhapricingarray['Dhapricing']['providerpricingfile_id']    =   $recorddata['Commonproviderpricingfile']['id'];
                $dhapricingarray['Dhapricing']['start_date']                =   $recorddata['Commonproviderpricingfile']['start_date'];
                $dhapricingarray['Dhapricing']['activity']                  =   (string) $row[1];
                $dhapricingarray['Dhapricing']['code']                      =   (string) $row[2];
                $dhapricingarray['Dhapricing']['gross']                     =   (string) $row[3];
                $dhapricingarray['Dhapricing']['discount']                  =   $row[4];
                $dhapricingarray['Dhapricing']['discountprice']             =   $row[5];
                $this->Dhapricing->create();
                $this->Dhapricing->save($dhapricingarray);
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
		$this->Dhapricing->id = $id;
		if (!$this->Dhapricing->exists()) {
			throw new NotFoundException(__('Invalid dhapricing'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Dhapricing->save($this->request->data)) {
				$this->Session->setFlash(__('The dhapricing has been saved'));
                                
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The dhapricing could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Dhapricing->read(null, $id);
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
		$this->Dhapricing->id = $id;
		if (!$this->Dhapricing->exists()) {
			throw new NotFoundException(__('Invalid dhapricing'));
		}
                $datas   =       $this->Dhapricing->find('first',array('conditions' => array('id' => $id)));
		if ($this->Dhapricing->delete()) {
			$this->Session->setFlash(__('Dhapricing deleted'));
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   $id;
                        $data['Log']['Objectcategory']  =   "providerpricings";
                        $data['Log']['Header']          =   "Dha pricings deleted";
                        $data['Log']['Desc']            =   "The Dha pricings ".$datas['Dhapricing']['code']." is deleted by : ".$this->Session->read('Auth.User.id');
                        $logobj->create();
                        $logobj->save($data);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Dhapricing was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
