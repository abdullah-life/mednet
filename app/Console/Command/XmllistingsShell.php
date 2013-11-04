<?php

class XmllistingsShell extends AppShell {

    public $uses = array('Xmllisting', 'Newfile', 'Batch');

    public function main() {
        for ($i = 0; $i < 4; $i++) {
            $this->out("starting the loop no : $i");
            $this->out('checking if the files has been picked');
            app::import('controller','Newfiles');
            $newfiles   =   new NewfilesController();
            $result = $newfiles->getTodaysCount();
            // uncommnet $savedxml to skip adding new files
            //         $result  =   1;
            if ($result == 0) {
                //today soap was not called at all, take the file ids 
                $this->out('No files has been picked');
                $this->out('running to get the file ids calling function getapi');
                $this->getapi();
                $this->out("exiting...");
            } else {
                $this->out('newfile has taken');
                $this->out('searching if any xmls are not picked using fileid');
                $savedxml = $this->Newfile->find('count',$params);
               // uncommnet $savedxml to skip downloading xmls
               // $savedxml   =   0;

                if ($savedxml > 0) {
                    $this->out('picking xmls using the the fileid and saving it locally..');
                    $params = array(
			'conditions' => array('created' => $newfiles->getDateForConsoleSearch()),
			'conditions' => array('cron_status' => 0),
                    );
                    $topick = $this->Newfile->find('list',$params);
//                    foreach ($topick as $val) {
//                        $this->out('Calling getxml......');
                        $this->getxml();
                   // }
                } else {
                    $this->out('Every xml picked, Checking if there are any xmls that need to be parsed and saved into db');
                     $params = array(
			'conditions' => array('created' => $newfiles->getDateForConsoleSearch(),'cronstatus' => 0),
                    );
                    
                    $tosavecountpick = $this->Xmllisting->find('count',$params);
                    echo "found ".$tosavecountpick." file to pick \n";

                    if ($tosavecountpick > 0) {
                        $this->out('Total number of xmls left to parse and save:' . $tosavecountpick);
                        $this->out('calling fucntion savexml');
                        $this->savexml();
                       
                    }else {
                             $params = array(
                                            'conditions' => array('created' => $newfiles->getDateForConsoleSearch()),
                                        );
                            $batchcount = $this->Batch->find('count',$params);
                            //$batchcount = 0;
                            if ($batchcount == 0) {
                                $this->out('Every xml has been saved, and splitted, creating batches, start the baching process...');
                                $this->startbatching();
                            } else {
                                $this->out('Batch already created');
                            }
                    }
                }
            }
        }
    }

    public function split() {
        $this->out("splitting starts here");
        app::import('controller', 'Xmllistings');
        $xmllistings = new XmllistingsController();
        $xmllistings->start();
    }

    public function UpdateCreterion() {
        app::import('controller', 'Xmllistings');
        $xmllistings = new XmllistingsController();
        $xmllistings->addcriterion();
    }

    public function getapi() {
        app::import('controller', 'Xmllistings');
        $xmllistings = new XmllistingsController();
        //first step is to pick the xml id (this does not have the actual xml)
        $this->out("calling pickallxml..");
        $xmlarray = $xmllistings->pickallxml();
        $this->out($xmlarray);
    }

    public function getxml() {
        app::import('controller', 'Xmllistings');
        $xmllistings = new XmllistingsController();
        //this will download the xml and save it to the directory
        $this->out("calling function getNewFileUnprocessedXml");
        $createxmllisting = $xmllistings->getnewfiles();
    }

    public function savexml() {
        app::import('controller', 'Xmllistings');
        $xmllistings = new XmllistingsController();
        //this will parse the xml that has been downloaded
        $this->out('calling function loopxmlandparse');
        
        $parseandprocess = $xmllistings->loopxmlandparse();
       
        $this->out(pr($parseandprocess));
    }

    public function startbatching() {
        app::import('controller', 'Batches');
        $batches = new BatchesController();
        $batches->createnewbatches();
        $batches->createnewresubmissionbatches();
    }

}


?>
