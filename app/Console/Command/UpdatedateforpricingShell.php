<?php
    class UpdatedateforpricingShell extends AppShell{
          public $uses = array('Providerpricing','Providerdetail');
          public function main()
          {
              $providerdetails     = $this->Providerdetail->find("all",array("conditions"  =>  array("city"    =>  "DUBAI"),'fields'   =>  array("id")));
              foreach ($providerdetails as $providerdetail)
              {
                  $providerpricings     =   $this->Providerpricing->find('all',array("conditions"   =>  array('providerdetail_id'   =>  $providerdetail['Providerdetail']['id'])));
                  foreach ($providerpricings as $providerpricing)
                  {
                      if(($providerpricing['Providerpricing']['start_date']['month']=="06")&&($providerpricing['Providerpricing']['start_date']['day']=="01")&&($providerpricing['Providerpricing']['start_date']['year']=="2013"))
                      {
                          $this->Providerpricing->id    =   $providerpricing['Providerpricing']['id'];
                          $this->Providerpricing->saveField('start_date.day','01');
                          $this->Providerpricing->saveField('start_date.month','01');
                          $this->Providerpricing->saveField('start_date.year','2013');
                          echo "Detail updated for pricing_id : ".$providerpricing['Providerpricing']['id'];
                      }
                  }
              }
          }
    }
?>
