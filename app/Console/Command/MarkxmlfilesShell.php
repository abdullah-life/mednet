<?php
    class MarkxmlfilesShell extends AppShell{
        
        public function main(){
            app::import('controller','App');
            app::import('model','Newfile');
            $newfileobj     =   new Newfile();
            $controllerobj  =   new AppController();
            $conditions     =   array('conditions' => array('created' => $controllerobj->getDateForConsoleSearch(),'mark_status' => array('$ne' => 1)));
            $fields         =   array('fields' => array('id','FileID','ReceiverID'));
            $newfiles       =   $newfileobj->find('all',$conditions,$fields);
            foreach ($newfiles as $nfile){
                if($nfile['Newfile']['ReceiverID'] == 'C004'){
                    if($this->settransactiondownloadedhaad($nfile['Newfile']['FileID'])){
                        echo "The file has been marked as downloaded ".$nfile['Newfile']['id'];
                    }else{
                        echo "The file ".$nfile['Newfile']['id']." failed to mark as downlaoded";
                    }
                }
                else{
                    if($this->settransactiondownloadeddha($nfile['Newfile']['FileID'])){
                        echo "The file has been marked as downloaded ".$nfile['Newfile']['id'];
                    }else{
                        echo "The file ".$nfile['Newfile']['id']." failed to mark as downlaoded";
                    }
                }
                $newfileobj->id = $nfile['Newfile']['id'];
                $newfileobj->save(array("mark_status" => 1));
                die($nfile['Newfile']['id']);
            }
        }
        public function settransactiondownloadeddha($fileid=null){
            
            if($fileid){
                $client = new SoapClient("http://www.eclaimlink.ae/dhpo/ValidateTransactions.asmx?wsdl",array(  "trace"    => 1, "exceptions" => 0));
                try{
                    $params  =   array ("login" => "MedNet UAE",
                                    "pwd" => "claimsmnu", 
                                    "fieldId" =>$fileid,
                                    );
                    $x = $client->SetTransactionDownloaded($params);
                    print_r($x);   
                    return true;
                }catch (SoapFault $exception) {
                    print_r ($exception);
                }
                return false;
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
                        return true;
                    }catch (SoapFault $exception) {
                        print_r( $exception);
                    }
                    return false;
            }
        }
    }
?>
