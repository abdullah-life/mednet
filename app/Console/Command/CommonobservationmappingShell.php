<?php
    class CommonobservationmappingShell extends AppShell
    {
        public $uses = array("Commonobservationmappingfile");
        public function main()
        {
            $fileentries        =   $this->Commonobservationmappingfile->find('first',array('conditions'   =>  array('status' => 0)));
            if($fileentries['Commonobservationmappingfile']['dha_status']==1)
            {
                app::import('controller', 'Dhaobservationmappings');
                $dhapricingobj  =   new DhaobservationmappingsController();
                $dhapricingobj->insertrecords($fileentries);
                $this->Commonobservationmappingfile->id    =   $fileentries['Commonobservationmappingfile']['id'];
                $this->Commonobservationmappingfile->saveField('status',1);
            }
            if($fileentries['Commonobservationmappingfile']['haad_status']==1)
            {
                app::import('controller', 'Haadobservationmappings');
                $dhapricingobj  =   new HaadobservationmappingsController();
                $dhapricingobj->insertrecords($fileentries);
                $this->Commonobservationmappingfile->id    =   $fileentries['Commonobservationmappingfile']['id'];
                $this->Commonobservationmappingfile->saveField('status',1);
            }
        }
    }
?>