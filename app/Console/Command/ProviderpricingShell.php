<?php

class ProviderpricingShell extends AppShell {

      public $uses = array('Providerpricing');
     
      
      public function main()
      {
          app::import('Controller','Providerpricings');
          $providerpricingObj   =   new ProviderpricingsController();
          $providerpricingObj->providerpricingcron();
      }
      
      
}