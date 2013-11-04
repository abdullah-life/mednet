<?php
class UpdatemappingsShell extends AppShell{
    public function main(){
        app::import('model','ObservationMapping');
        $observationmappingobj          =       new ObservationMapping();
        $mappings                       =       $observationmappingobj->find('all',array('conditions' => array('gross_price' => new MongoRegex("/,/"))));
        foreach($mappings as $mapping){
            $gross_price    = str_replace(",", "", $mapping['ObservationMapping']['gross_price']);
            $observationmappingobj->id  =   $mapping['ObservationMapping']['id'];
            if($observationmappingobj->save(array('gross_price' => $gross_price))){
                echo "Price Updated for ".$mapping['ObservationMapping']['id']."\n";
            }else{
                echo "Failed to Update\n";
            }
        }
    }
}
?>
