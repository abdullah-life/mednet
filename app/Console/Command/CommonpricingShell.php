<?php
    class CommonpricingShell extends AppShell
    {
        public $uses = array("Commonproviderpricingfile");
        public function main()
        {
            $fileentries        =   $this->Commonproviderpricingfile->find('first',array('conditions'   =>  array('status' => 0)));
            if($fileentries['Commonproviderpricingfile']['dha_status']==1)
            {
                app::import('controller', 'Dhapricings');
                $dhapricingobj  =   new DhapricingsController();
                $dhapricingobj->insertrecords($fileentries);
                $this->Commonproviderpricingfile->id    =   $fileentries['Commonproviderpricingfile']['id'];
                $this->Commonproviderpricingfile->saveField('status',1);
            }
            if($fileentries['Commonproviderpricingfile']['haad_status']==1)
            {
                app::import('controller', 'Haadpricings');
                $dhapricingobj  =   new HaadpricingsController();
                $dhapricingobj->insertrecords($fileentries);
                $this->Commonproviderpricingfile->id    =   $fileentries['Commonproviderpricingfile']['id'];
                $this->Commonproviderpricingfile->saveField('status',1);
            }
        }
    }
?>
