<?php

class TypefivepricingsController  extends AppController {
   var $uses    = false;
   var $place;
  

      public function beforeFilter($place) {
        parent::beforeFilter();
        $this->Auth->allow('*');
    }

   
 public function getnetprice( $Type, $Code, $Start, $observations = null,$place) {
     
        echo "inside getnetprice  \n";
        $this->place   =   $place;
        app::import('model', 'Dhapricing');
        app::import('model', 'Dhaobservationmapping');
        app::import('model', 'Haadpricing');
        app::import('model', 'Haadobservationmapping');
       
        if($this->place==1){
            $observationmapping         = new Dhaobservationmapping();
            $observationmodel           =   "Dhaobservationmapping";
            $providerpricing            = new Dhapricing();
            $pricingmodel               =   "Dhapricing";
            
        }else{
            $observationmapping         = new HaadObservationMapping();
            $observationmodel           =   "Haadobservationmapping";
            $providerpricing            = new Haadpricing();
            $pricingmodel               =   "Haadpricing";
        }
        
        
        echo "@ 37 \n";
        $avtiveobservation = array();
        if($observations!=null) {
            if (!isset($observations[0])) {
                $newobservation = $observations;
                unset($observations);
                $observations[] = $newobservation;
            }
        }

        echo "@ 47 \n";
        if (isset($observations)) {
            foreach ($observations as $observation) {
              
                if(($observation['Type'] == 'Text')&&(trim($observation['Code'])=='Non-Standard-Code' OR trim($observation['Code'])=='Presenting-Complaint' OR trim($observation['Code'])=='PresentingComplaint')) {
                    if (strpos($observation['Value'], "=")) {
                        $codearray = explode('=', $observation['Value']);
                        $observationcode = $codearray[0];
                    } else if (strpos($observation['Value'], "|")) {
                        $codearray = explode('|', $observation['Value']);
                        $observationcode = $codearray[0];
                    } else {
                       
                        $observationcode = $observation['Value'];
                    }
                }
            }
            if ($observationcode==null) {
                echo "@ 65 \n";
                echo " no valid observation code found \n So calling provider pricing @1288 \n";
                $pricing = $this->getnetpricefromprovider( $Type, $Code, $Start);
                if ($pricing == null) {
                    echo "could not find any provider pricing \n";
                    return false;
                } else {
                    echo "found provider pricing $pricing \n";
                    return $pricing;
                }
            } else {
                echo "@ 76 \n";
                echo "valid observation code found - checking if there is observation price for it \n";
                $pricingdetails = $observationmapping->find('all', array('conditions' => array('activity_code' => $Code, 'activity_type' => $Type, 'observation_code' => $observationcode)));
                if (count($pricingdetails) > 0) {
                    foreach ($pricingdetails as $prcing) {
                        $strtostarttime = strtotime($prcing[$observationmodel]['start_date']['day'] . "." . $prcing[$observationmodel]['start_date']['month'] . "." . $prcing[$observationmodel]['start_date']['year']);
                        $Start = date('d.m.Y', strtotime(str_replace("/", ".", $Start)));
                        if ($strtostarttime <= strtotime($Start)) {
                            $prcing['diff'] = strtotime(str_replace("/", ".", $Start)) - $strtostarttime;
                            $eligibelepricing[] = $prcing;
                        }
                    }

                    $lowerstdiff = $eligibelepricing[0]['diff'];

                    foreach ($eligibelepricing as $pricing) {
                        if ($lowerstdiff >= $pricing['diff']) {
                            $lowerstdiff = $pricing['diff'];
                            $prominentpricing = $pricing;
                        }
                    }
                    if (isset($prominentpricing[$observationmodel]['gross_price'])) {
                        echo " return observation pricing@1233 \n";
                        return $prominentpricing[$observationmodel]['gross_price'];
                    } else {
                        echo "No net price found from observation @1327 \n";
                        $pricing = $this->getnetpricefromprovider( $Type, $Code, $Start);
                        if (!$pricing) {
                            return false;
                        } else {
                            return $pricing;
                        }
                    }
                } else {
                    echo " calling provider pricing because there was no observation prcing found \n ";

                    $pricing = $this->getnetpricefromprovider( $Type, $Code, $Start);

                    if (!$pricing) {
                        return false;
                    } else {
                        return $pricing;
                    }
                }
            }
        } else {

            $pricing = $this->getnetpricefromprovider( $Type, $Code, $Start);
            return $pricing;
        }
    }
    
    public function getnetpricefromprovider( $Type, $code, $Start) {
      
        $lowerstdiff = 0;
        $eligibelepricing = array();
        app::import('model', 'Dhapricing');
        app::import('model', 'Dhaobservationmapping');
        app::import('model', 'Haadpricing');
        app::import('model', 'Haadobservationmapping');
       
        if($this->place==1){
            $observationmapping         = new Dhaobservationmapping();
            $observationmodel           =   "Dhaobservationmapping";
            $providerpricing            = new Dhapricing();
            $pricingmodel               =   "Dhapricing";
            
        }else{
            $observationmapping         = new HaadObservationMapping();
            $observationmodel           =   "Haadobservationmapping";
            $providerpricing            = new Haadpricing();
            $pricingmodel               =   "Haadpricing";
        }
        $providerpricingdet = $providerpricing->find('all', array('conditions' => array( 'code' => $code)));
        
     
        if (!$providerpricingdet)
            $providerpricingdet = $providerpricing->find('all', array('conditions' => array( 'code' => trim($code), 'activity' => new MongoInt32($Type))));
        
       
        if ($providerpricingdet) {
            foreach ($providerpricingdet as $prcing) {
                $strtostarttime = strtotime($prcing[$pricingmodel]['start_date']['day'] . "-" . $prcing[$pricingmodel]['start_date']['month'] . "-" . $prcing[$pricingmodel]['start_date']['year']);
                if ($strtostarttime <= strtotime(str_replace("/", "-", $Start))) {
                    $prcing['diff'] = strtotime($Start) - $strtostarttime;
                    $eligibelepricing[] = $prcing;
                }
            }
        }
       

        if (isset($eligibelepricing[0]['diff']))
            $lowerstdiff = $eligibelepricing[0]['diff'];
        else
            $lowerstdiff = 0;
        foreach ($eligibelepricing as $pricing) {
            if ($lowerstdiff >= $pricing['diff']) {
                $lowerstdiff = $pricing['diff'];
                $prominentpricing = $pricing;
            }
        }
       
        if (!isset($prominentpricing[$pricingmodel]['gross'])){
                echo "@173 no price found \n";
            return false;
           
        }
        else {
           
            echo "@1075 " . $prominentpricing[$pricingmodel]['gross'];
            return $prominentpricing[$pricingmodel]['gross'];
         
        }
    }
    
    
    public function getnetpricefromactivity($ProviderID, $activityid) {
       
        app::import('model', 'Dhapricing');
        app::import('model', 'Dhaobservationmapping');
        app::import('model', 'Haadpricing');
        app::import('model', 'Haadobservationmapping');
        app::import('model', 'Header');
        app::import('model', 'Activity');
        $activityobj                    = new Activity();
        
        $activityarray                  = $activityobj->read(null, $activityid);
        $avtiveobservation = array();
        $observations = $activityarray['Activity']['Observation'];
        $headerobj  =   new Header();
       
       
        $headerdata =   $headerobj->find('first',array('fields'=>array('ReceiverID'), 'conditions'=>array('xmllisting_id'=>$activityarray['Activity']['xmllisting_id'])));
     
        if($headerdata['Header']['ReceiverID']=='C004')
           $this->place   =   0;
       else
           $this->place   =   1;
       
       
       
       
        if (!isset($observations[0])) {
            $newobservation = $observations;
            unset($observations);
            $observations[0] = $newobservation;
        }
      
         if($this->place==1){
            $observationmapping         = new Dhaobservationmapping();
            $observationmodel           =   "Dhaobservationmapping";
            $providerpricing            = new Dhapricing();
            $pricingmodel               =   "Dhapricing";
            
        }else{
            $observationmapping         = new HaadObservationMapping();
            $observationmodel           =   "Haadobservationmapping";
            $providerpricing            = new Haadpricing();
            $pricingmodel               =   "Haadpricing";
        }
        if (isset($observations)) {
            foreach ($observations as $observation) {
                if(($observation['Type'] == 'Text')&&(trim($observation['Code'])=='Non-Standard-Code' OR trim($observation['Code'])=='Presenting-Complaint' OR trim($observation['Code'])=='PresentingComplaint')) {
                    if (strpos($observation['Value'], "=")) {
                        $codearray = explode('=', $observation['Value']);
                        $observationcode = $codearray[0];
                        //return $observationcode;
                    } else if (strpos($observation['Value'], "|")) {
                        $codearray = explode('|', $observation['Value']);
                        $observationcode = $codearray[0];
                    } else {
                        $observationcode = $observation['Value'];
                    }
                }
            }
          
            if (!isset($observationcode)) {
                $pricing = $this->getnetpricefromprovider( $activityarray['Activity']['Type'], $activityarray['Activity']['Code'], $activityarray['Activity']['start']);
                 
                if (!$pricing) {
                    return 0;
                } else {
                    return $pricing;
                }
            } else {
               
                $pricingdetails = $observationmapping->find('all', array('conditions' => array( 'activity_code' => $activityarray['Activity']['Code'], 'activity_type' => $activityarray['Activity']['Type'], 'observation_code' => $observationcode)));
                if (isset($pricingdetails)) {
                    foreach ($pricingdetails as $prcing) {
                        $strtostarttime = strtotime($prcing[$observationmodel]['start_date']['year'] . "-" . $prcing[$observationmodel]['start_date']['month'] . "-" . $prcing[$observationmodel]['start_date']['day']);
                        if ($strtostarttime < strtotime($activityarray['Activity']['start'])) {
                            $prcing['diff'] = strtotime($Start) - $strtostarttime;
                            $eligibelepricing[] = $prcing;
                        }
                    }
                    $lowerstdiff = $eligibelepricing[0]['diff'];

                    foreach ($eligibelepricing as $pricing) {

                        if ($lowerstdiff >= $pricing['diff']) {
                            $lowerstdiff = $pricing['diff'];
                            $prominentpricing = $pricing;
                        }
                    }
                    if (isset($prominentpricing[$observationmodel]['gross_price'])) {
                        return $prominentpricing[$observationmodel]['gross_price'];
                    } else {

                        $pricing = $this->getnetpricefromprovider( $activityarray['Activity']['Type'], $activityarray['Activity']['Code'], $activityarray['Activity']['start']);
                        if (!$pricing) {
                            return 0;
                        } else {
                            return $pricing;
                        }
                    }
                } else {

                    $pricing = $this->getnetpricefromprovider( $activityarray['Activity']['Type'], $activityarray['Activity']['Code'], $activityarray['Activity']['start']);
                    if (!$pricing) {
                        return 0;
                    } else {
                        return $pricing;
                    }
                }
            }
        } else {

            $pricing = $this->getnetpricefromprovider($activityarray['Activity']['Type'], $activityarray['Activity']['Code'], $activityarray['Activity']['start']);

            if ($pricing)
                return $pricing;
            else
                return 0;
        }
    }
    
    
    
    
}
?>
