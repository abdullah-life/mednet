<?php
class DeletebatchShell extends AppShell{
    public function main(){
           app::import('model','Batch');
           app::import('model','Claim');
           app::import('model','BatchesClaim');
           app::import('model','Activity');
           app::import('model','Newfile');
           app::import('model','Header');
           app::import('model','Xmllisting');
           $batchobj            =   new Batch();
           $claimobj            =   new Claim();
           $batchesclaimobj     =   new BatchesClaim();
           $activityobj         =   new Activity();
           $newfileobj          =   new Newfile();
           $headerobj           =   new Header();
           $xmllistingobj       =   new Xmllisting();
           //$batchid             =   '5237648e1da29a16360018e1';
           $batchdetails        =   $batchobj->find('first',array('conditions' => array('id' => $batchid,'status' => 0)));
           if(isset($batchdetails['Batch']['id']))
           {
               $claims          =   $batchesclaimobj->find('all',array('conditions' => array('batch_id' => $batchdetails['Batch']['id'])));
               foreach ($claims as $claim)
               {
                   $claimdata   =   $claimobj->find('first',array('conditions' => array('id' => $claim['BatchesClaim']['claim_id'])));
                   $activities  =   $activityobj->find('all',array('conditions' => array('claim_id' => $claimdata['Claim']['id'])));
                   foreach ($activities as $activity)
                   {
                       if($activityobj->delete($activity['Activity']['id']))
                       {
                           echo "Activity ".$activity['Activity']['id']." deleted\n";
                       }
                       else
                       {
                           echo "Activity ".$activity['Activity']['id']." deletion failed\n";
                       }
                   }
                   $xmllistings =   $xmllistingobj->find('first',array('conditions' => array('id' => $claimdata['Claim']['xmllisting_id'])));
                   $headers     =   $headerobj->find('first',array('conditions' => array('xmllisting_id' => $claimdata['Claim']['xmllisting_id'])));
                   if(isset($headers['Header']['id']))
                   {
                       if($headerobj->delete($headers['Header']['id']))
                       {
                           echo "Header ".$headers['Header']['id']." deleted\n";
                       }
                       else
                       {
                            echo "Header ".$headers['Header']['id']." deletion failed\n";
                       }
                   }
                   else{
                       echo "Header not present\n";
                   }
                   if(isset($xmllistings['Xmllisting']['newfile_id']))
                   {
                        $newfiledata =   $newfileobj->find('first',array('conditions' => array('id' => $xmllistings['Xmllisting']['newfile_id'])));
                        if(isset($newfiledata['Newfile']['id']))
                        {
                            if($newfileobj->delete($newfiledata['Newfile']['id']))
                            {
                                echo "Newfile ".$newfiledata['Newfile']['id']." deleted\n";
                            }
                            else
                            {
                                echo "Newfile ".$newfiledata['Newfile']['id']." deletion failed\n";
                            }
                        }
                        else{
                            echo "New file not present\n";
                        }
                   }
                   if(isset($xmllistings['Xmllisting']['id']))
                   {
                       if($xmllistingobj->delete($xmllistings['Xmllisting']['id'])){
                           echo "Xmllisting ".$xmllistings['Xmllisting']['id']." deleted\n";
                       }
                       else{
                           echo "Xmllisting ".$xmllistings['Xmllisting']['id']." deletion failed\n";
                       }
                   }
                   if($batchesclaimobj->delete($claim['BatchesClaim']['id']))
                   {
                       echo "Batches claim deleted\n";
                   }
                   else{
                       echo "Failed to delete batches claim\n";
                   }
                   if($claimobj->delete($claimdata['Claim']['id'])){
                       echo "Claim ".$claimdata['Claim']['id']." deleted\n";
                   }
                   else{
                        echo "Claim ".$claimdata['Claim']['id']." deletion failed\n";
                   }
               }
           }
           if($batchobj->delete($batchid)){
               echo "Batch deleted\n";
           }
           else{
               echo "Batch deletion failed\n";
           }
    }
}
?>
