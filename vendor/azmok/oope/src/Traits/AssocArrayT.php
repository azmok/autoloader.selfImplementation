<?php

namespace OOPe\Traits;



use function Autil\_, Autil\isAssoc, Autil\_forEach, Autil\isArray, Autil\head, Autil\append, Autil\prepend,  Autil\merge, Autil\concat, Autil\joinWith, Autil\every;


/*--------------
   <<trait>>
   AssocArrayT
----------------
  
----------------
   
------------------*/
Trait AssocArrayT {
   
   use ObjectT;
   use ArrayT;
   
   /** 
    * predicateFn whether specified property is exists
    * 
    * @return boolean
    * @param string $str 
    *        assocarray $asoc 
    */
   function contain($str, $assoc){
      if( empty($assoc) ){
         return;
      } else {
         foreach($assoc as $key=>$val){
            if( strpos($str, $key) !== false || strpos($str, $val) !== false ){
               return true;
            }
         }
      }
   }
}