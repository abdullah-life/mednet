<?php
class UpdatepriceShell extends AppShell{
    public function main(){
        app::import('model','Providerpricing');
        $providerpricingobj     =   new Providerpricing();
        $pricings               =   $providerpricingobj->find('all',array('conditions' => array('gross' => new MongoRegex("/,/"))));
        foreach ($pricings as $pricing){
            $gross  =   str_replace(",", "", $pricing['Providerpricing']['gross']);
            echo $gross;
            $providerpricingobj->id =   $pricing['Providerpricing']['id'];
            if($providerpricingobj->save(array('gross' => $gross))){
                echo "Updated for ".$pricing['Providerpricing']['id']."\n";
            }
            else{
                echo "Failed to update\n";
            }
        }
    }
}
?>
