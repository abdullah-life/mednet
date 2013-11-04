<?php
class PayerslistShell extends AppShell {

    public $uses = array('Payerslist');
    

    public function main() {
        
        
            if (file_exists(WWW_ROOT . 'files/Payerslist/payers.xlsx')) {
                app::import('Vendor','simplexlsx');
                $simple     =    new SimpleXLSX(WWW_ROOT . 'files/Payerslist/payers.xlsx');
                list($cols) = $simple->dimension();
                $i  = 0;
                foreach( $simple->rows() as $k => $r){
                    if($i==0)
                    {
                        $i++;
                        continue;
                    }
                    if($r[0]=="")
                        continue;
                    $data['Payerslist']['insurance_company']=$r[0];;
                    $data['Payerslist']['eclaimlinkid']= $r[1];
                    $data['Payerslist']['haad']=$r[2];
                    $this->Payerslist->create();
                    if($this->Payerslist->save($data))
                        echo "inserted";
                    else
                        echo "error"; 
                }
            }
            else
                die("failed to read file");
        }
}
?>
