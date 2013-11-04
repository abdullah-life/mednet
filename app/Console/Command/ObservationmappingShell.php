<?php
    class ObservationmappingShell extends AppShell
    {
        public $uses = array('ObservationMapping','Observationmappingfile');
        public function main()
        {
            app::import('controller','ObservationMappings');
            $observationMappingsobj =   new ObservationMappingsController();
            $file   =   $this->Observationmappingfile->find('first',array('conditions'  =>  array('status'  =>  0)));
            
          
            
            if(file_exists(WWW_ROOT . 'files/Observationmappings/'.$file['Observationmappingfile']['file']))
            $observationMappingsobj->saveFields($file);
            $this->Observationmappingfile->id = $file['Observationmappingfile']['id'];
            $this->Observationmappingfile->saveField('status',1);
         }
    }
?>
