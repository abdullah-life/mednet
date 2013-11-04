<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'excel_reader2');
/**
 * Xmllistings Controller
 *
 * @property Xmllisting $Xmllisting
 */
class SplittingsController extends AppController {
      
    
        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('*');
        }
        
    public function start(){
       $this->autoRender            =   FALSE;
       $this->Xmllisting->recursive =   -1;
       $xmltosplit                  =   $this->Xmllisting->find('all',array('conditions'=>array(
                                               'Xmllisting.splitstatus'=>0,'otherfile'=>0 
                                                )));
       echo "take count of the numbder of files that has splitting status 0  \n " ;
       echo 'files to split :'.count($xmltosplit). " \n";
       foreach($xmltosplit as $singlexml){
                $this->creatematernityxmls($singlexml['Xmllisting']['id']);
        }
    }
    
    public function creatematernityxmls($xmlistingid=null){
       $headers         =   $this->createxmlHeaders($xmlistingid);
       $this->Xmllisting->Claim->recursive  =-1;
       $patients       =   $this->CheckingIfOutPatient($xmlistingid);
       foreach($patients['out'] as $val){
           $maternityreturn       =   $this->getAllMAternityNonMaternity($val);
           if($maternityreturn=="non_maternity"){
               $patients['non_maternity'][]    =   $val;
           }else{
               $patients['maternity'][]    =   $val;
           }
       }
      $xmllistingDetails    =   $this->Xmllisting->read(null,$xmlistingid) ;
      $this->createXMl('Inpatents',$patients['in'],$headers,$xmllistingDetails);
      $this->createXMl('Inpatents',$patients['out'],$headers,$xmllistingDetails);
//      $this->createXMl('Outpatents_maternity',$patients['maternity'],$xmllistingDetails);
//      $this->createXMl('Outpatents_non_maternity',$patients['non_maternity'],$xmllistingDetails);
//   
     }

 public function getAllClaimDetails($claimid=null){
      $this->Xmllisting->Claim->recursive    =1;
      $claimarray     =   $this->Xmllisting->Claim->read(null,$claimid);
      return $claimarray;
 }   
 
 public function getObservationForActivity($activityid=null){
     $activity      =   $this->Xmllisting->Claim->Activity->Observation->read(null,$activityid);
     if($activity)
     return $activity;
     else
        return  null;
     
 }
    
 public function  createXMl($appendname,$claims,$headers,$xmllistingarray){
     $xml   =   $headers;
     foreach($claims as $claim){
        $claimarray         =   $this->getAllClaimDetails($claim);
        $claimxml .=   '<Claim>
                        <ID>'.$claimarray['Claim']['xmlclaimID'].'</ID>';
        if(isset($claimarray['Claim']['IDPayer']))
            $claimxml  .=  '<IDPayer>'.$claimarray['Claim']['IDPayer'].'</IDPayer>';
        else
            $claimxml  .=  '<IDPayer/>';
        if(isset($claimarray['Claim']['MemberID']))
            $claimxml  .= '<MemberID>'.$claimarray['Claim']['MemberID'].'</MemberID>';
        else    
            $claim  .= '<MemberID/>'; 
        if(isset($claimarray['Claim']['PayerID']))
            $claimxml  .= '<PayerID>'.$claimarray['Claim']['PayerID'].'</PayerID>';
        else
            $claimxml  .= '<PayerID/>';
        if(isset($claimarray['Claim']['ProviderID']))
            $claimxml  .= '<ProviderID>'.$claimarray['Claim']['ProviderID'].'</ProviderID>';
        else
            $claimxml  .= '<ProviderID/>';
                        
        if(isset($claimarray['Claim']['EmiratesIDNumber']))
            $claimxml  .= '<EmiratesIDNumber>'.$claimarray['Claim']['EmiratesIDNumber'].'</EmiratesIDNumber>';
        else
            $claimxml  .= '<EmiratesIDNumber/>';
                      
        if(isset($claimarray['Claim']['Gross']))
            $claimxml  .= '<Gross>'.$claimarray['Claim']['Gross'].'</Gross>';
        else
            $claimxml  .= '<Gross/>';
        if(isset($claimarray['Claim']['PatientShare']))
            $claimxml  .= '<PayerID>'.$claimarray['Claim']['PatientShare'].'</PayerID>';
        else
            $claimxml  .= '<PatientShare/>';
        if(isset($claimarray['Claim']['Net']))
            $claimxml  .= '<Net>'.$claimarray['Claim']['PatientShare'].'</Net>';
        else
            $claimxml  .= '<Net/>';
        //Claims xml ends here... now look into the encounter 
                $claimxml  .=   '<Encounter>';
               if(isset($claimarray['Encounter'][0]['FacilityID']))
                    $claimxml  .= '<FacilityID>'.$claimarray['Encounter'][0]['FacilityID'].'</FacilityID>';
                else
                    $claimxml  .= '<FacilityID/>';      
               if(isset($claimarray['Encounter'][0]['Type']))
                    $claimxml  .= '<Type>'.$claimarray['Encounter'][0]['Type'].'</Type>';
                else
                    $claimxml  .= '<Type/>';      
               if(isset($claimarray['Encounter'][0]['PatientID']))
                    $claimxml  .= '<PatientID>'.$claimarray['Encounter'][0]['PatientID'].'</PatientID>';
                else
                    $claimxml  .= '<PatientID/>';      
               if(isset($claimarray['Encounter'][0]['Start']))
                    $claimxml  .= '<Start>'.$claimarray['Encounter'][0]['Start'].'</Start>';
                else
                    $claimxml  .= '<Start/>';      
               if(isset($claimarray['Encounter'][0]['StartType']))
                    $claimxml  .= '<StartType>'.$claimarray['Encounter'][0]['StartType'].'</StartType>';
                else
                    $claimxml  .= '<StartType/>';      
               if(isset($claimarray['Encounter'][0]['EndType']))
                    $claimxml  .= '<EndType>'.$claimarray['Encounter'][0]['EndType'].'</EndType>';
                else
                    $claimxml  .= '<EndType/>';      
                    $claimxml  .= '</Encounter>';   
               //end of encounter start of with diagnosis
                if(count($claimarray['Diagnosi']>0)){    
                        foreach($claimarray['Diagnosi'] as $diagnosis){
                             $claimxml  .= '<Diagnosis>';
                             $claimxml  .= '<Type>'.$diagnosis['Type'].'</Type>';
                             $claimxml  .= '<Code>'.$diagnosis['Code'].'</Code>';
                             $claimxml  .= '</Diagnosis>';
                        }
                }
                if(count($claimarray['Activity']>0)){    
                        foreach($claimarray['Activity'] as $activity){
                             $claimxml  .= '<Activity>';
                                $claimxml  .= '<Start>'.$activity['Start'].'</Start>';
                                $claimxml  .= '<Type>'.$activity['Type'].'</Type>';
                                $claimxml  .= '<Code>'.$activity['Code'].'</Code>';
                                $claimxml  .= '<Quantity>'.$activity['Quantity'].'</Quantity>';
                                $claimxml  .= '<Net>'.$activity['Net'].'</Net>';
                                $claimxml  .= '<Clinician>'.$activity['Clinician'].'</Clinician>';
                                $claimxml  .= '<PriorAuthorizationID>'.$activity['PriorAuthorizationID'].'</PriorAuthorizationID>';
                                $observation=   $this->getObservationForActivity(1);
                                
                                if(ISSET($observation)){
                                        $claimxml.='<Observation>';
                                            $claimxml   .=  '<Type>'.$observation['Observation']['Type'].'</Type>
                                                                <Code>'.$observation['Observation']['Code'].'</Code>
                                            <Value>'.$observation['Observation']['Value'].'</Value>
                                            <ValueType>'.$observation['Observation']['ValueType'].'</ValueType>';
                                             $claimxml   .= '</Observation>';
                                    }
                             $claimxml  .= '</Activity>';
                        }
                }
                //end of diagnosis start of with activity
              $claimxml  .= '</Claim>';
     }
     $claimxml  .= '</Claim.Submission>';
     $fh                  =       fopen(WWW_ROOT.'files/splited/'.'test_'.$xmllistingarray['Xmllisting']['name'].".xml", 'w');
     if(!$fh)
         echo "ERROR::could not open folder @165";
    fwrite($fh, $headers.$claimxml);
    
    
     
     
 }  
    
    

 
 public function getAllMAternityNonMaternity($claimid =   null){
      if($claimid){
          $this->Xmllisting->Claim->Diagnosi->recursive   =   -1;
          $diagonis         =       $this->Xmllisting->Claim->Diagnosi->find('first',array('conditions'=>array('Diagnosi.claim_id'=>$claimid,'Type'=>'Principal')));
          app::import('model','Mcode');
          $mcodeobj         =       new Mcode();
          $maternitypatienst=       array();
          $ifmaternity      =       $mcodeobj->find('list',array('conditions'=>array('codenumber'=>$diagonis['Diagnosi']['Code'])));
          if($ifmaternity){
             return 'maternity';
          }else{
              return 'non_maternity';
          }
      }
 }
    
    
      
 
  public function CheckingIfOutPatient($xmlistingid=null){
      
      if($xmlistingid){
          $this->Xmllisting->Claim->Encounter->recursive    =   -1;
          $claims          =   $this->Xmllisting->Claim->find('all',array('conditions'=>array(
                                               'Claim.xmllisting_id'=> $xmlistingid
                                                )));
          $patients  =   array();
          foreach($claims as $claim)
          {
              
            $ecnounter            =   $this->Xmllisting->Claim->Encounter->find('first',array('conditions'=>array('Encounter.claim_id'=>$claim['Claim']['id'])));
            $inpatient            =   array(3,4,5,6);
            $outpatient           =   array(1,2,7,8,9 );
            
            if(in_array($ecnounter['Encounter']['Type'],$inpatient)) 
              {
                $patients['in'][]       =    $ecnounter['Encounter']['claim_id'];
              } 
            else
              {
                $patients['out'][]      =   $ecnounter['Encounter']['claim_id'];
              }
         }
            //make the check if the user is in/oput patiens
          return $patients;
          
      }
     
      
      
  }
  
  
  
    
    
    
    public function createxmlHeaders($xmllistingid=null)
    {
        
        $this->autoRender   =   false;
        if($xmllistingid){
            $headerdetails  =   $this->Xmllisting->Header->find('first',array('conditions'=>array('Header.xmllisting_id'=>$xmllistingid)));
            $header =  '<?xml version="1.0"?>
                <Claim.Submission xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:tns="http://www.haad.ae/DataDictionary/CommonTypes" xsi:noNamespaceSchemaLocation="http://www.haad.ae/DataDictionary/CommonTypes/ClaimSubmission.xsd">
                  <Header>
                    <SenderID>'.$headerdetails['Header']['SenderID'].'</SenderID>
                    <ReceiverID>'.$headerdetails['Header']['ReceiverID'].'</ReceiverID>
                    <TransactionDate>'.date('d/m/Y H:i:s',strtotime($headerdetails['Header']['TransactionDate'])).'</TransactionDate>
                    <RecordCount>'.$headerdetails['Header']['RecordCount'].'</RecordCount>
                    <DispositionFlag>'.$headerdetails['Header']['DispositionFlag'].'</DispositionFlag>
                  </Header>';
            return $header;
            
        }else{
            echo "id not present \n";
        }
         
   }
   
    
  function show_excel() {
        $data       =   new Spreadsheet_Excel_Reader('execlfiles/MCodes.xls', true);
        $exeldata   =   $data->sheets['0']['cells'];
        $mcode=   array();
        foreach($exeldata as $key=>$val){
            $mcode[$key]    = array('codenumber'=>$val['1'],'code_1'=>$val['1'],'code_2'=>$val['3'],'description_1'=>$val['4'],'description_2'=>$val['5']);
        }
        app::import('model','mcode');
        $mcodeobj  =    new Mcode();
        if($mcodeobj->saveAll($mcode))
        {
         
            die('saved');
        }else{
            die("could not save the mCodes");
        }
  }
    

}

?>