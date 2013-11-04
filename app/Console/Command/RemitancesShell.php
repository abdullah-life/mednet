<?php

class RemitancesShell extends AppShell {
    public $uses = array('Eopfile','Eopfileentry','Activity','Claim');
    public function main() {
        app::import('controller','Eopfileentries');
        $Eopfileentries =   new EopfileentriesController();
        $date               =   "'".trim(date("Y-m-d"))."'";  
        $result             =   $this->Eopfile->find('list',array('conditions'=>array('status'=>2),'fields' => array('Eopfile.id')));
        
        foreach ($result as $row)
        {
            $this->Eopfile->save(array('Eopfile' => array('status' => 3,'id' => $row)));
            $this->out("calling function \n");
            $Eopfileentries->createRemitance($row,"DHA");
            $Eopfileentries->createRemitance($row,"HAAD");
            $Eopfileentries->createexcels($row,"DHA");
            $Eopfileentries->createexcels($row,"HAAD");
            
        }
    }
}

?>