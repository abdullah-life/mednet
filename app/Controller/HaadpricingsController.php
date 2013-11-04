<?php
App::uses('AppController', 'Controller');
/**
 * Haadpricings Controller
 *
 * @property Haadpricing $Haadpricing
 */
class HaadpricingsController extends AppController {
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
		$this->Haadpricing->recursive = 0;
		$this->set('haadpricings', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Haadpricing->id = $id;
		if (!$this->Haadpricing->exists()) {
			throw new NotFoundException(__('Invalid haadpricing'));
		}
		$this->set('haadpricing', $this->Haadpricing->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			if (!file_exists(WWW_ROOT . 'files/haadpricing/')) {
                            mkdir(WWW_ROOT.'files/haadpricing'); 
                        }
                        $filename   =  $values['Haadpricing']['pricing']['name']; 
                        while(file_exists(WWW_ROOT.'files/haadpricing/'.$filename))
                        {
                            $filename   = rand(10, 1000).$this->request->data['Haadpricing']['pricing']['name'];
                        }
                        move_uploaded_file($this->request->data['Haadpricing']['pricing']['tmp_name'], WWW_ROOT.'files/haadpricing/'.$filename);
			app::import('model',  'Commonproviderpricingfile');
                        $providerpricingfileobj     =   new Commonproviderpricingfile();
                        $providerpricingfilearray['Commonproviderpricingfile']['start_date']   = $this->request->data['Haadpricing']['start_date'];
                        $providerpricingfilearray['Commonproviderpricingfile']['pricing']   = $this->request->data['Haadpricing']['pricing']['name'];
                        $providerpricingfilearray['Commonproviderpricingfile']['url']   = $filename;
                        $providerpricingfilearray['Commonproviderpricingfile']['dha_status']   = 0;
                        $providerpricingfilearray['Commonproviderpricingfile']['haad_status']   = 1;
                        $providerpricingfilearray['Commonproviderpricingfile']['status']   = 0;
                        $providerpricingfileobj->create();
                        $providerpricingfileobj->save($providerpricingfilearray);
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   "";
                        $data['Log']['Objectcategory']  =   "providerpricings";
                        $data['Log']['Header']          =   "Haad pricings file uploaded";
                        $data['Log']['Desc']            =   "The Haad pricings file ".$providerpricingfilearray['Commonproviderpricingfile']['pricing']." is uploaded by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
                        $this->Session->setFlash("The file has been uploaded. Please wait for the file to be processed");
		}
	}
         public function insertrecords($recorddata)
        {
            App::import('Vendor', 'excel_reader2');
            $data = new Spreadsheet_Excel_Reader(WWW_ROOT.'files/haadpricing/'.$recorddata['Commonproviderpricingfile']['url'], true);
            $exeldata = $data->sheets['0']['cells'];
            foreach ($exeldata as $key  =>  $row)
            {
                $haadpricingarray['Haadpricing']['providerpricingfile_id']    =   $recorddata['Commonproviderpricingfile']['id'];
                $haadpricingarray['Haadpricing']['start_date']                =   $recorddata['Commonproviderpricingfile']['start_date'];
                $haadpricingarray['Haadpricing']['activity']                  =   (string) $row[1];
                $haadpricingarray['Haadpricing']['code']                      =   (string) $row[2];
                $haadpricingarray['Haadpricing']['gross']                     =   (string) $row[3];
                $haadpricingarray['Haadpricing']['discount']                  =   $row[4];
                $haadpricingarray['Haadpricing']['discountprice']             =   $row[5];
                $this->Haadpricing->create();
                $this->Haadpricing->save($haadpricingarray);
            }
        }
        
        public function addsingle() {
		if ($this->request->is('post')) {
                    $haadpricingarray['Haadpricing']['start_date']                =     $this->request->data['Haadpricing']['start_date'];
                    $haadpricingarray['Haadpricing']['activity']                  =     (string) $this->request->data['Haadpricing']['activity'];
                    $haadpricingarray['Haadpricing']['code']                      =     (string) $this->request->data['Haadpricing']['code'];
                    $haadpricingarray['Haadpricing']['gross']                     =     (int) $this->request->data['Haadpricing']['gross'];
                    $haadpricingarray['Haadpricing']['discount']                  =     $this->request->data['Haadpricing']['discount'];
                    $haadpricingarray['Haadpricing']['discountprice']             =     $this->request->data['Haadpricing']['discountprice'];
                    $this->Haadpricing->create();
                    $this->Haadpricing->save($haadpricingarray);
                    app::import('model','Log');
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   "";
                    $data['Log']['Objectcategory']  =   "providerpricings";
                    $data['Log']['Header']          =   "Haad pricings record added";
                    $data['Log']['Desc']            =   "The Haad pricings ".$haadpricingarray['Haadpricing']['gross']." for activity type = ".$haadpricingarray['Haadpricing']['activity']." and activity code ".$this->request->data['Haadpricing']['code']." is added by : ".$this->Session->read('Auth.User.username');
                    $logobj->create();
                    $logobj->save($data);
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
		$this->Haadpricing->id = $id;
		if (!$this->Haadpricing->exists()) {
			throw new NotFoundException(__('Invalid haadpricing'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Haadpricing->save($this->request->data)) {
				$this->Session->setFlash(__('The haadpricing has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The haadpricing could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Haadpricing->read(null, $id);
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
		$this->Haadpricing->id = $id;
		if (!$this->Haadpricing->exists()) {
			throw new NotFoundException(__('Invalid haadpricing'));
		}
                $datas   =   $this->Haadpricing->find('first',array('conditions' => array('id' => $id)));
		if ($this->Haadpricing->delete()) {
                        app::import('model','Log');
                        $logobj                         =   new Log();
                        $data                           =   array();
                        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                        $data['Log']['Object']          =   "";
                        $data['Log']['Objectcategory']  =   "providerpricings";
                        $data['Log']['Header']          =   "Haad pricings record deleted";
                        $data['Log']['Desc']            =   "The Haad pricings ".$datas['Haadpricing']['code']." is deleted by : ".$this->Session->read('Auth.User.username');
                        $logobj->create();
                        $logobj->save($data);
			$this->Session->setFlash(__('Haadpricing deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Haadpricing was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
