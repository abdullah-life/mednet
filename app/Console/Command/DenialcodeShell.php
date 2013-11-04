<?php
        class DenialcodeShell extends AppShell
        {
                public $uses = array('Denialcode', 'Denialtable');
                
                public function main()
                {
                        
                        
                        $denialrecords          =   $this->Denialtable->find('first',array('conditions'   =>  array('status'  =>  0)));
                        App::uses('DenialcodesController', 'Controller');
                        $Denialtables           =   new DenialcodesController();
                       if($denialrecords)
                            $Denialtables->adddenialCodes($denialrecords);
                       
                }
                
        }

?>
