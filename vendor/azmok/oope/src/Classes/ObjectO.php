<?php

namespace OOPe\Classes;


use function Autil\type, Autil\isAssoc, Autil\object2String;

use OOPe\Traits\ObjectT;





class ObjectO{

   use ObjectT;
   
   
   
   function __construct($assoc=Null){
      if( is_null($assoc) ){
         $this->_value = Null;
         
      # argument is supplied 
      } elseif( isAssoc($assoc) ){
         foreach($assoc as $key=>$val){
         
            if( isAssoc($val) ){
               $this->{$key} = new self($val);
               
            # assing value
            } else {
               $this->{$key} = $val;
            }
         }
      } else {
         throw new \Exception("Invalid type of argument in __construct()".  __CLASS__);
      }
   }
   

   

   
   function  __toString(){
      switch( type($this) ){
         case "Array" || "AssocArray" ||  "ObjectO":
            return object2String($this);
            
         case "Number" || "Sting" ||  "Regex":
            return (string) $this->valueOf();
            
         case "Function" || "DOMDoc" ||  "DOMElm":
            return type($this);
            
         default:
            throw Exception("not implemented '__toAtring()' in this type object" );
      }
   }
   function toString(){
      $this->__toString();
   }
   
}
















