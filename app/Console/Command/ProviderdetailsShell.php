<?php

class ProviderdetailsShell extends AppShell {

      public $uses = array('Providerdetail');
     
      
      public function main()
      {
          app::import('model','Provider');
          $provider   =   new Provider();
          app::import('Controller','Providerdetails');
          $providerpricingObj   =   new ProviderdetailsController();
          
          $pfiles   =   $provider->find('all',array('conditions'    => array('status' =>  0)));
          foreach ($pfiles as $pfile)
          {
              $provider->save(array('Provider'=>array('status'=>1,'id'=>$pfile['Provider']['id'])));
              $providerpricingObj->insertproviders($pfile['Provider']['directory_name'].$pfile['Provider']['file_name']);
              
          }
      }
}