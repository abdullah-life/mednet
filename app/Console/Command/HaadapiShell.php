<?php
class HaadapiShell extends AppShell{
    public function main(){
        app::import('controller','Xmllistings');
        $xmllistingsobj     =   new XmllistingsController();
        $xmllistingsobj->callhaadapi();
    }
}
?>
