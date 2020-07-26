<?php

namespace OOPe\Classes;



use OOPe\Traits\ObjectT;

use function Autil\_, Autil\pretty, Autil\isArray, Autil\object2String;



/*--------------------
        Logger
  (wrapper logging class)
----------------------

----------------------


--------------------*/



class NullO{

   use ObjectT;
   
   
   private $_value;
   


   function __construct($val=null){
      $this->_value = null;
   }
   

   

}