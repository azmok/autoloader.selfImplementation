<?php

namespace OOPe\Traits;



use function Autil\_, Autil\type, Autil\toString, Autil\match, Autil\filter, Autil\map, Autil\object2String, Autil\splitNamespaces, Autil\indexOf, Autil\last, Autil\initial;

/*--------------------------
   <<trait>>
   ObjectT
----------------------------

-----------------------------
 + props() : <Assoc>
 + methods() : <Assoc>
 + getClassName() : <Str>
 + toString() : <Str>
 - __toString() : <Str>
---------------------------*/



trait ObjectT{
   
   private $_value;
   
   
   
   function valueOf(){
      return $this->_value;
   }
   
   /**
   * 
   * 
   */
   function getClassName(){
      $arr = splitNamespaces(get_class($this));
      $className = last($arr);
      
      return $className;
   }
   function getNamespace(){
      $arr = splitNamespaces(get_class($this));
      $namespace = initial($arr);
      
      return $namespace;
   }
   
   /**
   * 
   * 
   */
   function getProps(){
      $varsAssoc = get_object_vars($this);
      //_( $vars );
      $varNames = array_keys($varsAssoc);

      return $varNames;
   }
   
   /**s
   * 
   * 
   */
   function getMethods(){
      $methodNames = get_class_methods($this);
      $filtered = filter(function($curr){
         return $curr !== "__construct";
      }, $methodNames);
      
      $maped = map(function($curr, $indx){
         return $curr  ."\0";
      }, $filtered);
      return $maped;
   }
   
   /**
    */
    
   function pipe($fn, $reverse=false){
      _( '$this->valueOf() in pipe()::', type($this) );
      if( $this->valueOf() === null ){
         _( '$this->valueOf === null in pipe()');
         return $this;
      } else {
         if( $reverse ){
            if( !$fn($this->valueOf()) ){
               return $this;
            } else {
               return new self(null);
            }
         } else {
            if( $fn($this->valueOf()) ){
               return $this;
            } else {
               return new self(null);
            }
         }
      }
   }
    
   function then($fn, ...$args){
      _( '$this->valueOf() in then()::', type($this) );
      if( $this->valueOf() === null ){
         _( '$this->valueOf === null in then()');
         return $this;
      } else {
         _(3);
         $fn(...$args);
       
         return $this;
      }
   }

    

    

    

   
   
   function  __toString(){
      switch( type($this) ){
         case "Array" || "AssocArray" || "ObjectO":
            return object2String($this);
         case "Number" || "Sting" || "Regex":
            return (string) $this->valueOf();
         case "Function" || "DOMDoc" || "DOMElm":
            return type($this);
         default:
            throw new Exception("not implemented '__toString()' method in this object type");
      }      
   }
}



















