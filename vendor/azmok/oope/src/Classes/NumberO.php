<?php

namespace OOPe\Classes;



use OOPe\Traits\ObjectT;

use function Autil\_, Autil\indexOf, Autil\concat, Autil\isAssoc, Autil\isArray, Autil\_forEach, Autil\head, Autil\contain, Autil\pretty, Autil\append, Autil\prettify;



/*----------------
      NumberO
------------------
 - _value
------------------
 + value

/*---------------*/



class NumberO{

   use ObjectT;
   
   
   private $_value = 0;
   

   
   function __construct($val){
      $this->_value = $val;
   }
   
   

   
   
   function __toString(){
      return (string) $this->valueOf(); // Number, String, Regex
   }
   
}





























