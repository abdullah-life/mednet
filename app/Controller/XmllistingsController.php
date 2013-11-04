<?php

App::uses('AppController', 'Controller');
App::import('Vendor', 'excel_reader2');

/**
 * Xmllistings Controller
 *
 * @property Xmllisting $Xmllisting
 */
//this is for test

class XmllistingsController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
        $this->checkpermission();
    }

    public function upload() {
        echo json_encode(array('status' => "one"));
        $this->layout = "ajax";
    }

    /**
     *  Function to control the date selection
     *  @author dijo 
     *  @return $sel_date date selected 
     */
    public function sel_date() {
        if ($this->request->is('post')) {
            $from_date = trim($this->request->data['User']['from']);
            $to_date = trim($this->request->data['User']['to']);
            if (!empty($from_date) OR !empty($to_date)) {
                if (!$from_date)
                    $from_date = $to_date;

                $this->Session->write('from_date', $from_date);
                $this->Session->write('to_date', $to_date);
            }
            else {
                $sel_date = trim(date("Y-m-d"));
            }
        }
        $this->autoRender = FALSE;
        $params = $this->request->data['params'];
        $this->redirect(array('controller' => $this->request->data['controller'], 'action' => $this->request->data['action'] . "/" . $params));
    }

    public function otherfiles_index() {
        app::import('model','Log');
        $logobj                         =   new Log();
        $data                           =   array();
        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
        $data['Log']['Object']          =   "";
        $data['Log']['Objectcategory']  =   "users";
        $data['Log']['Header']          =   "User - Page access";
        $data['Log']['Desc']            =   "The ".$this->Session->read('Auth.User.username')." accessed the  page for listing other files than DHA and HAAD files";
        $logobj->create();
        $logobj->save($data);
        $this->Xmllisting->recursive = 0;

        $this->paginate = array(
            'conditions' => array('Xmllisting.otherfile' => 1, 'created' => $this->getDateForSearch('Xmllisting'))
        );
        $this->set('xmllistings', $this->paginate());
    }

    public function index($batchid = null) {
        app::import('model','Log');
        $logobj                         =   new Log();
        $data                           =   array();
        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
        $data['Log']['Object']          =   "";
        $data['Log']['Objectcategory']  =   "users";
        $data['Log']['Header']          =   "User - Page access";
        $data['Log']['Desc']            =   "The ".$this->Session->read('Auth.User.username')." accessed the  page for listing XMLs";
        $logobj->create();
        $logobj->save($data);
        $this->Xmllisting->recursive = 0;
        if ($batchid) {
            $this->paginate = array('conditions' => array('Xmllisting.xmllisting_id' => $id));
        }
        else
            $this->paginate = array('conditions' => array('created' => $this->getDateForSearch('Xmllisting')));
        $this->set('xmllistings', $this->paginate());
    }

    /**
     * view methodexplode
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Xmllisting->id = $id;
        if (!$this->Xmllisting->exists()) {
            throw new NotFoundException(__('Invalid xml'));
        }
        $this->set('xmllisting', $this->Xmllisting->read(null, $id));
    }

    public function getAndInsertDHA() {
        $this->autoRender = FALSE;
        $data = array();
        echo "connecting to DHA WEBSERVICES \n";
        $client = new SoapClient("http://www.eclaimlink.ae/dhpo/ValidateTransactions.asmx?wsdl", array("trace" => 1, "exceptions" => 0));
        try {
            $x = $client->GetNewTransactions(array("login" => "MedNet UAE",
                "pwd" => "claimsmnu"
            ));
            if ($x) {
                echo "Connection was established \n";
            }

            if ($x->GetNewTransactionsResult == 0) {

                //$x->xmlTransaction =   ereg_replace(" & ", "&amp; ", $x->xmlTransaction);
                $x->xmlTransaction = ereg_replace("&", "&amp; ", $x->xmlTransaction);

                $DHAdata = Xml::toArray(Xml::build($x->xmlTransaction));



                if (isset($DHAdata['Files']['File'])) {
                    
                } else {
                    echo "no xmlsid's present \n";
                    return " No files found in DHA";
                }
            }

            if (!isset($DHAdata['Files']['File'])) {
                echo "found 1 file \n";
            } else {
                echo "found " . count($DHAdata['Files']['File']) . " files";
            }

            if ($DHAdata['Files']) {
                $dhacount = 0;
                if (isset($DHAdata['Files']['File'][0])) {
                    foreach ($DHAdata['Files']['File'] as $newxml) {

//                        if (!$this->checkactiveprovider($newxml['@SenderID'])) {
//                            continue;
//                        }
                        if(!$this->checkdaternage('DHA',date('Y-m-d', strtotime(str_replace("/", "-",$newxml['@TransactionDate']))))){
                            continue;
                        }
                        if (!$this->checkduplicatefileID($newxml['@FileID'])){
                         echo "duplicate \n ";
                         continue;
                        }else{
                            echo $newxml['@FileID']." \n";
                        }
                        $data[$dhacount]['FileID'] = $newxml['@FileID'];
                        $data[$dhacount]['place'] = 1;
                        $data[$dhacount]['FileName'] = $newxml['@FileName'];
                        $data[$dhacount]['SenderID'] = $newxml['@SenderID'];
                        $data[$dhacount]['ReceiverID'] = $newxml['@ReceiverID'];
                        $data[$dhacount]['TransactionDate'] = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $newxml['@TransactionDate'])));
                        $data[$dhacount]['RecordCount'] = $newxml['@RecordCount'];
                        $data[$dhacount]['cron_status'] = 0;
                        $data[$dhacount]['marked'] = 1;
                        $this->settransactiondownloadeddha($data[$dhacount]['FileID']);
                        $dhacount++;
                        
                    }
                } else {
                    if (!$this->checkactiveprovider($DHAdata['Files']['File']['@SenderID'])) {
                        continue;
                    }
                    if(!$this->checkdaternage('DHA',date('Y-m-d', strtotime(str_replace("/", "-", $DHAdata['Files']['File']['@TransactionDate']))))){
                            continue;
                        }
                    if (!$this->checkduplicatefileID($DHAdata['Files']['File']['@FileID'])){
                         echo "duplicate \n ";
                         continue;
                    }else{
                        echo $newxml['@FileID']." \n";
                    }
                    
                    $data[$dhacount]['FileID'] = $DHAdata['Files']['File']['@FileID'];
                    $data[$dhacount]['place'] = 1;
                    $data[$dhacount]['FileName'] = $DHAdata['Files']['File']['@FileName'];
                    $data[$dhacount]['SenderID'] = $DHAdata['Files']['File']['@SenderID'];
                    $data[$dhacount]['ReceiverID'] = $DHAdata['Files']['File']['@ReceiverID'];
                    $data[$dhacount]['TransactionDate'] = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $DHAdata['Files']['File']['@TransactionDate'])));
                    $data[$dhacount]['RecordCount'] = $DHAdata['Files']['File']['@RecordCount'];
                    $data[$dhacount]['marked'] = 1;
                    $data[$dhacount]['cron_status'] = 0;
                    $this->settransactiondownloadeddha($data[$dhacount]['FileID']);
                    $dhacount++;
                }
                app::import('model', 'newfile');

                $newfile = new Newfile();
                if ($data) {
                    if ($newfile->saveAll($data)) {
                        echo "DHA xml ids saved";
                        return "dha";
                    } else {
                        echo "could not save xmls";
                    }
                } else {
                    echo "No new files found";
                }
            }
        } catch (SoapFault $exception) {
            echo $exception;
            $fh = fopen(WWW_ROOT . 'files/xmlprocessed/newerrro.xml', 'w');
            if (!$fh)
                echo "ERROR Not able to created file @ 174";
            fwrite($fh, $x->xmlTransaction);
        }
    }

    public function checkactiveprovider($providerid,$place) {
        App::import('model', 'Providerdetail');
        $Providerdetailobj = new Providerdetail();
        $provider = $Providerdetailobj->find('first', array('conditions' => array('licence' => $providerid)));
        if(count($provider['Providerdetail']['id'])>0)
        {
            if($provider['Providerdetail']['active'] == 1)
            {
                return true;
            }
            else{
                echo "Not active";
                return false;
            }
        }
        else{
            app::import('model','Missingprovider');
            $missingproviderobj         =   new Missingprovider();
            $data   =   array();
            $data['Missingprovider']['licence'] = $providerid;
            $data['Missingprovider']['status'] = 0;
            if($place==1)
            {
                $data['Missingprovider']['ReceiverID']='C004';
            }
            else
            {
                $data['Missingprovider']['ReceiverID']='TPA009';
            }
            $missingproviderobj->create();
            $missingproviderobj->save($data);
            return false;
            
        }
//        echo $providerid." count ".$provider." \n";
//        if ($provider > 0)
//            return true;
//        else
//            return false;
    }
    
    public function callhaadapi(){
        app::import('model','Xml');
        $xmlobj     =   new Xml();
        $client = new SoapClient("https://www.shafafiya.org/v2/webservices.asmx?wsdl", array("trace" => 1, "exceptions" => 0));
        try {
            $x = $client->GetNewTransactions(array("login" => "Mednet", "pwd" => "ph7gAbe4"));
            if ($x)
                echo "Connected to MEDNET \n";
             $newxmltransactions = $xmlobj->toArray($xmlobj->build($x->xmlTransactions));
             print_r($newxmltransactions);
        }  catch (SoapFault $exception){
            die("Error");
        }
        $this->settransactiondownloadedhaad('5dcb05a8-15fd-42f5-bde6-e1da03113a48');
        $this->settransactiondownloadedhaad('bd715bb5-556a-447d-8586-6ed9b7840fd5');
    }
    public function checkdaternage($place=null,$date){
       
        $startdate      =   strtotime($date);
        if($place!=null){
            $benchmarkdate  =   strtotime('2013-05-01');
        }
        $benchmarkdate  =   strtotime('2013-05-15');
       
        if($startdate>=$benchmarkdate)
            return true;
        else {
               return false; 
        }
        
                
    }
    public function getAndInsertHaad() {
        $this->autoRender = FALSE;
        echo "connecting to Webserves \n";
        $client = new SoapClient("https://www.shafafiya.org/v2/webservices.asmx?wsdl", array("trace" => 1, "exceptions" => 0));
        try {
            $x = $client->GetNewTransactions(array("login" => "Mednet", "pwd" => "ph7gAbe4"));
            if ($x)
                echo "Connected to MEDNET \n";
            if ($x->GetNewTransactionsResult == 0) {
                //list of all the new xmls
                try {
                    $x->xmlTransaction = ereg_replace(" & ", "&amp; ", $x->xmlTransaction);
                    $newxmltransactions = Xml::toArray(Xml::build($x->xmlTransactions));
                } catch (SoapFault $exception) {
                    echo "error getting xml";
                    return "error trying to pick getAndInsertHaad \n";
               
                $haadcount = 0;
                echo count($newxmltransactions['Files']['File']) . " Files found \n";
                foreach ($newxmltransactions['Files']['File'] as $newxml) {
                    // echo "checking if provider ".$newxml['@SenderID']."  is active \n";
//                    if (false) {
//                        echo "The provider is not active \n";
//                        continue;
//                    } else {
//                        echo "active provider found " . $newxml['@SenderID'] . "\n";
//                    }
                    if(!$this->checkdaternage('',date('Y-m-d', strtotime(str_replace("/", "-", $newxml['@TransactionDate']))))){
                        continue;
                    }
                  
                        echo "calling duplicat check at 245 \n";
                     if (!$this->checkduplicatefileID($newxml['@FileID'])){
                         echo "duplicate \n ";
                         continue;
                    }else{
                        echo $newxml['@FileID']." \n";
                    }
                    echo "arraging the data \n";
                        
                    $data[$haadcount]['FileID'] = $newxml['@FileID'];
                    $data[$haadcount]['place'] = 2;
                    $data[$haadcount]['FileName'] = $newxml['@FileName'];
                    $data[$haadcount]['SenderID'] = $newxml['@SenderID'];
                    $data[$haadcount]['ReceiverID'] = $newxml['@ReceiverID'];
                    $data[$haadcount]['TransactionDate'] = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $newxml['@TransactionDate'])));
                    $data[$haadcount]['RecordCount'] = $newxml['@RecordCount'];
                    $data[$haadcount]['marked'] = 1;
                    $data[$haadcount]['cron_status'] = 0;
                    $this->settransactiondownloadedhaad($data[$haadcount]['FileID']);
                    $haadcount++;
                    //creating xml foe HAAD
                }

                app::import('model', 'newfile');
                $newfile = new Newfile();
                echo "saving all the file id's into newfile \n";


                if ($data) {
                    if ($newfile->saveAll($data))
                        echo "haad xml ids saved successfully \n";
                    return "saved haad \n";
                }else {
                    echo "No records found \n";
                }
            }}
        } catch (SoapFault $exception) {
            echo $exception;
        }
    }

    /**
     * Maily gets the list of xml from dha as we as HAAD, 
     *
     * @param no params to pass, just run  cron, single time a day
     *
     */
    function pickallxml() {
        $this->autoRender = false;
        //picking haad from shafafiya
        echo "picking HAAD xml ids (newfiles) \n";
        $haad = $this->getAndInsertHaad();
        echo "Picking marked xmls";  
        $this->searchandinsertHaad(); 
        
        //picking DHA from eclaim link
         echo "picking DHA xml ids (newfiles) \n";
         $dha     =   $this->getAndInsertDHA(); 
          
        $this->searchandinsertDHA(); 
        
        
        $this->layout = "ajax";
    }
     public function searchandinsertDHA(){
         $curdate    =    date("d-m-Y");  
         $last    =     date("d-m-Y", strtotime("-2 months"))  ;
         $client = new SoapClient("http://www.eclaimlink.ae/dhpo/ValidateTransactions.asmx?wsdl",array(  "trace"    => 1, "exceptions" => 0));
                try{
                    $y = $client->SearchTransactions( array( "login" => "MedNet UAE",
                                                                                   "pwd" => "claimsmnu",
                                                                                   'transactionID'=>-1,
                                                                                    'direction'=>2,
                                                                                    'TransactionStatus'=>2,
                                                                                     'transactionFromDate'=>'01-08-2013',
                                                                                     'transactionToDate'=> $curdate,
                                                                                     'minRecordCount'=>-1,
                                                                                     'maxRecordCount'=>-1,
                       
                                                                               ));
                     if($y){
                        
                         $newfiles     =    Xml::build($y->foundTransactions);
                         $haadcount =   0;
                    
                         foreach ($newfiles as $key=> $newxml) {
                            
                            // echo "checking if provider ".$newxml['@SenderID']."  is active \n";
//                            if (!$this->checkactiveprovider(end($newxml->attributes()->SenderID[0]))) {
//
//                                echo "The provider is not active \n";
//                                continue;
//                            } else {
//                                echo "active provider found " . $newxml['SenderID'] . "\n";
//                            }

                            if (!$this->checkduplicatefileID(end($newxml->attributes()->FileID[0]))){
                                 echo "duplicate \n ..taking next \n";
                                continue;
                            }
                            
                            echo "arraging the data \n";
                            
                            
                            $data[$haadcount]['FileID'] = end($newxml->attributes()->FileID[0]);
                            $data[$haadcount]['place'] = 1;
                            $data[$haadcount]['FileName'] = end($newxml->attributes()->FileName[0]);
                            $data[$haadcount]['SenderID'] = end($newxml->attributes()->SenderID[0]);
                            $data[$haadcount]['ReceiverID'] = end($newxml->attributes()->ReceiverID[0]);
                            $data[$haadcount]['TransactionDate'] = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", end($newxml->attributes()->TransactionDate[0]))));
                            $data[$haadcount]['RecordCount'] = end($newxml->attributes()->RecordCount[0]);
                            $data[$haadcount]['marked'] = (end($newxml->attributes()->IsDownloaded[0])) ? 1 : 0;
                            $data[$haadcount]['cron_status'] = 0;
                            
                            $haadcount++;
                            //creating xml foe HAAD
                        }
                        
                        app::import('model', 'newfile');
                        $newfile = new Newfile();
                        echo "saving all the file id's into newfile \n";

                        if ($data) {
                            if ($newfile->saveAll($data))
                                echo "haad xml ids saved successfully \n";
                            return "saved haad \n";
                        }else {
                            echo "No records found \n";
                        }

                        echo "inserted \n";
                        
                        
                     }
                }catch (SoapFault $exception) {
                      echo "error";
                     
                    
                }
                
     }
     public function xmlthroughemails(){
         
         if($this->request->is("post"))
         {
             if(!file_exists(WWW_ROOT."files/Emailxmls/")){
                 mkdir(WWW_ROOT."files/Emailxmls");
             }
             $fname =   $this->request->data['emailxmls']['xmls']['name'];
             while(file_exists(WWW_ROOT."files/Emailxmls/".$fname)){
                 $fname     =   rand(10,1000).$fname;
             }
             if(move_uploaded_file($this->request->data['emailxmls']['xmls']['tmp_name'],WWW_ROOT."files/Emailxmls/" .$fname)){
                 $data  =   array();
                 $data['Xmllisting']['name'] = $this->request->data['emailxmls']['xmls']['name'];
                 $data['Xmllisting']['url'] = $fname;
                 $data['Xmllisting']['manual_upload_status'] = 0;
                 $data['Xmllisting']['place'] = $this->request->data['emailxmls']['Location'];
                 $data['Xmllisting']['user'] = $this->Session->read('Auth.User.id');
                 $this->Xmllisting->create();
                 if($this->Xmllisting->save($data)){
                    $this->Session->setFlash("XML uploaded succesfully");
                    app::import('model','Log');
                    $logobj                         =   new Log();
                    $data                           =   array();
                    $data['Log']['User']            =   $this->Session->read('Auth.User.id');
                    $data['Log']['Object']          =   "";
                    $data['Log']['Objectcategory']  =   "users";
                    $data['Log']['Header']          =   "Xml Upload for batching";
                    $data['Log']['Desc']            =   "The ".$this->Session->read('Auth.User.username')."uploaded the".$this->request->data['emailxmls']['xmls']['name']." XML to Split  : ";
                    $logobj->create();
                    $logobj->save($data);
                 }
                 else{
                     $this->Session->setFlash("Failed to upload the xml");
                 }
             }
             else{
                 $this->Session->setFlash("Failed to upload the xml");
             }
             
         }
         $places    =   array(
                            "1" => "TPA009",
                            "2" => "C004"
                        );
        $this->set('place',$places);
     }
    public function settransactiondownloadeddha($fileid=null){
        echo "Exiting from marking";
        return;
        if($fileid){
            $client = new SoapClient("http://www.eclaimlink.ae/dhpo/ValidateTransactions.asmx?wsdl",array(  "trace"    => 1, "exceptions" => 0));
            try{
                $params  =   array ("login" => "MedNet UAE",
                                    "pwd" => "claimsmnu", 
                                    "fieldId" =>$fileid,
                                    );
                $x = $client->SetTransactionDownloaded($params);
                print_r($x);        
            }catch (SoapFault $exception) {
                print_r ($exception);
            }
        }
    }
    public function settransactiondownloadedhaad($fileid=null){
        echo "Exiting from marking";
        return;
        if($fileid){
            $client = new SoapClient("https://www.shafafiya.org/v2/webservices.asmx?wsdl",array(  "trace"    => 1, "exceptions" => 0));
                try{
                    $haadxml                  =     $client->SetTransactionDownloaded( array (
                                                                            "login" => "Mednet",
                                                                            "pwd"  => "ph7gAbe4", 
                                                                            "fileId" => $fileid
                                                                          ));
                    print_r($haadxml);
                }catch (SoapFault $exception) {
                        print_r( $exception);
                }
        }
    }
    public function checkduplicatefileID($fileID = null) {
        //return true;
        app::import('model', 'newfile');
        $newfile = new Newfile();
        $newfilecount = $newfile->find('count', array('conditions' => array('FileID' => $fileID)));
        if ($newfilecount == 0)
            return true;
        else
            return false;
    }

    public function searchandinsertHaad() {

        
        $curdate    =    date("d-m-Y");  
        $last    =     date("d-m-Y", strtotime("-2 months"))  ;
    
        $client = new SoapClient("https://www.shafafiya.org/v2/webservices.asmx?wsdl", array("trace" => 1, "exceptions" => 0));
        try {
            $x = $client->SearchTransactions(array("login" => "Mednet",
                "pwd" => "ph7gAbe4",
                'transactionID' => -1,
                'direction' => 2,
                'transactionStatus' => 2,
                'transactionFromDate' => $last,
                'transactionToDate' => $curdate,
                'minRecordCount' => -1,
                'maxRecordCount' => -1,
            ));
            if ($x) {


                //list of all the new xmls
                try {
                    
                    $x->xmlTransaction = ereg_replace(" & ", "&amp; ", $x->foundTransactions);
                    if($x->foundTransactions==NULL)
                        return;
                    $newxmltransactions = Xml::toArray(Xml::build($x->foundTransactions));
                    
                } catch (SoapFault $exception) {
                    echo "error getting xml";
                    return "error trying to pick getAndInsertHaad \n";
                }
                $haadcount  =   0;
                foreach ($newxmltransactions['Files']['File'] as $newxml) {
                    
                   
                     echo "checking if provider ".$newxml['@SenderID']."  is active \n";
//                    if (!$this->checkactiveprovider($newxml['@SenderID'])) {
//                        echo "The provider is not active \n";
//                        continue;
//                    } else {
//                        echo "active provider found " . $newxml['@SenderID'] . "\n";
//                    }
                    if (!$this->checkduplicatefileID($newxml['@FileID'])){
                        echo "duplicate found \n";
                        continue;
                        
                    }else{
                     echo "arraging array \n";   
                    }
                    echo $haadcount;
                    echo $newxml['@FileID'];
                    $data[$haadcount]['FileID'] = $newxml['@FileID'];
                    $data[$haadcount]['place'] = 2;
                    $data[$haadcount]['FileName'] = $newxml['@FileName'];
                    $data[$haadcount]['SenderID'] = $newxml['@SenderID'];
                    $data[$haadcount]['ReceiverID'] = $newxml['@ReceiverID'];
                    $data[$haadcount]['TransactionDate'] = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $newxml['@TransactionDate'])));
                    $data[$haadcount]['RecordCount'] = $newxml['@RecordCount'];
                    $data[$haadcount]['marked'] = ($newxml['@IsDownloaded']) ? 1 : 0;
                    $data[$haadcount]['cron_status'] = 0;
                    $haadcount++;
                    //creating xml foe HAAD
                }
               
                app::import('model', 'newfile');
                $newfile = new Newfile();
                echo "saving all the file id's into newfile \n";
                
                
               
                if ($data) {
                    if ($newfile->saveAll($data))
                        echo "haad xml ids saved successfully \n";
                    return "saved haad \n";
                }else {
                    echo "No records found \n";
                }

                echo "inserted \n";
            }
        } catch (SoapFault $exception) {
            echo "error";
        }
    }

    public function xmlstructure($id = null) {
        $this->Xmllisting->id = $id;
        if ($this->Xmllisting->exists()) {
            $data = $this->Xmllisting->read(null, $id);
            $this->set('xml', $data);
        } else {
            throw new NotFoundException('The xml was not found');
        }
    }

    public function splitxmlandinsert($xmlarray, $xmllistingid) {


        $this->autoRender = FALSE;
        $claimcount = 0;
        $claim = array();
        $message = "";
        if (isset($xmlarray['Claim.Submission'])) {
            $this->resubmissionclaimsfound = 0;
            foreach ($xmlarray['Claim.Submission'] as $key => $val) {
                if ($key == "Header") {
                    $header = array();
                    $header = $val;
                    $header['TransactionDate'] = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $val['TransactionDate'])));
                    $header['TransactionDate'] = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $val['TransactionDate'])));
                    $header['xmllisting_id'] = $xmllistingid;
                    $header['ReceiverID'] = (string) $val['ReceiverID'];
                    if (trim($val['ReceiverID']) == 'C004') {
                        $this->place = 0;
                    }
                    if (trim($val['ReceiverID']) == 'TPA009') {
                        $this->place = 1;
                    }
                    print_r($header);
                    sleep(1);
                    $this->Xmllisting->Header->create();
                    if ($this->Xmllisting->Header->save($header))
                        echo "header saved";
                }
                else {
                    if ($key == "Claim") {
                        echo "extracting all claims";
                        echo "checking if the array has any issues! \n";
                        $rawdata = array();
                        if (!isset($val['0'])) {
                            echo " missiong 0th key, so adding that \n";
                            $rawdata[0] = $val;
                        } else {
                            echo "perfect array... parsing it \n";
                            $rawdata = $val;
                        }
                        $claim['xmllisting_id'] = $xmllistingid;
                        $claim = array();
                        foreach ($rawdata as $secondkey => $secondvalue) {

                            $claim['xmllisting_id'] = $xmllistingid;

                            $claim['claim']['xmlclaimID'] = (string) $secondvalue['ID'];
                            $claim['claim']['MemberID'] = (string) $secondvalue['MemberID'];
                            $claim['claim']['PayerID'] = (string) $secondvalue['PayerID'];
                            $claim['claim']['ProviderID'] = (string) $secondvalue['ProviderID'];
                            $claim['claim']['EmiratesIDNumber'] = (string) $secondvalue['EmiratesIDNumber'];
                            $claim['claim']['Gross'] = (string) $secondvalue['Gross'];
                            $claim['claim']['PatientShare'] = (string) $secondvalue['PatientShare'];
                            $claim['claim']['Net'] = (string) $secondvalue['Net'];

                            echo "fetching data for encounter \n";
                            $Encounter = $secondvalue['Encounter'];
                            $Encounter['Start'] = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $Encounter['Start'])));
                            if (isset($Encounter['End']))
                                $Encounter['End'] = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $Encounter['End'])));
                            if ($Encounter)
                                $claim['claim']['Encounter'] = $Encounter;
                            $claim['claim']['Diagnosis'] = $secondvalue['Diagnosis'];
                            $claim['claim']['markedresubmission'] = 0;
                            if (isset($secondvalue['Resubmission'])) {
                                $claim['claim']['Resubmission'] = $secondvalue['Resubmission'];
                                $claim['claim']['markedresubmission'] = 1;
                                $this->resubmissionclaimsfound = 1;
                            }
                            $activitybigdata = array();
                            if (!isset($secondvalue['Activity'][0])) {
                                $activitybigdata[0] = $secondvalue['Activity'];
                            } else {
                                $activitybigdata = $secondvalue['Activity'];
                            }
                            if (isset($secondvalue['Contract'])) {
                                $claim['claim']['Contract'] = $secondvalue['Contract'];
                            }

                            if (!isset($secondvalue['Activity'][0])) {
                                $activitybigdata[0] = $secondvalue['Activity'];
                            } else {
                                $activitybigdata = $secondvalue['Activity'];
                            }
                            $this->Xmllisting->Claim->create();
                            if ($this->Xmllisting->Claim->save($claim)) {
                                $claimlastinsertid = $this->Xmllisting->Claim->getLastInsertID();
                            }
                            $activitydata = array();
                            foreach ($activitybigdata as $Activitykey => $Activityarray) {

                                $activitydata[$Activitykey]['Activity']['claim_id'] = $claimlastinsertid;
                                $activitydata[$Activitykey]['Activity']['xmllisting_id'] = $xmllistingid;
                                if (isset($Activityarray['ID']))
                                    $activitydata[$Activitykey]['Activity']['Activity_id'] = (string) $Activityarray['ID'];
                                if (isset($Activityarray['Type']))
                                    $activitydata[$Activitykey]['Activity']['Type'] = (string) $Activityarray['Type'];
                                if (isset($Activityarray['Code'])) {
                                    $Activityarray['Code'] = (string) $Activityarray['Code'];
                                    if ($this->place == 1 AND $Activityarray['Code'] == '6') {
                                        $activitydata[$Activitykey]['Activity']['Code'] = 96;
                                    } else {
                                        $activitydata[$Activitykey]['Activity']['Code'] = (string) $Activityarray['Code'];
                                    }
                                }
                                if (isset($Activityarray['Quantity']))
                                    $activitydata[$Activitykey]['Activity']['Quantity'] = (string) $Activityarray['Quantity'];
                                if (isset($Activityarray['Net']))
                                    $activitydata[$Activitykey]['Activity']['Net'] = (string) $Activityarray['Net'];
                                if (isset($Activityarray['Clinician']))
                                    $activitydata[$Activitykey]['Activity']['Clinician'] = (string) $Activityarray['Clinician'];
                                if (isset($Activityarray['PriorAuthorizationID']))
                                    $activitydata[$Activitykey]['Activity']['PriorAuthorizationID'] = (string) $Activityarray['PriorAuthorizationID'];
                                if (isset($Activityarray['Start']))
                                    $activitydata[$Activitykey]['Activity']['start'] = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $Activityarray['Start'])));
                                if (isset($Activityarray['End']))
                                    $activitydata[$Activitykey]['Activity']['End '] = date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $Activityarray['End'])));
                                if (isset($Activityarray['Observation'])) {
                                    $activitydata[$Activitykey]['Activity']['Observation'] = $Activityarray['Observation'];
                                }
                                $activitydata[$Activitykey]['Activity']['marked'] = 0;
                            }
                            $claim['claim']['Activity'] = $activitydata;
                            $this->Xmllisting->Claim->Activity->saveAll($activitydata);
                        }
                    }
                }
            }
            $this->creatematernityxmls($xmlarray, $xmllistingid);
            
        } else {
            echo "this is an authorization file \n";
            if ($this->Xmllisting->save(array('id' => $xmllistingid, 'otherfile' => 1)))
                echo "otherfile found";
        }
    }

    /**
     * Run by cron, PIcks up an XML and  parses it creates a copy of the xml with the data parsed and saved....
     * * */
    public function getHaadApi($xmldetails = null) {
        $this->autoRender = FALSE;
        echo "getting HAAD xml by calling WEBSERVICE \n";

        if ($xmldetails) 
            {
            $client = new SoapClient("https://www.shafafiya.org/v2/webservices.asmx?wsdl", array("trace" => 1, "exceptions" => 0));
            try {
                $haadxml = $client->DownloadTransactionFile(array(
                    "login" => "Mednet",
                    "pwd" => "ph7gAbe4",
                    "fileId" => $xmldetails,
                ));
                if (!property_exists($haadxml, "DownloadTransactionFileResult")) {
                    $this->getHaadApi($xmldetails);
                }


                if ($haadxml->DownloadTransactionFileResult == 0) {
                    echo "File picked \n";
                    if (trim($haadxml->file))
                        return $haadxml;
                    else {
                        echo "claim cound not be picked going for again \n";
                        $this->getHaadApi($xmldetails);
                    }
                }
                else
                    echo "Error :" . $x->errorMessage;
            } catch (SoapFault $exception) {
                $this->getHaadApi($xmldetails);
            }
        } else {

            echo ("ERROR haad details passed is not valid");
        }
    }

    public function getDhaApi($xmldetails = null) {
        $this->autoRender = FALSE;
        if ($xmldetails) {
            echo "connecting DHA WEBSERVICE \n";

            $client = new SoapClient("http://www.eclaimlink.ae/dhpo/ValidateTransactions.asmx?wsdl", array("trace" => 1, "exceptions" => 0));

            try {

                $x = $client->DownloadTransactionFile(array(
                    "login" => "MedNet UAE",
                    "pwd" => "claimsmnu",
                    "fileId" => $xmldetails,
                ));

                if (!property_exists($x, "DownloadTransactionFileResult")) {
                    $this->getDhaApi($xmldetails);
                }

                if ($x->DownloadTransactionFileResult == 0) {
                    echo "collected the file using webservice";
                    if (trim($x->file))
                        return $x;
                    else {
                        echo "cound not pick starting again \n";
                        $this->getDhaApi($xmldetails);
                    }
                }
            } catch (SoapFault $exception) {
                echo "Could not get the file using the webservice";
                $this->getDhaApi($xmldetails);
            }
        }
    }

    public function getnewfiles() {
        app::import('model', 'newfile');
        $newfileobj = new Newfile();
        do {
            $params = array(
                'conditions' => array('created' => $this->getDateForConsoleSearch()),
                'conditions' => array('cron_status' => 0),
            );
            $newfilecount = $newfileobj->find('count', $params);
            echo $newfilecount;

            $this->getNewFileUnprocessedXml();
        } while ($newfilecount > 0);
    }

    public function getNewFileUnprocessedXml() {
        $this->autoRender = FALSE;
        app::import('model', 'newfile');
        $newfileobj = new Newfile();
        $params = array(
            'conditions' => array('created' => $this->getDateForConsoleSearch()),
            'conditions' => array('cron_status' => 0),
        );
        $newfile = $newfileobj->find('first', $params);
        $name = str_replace(' ', '', $newfile['Newfile']['FileName']);

        if (!$newfile['Newfile']['FileID']) {
            $newfileobj->id = $newfile['Newfile']['id'];
            if ($newfileobj->save(array('id' => $newfile['Newfile']['id'], 'cron_status' => 1)))
                echo "updated cron status in new files \n \n ";
            return true;
        }
        
        echo "starting to process newfile ID:" . $newfile['Newfile']['id'] . " \n";
        if($this->checkactiveprovider($newfile['Newfile']['SenderID'],$newfile['Newfile']['place']))
        {
            echo "The provider is active. Saving the file to xmllistings";
        }else{
            echo "Provider ".$newfile['Newfile']['SenderID']." is not active";
            $newfileobj->save(array('id' => $newfile['Newfile']['id'], 'cron_status' => 1));
            return;
        }
        
        //renaming the file it is already present
        echo "renaming the file to avoid overwriting..\n";
        $date = date('Ymd');
        if (!file_exists(WWW_ROOT . 'files/xmlunprocessed/' . $date)) {
            mkdir(WWW_ROOT . 'files/xmlunprocessed/' . $date);
        }
        do {
            srand((double) microtime() * 1000000);
            $random_num = rand(0, 1000);
            $name = $random_num . $name;
        } while (file_exists(WWW_ROOT . 'files/xmlunprocessed/' . $date . '/' . $name));

        echo 'xml url : ' . $name . " \n";

        if ($newfile['Newfile']['place'] == 1) {
            echo "XMl belongs to DHA.. calling function getDhaApi() \n";
            $xmldata = $this->getDhaApi($newfile['Newfile']['FileID']);
        } else {
            echo "XMl belongs to HAAD.. calling function getHaadApi() \n";
            $xmldata = $this->getHaadApi($newfile['Newfile']['FileID']);
        }
        $xmlfile = $name;
        $xmlfile . " \n \n";

        echo "Writing the file to unproceesed folder  name:" . $date . "/" . $name . " \n";
        $fh = fopen(WWW_ROOT . 'files/xmlunprocessed/' . $date . '/' . $xmlfile, 'w');
        if (!$fh) {
            echo "could not write file successfully \n";
        }
        if (!fwrite($fh, $xmldata->file)) {
            echo "could not write file successfully \n";
            return "not able to write xml";
        }


        if (end(explode('.', $xmldata->fileName)) == "zip" OR end(explode('.', $xmldata->fileName)) == "ZIP") {

            //now unzip it
            echo "The file is a zip file. \n";
            $zip = new ZipArchive;
            if (!$zip)
                echo "ERRROR :no zip installed at 551";

            if ($zip->open(WWW_ROOT . 'files/xmlunprocessed/' . $date . '/' . $name) === TRUE) {
                $unzipfoldername = substr($name, 0, -4);
                echo "Unzipping the file to " . $unzipfoldername . " \n";

                if ($zip->extractTo(WWW_ROOT . 'files/xmlunprocessed/' . $date . '/' . $unzipfoldername)) {
                    echo "Creating the unziped folder @" . WWW_ROOT . 'files/xmlunprocessed/' . $date . '/' . $unzipfoldername . " \n";
                    echo "the zile file contains " . count(glob(WWW_ROOT . 'files/xmlunprocessed/' . $date . '/' . $unzipfoldername . "/*.xml")) . " xml file \n";
                    if ($handle = opendir(WWW_ROOT . 'files/xmlunprocessed/' . $date . '/' . $unzipfoldername)) {
                        echo "reading each file inside the unziped folder \n";
                        while (false !== ($entry = readdir($handle))) {
                            if ($entry != "." && $entry != "..") {
                                echo "looping through each xml \n";
                                try {
                                    echo "reading xml " . $unzipfoldername . '/' . $entry . " \n ";
                                    $xmlbuild = Xml::build(WWW_ROOT . 'files/xmlunprocessed/' . $date . '/' . $unzipfoldername . '/' . $entry);
                                } catch (Exception $e) {
                                    echo "could not read xml " . $unzipfoldername . '/' . $date . '/' . $entry . " \n ";
                                    return "could not parse xml HAAD ziped xml " . $name;
                                }
                                $xmlarray = Xml::toArray($xmlbuild);
                                // reached here this means that the xml is picked and parsed successfully... 
                                // create a new entry into the xmlisting table
                                //but get the name of the place (1=abudabi,2=dubai)

                                $xmllisting = array();
                                $xmllisting['Xmllisting']['name'] = $newfile['Newfile']['FileName'];
                                $xmllisting['Xmllisting']['user_id'] = "3";
                                $xmllisting['Xmllisting']['newfile_id'] = $newfile['Newfile']['id'];
                                $xmllisting['Xmllisting']['xmlstatus'] = 0;
                                $xmllisting['Xmllisting']['cronstatus'] = 0;
                                $xmllisting['Xmllisting']['otherfile'] = 0;
                                //dubai=1,abudabi=2
                                //coo4  =   abudabi == 2
                                if (isset($xmlarray['Claim.Submission']))
                                    $xmllisting['Xmllisting']['place'] = (strtolower($xmlarray['Claim.Submission']['Header']['ReceiverID']) == "c004") ? 2 : 1;

                                if (isset($xmlarray['Prior.Request']))
                                    $xmllisting['Xmllisting']['place'] = (strtolower($xmlarray['Prior.Request']['Header']['ReceiverID']) == "c004") ? 2 : 1;

                                $xmllisting['Xmllisting']['xml_url'] = $unzipfoldername . '/' . $entry;

                                $this->Xmllisting->create();
                                if ($this->Xmllisting->save($xmllisting)) {

                                    echo "Created XMllisting for the ziped file with cron status 0 \n";
                                    $newfileobj->id = $newfile['Newfile']['id'];
                                    if ($newfileobj->save(array('id' => $newfile['Newfile']['id'], 'cron_status' => 1)))
                                        echo "updated cron status in new files";
                                    else
                                        echo "Error updating status";
                                    echo "New xml listing created id:" . $this->Xmllisting->getLastInsertID() . " \n";
                                    return $this->Xmllisting->getLastInsertID();
                                }
                            }
                        }
                    }else {
                        echo "error while opening the zip directory for" . $unzipfoldername . " \n";
                        return "error while opening the zip directory for" . $unzipfoldername;
                    }
                } else {
                    echo "could not extract " . $unzipfoldername . " \n";
                    return ("could not extract " . $unzipfoldername);
                }
            } else {
                echo "Zip not working \n";
                return "zip not working";
            }
        } else if (end(explode('.', $xmldata->fileName)) == "xml" OR end(explode('.', $xmldata->fileName)) == "XML") {

            echo "XML file found";
            try {
                $xmlbuild = Xml::build($xmldata->file);
            } catch (Exception $e) {
                return "Error::could not parse xml HAAD at line 533 " . $name;
            }

            $xmlarray = Xml::toArray($xmlbuild);
            // reached here this means that the xml is picked and parsed successfully... 
            // create a new entry into the xmlisting table
            //but get the name of the place (1=abudabi,2=dubai)
            $xmllisting = array();

            $xmllisting['Xmllisting']['name'] = $newfile['Newfile']['FileName'];
            $xmllisting['Xmllisting']['user_id'] = "3";
            $xmllisting['Xmllisting']['newfile_id'] = $newfile['Newfile']['id'];
            $xmllisting['Xmllisting']['xmlstatus'] = 0;
            $xmllisting['Xmllisting']['cronstatus'] = 0;
            $xmllisting['Xmllisting']['otherfile'] = 0;
            //dubai=1,abudabi=2
            //coo4  =   abudabi == 2
            $xmllisting['Xmllisting']['place'] = ($xmlarray['Claim.Submission']['Header']['ReceiverID'] == "C004") ? 2 : 1;
            $xmllisting['Xmllisting']['xml_url'] = $name;
            $this->Xmllisting->create();
            if ($this->Xmllisting->save($xmllisting)) {
                echo "Created the xml listing \n";
                $newfileobj->id = $newfile['Newfile']['id'];
                if ($newfileobj->save(array('id' => $newfile['Newfile']['id'], 'cron_status' => 1)))
                    echo "updated cron status in new files \n \n ";
                else
                    return $this->Xmllisting->getLastInsertID();
            }
        }else {
            echo "Unsupported formats";
            return("unsupported format");
        }
    }

    public function loopxmlandparse() {
        echo " executing function  loopxmlandparse...\n \n";
        $date = "'" . trim(date("Y-m-d")) . "'";
        $this->Xmllisting->recursive = -1;
        $paramsunprocessedxml = array(
            'conditions' => array('created' => $this->getDateForConsoleSearch()),
            'conditions' => array('cronstatus' => 0),
        );
        $unprocessedxml = $this->Xmllisting->find('count', $paramsunprocessedxml);

        echo "the number of file to loop  parse and save" . $unprocessedxml . " \n";
        while ($unprocessedxml > 0){
            echo " parsing xml.. calling function startProcessingUnprocessedXml \n";
            $data = $this->startProcessingUnprocessedXml();
            $unprocessedxml = $this->Xmllisting->find('count', $paramsunprocessedxml);
	    $all_files	    = $this->Xmllisting->find('all',$paramsunprocessedxml);
	    print_r($all_files);sleep(5);
        } 
    }
    public function loopxmlandparseemailxml() {
        echo " executing function  loopxmlandparse...\n \n";
        
        
        $date = "'" . trim(date("Y-m-d")) . "'";
        $this->Xmllisting->recursive = -1;
        $paramsunprocessedxml = array(
            'conditions' => array('created' => $this->getDateForConsoleSearch(),'manual_upload_status' => 0),
        );

        $unprocessedxml = $this->Xmllisting->find('count', $paramsunprocessedxml);

        echo "the number of file to loop  parse and save" . $unprocessedxml . " \n";
        do {
            echo " parsing xml.. calling function startProcessingUnprocessedXml \n";
            $data = $this->startProcessingUnprocessedemailXml();
            $unprocessedxml = $this->Xmllisting->find('count', $paramsunprocessedxml);
        } while ($unprocessedxml > 0);
    }

    public function startProcessingUnprocessedXml() {

        echo "inside the function  startProcessingUnprocessedXml \n";
        $this->autoRender = FALSE;
        $this->Xmllisting->recursive = -1;
        echo "Picking up an xml \n";
        $params = array(
            'conditions' => array('created' => $this->getDateForConsoleSearch(), 'cronstatus' => 0)
        );
        $newfile = $this->Xmllisting->find('first', $params);
        $date = date('Ymd');
        $file = WWW_ROOT . 'files/xmlunprocessed/' . $date . '/' . trim($newfile['Xmllisting']['xml_url']);
        if ($this->Xmllisting->save(array('id' => $newfile['Xmllisting']['id'], 'xmlstatus' => 1, 'cronstatus' => 1)))
            echo "status updated \n";
        echo "saving xml with xmllisting id   :" . $newfile['Xmllisting']['id'] . " \n";
        echo "url  :" . $newfile['Xmllisting']['xml_url'];
	if(!isset($newfile['Xmllisting']['id'])){
		return;
	}
        if (file_exists($file)) {
            try {
		echo "file ".$file." with id ".$newfile['Xmllisting']['id'];
                echo "building xml..@" . $newfile['Xmllisting']['xml_url'] . " \n";
                $xmlbuild = Xml::build($file);
            } catch (Exception $e) {
                echo 'ERROR::failed @714 error building xml&' . $file . "::" . $newfile['Xmllisting']['id'] . " \n";
            }
            $xmlarray = Xml::toArray($xmlbuild);
            echo "converting to array  .\n";
            $xmllistingid = $newfile['Xmllisting']['id'];
            echo "calling function splitxmlandinsert....\n ";
            $xmlarray = $this->splitxmlandinsert($xmlarray, $xmllistingid);
        } else {
            echo "the xml was not found id:" . $newfile['Xmllisting']['id'] . " \n";
            echo "ERROR ::The xml was not picked @744 \n";
        }
    }
    public function startProcessingUnprocessedemailXml() {
        echo "inside the function  startProcessingUnprocessedXml \n";
        $this->autoRender = FALSE;
        $this->Xmllisting->recursive = -1;
        echo "Picking up an xml \n";
        $params = array(
            'conditions' => array('created' => $this->getDateForConsoleSearch(), 'manual_upload_status' => 0)
        );
        $newfile = $this->Xmllisting->find('first', $params);
	$this->Xmllisting->saveField(array('manual_upload_status' => 1),array('id' => $newfile['Xmllisting']['id']));
        $date = date('Ymd');
        $file = WWW_ROOT . 'files/Emailxmls/' . trim($newfile['Xmllisting']['url']);
        if ($this->Xmllisting->save(array('id' => $newfile['Xmllisting']['id'], 'manual_upload_status' => 1)))
            echo "status updated \n";
        echo "saving xml with xmllisting id   :" . $newfile['Xmllisting']['id'] . " \n";
        echo "url  :" . $newfile['Xmllisting']['url'];
        if (file_exists($file)) {
            try {
                echo "building xml..@" . $newfile['Xmllisting']['url'] . " \n";
                $xmlbuild = Xml::build($file);
            } catch (Exception $e) {
                echo 'ERROR::failed @714 error building xml&' . $file . "::" . $newfile['Xmllisting']['id'] . " \n";
            }
            $xmlarray = Xml::toArray($xmlbuild);
            echo "converting to array  .\n";
            $xmllistingid = $newfile['Xmllisting']['id'];
            echo "calling function splitxmlandinsert....\n ";
            $xmlarray = $this->splitxmlandinsert($xmlarray, $xmllistingid);
        } else {
            die("fie not found");
            echo "the xml was not found id:" . $newfile['Xmllisting']['id'] . " \n";
            echo "ERROR ::The xml was not picked @744 \n";
        }
    }

    function getcount($date = null) {
        $this->Xmllisting->recursive = -1;
//           $tosavecountpick         =   $this->Xmllisting->find('count',array('conditions'=> array(
//                                                                  $this->getDateForSearch('Xmllisting')
//                                                              )));
//           return $tosavecountpick;
        $tosavecountpick = $this->Xmllisting->find('count', array('conditions' => array('created' => $this->getDateForSearch('Xmllisting'))));

        return $tosavecountpick;
    }

    function getDHAcount($date = null) {
        $this->Xmllisting->recursive = -1;
        $tosavecountpick = $this->Xmllisting->find('count', array('conditions' => array('created' => $this->getDateForSearch('Xmllisting'), 'Xmllisting.place' => 1)));
        return $tosavecountpick;
    }

    function getHAADcount($date = null) {
        $this->Xmllisting->recursive = -1;
        $tosavecountpick = $this->Xmllisting->find('count', array('conditions' => array('created' =>
                $this->getDateForSearch('Xmllisting'),
                'Xmllisting.place' => 2
        )));
        return $tosavecountpick;
    }

    public function getotherfiles($date = null) {
        $this->Xmllisting->recursive = -1;
        $this->autoRender = false;
        $tosavecountpick = $this->Xmllisting->find('count', array('conditions' => array('created' =>
                $this->getDateForSearch('Xmllisting'), 'Xmllisting.otherfile' => 1
        )));
        return $tosavecountpick;
    }

    /**
     * Returns the true  if the error was inserted.
     *
     * @param string $error     the type of error NOT_FOUND,ERROR_XML
     * @param $hotfolder    name of the folders 
     * @return string field contents, or false if not found
     * @link http://book.cakephp.org/2.0/en/models/retrieving-your-data.html#model-field
     */
    public function notifyerror($error, $hotfolder) {
        //write the code to insert the data into the database and if the insertion was succcessfull return true
        return true;
    }

    public function edit($id = null) {
        $this->Xmllisting->id = $id;
        if (!$this->Xmllisting->exists()) {
            throw new NotFoundException(__('Invalid xml'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Xmllisting->save($this->request->data)) {
                $this->Session->setFlash(__('The xml has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The xml could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Xmllisting->read(null, $id);
        }
        $users = $this->Xmllisting->User->find('list');
        $this->set(compact('users'));
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
        $this->Xmllisting->id = $id;
        if (!$this->Xmllisting->exists()) {
            throw new NotFoundException(__('Invalid xml'));
        }
        if ($this->Xmllisting->delete()) {
            $this->Session->setFlash(__('Xml deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Xml was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Xmllisting->recursive = 0;
        $this->set('xmls', $this->paginate());
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Xmllisting->id = $id;
        if (!$this->Xmllisting->exists()) {
            throw new NotFoundException(__('Invalid xml'));
        }
        $this->set('xml', $this->Xmllisting->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Xmllisting->create();
            if ($this->Xmllisting->save($this->request->data)) {
                $this->Session->setFlash(__('The xml has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The xml could not be saved. Please, try again.'));
            }
        }
        $users = $this->Xmllisting->User->find('list');
        $this->set(compact('users'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->Xmllisting->id = $id;
        if (!$this->Xmllisting->exists()) {
            throw new NotFoundException(__('Invalid xml'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Xmllisting->save($this->request->data)) {
                $this->Session->setFlash(__('The xml has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The xml could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Xmllisting->read(null, $id);
        }
        $users = $this->Xmllisting->User->find('list');
        $this->set(compact('users'));
    }

    /*     * ***************************************Splitting code starts there*********************** */
    /*     * ********************************************************************************************* */

    public $place;
    public $resubmissionclaimsfound;

    public function getclaimsBenefits($activity) {
        app::import('model', 'benefit');
        $benefitobj = new Benefit();
        echo " \n" . $activity['Code'] . " \n";
        echo $activity['Type'] . " \n";
        $activity['Code'] = (string) $activity['Code'];
        if ($this->place == 1 AND $activity['Code'] == '6') {
            $activity['Code'] = 96;
        }
        $params = array('conditions' => array('CODE' => trim($activity['Code']), 'TYPE' => trim($activity['Type'])));
        $benefit = $benefitobj->find('first', $params);
        if ($benefit) {
            echo "found " . $benefit['Benefit']['BENEFIT'] . " \n";
            return $benefit['Benefit']['BENEFIT'];
        } else {
            echo "Found No Benefit \n";
            return 'Nobenefit';
        }
    }

    public function creatematernityxmls($xmlarray, $xmllistingid) {
        $inpatient = array(3, 4, 5, 6);
        $outpatient = array(1, 2, 7, 8, 9);
        if (isset($xmlarray['Claim.Submission'])) {
            foreach ($xmlarray['Claim.Submission'] as $key => $val) {

                if ($key == "Header") {
                    $header = $val;
                } else {
                    if ($key == "Claim") {
                        if (!isset($val[0])) {
                            $claimsarray[] = $val;
                        }
                        else
                            $claimsarray = $val;

                        //updating priorauthorization code
                        foreach ($claimsarray as $key => $claim) {
                            if (!isset($claim['Activity'][0])) {
                                $actvitydata[0] = $claim['Activity'];
                            }
                            else
                                $actvitydata = $claim['Activity'];
                            $PriorAuthorizationID = null;
                            foreach ($actvitydata as $activitykey => $val) {
                                 if ($this->place == 1 AND $val['Code'] == '6') {
                                        $actvitydata[$activitykey]['Code'] = 96;
                                    } else {
                                        $activitydata[$Activitykey]['Code'] = (string) $Activityarray['Code'];
                                    }
                                
                                
                                //check for prior authorization code
                                if ((trim($val['PriorAuthorizationID']) != "") AND ($PriorAuthorizationID == "")) {

                                    $PriorAuthorizationID = $val['PriorAuthorizationID'];
                                }
                            }


                            if ($PriorAuthorizationID != "") {
                                echo "Prior authorization code found \n";
                                echo "Updating prior authorization code \n";
                                if (!$claimsarray[$key]['Activity'][0]) {
                                    $claimsarray[$key]['Activity']['PriorAuthorizationID'] = $PriorAuthorizationID;
                                } else {
                                    foreach ($claimsarray[$key]['Activity'] as $activitykey => $act) {
                                        if (trim($claimsarray[$key]['Activity'][$activitykey]['PriorAuthorizationID']) == "")
                                            $claimsarray[$key]['Activity'][$activitykey]['PriorAuthorizationID'] = $PriorAuthorizationID;
                                    }
                                }
                            }else {
                                echo "No prior authorization code found \n";
                            }
                        }
                        $patients = array();

                        foreach ($claimsarray as $claim) {
                            if (in_array($claim['Encounter']['Type'], $inpatient)) {
                                echo "found in patient \n";
                                $patients['in'][] = $claim;
                            } else {
                                echo "found out patient \n";
                                $patients['out'][] = $claim;
                            }
                        }
                    }
                }
            }
            $maternity = array();
            $nonmaternity = array();

            foreach ($patients['out'] as $key => $val) {
                if (isset($val['Diagnosis'][0])) {
                    foreach ($val['Diagnosis'] as $diagnosiskey => $diagnosisval) {
                        //sort out the best way to kind if this is maternity or not
                        if ($diagnosisval['Type'] == "Principal") {
                            if ($this->getAllMAternityNonMaternity($diagnosisval['Code']))
                                $maternity[] = $val;
                            else
                                $nonmaternity[] = $val;
                        }
                    }
                }else {
                    if ($val['Diagnosis']['Type'] == "Principal") {
                        if ($this->getAllMAternityNonMaternity($val['Diagnosis']['Code'])) {
                            $maternity[] = $val;
                        }
                        else
                            $nonmaternity[] = $val;
                    }
                }
            }
            $activitynewarray = array();
            $finalMatArray = array();
            if ($maternity) {
                foreach ($maternity as $benefitmatkey => $benefitmatval) {
                    $claimid = $benefitmatval['ID'];

                    echo "processing " . $benefitmatkey . " \n";
                    $activitynewarray = array();
                    if (!isset($benefitmatval['Activity'][0])) {
                        $activitynewarray[] = $benefitmatval['Activity'];
                    } else {
                        $activitynewarray = $benefitmatval['Activity'];
                    }

                    foreach ($activitynewarray as $maternitybenefitactivitykey => $maternitybenefitactivity) {
                        $benefit = $this->getclaimsBenefits($maternitybenefitactivity);
                        $toremoved = $benefitmatval;
                        unset($toremoved['Activity']);
                        if (!isset($finalMatArray[$benefit][$claimid]))
                            $finalMatArray[$benefit][$claimid] = $toremoved;
                        $finalMatArray[$benefit][$claimid]['Activity'][] = $maternitybenefitactivity;
                    }
                }
            }
            $activitynewarray = array();
            $finalNonMatArray = array();
            if ($nonmaternity) {
                foreach ($nonmaternity as $benefitnonmatkey => $benefitnonmatval) {
                    echo "processing " . $benefitnonmatkey . " \n";
                    $claimid = $benefitnonmatval['ID'];
                    $activitynewarray = array();
                    if (!isset($benefitnonmatval['Activity'][0])) {
                        $activitynewarray[] = $benefitnonmatval['Activity'];
                    } else {
                        $activitynewarray = $benefitnonmatval['Activity'];
                    }


                    foreach ($activitynewarray as $nonmaternitybenefitactivitykey => $nonmaternitybenefitactivity) {
                        $benefit = $this->getclaimsBenefits($nonmaternitybenefitactivity);
                        $toremoved = $benefitnonmatval;
                        unset($toremoved['Activity']);
                        if (!isset($finalNonMatArray[$benefit][$claimid]))
                            $finalNonMatArray[$benefit][$claimid] = $toremoved;
                        $finalNonMatArray[$benefit][$claimid]['Activity'][] = $nonmaternitybenefitactivity;
                    }
                }
            }



            $this->createXMlBenefits($finalNonMatArray, $header, $xmllistingid, "nonmaternity");
            $this->createXMlBenefits($finalMatArray, $header, $xmllistingid, "maternity");
            if (isset($patients['in']))
                $this->createXMlInPatients($patients['in'], $header, $xmllistingid, "inpatients");
        }
    }

    public function getnetpricefromprovider($providerID, $Type, $code, $Start) {
        $lowerstdiff = 0;
        $eligibelepricing = array();
        app::import('model', 'Providerdetail');
        $providerdetailsobj = new Providerdetail();
        app::import('model', 'Providerpricing');
        $providerpricing = new Providerpricing();
        $providerimongarray = $providerdetailsobj->find('first', array('conditions' => array('licence' => $providerID)));
        $providerpricingdet = $providerpricing->find('all', array('conditions' => array('providerdetail_id' => $providerimongarray['Providerdetail']['id'], 'code' => trim($code), 'activity' => trim($Type))));
        if (!$providerpricingdet)
            $providerpricingdet = $providerpricing->find('all', array('conditions' => array('providerdetail_id' => $providerimongarray['Providerdetail']['id'], 'code' => trim($code), 'activity' => new MongoInt32($Type))));

        if ($providerpricingdet) {
            foreach ($providerpricingdet as $prcing) {
                $strtostarttime = strtotime($prcing['Providerpricing']['start_date']['day'] . "-" . $prcing['Providerpricing']['start_date']['month'] . "-" . $prcing['Providerpricing']['start_date']['year']);
                if ($strtostarttime < strtotime(str_replace("/", "-", $Start))) {
                    $prcing['diff'] = strtotime($Start) - $strtostarttime;
                    $eligibelepricing[] = $prcing;
                }
            }
        }

        if (isset($eligibelepricing[0]['diff']))
            $lowerstdiff = $eligibelepricing[0]['diff'];
        else
            $lowerstdiff = 0;
        foreach ($eligibelepricing as $pricing) {
            if ($lowerstdiff >= $pricing['diff']) {
                $lowerstdiff = $pricing['diff'];
                $prominentpricing = $pricing;
            }
        }

        if (!isset($prominentpricing['Providerpricing']['gross']))
            return false;
        else {
            echo "@1075 " . $prominentpricing['Providerpricing']['gross'];
            return $prominentpricing['Providerpricing']['gross'];
        }
    }
    public function gettypefiveprice($activityType, $activityCode, $activityStart, $observation){
        echo "creating instance \n";
        App::import('Controller','Typefivepricings');
        $typefivepricingobj     =    new TypefivepricingsController();
       
        $price      =   $typefivepricingobj->getnetprice($activityType, $activityCode, $activityStart, $observation,$this->place);
        return $price;
    }
    public function getnetpricefromactivity($ProviderID, $activityid) {
        app::import('model', 'providerdetail');
        app::import('model', 'Providerpricing');
        app::import('model', 'ObservationMapping');
        app::import('model', 'Activity');
        $activityobj = new Activity();
        $observationmapping = new ObservationMapping();
        $providerpricing = new Providerpricing();
        $activityarray = $activityobj->read(null, $activityid);
        $avtiveobservation = array();
        $observations = $activityarray['Activity']['Observation'];
        if (!isset($observations[0])) {
            $newobservation = $observations;
            unset($observations);
            $observations[0] = $newobservation;
        }

        $providerdetailsObj = new Providerdetail();
        $providerdeteilsarrray = $providerdetailsObj->find('first', array('conditions' => array('licence' => $ProviderID)));

        $providerdetailsid = $providerdeteilsarrray['Providerdetail']['id'];

        if (isset($observations)) {
            foreach ($observations as $observation) {
                if(($observation['Type'] == 'Text')&&(trim($observation['Code'])=='Non-Standard-Code' OR trim($observation['Code'])=='Presenting-Complaint' OR trim($observation['Code'])=='PresentingComplaint')){
                    if (strpos($observation['Value'], "=")) {
                        $codearray = explode('=', $observation['Value']);
                        $observationcode = $codearray[0];
                        //return $observationcode;
                    } else if (strpos($observation['Value'], "|")) {
                        $codearray = explode('|', $observation['Value']);
                        $observationcode = $codearray[0];
                    } else {
                        $observationcode = $observation['Value'];
                    }
                }
            }
            //return $observationcode;
            if (!isset($observationcode)) {


                $pricing = $this->getnetpricefromprovider($ProviderID, $activityarray['Activity']['Type'], $activityarray['Activity']['Code'], $activityarray['Activity']['start']);

                if (!$pricing) {
                    return 0;
                } else {
                    return $pricing;
                }
            } else {

                $pricingdetails = $observationmapping->find('all', array('conditions' => array('providerdetail_id' => $providerdetailsid, 'activity_code' => $activityarray['Activity']['Code'], 'activity_type' => $activityarray['Activity']['Type'], 'observation_code' => $observationcode)));

                if (isset($pricingdetails)) {
                    foreach ($pricingdetails as $prcing) {
                        $strtostarttime = strtotime($prcing['ObservationMapping']['start_date']['year'] . "-" . $prcing['ObservationMapping']['start_date']['month'] . "-" . $prcing['ObservationMapping']['start_date']['day']);
                        if ($strtostarttime < strtotime($activityarray['Activity']['start'])) {
                            $prcing['diff'] = strtotime($Start) - $strtostarttime;
                            $eligibelepricing[] = $prcing;
                        }
                    }
                    $lowerstdiff = $eligibelepricing[0]['diff'];

                    foreach ($eligibelepricing as $pricing) {

                        if ($lowerstdiff >= $pricing['diff']) {
                            $lowerstdiff = $pricing['diff'];
                            $prominentpricing = $pricing;
                        }
                    }
                    if (isset($prominentpricing['ObservationMapping']['gross_price'])) {
                        return $prominentpricing['ObservationMapping']['gross_price'];
                    } else {

                        $pricing = $this->getnetpricefromprovider($ProviderID, $activityarray['Activity']['Type'], $activityarray['Activity']['Code'], $activityarray['Activity']['start']);
                        if (!$pricing) {
                            return 0;
                        } else {
                            return $pricing;
                        }
                    }
                } else {

                    $pricing = $this->getnetpricefromprovider($ProviderID, $activityarray['Activity']['Type'], $activityarray['Activity']['Code'], $activityarray['Activity']['start']);
                    if (!$pricing) {
                        return 0;
                    } else {
                        return $pricing;
                    }
                }
            }
        } else {

            $pricing = $this->getnetpricefromprovider($ProviderID, $activityarray['Activity']['Type'], $activityarray['Activity']['Code'], $activityarray['Activity']['start']);

            if ($pricing)
                return $pricing;
            else
                return 0;
        }
    }

    public function payeeUpgrade() {
        app::import('model', 'Payerslist');
        $payerlist = new Payerslist();
    }

    public function getnetprice($ProviderID, $Type, $Code, $Start, $observations = null) {
        app::import('model', 'Providerpricing');
        app::import('model', 'ObservationMapping');
        $observationmapping = new ObservationMapping();
        $providerpricing = new Providerpricing();
        $avtiveobservation = array();

        if (isset($observations)) {
            if (!isset($observations[0])) {
                $newobservation = $observations;
                unset($observations);
                $observations[] = $newobservation;
            }
        }



        app::import('model', 'providerdetail');
        $providerdetailsObj = new Providerdetail();
        $providerdeteilsarrray = $providerdetailsObj->find('first', array('conditions' => array('licence' => $ProviderID)));
        $providerdetailsid = $providerdeteilsarrray['Providerdetail']['id'];



        if (isset($observations)) {
            echo "found observations \n";
            foreach ($observations as $observation) {

                if(($observation['Type'] == 'Text')&&(trim($observation['Code'])=='Non-Standard-Code' OR trim($observation['Code'])=='Presenting-Complaint' OR trim($observation['Code'])=='PresentingComplaint')) {
                    if (strpos($observation['Value'], "=")) {
                        $codearray = explode('=', $observation['Value']);
                        $observationcode = $codearray[0];
                    } else if (strpos($observation['Value'], "|")) {
                        $codearray = explode('|', $observation['Value']);
                        $observationcode = $codearray[0];
                    } else {
                        $observationcode = $observation['Value'];
                    }
                }
            }

            if (!isset($observationcode)) {
                echo " no valid observation code found \n So calling provider pricing @1288 \n";
                $pricing = $this->getnetpricefromprovider($ProviderID, $Type, $Code, $Start);
                if ($pricing == null) {
                    echo "could not find any provider pricing \n";
                    return false;
                } else {
                    echo "found provider pricing $pricing \n";
                    return $pricing;
                }
            } else {
                echo "valid observation code found - checking if there is observation price for it \n";
                $pricingdetails = $observationmapping->find('all', array('conditions' => array('providerdetail_id' => $providerdetailsid, 'activity_code' => $Code, 'activity_type' => $Type, 'observation_code' => $observationcode)));

                if (count($pricingdetails) > 0) {
                    foreach ($pricingdetails as $prcing) {
                        $strtostarttime = strtotime($prcing['ObservationMapping']['start_date']['day'] . "." . $prcing['ObservationMapping']['start_date']['month'] . "." . $prcing['ObservationMapping']['start_date']['year']);
                        $Start = date('d.m.Y', strtotime(str_replace("/", ".", $Start)));
                        if ($strtostarttime < strtotime($Start)) {
                            $prcing['diff'] = strtotime(str_replace("/", ".", $Start)) - $strtostarttime;
                            $eligibelepricing[] = $prcing;
                        }
                    }

                    $lowerstdiff = $eligibelepricing[0]['diff'];

                    foreach ($eligibelepricing as $pricing) {
                        if ($lowerstdiff >= $pricing['diff']) {
                            $lowerstdiff = $pricing['diff'];
                            $prominentpricing = $pricing;
                        }
                    }

                    if (isset($prominentpricing['ObservationMapping']['gross_price'])) {
                        echo " return observation pricing@1233 \n";
                        return $prominentpricing['ObservationMapping']['gross_price'];
                    } else {
                        echo "No net price found from observation @1327 \n";
                        $pricing = $this->getnetpricefromprovider($ProviderID, $Type, $Code, $Start);
                        if (!$pricing) {
                            return false;
                        } else {
                            return $pricing;
                        }
                    }
                } else {
                    echo " calling provider pricing because there was no observation prcing found \n ";

                    $pricing = $this->getnetpricefromprovider($ProviderID, $Type, $Code, $Start);

                    if (!$pricing) {
                        return false;
                    } else {
                        return $pricing;
                    }
                }
            }
        } else {

            $pricing = $this->getnetpricefromprovider($ProviderID, $Type, $Code, $Start);
            return $pricing;
        }
    }

    public function roundoff($number) {
        return round($number,2);
    }

    public function getAllclaimDetails($claimid = null) {
        $this->Xmllisting->claim->recursive = 1;
        $claimarray = $this->Xmllisting->claim->read(null, $claimid);
        return $claimarray;
    }

    function xmlencode($data) {
        $observationvalue = ereg_replace("& amp;", "&amp; ", $data);
        return $data;
    }

    public function payeridrename($payerid = null) {
        if ($payerid) {
            app::import('model', 'payerslist');
            $payerslist = new Payerslist();
            if ($this->place == 1) {
                $eclaimlink = $payerslist->find('first', array('conditions' => array('eclaimlinkid' => $payerid)));
            } if (isset($eclaimlink['Payerslist']['haad'])) {
                return $eclaimlink['Payerslist']['haad'];
            } else {
                return $payerid;
            }
        }
    }

    public function createXMlBenefits($claimsArray, $headervalues, $xmllistingid, $typename) {
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

                app::import('model', 'Providerdetail');
                $providerdetailsobj = new Providerdetail();
                $providername = $singleClaim['ProviderID'];
                $providerprimarykey = $providerdetailsobj->find('first', array('conditions' => array('licence' => $singleClaim['ProviderID'])));

                if (isset($singleClaim['Resubmission'])) {
                    if ($singleClaim['Resubmission']['Attachment']) {
                        $pdfcontent = $singleClaim['Resubmission']['Attachment'];
                        $pdfclaimid = $singleClaim['ID'];
                    }
                } else {
                    $pdf = NULL;
                }
                $claim = $xmllistingsclaims->appendChild(new DOMElement('Claim'));
                $ID = $claim->appendChild(new DOMElement('ID', $singleClaim['ID']));
                if (isset($singleClaim['IDPayer']))
                    $IDPayer = $claim->appendChild(new DOMElement('IDPayer', $singleClaim['IDPayer']));
                $MemberID = $claim->appendChild(new DOMElement('MemberID', $this->memberIdTruncate($singleClaim['MemberID'])));
                $PayerID = $claim->appendChild(new DOMElement('PayerID', $this->payeridrename($singleClaim['PayerID'])));
                $ProviderID = $claim->appendChild(new DOMElement('ProviderID', $singleClaim['ProviderID']));
                $EmiratesIDNumber = $claim->appendChild(new DOMElement('EmiratesIDNumber', $singleClaim['EmiratesIDNumber']));
                $Gross = $claim->appendChild(new DOMElement('Gross', $singleClaim['Gross']));
                $PatientShare = $claim->appendChild(new DOMElement('PatientShare', $singleClaim['PatientShare']));
                $Net = $claim->appendChild(new DOMElement('Net', $singleClaim['Net']));
                $Encounter = $claim->appendChild(new DOMElement('Encounter'));
                $FacilityID = $Encounter->appendChild(new DOMElement('FacilityID', $singleClaim['Encounter']['FacilityID']));
                $Type = $Encounter->appendChild(new DOMElement('Type', $singleClaim['Encounter']['Type']));
                $PatientID = $Encounter->appendChild(new DOMElement('PatientID', $singleClaim['Encounter']['PatientID']));
                $Start = $Encounter->appendChild(new DOMElement('Start', $singleClaim['Encounter']['Start']));
                if ($singleClaim['Encounter']['End'])
                    $End = $Encounter->appendChild(new DOMElement('End', $singleClaim['Encounter']['End']));
                else
                    $End = $Encounter->appendChild(new DOMElement('End', $singleClaim['Encounter']['Start']));

                $StartType = $Encounter->appendChild(new DOMElement('StartType', $singleClaim['Encounter']['StartType']));
                if (isset($singleClaim['Encounter']['EndType']))
                    $EndType = $Encounter->appendChild(new DOMElement('EndType', $singleClaim['Encounter']['EndType']));

                if (isset($singleClaim['Contract']['PackageName'])) {
                    $Contract = $claim->appendChild(new DOMElement('Contract'));
                    $PackageName = $Contract->appendChild(new DOMElement('PackageName', $singleClaim['Contract']['PackageName']));
                }
                if (isset($singleClaim['Resubmission']['Type'])) {
                    $resubmission = $claim->appendChild(new DOMElement('Resubmission'));
                    $resubmissiontype = $resubmission->appendChild(new DOMElement('Type', $singleClaim['Resubmission']['Type']));
                    $resubmissionComment = $resubmission->appendChild(new DOMElement('Comment', $singleClaim['Resubmission']['Comment']));
                }
                if (isset($singleClaim['Diagnosis'][0])) {
                    foreach ($singleClaim['Diagnosis'] as $key => $diag) {
                        $Diagnosi = $claim->appendChild(new DOMElement('Diagnosis'));
                        $Type = $Diagnosi->appendChild(new DOMElement('Type', $diag['Type']));
                        $code = $Diagnosi->appendChild(new DOMElement('Code', $diag['Code']));
                    }
                } else {
                    $Diagnosi = $claim->appendChild(new DOMElement('Diagnosis'));
                    $Type = $Diagnosi->appendChild(new DOMElement('Type', $singleClaim['Diagnosis']['Type']));
                    $code = $Diagnosi->appendChild(new DOMElement('Code', $singleClaim['Diagnosis']['Code']));
                }
                $activitydetails = $singleClaim['Activity'];
                foreach ($activitydetails as $singleactivity) {
                    $activitydomobj = $claim->appendChild(new DOMElement('Activity'));
                    $activity_id = $activitydomobj->appendChild(new DOMElement('ID', $singleactivity['ID']));
                    $Start = $activitydomobj->appendChild(new DOMElement('Start', $singleactivity['Start']));
                    if (isset($singleactivity['End']))
                        $end = $activitydomobj->appendChild(new DOMElement('End', $singleactivity['End']));
                    else
                        $end = $activitydomobj->appendChild(new DOMElement('End', $singleactivity['Start']));

                    $Code = $activitydomobj->appendChild(new DOMElement('Code', $singleactivity['Code']));
                    $type = $activitydomobj->appendChild(new DOMElement('Type', $singleactivity['Type']));
                    $Quantity = $activitydomobj->appendChild(new DOMElement('Quantity', $this->roundoff($singleactivity['Quantity'])));

                    if ($providerprimarykey['Providerdetail']['code'])
                        echo "calingnetprice @1431 \n";
                    if (!isset($singleactivity['Observation']))
                        $observation = "";
                    else
                        $observation = $singleactivity['Observation'];

                    if($singleactivity['Type']==5){
                        echo "a calling gettypefiveprice @1660 \n";
                        $netprice = $this->gettypefiveprice($singleactivity['Type'], $singleactivity['Code'], $singleactivity['Start'], $observation);
                    }else{
                        $netprice = $this->getnetprice($singleClaim['ProviderID'], $singleactivity['Type'], $singleactivity['Code'], $singleactivity['Start'], $observation);
                    }
                    

                    if ($netprice) {
                        echo "Got new net price $netprice \n ";
                        $Net = $activitydomobj->appendChild(new DOMElement('Net', $netprice));
                    } else {
                        echo "no net price available keeping the 0 net price \n";
                        $Net = $activitydomobj->appendChild(new DOMElement('Net', 0));
                    }
                    $Clinician = $activitydomobj->appendChild(new DOMElement('Clinician', $singleactivity['Clinician']));
                    if (isset($singleactivity['PriorAuthorizationID']))
                        $PriorAuthorizationID = $activitydomobj->appendChild(new DOMElement('PriorAuthorizationID', $singleactivity['PriorAuthorizationID']));
                    if (isset($singleactivity['Observation'])) {
                        if (isset($singleactivity['Observation'][0]))
                            $allobservation = $singleactivity['Observation'];
                        else
                            $allobservation[0] = $singleactivity['Observation'];
                        foreach ($allobservation as $singleobservation) {
                            $Observation = $activitydomobj->appendChild(new DOMElement('Observation'));
                            $Type = $Observation->appendChild(new DOMElement('Type', $singleobservation['Type']));
                            $Code = $Observation->appendChild(new DOMElement('Code', $singleobservation['Code']));
                            //$observationvalue = ereg_replace("&", "&amp; ", $message);


                            $Value = $Observation->appendChild(new DOMElement('Value', $this->xmlencode($singleobservation['Value'])));
                            $ValueType = $Observation->appendChild(new DOMElement('ValueType', $this->xmlencode($singleobservation['ValueType'])));
                        }
                    }
                }
            }

            //$xmldetails = $this->Xmllisting->find('first',array('conditions'=>array('id'=>$xmllistingid)) );

            $date = trim(date("Ymd"));
            if (!file_exists(WWW_ROOT . 'files/splited/' . $date . '/')) {
                echo "creating folder with name " . WWW_ROOT . 'files/splited/' . $date . " \n";
                mkdir(WWW_ROOT . 'files/splited/' . $date);
            }
            if (!file_exists(WWW_ROOT . 'files/splited/' . $date . '/' . $xmllistingid)) {
                echo "creating folder with name " . WWW_ROOT . 'files/splited/' . $date . '/' . $xmllistingid . " \n";
                mkdir(WWW_ROOT . 'files/splited/' . $date . '/' . $xmllistingid);
            }
            if (isset($pdfcontent)) {
                $Fh = fopen(WWW_ROOT . 'files/splited/' . $date . '/' . $xmllistingid . "/" . $pdfclaimid . ".pdf", "w");
                fwrite($Fh, base64_decode($pdfcontent));
            }
            if ($this->resubmissionclaimsfound == 0)
                $dom->save(WWW_ROOT . 'files/splited/' . $date . '/' . $xmllistingid . "/" . date("Y-m-d") . "_" . $providername . "_" . $typename . "_" . $benefitname . "_benefit.xml");

            if ($this->resubmissionclaimsfound == 1)
                $dom->save(WWW_ROOT . 'files/splited/' . $date . '/' . $xmllistingid . "/" . date("Y-m-d") . "_" . $providername . "_" . $typename . "_" . $benefitname . "_resubmission_benefit.xml");
        }
        return true;
    }

    public function createXMlInPatients($claimsArray, $headervalues, $xmllistingid, $typename) {
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
        $RecordCount = $header->appendChild(new DOMElement('RecordCount', count($claimsArray)));
        foreach ($claimsArray as $claimid => $singleClaim) {
            app::import('model', 'Providerdetail');
            $providerdetailsobj = new Providerdetail();
            $providername = $singleClaim['ProviderID'];
            $providerprimarykey = $providerdetailsobj->find('first', array('conditions' => array('licence' => $singleClaim['ProviderID'])));
            if ($singleClaim['Resubmission']) {
                if ($singleClaim['Resubmission']['Attachment']) {
                    $pdfcontent = $singleClaim['Resubmission']['Attachment'];
                    $pdfclaimid = $singleClaim['ID'];
                }
            } else {
                $pdf = NULL;
            }

            $claim = $xmllistingsclaims->appendChild(new DOMElement('Claim'));
            $ID = $claim->appendChild(new DOMElement('ID', $singleClaim['ID']));
            $IDPayer = $claim->appendChild(new DOMElement('IDPayer', $singleClaim['IDPayer']));
            $MemberID = $claim->appendChild(new DOMElement('MemberID', $this->memberIdTruncate($singleClaim['MemberID'])));
            $PayerID = $claim->appendChild(new DOMElement('PayerID', $this->payeridrename($singleClaim['PayerID'])));
            $ProviderID = $claim->appendChild(new DOMElement('ProviderID', $singleClaim['ProviderID']));
            $EmiratesIDNumber = $claim->appendChild(new DOMElement('EmiratesIDNumber', $singleClaim['EmiratesIDNumber']));
            $Gross = $claim->appendChild(new DOMElement('Gross', $singleClaim['Gross']));
            $PatientShare = $claim->appendChild(new DOMElement('PatientShare', $singleClaim['PatientShare']));
            $Net = $claim->appendChild(new DOMElement('Net', $singleClaim['Net']));
            $Encounter = $claim->appendChild(new DOMElement('Encounter'));
            $FacilityID = $Encounter->appendChild(new DOMElement('FacilityID', $singleClaim['Encounter']['FacilityID']));
            $Type = $Encounter->appendChild(new DOMElement('Type', $singleClaim['Encounter']['Type']));
            $PatientID = $Encounter->appendChild(new DOMElement('PatientID', $singleClaim['Encounter']['PatientID']));
            $Start = $Encounter->appendChild(new DOMElement('Start', $singleClaim['Encounter']['Start']));
            if ($singleClaim['Encounter']['End'])
                $End = $Encounter->appendChild(new DOMElement('End', $singleClaim['Encounter']['End']));
            else
                $End = $Encounter->appendChild(new DOMElement('End', $singleClaim['Encounter']['Start']));

            $StartType = $Encounter->appendChild(new DOMElement('StartType', $singleClaim['Encounter']['StartType']));
            $EndType = $Encounter->appendChild(new DOMElement('EndType', $singleClaim['Encounter']['EndType']));

            $Contract = $claim->appendChild(new DOMElement('Contract'));
            $PackageName = $Contract->appendChild(new DOMElement('PackageName', $singleClaim['Contract']['PackageName']));


            $resubmission = $claim->appendChild(new DOMElement('Resubmission'));
            if (isset($singleClaim['Resubmission']['Type']))
                $resubmissiontype = $resubmission->appendChild(new DOMElement('Type', $singleClaim['Resubmission']['Type']));
            if (isset($singleClaim['Resubmission']['Comment']))
                $resubmissionComment = $resubmission->appendChild(new DOMElement('Comment', $singleClaim['Resubmission']['Comment']));
            if (isset($singleClaim['Diagnosis'][0])) {
                foreach ($singleClaim['Diagnosis'] as $key => $diag) {
                    $Diagnosi = $claim->appendChild(new DOMElement('Diagnosis'));
                    $Type = $Diagnosi->appendChild(new DOMElement('Type', $diag['Type']));
                    $code = $Diagnosi->appendChild(new DOMElement('Code', $diag['Code']));
                }
            } else {
                $Diagnosi = $claim->appendChild(new DOMElement('Diagnosis'));
                $Type = $Diagnosi->appendChild(new DOMElement('Type', $singleClaim['Diagnosis']['Type']));
                $code = $Diagnosi->appendChild(new DOMElement('Code', $singleClaim['Diagnosis']['Code']));
            }
            $activitydetails = $singleClaim['Activity'];
            foreach ($activitydetails as $singleactivity) {
                $activitydomobj = $claim->appendChild(new DOMElement('Activity'));
                $activity_id = $activitydomobj->appendChild(new DOMElement('ID', $singleactivity['ID']));
                $Start = $activitydomobj->appendChild(new DOMElement('Start', $singleactivity['Start']));
                if (isset($singleactivity['End']))
                    $end = $activitydomobj->appendChild(new DOMElement('End', $singleactivity['End']));
                else
                    $end = $activitydomobj->appendChild(new DOMElement('End', $singleactivity['Start']));

                $Code = $activitydomobj->appendChild(new DOMElement('Code', $singleactivity['Code']));
                $type = $activitydomobj->appendChild(new DOMElement('Type', $singleactivity['Type']));
                $Quantity = $activitydomobj->appendChild(new DOMElement('Quantity', $this->roundoff($singleactivity['Quantity'])));
                echo "initializing the replacement of net price for provider \n passing parameters \n";
                echo "initializing the replacement of net price for provider \n passing parameters \n";
                if($singleactivity['Type']==5){
                    echo "a calling gettypefiveprice 1806 \n";
                    $netprice = $this->gettypefiveprice($singleactivity['Type'], $singleactivity['Code'], $singleactivity['Start'], $observation);
                }else{
                    $netprice = $this->getnetprice($singleClaim['ProviderID'], $singleactivity['Type'], $singleactivity['Code'], $singleactivity['Start'], $observation);
                }
                if ($netprice) {
                    echo "Got new net price $netprice \n ";
                    $Net = $activitydomobj->appendChild(new DOMElement('Net', $netprice));
                } else {
                    echo "no net price available keeping the existing net price";
                    $Net = $activitydomobj->appendChild(new DOMElement('Net', 0));
                }
                $Clinician = $activitydomobj->appendChild(new DOMElement('Clinician', $singleactivity['Clinician']));
                $PriorAuthorizationID = $activitydomobj->appendChild(new DOMElement('PriorAuthorizationID', $singleactivity['PriorAuthorizationID']));
                if (isset($singleactivity['Observation'])) {
                    if (isset($singleactivity['Observation'][0]))
                        $allobservation = $singleactivity['Observation'];
                    else
                        $allobservation[0] = $singleactivity['Observation'];
                    foreach ($allobservation as $singleobservation) {
                        $Observation = $activitydomobj->appendChild(new DOMElement('Observation'));
                        $Type = $Observation->appendChild(new DOMElement('Type', $singleobservation['Type']));
                        $Code = $Observation->appendChild(new DOMElement('Code', $singleobservation['Code']));
                        $Value = $Observation->appendChild(new DOMElement('Value', $this->xmlencode($singleobservation['Value'])));
                        $ValueType = $Observation->appendChild(new DOMElement('ValueType', $this->xmlencode($singleobservation['ValueType'])));
                    }
                }
            }
        }


        // $xmldetails = $this->Xmllisting->read(null, $xmllistingid);
        $date = trim(date("Ymd"));
        if (!file_exists(WWW_ROOT . 'files/splited/' . $date . '/')) {
            echo "creating folder with name " . WWW_ROOT . 'files/splited/' . $date . " \n";
            mkdir(WWW_ROOT . 'files/splited/' . $date);
        }

        if (!file_exists(WWW_ROOT . 'files/splited/' . $date . '/' . $xmllistingid)) {
            echo "creating folder with name " . WWW_ROOT . 'files/splited/' . $date . '/' . $xmllistingid . " \n";
            mkdir(WWW_ROOT . 'files/splited/' . $date . '/' . $xmllistingid);
            echo WWW_ROOT . 'files/xmlunprocessed/' . $date . '/' . $xmldetails['Xmllisting']['xml_url'];
            //copy(WWW_ROOT . 'files/xmlunprocessed/' . $date . '/' . $xmldetails['Xmllisting']['xml_url'], WWW_ROOT . 'files/splited/' . $date . '/' . $xmllistingid . '/' . $xmldetails['Xmllisting']['name']);
        }
        if ($pdfcontent) {
            $Fh = fopen(WWW_ROOT . 'files/splited/' . $date . '/' . $xmllistingid . "/" . $pdfclaimid . ".pdf", "w");
            fwrite($Fh, base64_decode($pdfcontent));
        }
        if ($this->resubmissionclaimsfound == 0)
            $dom->save(WWW_ROOT . 'files/splited/' . $date . '/' . $xmllistingid . "/" . date("Y-m-d") . "_" . $providername . "_" . $typename . "_" . $benefitname . "_benefit.xml");
        if ($this->resubmissionclaimsfound == 1)
            $dom->save(WWW_ROOT . 'files/splited/' . $date . '/' . $xmllistingid . "/" . date("Y-m-d") . "_" . $providername . "_" . $typename . "_" . $benefitname . "_resubmission_benefit.xml");

        return true;
    }

    public function checkGlobalSetting($setting) {
        $this->autoRender = false;
        return true;
    }

    public function memberIdTruncate($memberid = null) {
        $this->autoRender = FALSE;
        if ($memberid) {
            $membrid = $memberid . "";
            $specialcharactersarray = array(',', '!', '@', '#', '$', '%', '^', '&', '*', '-', '/', ';', ':', ' ', '_');
            $membrid = str_replace($specialcharactersarray, '', $membrid);

            if (strlen($membrid) == 18) {
                if ($this->checkGlobalSetting("TRUNCATE_MEMBER_ID")) {
                    $frontruncated = trim(substr($membrid, 10));
                    $integeronly = trim(ltrim($frontruncated, '0'));
                    $backtrunctated = trim(substr($integeronly, 0, strlen($integeronly) - 2));
                    return $backtrunctated;
                } else {
                    return $memberid;
                }
            } else {
                return $memberid;
            }
        }
    }

    public function mapppayerid($payerid) {
        if ($this->place == 1) {

            app::import('model', 'Payermapping');
            $Payermapping = new Payermapping();


            $payerdetails = $Payermapping->find('first', array('conditions' => array('auth_no_dubai' => $payerid)));
            if ($payerdetails['Payermapping']['auth_no_haad']) {
                return $payerdetails['Payermapping']['auth_no_haad'];
            } else {
                return $payerid;
            }
        }
        else
            return $payerid;
    }

    public function xmlDateFormat($date) {
        $this->layout = false;
        $this->autoRender = FALSE;
        return date('d/m/Y H:i:s', strtotime($date));
    }

    public function getAllMAternityNonMaternity($code) {
        if ($code) {
            app::import('model', 'Mcode');
            $Mcodeobj = new Mcode();
            $params = array(
                'conditions' => array('codenumber' => trim($code)),
            );
            echo $code . " \n";
            $maternity = $Mcodeobj->find('count', $params);
            if ($maternity > 0) {
                return true;
            }
            else
                return FALSE;
        }
    }

    public function addbenefit() {
        app::import('model', 'Benefit');
        $benefitobj = new Benefit();
        $data = new Spreadsheet_Excel_Reader(WWW_ROOT . 'files/benefits/HADcodesAbudhabi.xls', true);
        $exeldata = $data->sheets['0']['cells'];
        $count  =   0;
        foreach ($exeldata as $key => $benefitdata) {
            if ($key ==1) {
                
                continue;
            }
            
            if(!$benefitdata[1]){
                continue;
            }
//           print_r($benefitdata);
//          exit;
            
            $occurance = $benefitobj->find('first', array('conditions' => array('CODE' => trim($benefitdata[1]), 'TYPE' => trim($benefitdata[2]))));
            if (!$occurance)
                $occurance = $benefitobj->find('first', array('conditions' => array('CODE' => trim($benefitdata[1]), 'TYPE' => (string) trim($benefitdata[2]))));
            
            //print_r($benefitdata);
            if ($occurance ) {
                echo "occurance present \n";

               if($occurance['Benefit']['LOCAL_DESCRIPTION_1']==""){
                   print_r($occurance);
                   die("no description");
               }else{
                   echo "desc present \n";
               }
            }else{
                  echo $count++." \n";   
                
                $benefit['Benefit']['TYPE'] = (string) trim($benefitdata['2']);
                $benefit['Benefit']['CODE'] = (string) trim($benefitdata[1]);
                $benefit['Benefit']['BENEFIT'] = strtoupper('CDA_NA');
                $benefit['Benefit']['LOCAL_DESCRIPTION_1'] = utf8_encode($benefitdata[3]);
                $benefit['Benefit']['CRITERION_NBR'] = '';
                $benefit['Benefit']['LOCAL_DESCRIPTION'] = '';
                
                
                $benefitobj->create();
                if ($benefitobj->save($benefit)) {
                    print_r($benefitdata);
                    
                    echo "Value inserted";        
                   
                } else {
                    echo 'Error...Can not insert the record';
                }
                
            }
        
        }
        echo $count;
    }
    public function addbenefit_old() {
        app::import('model', 'Benefit');
        $benefitobj = new Benefit();
        $data = new Spreadsheet_Excel_Reader(WWW_ROOT . 'files/benefits/dubai_service_list.xls', true);
        $exeldata = $data->sheets['0']['cells'];
        foreach ($exeldata as $key => $benefitdata) {
            if ($key == 1) {
                continue;
            }
            print_r($benefitdata);
            exit;
            $occurance = $benefitobj->find('count', array('conditions' => array('CODE' => $benefitdata[2], 'TYPE' => $benefitdata[1])));
            if ($occurance == 0)
                $occurance = $benefitobj->find('count', array('conditions' => array('CODE' => $benefitdata[2], 'TYPE' => (string) $benefitdata[1])));
            if ($occurance == 0) {
                $benefit['Benefit']['TYPE'] = (string) $benefitdata[1];
                $benefit['Benefit']['CODE'] = (string) $benefitdata[2];
                $benefit['Benefit']['BENEFIT'] = 'PH';
                $benefit['Benefit']['LOCAL_DESCRIPTION_1'] = utf8_encode($benefitdata[3]);
                $benefit['Benefit']['CRITERION_NBR'] = 'Greenrain';
                $benefit['Benefit']['LOCAL_DESCRIPTION'] = '';
                $benefitobj->create();
                if ($benefitobj->save($benefit)) {
                    echo "Value inserted";
                } else {
                    echo 'Error...Can not insert the record';
                }
            } else {
                echo 'Record already exist';
            }
        }
    }

    function add_benefit() {

        echo "benefit is not correct.. \n";
        exit;
        $data = new Spreadsheet_Excel_Reader(WWW_ROOT . 'files/providerdetails/ddh.xls', true);
        $exeldata = $data->sheets['0']['cells'];
        $benefit = array();

        foreach ($exeldata as $key => $val) {
            //  $benefit[$key]    = array('CRITERION_NBR'=>trim(mb_strtolower($val['1'])),'LOCAL_DESCRIPTION'=>trim(mb_strtolower($val['5'])),'BENEFIT'=>trim($val['2']),'TYPE'=>(string)$val['3'],'CODE'=>trim($val['4']),'LOCAL_DESCRIPTION_1'=>mb_strtolower(trim($val['6'])));
        }

        app::import('model', 'Benefit');
        $benefitobj = new Benefit();
        if ($benefitobj->saveAll($benefit)) {
            echo('saved');
        } else {
            print_r($val);
            echo("could not save the benefit counld not be saved");
        }
    }

    function add_mcodes() {
        $data = new Spreadsheet_Excel_Reader(WWW_ROOT . 'files/providerdetails/mcode.xls', true);
        $exeldata = $data->sheets['0']['cells'];
        $mcode = array();


        foreach ($exeldata as $key => $val) {
            $mcode[$key] = array('codenumber' => trim($val['1']), 'description_1' => trim($val['2']), 'description_2' => trim($val['3']));
        }


        app::import('model', 'Mcode');
        $mcodeobj = new Mcode();
        if ($mcodeobj->saveAll($mcode)) {
            echo ('saved');
        } else {
            echo("could not save the mCodes");
        }
    }

    public function DHA_index($option = null) {
        $option==2?$ftype="HAAD":$ftype="DHA";
        app::import('model','Log');
        $logobj                         =   new Log();
        $data                           =   array();
        $data['Log']['User']            =   $this->Session->read('Auth.User.id');
        $data['Log']['Object']          =   "";
        $data['Log']['Objectcategory']  =   "users";
        $data['Log']['Header']          =   "User - Page access";
        $data['Log']['Desc']            =   "The ".$this->Session->read('Auth.User.username')." accessed the  page for listing ".$ftype   ." files";
        $logobj->create();
        $logobj->save($data);
        if ($option == 1) {
            $dhas = $this->Xmllisting->find('all', array('conditions' => array('created' => $this->getDateForSearch('Xmllistings'), 'Xmllisting.place' => 1)));
            $this->set('dhas', $dhas);
        }
        if ($option == 2) {
            $dhas = $this->Xmllisting->find('all', array('conditions' => array('created' => $this->getDateForSearch('Xmllistings'), 'Xmllisting.place' => 2)));
            $this->set('dhas', $dhas);
        }
    }

}
