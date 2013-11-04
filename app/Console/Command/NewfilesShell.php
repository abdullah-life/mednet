<?php

class NewfilesShell extends AppShell {

      public $uses = array('newfile');
     
      
      public function main()
      {

         app::import('controller','newfiles');
         $newfiles   =   new NewfilesController();
         $newfiles->markeddownloaded();
          
      }
      
      
}