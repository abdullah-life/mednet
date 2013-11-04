<?php
class XmlemailShell extends AppShell{
    public $uses = array('Xmllisting', 'Newfile', 'Batch');
    
    public function main() {
       app::import('controller','Newfiles');
       $newfiles   =   new NewfilesController();
       $params          =   array(
                                'conditions' => array(
                                    'manual_upload_status' => 0
                                )
                            );
       
       
      $tosavecountpick = $this->Xmllisting->find('count',$params);
      echo $tosavecountpick ."..........................................";
      if ($tosavecountpick > 0) {
           $this->out('Total number of xmls left to parse and save:' . $tosavecountpick);
	   $file_det	=	$this->Xmllisting->find('first',$params);
           $this->out('calling fucntion savexml');
           $this->savexml();
	
           $this->out('Every xml has been saved, and splitted, creating batches, start the baching process...');
           $this->startbatching($file_det['Xmllisting']['id']);
      }
      else{
	die("Batch Already created");
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
        
        $parseandprocess = $xmllistings->loopxmlandparseemailxml();
        $this->out(pr($parseandprocess));
    }

    public function startbatching($id=null){
        app::import('controller', 'Batches');
        $batches = new BatchesController();
        $batches->createnewbatches($id);
        $batches->createnewresubmissionbatches($id);
    }
}
?>
