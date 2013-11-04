<?php

class MailShell extends AppShell {


      public $uses = array('newfile');

     
      
      public function main()
      {
////          echo "Calling the dummy controller to differnet things \n";
////          echo "asd";
//         app::import('controller','xmllistings');
//         $xmllisting   =   new XmllistingsController()

//          app::import('controller','Benefits');
//         $batches   =   new benefitsController();
//     
//         $batches->benefitupdate();
          
          
////         $batches->removeentriesbydate();
//          if(is_dir(WWW_ROOT.'files/batch/'))
//          {          if(chmod(WWW_ROOT . 'files/batch/',0777))
//                  echo "sucess";
//          }
//          exit;
   //       $xmllisting->add_benefit();
//          app::import('model','providerdetail');
//          $providerdetail = new Providerdetail();
//          if($providerdetail->updateAll(array('active'=>0),array('active'=>1))){
//              echo "updated";
//              
//          }else 
//              echo "hi";
      }
      
      function addbenefit(){
         app::import('controller','Xmllistings');
         $xmllisting   =   new XmllistingsController();
         $xmllisting->addbenefit();
          
      }
      function mark(){
         app::import('controller','Newfiles');
         $xmllisting   =   new NewfilesController();
         $xmllisting->markeddownloaded();
          
      }
      function getfromproviderpricing(){
          app::import('controller','Providerpricings');
          $providerpricingobj   =   new ProviderpricingsController();
          $providerpricingobj->populatehaadpricing();
          
      }
      public function pricingfrommultipleproviders()
      {
          app::import('controller',  'Providerpricings');
          $pricingcontrollerobj     =   new ProviderpricingsController();
          $pricingcontrollerobj->insertformultiupleproviders();
      }
      public function benefitduplicates()
      {
          app::import('controller',  'benefits');
          $benefitsobj     =   new BenefitsController();
          $benefitsobj->getduplicatebenefits();
      }
      
      public function updatedenial(){
          app::import('Controller','Claims');
          $claimsobj  =   new ClaimsController();
          $claimsobj->updatedenialcodeforclaims();
      }
      
      public function createexcelfordhaproviders(){
          app::import('controller','Newfiles');
          $newfilesobj      =   new NewfilesController();
          $newfilesobj->printdhaprovider();
          $newfilesobj->printotherhaadprovider();
      }


      public function createbatchlist(){
          app::import('Controller','Claims');
          $claimsobj  =   new ClaimsController();
          $claimsobj->listbatchesandclaims();
      }
      public function fixcomment(){
           app::import('model','Claim');
           app::import('model','claimback');
           $claimobj    =   new Claim();
           $claimbackobj    =   new claimback();
           
           $failedclaims           =       $claimbackobj->find('all',array('conditions' => array('comment_id' =>array('$ne' => null))));
           foreach ($failedclaims as $failedclaim){
               $existingclaims      =   $claimobj->find('first',array('conditions' => array('id' =>  $failedclaim['claimback']['id'])));
               if(isset($existingclaims['Claim']['id'])){
                   if($claimobj->save(array('id' => $existingclaims['Claim']['id'],'comment_id' => $failedclaim['claimback']['comment_id']))){
                                        echo "Claim comment updated for ".$existingclaims['Claim']['id']." \n";
                                     
                                }
               }else{
                   echo "id not found".$existingclaims['Claim']['id']." \n";
                  
              }
            }
           
      }
      
      public function findclaims(){
          app::import('model','Claim');
          app::import('model','Claimstoday');
          $count=0;
          $claimobj                         =   new Claim();
          $claimtodayobj                    =   new Claimstoday();
          $claimsbackups                    =   $claimtodayobj->find('all');
          
          foreach($claimsbackups as $claimsbackup){
              $existingclaims               =   $claimobj->find('count',array('conditions' => array('id' => $claimsbackup['Claimstoday']['id'])));
              if($existingclaims ==  0)
              {
                  print_r($claimsbackup);
                  $claimtoinsert['Claim']   =   $claimsbackup['Claimstoday'];
                  $claimobj->create();
                  print_r($claimtoinsert);
                  if($claimobj->save($claimtoinsert)){
                      echo "Inserted ".$claimtoinsert['Claim']['claim']['xmlclaimID'];
                  }
                  $count++;
              }
          }
          echo $count;
          
      }
      
      public function uploadpayermappings()
      {
          app::import('controller',  'Payerslists');
          $payerlistobj     =   new PayerslistsController();
          $payerlistobj->uploadData();
      }
      public function activateproviders()
      {
          app::import('controller','Providerdetails');
          $providerdetailsobj       =    new ProviderdetailsController();
          $providerdetailsobj->activatefromexcel();
          echo 'Updated';
      }
      public function removespecialchar(){
          app::import('model','providerpricing');
          $providerpricing  =    new Providerpricing();
          $entries    =   $providerpricing->find('all',array('conditions'=>array('gross'=>array('$regex'=>'\*'))));
          $totalcount   =   count($entries);
          foreach($entries as $key=>$val){
              echo $totalcount-$key." \n \n";
              echo $val['gross'];
             
              if(strpos($val['Providerpricing']['gross'],'*')!==FALSE){
                 
                 $providerpricing->id   =  $val['id'];
                 $newgros               =   (int) str_replace('*', '', $val['Providerpricing']['gross']);
                 $updted                =   $providerpricing->save( array('Providerpricing'=>array('id'=>$val['Providerpricing']['id'],'gross'=> $newgros)));
                 $newlyread             =   $providerpricing->find('first',array('conditions'=>array('id'=>$val['Providerpricing']['id'])));
                 print_r($newlyread);
               
              }
               else{

                    
               
                  
              }
              
          }
          
      }
      public function deactivate()
      {
          app::import('controller','Providerdetails');
          $providerdetailsobj = new ProviderdetailsController();
          $providerdetailsobj->activateprovidersfromexcel();
      }
      
      public function failedactivitycount(){
          app::import('model','claim');
          app::import('model','activity');
          $claimobj     =   new Claim();
          $activityobj  =   new Activity();
          $claims       =   $claimobj->find('list',array('conditions' => array('comment_id' => array('$ne' => null))));
          $activitycount = 0;
          foreach ($claims as $claim)
          {
              $activitycount+=$activityobj->find('count',array('conditions' => array('claim_id' => $claim)));
          }
          echo $activitycount;   
          
      }
      public function addmcodes(){
          app::import('controller','Mcodes');
          $mcodesobj         =   new McodesController();
          $mcodesobj->addmcodes();
          
      }
      
}